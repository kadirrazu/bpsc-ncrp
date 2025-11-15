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
            'currentExam' => $currentExam,
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
            'currentExam' => $currentExam,
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
            'currentExam' => $currentExam,
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

        $optionACount = 0;
        $optionBCount = 0;
        $optionCCount = 0;
        $optionDCount = 0;

        for( $i=0; $i<strlen( $correctAnswers[2] ); $i++ )
        {
            if( $correctAnswers[2][$i] == 'A' )
            {
                $optionACount++;
            }
            else if( $correctAnswers[2][$i] == 'B' )
            {
                $optionBCount++;
            }
            else if( $correctAnswers[2][$i] == 'C' )
            {
                $optionCCount++;
            }
            else if( $correctAnswers[2][$i] == 'D' )
            {
                $optionDCount++;
            }
        }

        $set2Count = [
            'a_count' => $optionACount,
            'b_count' => $optionBCount,
            'c_count' => $optionCCount,
            'd_count' => $optionDCount,
        ];

        $optionACount = 0;
        $optionBCount = 0;
        $optionCCount = 0;
        $optionDCount = 0;

        for( $i=0; $i<strlen( $correctAnswers[3] ); $i++ )
        {
            if( $correctAnswers[3][$i] == 'A' )
            {
                $optionACount++;
            }
            else if( $correctAnswers[3][$i] == 'B' )
            {
                $optionBCount++;
            }
            else if( $correctAnswers[3][$i] == 'C' )
            {
                $optionCCount++;
            }
            else if( $correctAnswers[3][$i] == 'D' )
            {
                $optionDCount++;
            }
        }

        $set3Count = [
            'a_count' => $optionACount,
            'b_count' => $optionBCount,
            'c_count' => $optionCCount,
            'd_count' => $optionDCount,
        ];

        $optionACount = 0;
        $optionBCount = 0;
        $optionCCount = 0;
        $optionDCount = 0;

        for( $i=0; $i<strlen( $correctAnswers[4] ); $i++ )
        {
            if( $correctAnswers[4][$i] == 'A' )
            {
                $optionACount++;
            }
            else if( $correctAnswers[4][$i] == 'B' )
            {
                $optionBCount++;
            }
            else if( $correctAnswers[4][$i] == 'C' )
            {
                $optionCCount++;
            }
            else if( $correctAnswers[4][$i] == 'D' )
            {
                $optionDCount++;
            }
        }

        $set4Count = [
            'a_count' => $optionACount,
            'b_count' => $optionBCount,
            'c_count' => $optionCCount,
            'd_count' => $optionDCount,
        ];

        return view('dashboard.reports.answer-key-report',[
            'set1Answers' => $correctAnswers[1] ?? null,
            'set1Count' => $set1Count,
            'set2Answers' => $correctAnswers[2] ?? null,
            'set2Count' => $set2Count,
            'set3Answers' => $correctAnswers[3] ?? null,
            'set3Count' => $set3Count,
            'set4Answers' => $correctAnswers[4] ?? null,
            'set4Count' => $set4Count,
            'currentExam' => $currentExam,
        ]);
    }

    public function printResultOptionView()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.reports.result-print-options',[
            'exam' => $currentExam,
            'currentExam' => $currentExam,
        ]);
    }

    public function printResultWithMarks()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $resultTable = DB::table('etype_data')
                        ->join('htype_data', 'etype_data.hex_code1', '=', 'htype_data.hex_code1')
                        ->join('candidates', 'candidates.reg_number', '=', 'etype_data.reg_number')
                        ->select(
                            'etype_data.reg_number',
                            'etype_data.set_code',
                            'htype_data.final_mark',
                            'htype_data.result_status',
                            'candidates.name',
                            'candidates.district',
                        )
                        ->where('htype_data.result_status', 'PASSED')
                        ->orderBy('etype_data.reg_number', 'ASC')
                        ->get();

        return view('dashboard.reports.result-print-report',[
            'resultTable' => $resultTable,
            'currentExam' => $currentExam,
        ]);
    }

    public function bndWiseResult()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $resultTable = DB::table('etype_data')
                        ->join('htype_data', 'etype_data.hex_code1', '=', 'htype_data.hex_code1')
                        ->join('candidates', 'candidates.reg_number', '=', 'etype_data.reg_number')
                        ->select(
                            'etype_data.reg_number',
                            'etype_data.set_code',
                            'etype_data.bnd_number',
                            'htype_data.final_mark',
                            'htype_data.result_status',
                            'candidates.name',
                            'candidates.district',
                        )
                        ->where('htype_data.result_status', 'PASSED')
                        ->orderBy('etype_data.reg_number', 'ASC')
                        ->get();

        $groupedResults = $resultTable->groupBy('bnd_number');

        return view('dashboard.reports.result-bndwise-print-report',[
            'groupedResults' => $groupedResults,
            'currentExam' => $currentExam,
        ]);
    }

    public function generateResultTextFile()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $resultTable = DB::table('etype_data')
                        ->join('htype_data', 'etype_data.hex_code1', '=', 'htype_data.hex_code1')
                        ->select(
                            'etype_data.reg_number',
                            'htype_data.result_status',
                        )
                        ->where('htype_data.result_status', 'PASSED')
                        ->orderBy('etype_data.reg_number', 'ASC')
                        ->get();

        $total = 1;
        $endIndex = $resultTable->count();

        echo "<br><strong>Ministry / Division / Organization: </strong>" . $currentExam->entity . ";<br>";
        echo "<strong>Post Code & Title: </strong>" . $currentExam->post_code . ' - ' . $currentExam->post_name . ";<br><br>";
        echo "<strong>Final Result - </strong><br><br>";

        foreach( $resultTable as $row )
        {
            echo $row->reg_number;

            if($total == $endIndex )
            {
                echo "\t" . 'Total = ' . $total;
            }
            else{
                echo "\t";
            }
            
            $total++;
        }
    }

} //End of the Class
