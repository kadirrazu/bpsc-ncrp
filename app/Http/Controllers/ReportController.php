<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;

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

}
