<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Exam;
use App\Models\Datafile;
use App\Models\Regifile;
use App\Models\Candidate;
use App\Models\Answer;
use App\Models\Answerfile;
use App\Models\Config;
use App\Models\Cutmark;

use Carbon\Carbon;

class ResultProcessingController extends Controller
{
    public function uploadAnswerFileView()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $answerFile = Answerfile::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->first();

        return view('dashboard.preli-processing.upload-answer-file', [
            'exam' => $currentExam,
            'answerFile' => $answerFile,
        ]);
    }

    public function uploadAnsweKeyFileProcessor(Request $request)
    {
        $validated = $request->validate([
            'exam-id' => 'required',
            'post-code' => 'required',
            'file-type' => 'required',
            'answerfile' => 'required|file',
            'answerfile.*' => 'extensions:txt',
        ]);

        $examInfo = [
            'exam_id' => $request->input('exam-id'),
            'post_code' => $request->input('post-code'),
            'file_type' => $request->input('file-type'),
        ];

        if ($request->hasFile('answerfile')) {

            $filename = $request->input('exam-id') . '_' . $request->input('post-code') . '_' . $request->file('answerfile')->getClientOriginalName();
            
            $request->file('answerfile')->storeAs( 'datafiles/' . $request->input('post-code') . '/' . strtoupper($request->input('file-type')), $filename, 'public' );

            $inserted = Answerfile::create([
                'exam_id' => $examInfo['exam_id'],
                'post_code' => $examInfo['post_code'],
                'file_type' => $examInfo['file_type'],
                'file_name' => $filename,
            ]);

            return redirect()->back()->with('success', 'Answer Key file was uploaded successfully!');

        }

        return redirect()->back()->with('error', 'No file was uploaded! Check for issues and try again.');

    }

    public function convertAnswerFile()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $answerFile = Answerfile::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->first();

        $post_code = $answerFile->post_code;
        $file_type = $answerFile->file_type;
        $file_name = $answerFile->file_name;

        $contents = '';
        $data = [];

        if( Storage::disk('public')->exists('datafiles/'.$post_code.'/'.strtoupper($file_type).'/'.$file_name) ) 
        {
            $contents = Storage::disk('public')->get('datafiles/'.$post_code.'/'.strtoupper($file_type).'/'.$file_name);
        }
        else{
            return redirect()->back()->with('error', '404 - File not found.');
        }

        if( $contents != null )
        {
            $lines = explode("\n", $contents);

            foreach ($lines as $line) 
            {
                $start = 0;
                $setCode = null;
                $answers = null;
                
                if(trim($line) != "" && trim($line) != null)
                {
                    $setCode = trim($line[0]);
                    $answers = str_replace( array("\n", "\r"), '', trim( substr($line, 1) ) );
                    
                    $data[] = [
                        'exam_id' => $currentExam->id,
                        'post_code' => $currentExam->post_code,
                        'set_code' => $setCode,
                        'answers' => $answers,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }
        }

        DB::table('answers')->truncate();

        $result = Answer::insert($data);

        if($result){
            Answerfile::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->update([
                'conversion_status' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Answer Key File data were converted and placed to database table successfully.');
    }

    public function calculateMarks()
    {

        $currentExam = Exam::where('is_current', 1)->first();

        $answerTable = DB::table('answers')
            ->select('set_code', 'answers')
            ->where('exam_id', $currentExam->id)
            ->where('post_code', $currentExam->post_code)
            ->get();

        $config = Config::pluck('value', 'key');

        // Create lookup array for correct answers
        $correctAnswers = $answerTable->pluck('answers', 'set_code')->toArray();

        // Optional negative marking
        $negativeMark = (float)$config['negative_mark'] ?? 0;  // 0 means no negative marking

        $set1ExtraMark = (float)$config['set1_extra_mark'] ?? 0;
        $set2ExtraMark = (float)$config['set2_extra_mark'] ?? 0;
        $set3ExtraMark = (float)$config['set3_extra_mark'] ?? 0;
        $set4ExtraMark = (float)$config['set4_extra_mark'] ?? 0;

        $joinedTable = DB::table('etype_data')
            ->join('htype_data', 'etype_data.hex_code1', '=', 'htype_data.hex_code1')
            ->select(
                'etype_data.reg_number',
                'etype_data.set_code',
                'htype_data.id as ht_id',
                'htype_data.answers'
            )
            ->where('etype_data.duplicate_script', 0)
            ->where('etype_data.invalid_fillup', 0)
            ->where('htype_data.duplicate_script', 0)
            ->where('etype_data.hex_code1', '!=', '')
            ->where('htype_data.hex_code1', '!=', '')
            ->get();

        // Final results per candidate
        $resultList = [];
        $updates = [];
        $updated = 0;

        DB::table('htype_data')
            ->update([
                'total_mark'    => NULL,
                'negative_mark' => NULL,
                'final_mark'    => NULL,
            ]);

        foreach ($joinedTable as $candidate) 
        {

            $candidateAnswers = $candidate->answers;
            $setCode = $candidate->set_code;

            if (!isset($correctAnswers[$setCode])) {
                continue; // Skip missing set codes
            }

            $extraMarks = 0;

            if( $candidate->set_code == '1' || $candidate->set_code == 'A' )
            {
                $extraMarks = $set1ExtraMark;
            }
            else if( $candidate->set_code == '2' || $candidate->set_code == 'B' )
            {
                $extraMarks = $set2ExtraMark;
            }
            else if( $candidate->set_code == '3' || $candidate->set_code == 'C' )
            {
                $extraMarks = $set3ExtraMark;
            }
            else if( $candidate->set_code == '4' || $candidate->set_code == 'D' )
            {
                $extraMarks = $set4ExtraMark;
            }

            $correct = $correctAnswers[$setCode];

            $totalCorrect = 0;
            $totalNegative = 0;

            // Compare all 100 characters
            for ($i = 0; $i < strlen($correct); $i++) {

                $candChar = $candidateAnswers[$i] ?? ' ';
                $corrChar = $correct[$i];

                if ($candChar === ' ') {
                    continue;   // skip blank answers
                }

                if ($candChar === $corrChar) {
                    $totalCorrect++;
                } else {
                    if ($negativeMark > 0) {
                        $totalNegative += $negativeMark;
                    }
                }
            }

            // Store result for each candidate
            $resultList[] = [
                'reg_number'      => $candidate->reg_number,
                'set_code'        => $setCode,
                'total_correct'   => $totalCorrect,
                'total_negative'  => round($totalNegative, 2),
                'extra_mark'      => $extraMarks,
                'final_score'     => round(($totalCorrect - $totalNegative) + $extraMarks, 2),
            ];

            $updates[$candidate->ht_id] = [
                'total_mark'    => $totalCorrect,
                'negative_mark' => round($totalNegative, 2),
                'extra_mark'    => $extraMarks,
                'final_mark'    => round(($totalCorrect - $totalNegative) + $extraMarks, 2),
            ];
        }

        if( !empty($updates) ) 
        {
            // Prepare CASE WHEN SQL for each column
            $totalMarkSql    = "CASE id";
            $negativeMarkSql = "CASE id";
            $extraMarkSql    = "CASE id";
            $finalMarkSql    = "CASE id";

            $ids = [];

            foreach ($updates as $id => $data) {
                $ids[] = $id;
                $totalMarkSql    .= " WHEN $id THEN {$data['total_mark']}";
                $negativeMarkSql .= " WHEN $id THEN {$data['negative_mark']}";
                $extraMarkSql    .= " WHEN $id THEN {$data['extra_mark']}";
                $finalMarkSql    .= " WHEN $id THEN {$data['final_mark']}";
            }

            $totalMarkSql    .= " END";
            $negativeMarkSql .= " END";
            $extraMarkSql    .= " END";
            $finalMarkSql    .= " END";

            // Execute a single bulk update
            DB::table('htype_data')
                ->whereIn('id', $ids)
                ->update([
                    'total_mark'    => DB::raw($totalMarkSql),
                    'negative_mark' => DB::raw($negativeMarkSql),
                    'extra_mark'    => DB::raw($extraMarkSql),
                    'final_mark'    => DB::raw($finalMarkSql),
                ]);

            $updated = 1;
        }

        if( $updated )
        {
            return redirect()->back()->with('success', 'Marks were calculated and score table was updated accordingly.');
        }
        else{
            return redirect()->back()->with('error', 'There were some error during processing your request.');
        }
        
    }

    public function cutMarkPostingView()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $cutmark = Cutmark::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->first();

        return view('dashboard.preli-processing.cut-mark-posting',[
            'exam' => $currentExam,
            'cutmark' => $cutmark->cut_mark ?? null,
        ]);
    }

    public function cutMarkPostingProcessor(Request $request)
    {
        $validated = $request->validate([
            'exam-id' => 'required',
            'post-code' => 'required',
            'cut_mark' => 'required',
        ]);

        $data = [
            'exam_id' => $request->input('exam-id'),
            'post_code' => $request->input('post-code'),
            'cut_mark' => $request->input('cut_mark'),
        ];

        Cutmark::truncate();

        $inserted = Cutmark::create( $data );

        if( $inserted )
        {
            return redirect()->back()->with('success', 'Cut mark was set successfully.');
        }
        else{
            return redirect()->back()->with('error', 'Error during posting cut mark.');
        }

    }

    public function deleteCutMark()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $deleted = Cutmark::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->delete();

        if( $deleted )
        {
            return redirect()->back()->with('warning', 'Cut mark was deleted successfully.');
        }
        else{
            return redirect()->back()->with('error', 'Error during deleting existing cut mark.');
        }
    }

    public function generateResultStatus()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $cutMarkRow = Cutmark::select('cut_mark')->where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->first();
        
        $cutMark = $cutMarkRow->cut_mark ?? null;

        $statusCount = 0;

        if( $cutMark !== null )
        {
            $hTypeData = DB::table('htype_data')->select('id', 'final_mark', 'result_status')->where('post_code', $currentExam->post_code)->where('final_mark', '!=', null)->where('hex_matched', 1)->get();

            $updateData = [];

            foreach($hTypeData as $row )
            {
                $resultStatus = 'INVALID';

                if( $row->final_mark != null && ((float)$row->final_mark >= (float)$cutMark) )
                {
                    $resultStatus = 'PASSED';
                }
                else if( $row->final_mark != null && ((float)$row->final_mark < (float)$cutMark) )
                {
                    $resultStatus = 'FAILED';
                }

                $updateData[] = [
                    'id' => $row->id,
                    'final_mark' => $row->final_mark,
                    'result_status' => $resultStatus
                ];

            }

            if( count($updateData) > 0 )
            {
                DB::transaction(function () use ($updateData, &$statusCount) {
                    foreach ($updateData as $data) {
                        DB::table('htype_data')->where('id', $data['id'])
                        ->update([
                            'result_status' => strtoupper($data['result_status'])
                        ]);
                        $statusCount++;
                    }
                });
            }

        }

        return redirect()->back()->with('info', $statusCount . ' - Candidates result status was marked successfully.');

    }

} //End of Class
