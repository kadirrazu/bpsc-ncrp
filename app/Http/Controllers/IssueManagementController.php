<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Datafile;

use Carbon\Carbon;

class IssueManagementController extends Controller
{

    public function generateIssueStatusView()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $issueReportTable = DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->get();

        return view('dashboard.preli-processing.generate-issue-status', [
            'exam' => $currentExam,
            'issueReportTable' => $issueReportTable
        ]);
    }

    public function issueLogsView()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueReportTable = DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->get();

        return view('dashboard.preli-processing.issue-logs', [
            'exam' => $currentExam,
            'issueReportTable' => $issueReportTable
        ]);
    }

    /*
    * Function: markEtypeRegiIssues()
    * Mark all registration_number related issues - like: proper lenght, empty or * characters, duplicate records.
    */
    public function markEtypeRegiIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all reg_number related issues to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'reg_number_issue' => 0,
            'reg_number_status' => ''
        ]);

        //Set all reg_number issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'reg_issue')->delete();

        $eTypeDataSet = DB::table('etype_data')->where('post_code', $currentExam->post_code)->get();

        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {
            $issue = 0;
            $issueStatus = '';

            //Check if the reg_number is in PROPER LENGTH
            if( strlen(trim($dataRow->reg_number)) !== 6 ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>Invalid REG NUMBER Length.</li>';
            }

            //Check if the reg_number contains INVALID CHARACTERS
            if( strpos(trim($dataRow->reg_number), ' ') !== false || strpos(trim($dataRow->reg_number), '*') !== false ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>REG NUMBER Contains [ EMPTY/* ] Character(s).</li>';
            }
            
            //Check if the reg_number is DUPLICATE
            if( $eTypeDataSet->where('reg_number', $dataRow->reg_number)->count() > 1 ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>DUPLICATE REG NUMBER.</li>';
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                $setIssue = DB::table('etype_data')->where('id', $dataRow->id)->update([
                    'reg_number_issue' => 1,
                    'reg_number_status' => $issueStatus
                ]);

                $issueCount++;

            }

        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'reg_issue',
            'run_time' => Carbon::now(),
            'issue_count' => $issueCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper($issueCount . ' - REG NUMBER issues were marked for E-TYPE DATA.'));
    }

    //SET CODE issue finding for e-type data
    public function markEtypeSetCodeIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all set_code related issues to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'set_code_issue' => 0,
            'set_code_status' => ''
        ]);

        //Set all set_code issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'set_issue')->delete();

        $eTypeDataSet = DB::table('etype_data')->where('post_code', $currentExam->post_code)->get();

        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {
            $issue = 0;
            $issueStatus = '';

            //Check if the reg_number contains INVALID CHARACTERS
            if( strpos(trim($dataRow->set_code), ' ') !== false || strpos(trim($dataRow->set_code), '*') !== false ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>SET CODE contains [ EMPTY/* ] Character.</li>';
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                $setIssue = DB::table('etype_data')->where('id', $dataRow->id)->update([
                    'set_code_issue' => 1,
                    'set_code_status' => $issueStatus
                ]);

                $issueCount++;

            }

        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'set_issue',
            'run_time' => Carbon::now(),
            'issue_count' => $issueCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper($issueCount . ' - SET CODE issues were marked for E-TYPE DATA.'));
    }


    //CENTER CODE issue finding for e-type data
    public function markEtypeCenterCodeIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all center_code related issues to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'center_issue' => 0,
            'center_status' => ''
        ]);

        //Set all center_code issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'center_issue')->delete();

        $eTypeDataSet = DB::table('etype_data')->where('post_code', $currentExam->post_code)->get();

        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {
            $issue = 0;
            $issueStatus = '';

            //Check if the reg_number contains INVALID CHARACTERS
            if( strpos(trim($dataRow->center), ' ') !== false || strpos(trim($dataRow->center), '*') !== false ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>CENTER CODE contains [ EMPTY/* ] Character.</li>';
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                $setIssue = DB::table('etype_data')->where('id', $dataRow->id)->update([
                    'center_issue' => 1,
                    'center_status' => $issueStatus
                ]);

                $issueCount++;

            }

        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'center_issue',
            'run_time' => Carbon::now(),
            'issue_count' => $issueCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper($issueCount . ' - CENTER CODE issues were marked successfully for E-TYPE DATA.'));
    }

    //LITHO CODE issue finding for e-type data
    public function markEtypeLithoCodeIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all litho_code related issues to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'litho_issue' => 0,
            'litho_status' => ''
        ]);

        //Set all litho_code issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'litho_issue')->delete();

        $eTypeDataSet = DB::table('etype_data')->where('post_code', $currentExam->post_code)->get();

        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {
            $issue = 0;
            $issueStatus = '';

            $lithoCode1 = str_replace(" ", "0", $dataRow->litho_code1);
            $lithoCode2 = str_replace(" ", "0", $dataRow->litho_code2);

            //Check if the litho_code1 does not match with litho_code2
            if( strlen($lithoCode1) !== strlen($lithoCode2) || trim($lithoCode1) !== trim($lithoCode2) ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>LITHO_CODE-1 and LITHO_CODE-2 does not matched.</li>';
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                $setIssue = DB::table('etype_data')->where('id', $dataRow->id)->update([
                    'litho_issue' => 1,
                    'litho_status' => $issueStatus
                ]);

                $issueCount++;

            }

        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'litho_issue',
            'run_time' => Carbon::now(),
            'issue_count' => $issueCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper($issueCount . ' - LITHO CODE issues were marked for E-TYPE DATA.'));
    }

    //LITHO CODE issue finding for h-type data
    public function markHTypeLithoCodeIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all litho_code related issues to empty first.
        $setStatusToEmptyFirst = DB::table('htype_data')->where('post_code', $currentExam->post_code)->update([
            'litho_issue' => 0,
            'litho_status' => ''
        ]);

        //Set all litho_code issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'litho_issue_htype')->delete();

        $hTypeDataSet = DB::table('htype_data')->where('post_code', $currentExam->post_code)->get();

        //Iterate through each rows of the E-TYPE data table.
        foreach( $hTypeDataSet as $dataRow )
        {
            $issue = 0;
            $issueStatus = '';

            $lithoCode1 = str_replace(" ", "0", $dataRow->litho_code1);
            $lithoCode2 = str_replace(" ", "0", $dataRow->litho_code2);

            //Check if the litho_code1 does not match with litho_code2
            if( strlen($lithoCode1) !== strlen($lithoCode2) || trim($lithoCode1) !== trim($lithoCode2) ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '<li>LITHO_CODE-1 and LITHO_CODE-2 does not matched.</li>';
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                $setIssue = DB::table('htype_data')->where('id', $dataRow->id)->update([
                    'litho_issue' => 1,
                    'litho_status' => $issueStatus
                ]);

                $issueCount++;

            }

        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'h_type',
            'issue_type' => 'litho_issue_htype',
            'run_time' => Carbon::now(),
            'issue_count' => $issueCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper($issueCount . ' - LITHO CODE issues were marked for H-TYPE DATA.'));
    }

}
