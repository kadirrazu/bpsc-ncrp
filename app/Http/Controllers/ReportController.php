<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Answer;

class ReportController extends Controller
{

    public function hexcodeUnmatchReport()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $eTypeDataSet = DB::table('etype_data')->select('id', 'bnd_number', 'scan_sr', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();
        $hTypeDataSet = DB::table('htype_data')->select('id', 'bnd_number', 'scan_sr', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();

        $matchCountE = 0;
        $unMatchCountE = 0;
        $unMatchedIdsE = [];
        
        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {

            $eHex1 = $dataRow->hex_code1 ?? '';

            //Check if the e-type hex_code1 does match with hex_code1 of h-type data
            if( $hTypeDataSet->contains('hex_code1', $eHex1) )
            {
                $matchCountE++;
            }
            else
            {
                $unMatchCountE++;
                $unMatchedIdsE[] = [
                    'script_part' => 'E-TYPE',
                    'id' => $dataRow->id,
                    'bnd_number' => $dataRow->bnd_number,
                    'scan_sr' => $dataRow->scan_sr,
                    'hexcode' => $eHex1
                ];
            }

        }

        //FOR H-TYPE
        $matchCountH = 0;
        $unMatchCountH = 0;
        $unMatchedIdsH = [];
        
        //Iterate through each rows of the E-TYPE data table.
        foreach( $hTypeDataSet as $dataRow )
        {

            $hHex1 = $dataRow->hex_code1 ?? '';

            //Check if the e-type hex_code1 does match with hex_code1 of h-type data
            if( $eTypeDataSet->contains('hex_code1', $hHex1) )
            {
                $matchCountH++;
            }
            else
            {
                $unMatchCountH++;
                $unMatchedIdsH[] = [
                    'script_part' => 'H-TYPE',
                    'id' => $dataRow->id,
                    'bnd_number' => $dataRow->bnd_number,
                    'scan_sr' => $dataRow->scan_sr,
                    'hexcode' => $hHex1
                ];
            }

        }

        return view('dashboard.reports.hex-unmatch-report',[
            'e_matched' => $matchCountE,
            'e_unmatched' => $unMatchCountE,
            'h_matched' => $matchCountH,
            'h_unmatched' => $unMatchCountH,
            'e_unmatched_array' => $unMatchedIdsE,
            'h_unmatched_array' => $unMatchedIdsH,
        ]);

    }

    public function scoreFrequencyReport()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $scoreFrequencyData = DB::table('htype_data')
                            ->select('final_mark', DB::raw('COUNT(*) as candidate_count'))
                            ->where('post_code', $currentExam->post_code)
                            ->where('hex_matched', 1)
                            ->where('final_mark', '!=', null)
                            ->groupBy('final_mark')
                            ->orderBy('final_mark', 'DESC')->get();

        return view('dashboard.reports.score-frequency-report',[
            'scoreFrequencyData' => $scoreFrequencyData,
        ]);
    }

    public function ehBalanceReport()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $eTypeBalance = DB::table('etype_data')
                        ->select('bnd_number', DB::raw('COUNT(*) as script_count'))
                        ->where('post_code', $currentExam->post_code)
                        ->groupBy('bnd_number')
                        ->orderBy('bnd_number', 'ASC')->get();
        
        $hTypeBalance = DB::table('htype_data')
                        ->select('bnd_number', DB::raw('COUNT(*) as script_count'))
                        ->where('post_code', $currentExam->post_code)
                        ->groupBy('bnd_number')
                        ->orderBy('bnd_number', 'ASC')->get();

        return view('dashboard.reports.eh-balance-report',[
            'eTypeBalance' => $eTypeBalance,
            'hTypeBalance' => $hTypeBalance,
        ]);

    }

    public function answerKeyReport()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        
        $answerTable = DB::table('answers')
            ->select('set_code', 'answers')
            ->where('exam_id', $currentExam->id)
            ->where('post_code', $currentExam->post_code)
            ->get();

        // Create lookup array for correct answers
        $correctAnswers = $answerTable->pluck('answers', 'set_code')->toArray();

        $set1Count = [];
        $set2Count = [];
        $set3Count = [];
        $set4Count = [];

        $optionACount = 0;
        $optionBCount = 0;
        $optionCCount = 0;
        $optionDCount = 0;

        for( $i=0; $i<strlen( $correctAnswers[1] ); $i++ )
        {
            if( $correctAnswers[1][$i] == 'A' )
            {
                $optionACount++;
            }
            else if( $correctAnswers[1][$i] == 'B' )
            {
                $optionBCount++;
            }
            else if( $correctAnswers[1][$i] == 'C' )
            {
                $optionCCount++;
            }
            else if( $correctAnswers[1][$i] == 'D' )
            {
                $optionDCount++;
            }
        }

        $set1Count = [
            'a_count' => $optionACount,
            'b_count' => $optionBCount,
            'c_count' => $optionCCount,
            'd_count' => $optionDCount,
        ];

        return view('dashboard.reports.answer-key-report',[
            'set1Answers' => $correctAnswers[1] ?? null,
            'set1Count' => $set1Count
        ]);
    }

} //End of the Class
