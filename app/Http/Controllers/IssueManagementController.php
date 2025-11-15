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
    /*public function markEtypeRegiIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all reg_number related issues to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'reg_number_issue' => 0,
            'reg_number_status' => ''
        ]);

        $rejectInvalidFillup = DB::table('configs')->where('key', 'reject_invalid_fillup')->first()->value ?? 0;

        //Set all reg_number issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'reg_issue')->delete();

        $eTypeDataSet = DB::table('etype_data')->select('id','reg_number')->where('post_code', $currentExam->post_code)->get();

        $candidatesDataSet = DB::table('candidates')->select('reg_number')->where('post_code', $currentExam->post_code)->get();

        $configRegNumber = DB::table('datalines')->where('script_type', 'e_type')->where('part_title', 'reg_number')->first();
        $regNumberLength = $configRegNumber->length ?? 0;

        $regIssueArray = [];

        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {
            $issue = 0;
            $issueStatus = '';
            $invalidFillup = 0;
            $lengthOrCharacterIssue = 0;

            //Check if the reg_number is in PROPER LENGTH
            if( strlen(trim($dataRow->reg_number)) !== $regNumberLength ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '-INVALID REG NUMBER LENGTH;';
                $invalidFillup = 1;
                $lengthOrCharacterIssue = 1;
            }

            //Check if the reg_number contains INVALID CHARACTERS
            if( strpos(trim($dataRow->reg_number), ' ') !== false || strpos(trim($dataRow->reg_number), '*') !== false ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '-REG NUMBER CONTAINS [ EMPTY/* ];';
                $invalidFillup = 1;
                $lengthOrCharacterIssue = 1;
            }

            //Check if reg number is in full lenght and all characters are okay. Only then check with candidate table.
            if( !$lengthOrCharacterIssue )
            {
                //INVALID in respect with REGI DATA candidatesDataSet
                if(  $candidatesDataSet->where('reg_number', $dataRow->reg_number)->count() < 1 ){
                    $issue = 1;
                    $issueStatus = trim($issueStatus) . '-MISSMATCH WITH REGI DATA;';
                }
            }
            
            //Check if the reg_number is DUPLICATE
            if( $eTypeDataSet->where('reg_number', $dataRow->reg_number)->count() > 1 ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '-DUPLICATE REG NUMBER;';
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                if( $rejectInvalidFillup == '1' )
                {
                    $regIssueArray[] = [
                        'id' => $dataRow->id,
                        'reg_number_issue' => 1,
                        'reg_number_status' => $issueStatus,
                        'invalid_fillup' => $invalidFillup,
                    ];
                }
                else
                {
                    $regIssueArray[] = [
                        'id' => $dataRow->id,
                        'reg_number_issue' => 1,
                        'reg_number_status' => $issueStatus,
                    ];
                }

                $issueCount++;

            }

        }

        DB::transaction(function () use ($regIssueArray) {
            foreach ($regIssueArray as $data) {
                DB::table('etype_data')->where('id', $data['id'])
                ->update([
                    'reg_number_issue' => $data['reg_number_issue'],
                    'reg_number_status' => $data['reg_number_status'],
                    'invalid_fillup' => $data['invalid_fillup']
                ]);
            }
        });

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
    }*/

    public function markEtypeRegiIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        // Reset statuses
        DB::table('etype_data')
            ->where('post_code', $currentExam->post_code)
            ->update([
                'reg_number_issue' => 0,
                'reg_number_status' => '',
                'invalid_fillup' => 0
            ]);

        $rejectInvalidFillup = DB::table('configs')
            ->where('key', 'reject_invalid_fillup')
            ->value('value') ?? 0;

        DB::table('issue_generation_report')
            ->where('exam_id', $currentExam->id)
            ->where('issue_type', 'reg_issue')
            ->delete();

        // Load datasets
        $eTypeDataSet = DB::table('etype_data')
            ->select('id','reg_number')
            ->where('post_code', $currentExam->post_code)
            ->get();

        $candidateLookup = DB::table('candidates')
            ->where('post_code', $currentExam->post_code)
            ->pluck('reg_number')
            ->flip()
            ->all();

        $configRegNumber = DB::table('datalines')
            ->where('script_type', 'e_type')
            ->where('part_title', 'reg_number')
            ->first();

        $regNumberLength = $configRegNumber->length ?? 0;

        // Pre-count duplicates
        $regCounts = [];

        foreach ($eTypeDataSet as $row) {
            $regCounts[$row->reg_number] = ($regCounts[$row->reg_number] ?? 0) + 1;
        }

        $regIssueArray = [];
        $issueCount = 0;

        foreach ($eTypeDataSet as $dataRow) {

            $reg = trim($dataRow->reg_number);
            $issue = false;
            $msg = [];
            $invalidFillup = 0;

            // 1) Length check
            if (strlen($reg) != $regNumberLength) {
                $issue = true;
                $invalidFillup = 1;
                $msg[] = 'INVALID REG NUMBER LENGTH';
            }

            // 2) Invalid characters
            if (strpos($reg, ' ') !== false || strpos($reg, '*') !== false) {
                $issue = true;
                $invalidFillup = 1;
                $msg[] = 'REG NUMBER CONTAINS [ EMPTY/* ]';
            }

            // 3) Only check candidate list if valid length & chars
            if (!$invalidFillup && !isset($candidateLookup[$reg])) {
                $issue = true;
                $msg[] = 'MISMATCH WITH REGI DATA';
            }

            // 4) Duplicate check
            $isDuplicate = ($regCounts[$reg] ?? 0) > 1;

            if ($isDuplicate) {
                $issue = true;
                $msg[] = 'DUPLICATE REG NUMBER';
            }

            if ($issue) {
                $regIssueArray[] = [
                    'id' => $dataRow->id,
                    'reg_number_issue' => 1,
                    'reg_number_status' => implode('; ', $msg) . ';',
                    'invalid_fillup' => $invalidFillup
                ];
                $issueCount++;
            }
        }

        // Batch update in chunks to reduce DB overhead
        foreach (array_chunk($regIssueArray, 500) as $chunk) {

            DB::transaction(function () use ($chunk) {

                foreach ($chunk as $row) {
                    DB::table('etype_data')
                        ->where('id', $row['id'])
                        ->update([
                            'reg_number_issue' => $row['reg_number_issue'],
                            'reg_number_status' => $row['reg_number_status'],
                            'invalid_fillup' => $row['invalid_fillup'],
                        ]);
                }

            });

        }

        // Save issue report
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'reg_issue',
            'run_time' => now(),
            'issue_count' => $issueCount
        ]);

        return redirect()->back()->with('info', strtoupper("$issueCount - REG NUMBER issues were marked."));
    }

    //SET CODE issue finding for e-type data
    public function markEtypeSetCodeIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        $rejectInvalidFillup = DB::table('configs')->where('key', 'reject_invalid_fillup')->first()->value ?? 0;

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
            $invalidFillup = 0;

            //Check if the reg_number contains INVALID CHARACTERS
            if( strpos(trim($dataRow->set_code), ' ') !== false || strpos(trim($dataRow->set_code), '*') !== false ){
                $issue = 1;
                $issueStatus = trim($issueStatus) . '-SET CODE CONTAINS [ EMPTY/* ];';
                $invalidFillup = 1;
            }

            //Update reg_number Status if there is any of the above ISSUE exists
            if( $issue === 1 )
            {

                if( $rejectInvalidFillup == 1 )
                {
                    $setIssue = DB::table('etype_data')->where('id', $dataRow->id)->update([
                        'set_code_issue' => 1,
                        'set_code_status' => $issueStatus,
                        'invalid_fillup' => $invalidFillup,
                    ]);
                }
                else
                {
                    $setIssue = DB::table('etype_data')->where('id', $dataRow->id)->update([
                        'set_code_issue' => 1,
                        'set_code_status' => $issueStatus
                    ]);
                }

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
                $issueStatus = trim($issueStatus) . '-CENTER CODE CONTAINS [ EMPTY/* ];';
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
                $issueStatus = trim($issueStatus) . '-SELF LITHOCODE MISSMATCH;';
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

    //HEX CODE MISS MATCH issue finding for e-type data
    public function markETypeHexCodeMissMatchIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        //Set all hexcode missmatch related issue count to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'hex_matched' => 1,
        ]);

        //Set all hexcode missmatch issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'hexmissmatch_issue_etype')->delete();

        $eTypeDataSet = DB::table('etype_data')->select('id', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();
        $hTypeDataSet = DB::table('htype_data')->select('id', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();

        $matched = 0;
        $matchCount = 0;
        $unMatchCount = 0;
        $unMatchedIds = [];
        $matchedIds = [];
        
        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {

            $eHex1 = $dataRow->hex_code1 ?? '';
            $eHex2 = $dataRow->hex_code2 ?? '';

            //Check if the e-type hex_code1 does match with hex_code1 of h-type data
            if( $hTypeDataSet->contains('hex_code1', $eHex1) )
            {
                $matched = 1;
                $matchCount++;
                $matchedIds[] = $dataRow->id;
            }
            else
            {
                $matched = 0;
                $unMatchCount++;
                $unMatchedIds[] = $dataRow->id;
            }

        }

        if( count($unMatchedIds) > 0 )
        {
            DB::transaction(function () use ($unMatchedIds) {
                foreach ($unMatchedIds as $id) {
                    DB::table('etype_data')->where('id', $id)
                    ->update([
                        'hex_matched' => 0,
                    ]);
                }
            });
        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'hexmissmatch_issue_etype',
            'run_time' => Carbon::now(),
            'issue_count' => $unMatchCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper( 'E-TYPE Hex Checking Report: Matched - ' . $matchCount . '; Unmatched - ' . $unMatchCount));
    }

    //HEX CODE MISS MATCH issue finding for h-type data
    public function markHTypeHexCodeMissMatchIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        //Set all hexcode missmatch related issue count to empty first.
        $setStatusToEmptyFirst = DB::table('htype_data')->where('post_code', $currentExam->post_code)->update([
            'hex_matched' => 1,
        ]);

        //Set all hexcode missmatch issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'hexmissmatch_issue_htype')->delete();

        $eTypeDataSet = DB::table('htype_data')->select('id', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();
        $hTypeDataSet = DB::table('etype_data')->select('id', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();

        $matched = 0;
        $matchCount = 0;
        $unMatchCount = 0;
        $unMatchedIds = [];
        $matchedIds = [];
        
        //Iterate through each rows of the E-TYPE data table.
        foreach( $hTypeDataSet as $dataRow )
        {

            $hHex1 = $dataRow->hex_code1 ?? '';
            $hHex2 = $dataRow->hex_code2 ?? '';

            //Check if the e-type hex_code1 does match with hex_code1 of h-type data
            if( $eTypeDataSet->contains('hex_code1', $hHex1) )
            {
                $matched = 1;
                $matchCount++;
                $matchedIds[] = $dataRow->id;
            }
            else
            {
                $matched = 0;
                $unMatchCount++;
                $unMatchedIds[] = $dataRow->id;
            }

        }

        if( count($unMatchedIds) > 0 )
        {
            DB::transaction(function () use ($unMatchedIds) {
                foreach ($unMatchedIds as $id) {
                    DB::table('htype_data')->where('id', $id)
                    ->update([
                        'hex_matched' => 0,
                    ]);
                }
            });
        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'hexmissmatch_issue_htype',
            'run_time' => Carbon::now(),
            'issue_count' => $unMatchCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper( 'H-TYPE Hex Checking Report: Matched - ' . $matchCount . '; Unmatched - ' . $unMatchCount));
    }

    //HEX CODE MATCH CHECKING WITH OWN DATA - E TYPE
    public function markETypeOwnHexCodeMissMatches()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        //Set all hexcode missmatch related issue count to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'hex_issue' => 0,
        ]);

        //Set all hexcode missmatch issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'own_hexmissmatch_issue_etype')->delete();

        $eTypeDataSet = DB::table('etype_data')->select('id', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();

        $matched = 0;
        $matchCount = 0;
        $unMatchCount = 0;
        $matchedIds = [];
        $unMatchedIds = [];
        
        //Iterate through each rows of the E-TYPE data table.
        foreach( $eTypeDataSet as $dataRow )
        {

            $hexCode1 = $dataRow->hex_code1 ?? '';
            $hexCode2 = $dataRow->hex_code2 ?? '';

            //Check if the e-type hex_code1 does match with hex_code1 of h-type data
            if( $hexCode1 == $hexCode2 )
            {
                $matched = 1;
                $matchCount++;
                $matchedIds[] = $dataRow->id;
            }
            else
            {
                $matched = 0;
                $unMatchCount++;
                $unMatchedIds[] = $dataRow->id;
            }

        }

        if( count($unMatchedIds) > 0 )
        {
            DB::transaction(function () use ($unMatchedIds) {
                foreach ($unMatchedIds as $id) {
                    DB::table('etype_data')->where('id', $id)
                    ->update([
                        'hex_issue' => 1,
                    ]);
                }
            });
        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'own_hexmissmatch_issue_etype',
            'run_time' => Carbon::now(),
            'issue_count' => $unMatchCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper( 'E-TYPE Own Hexcode Checking Report: Matched - ' . $matchCount . '; Unmatched - ' . $unMatchCount));
    }

    //HEX CODE MATCH CHECKING WITH OWN DATA - H TYPE
    public function markHTypeOwnHexCodeMissMatches()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        //Set all hexcode missmatch related issue count to empty first.
        $setStatusToEmptyFirst = DB::table('htype_data')->where('post_code', $currentExam->post_code)->update([
            'hex_issue' => 0,
        ]);

        //Set all hexcode missmatch issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'own_hexmissmatch_issue_htype')->delete();

        $hTypeDataSet = DB::table('htype_data')->select('id', 'hex_code1', 'hex_code2')->where('post_code', $currentExam->post_code)->where('litho_issue', '!==', 1)->get();

        $matched = 0;
        $matchCount = 0;
        $unMatchCount = 0;
        $matchedIds = [];
        $unMatchedIds = [];
        
        //Iterate through each rows of the E-TYPE data table.
        foreach( $hTypeDataSet as $dataRow )
        {

            $hexCode1 = $dataRow->hex_code1 ?? '';
            $hexCode2 = $dataRow->hex_code2 ?? '';

            //Check if the e-type hex_code1 does match with hex_code1 of h-type data
            if( $hexCode1 == $hexCode2 )
            {
                $matched = 1;
                $matchCount++;
                $matchedIds[] = $dataRow->id;
            }
            else
            {
                $matched = 0;
                $unMatchCount++;
                $unMatchedIds[] = $dataRow->id;
            }

        }

        if( count($unMatchedIds) > 0 )
        {
            DB::transaction(function () use ($unMatchedIds) {
                foreach ($unMatchedIds as $id) {
                    DB::table('htype_data')->where('id', $id)
                    ->update([
                        'hex_issue' => 1,
                    ]);
                }
            });
        }

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'own_hexmissmatch_issue_htype',
            'run_time' => Carbon::now(),
            'issue_count' => $unMatchCount
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper( 'H-TYPE Own Hexcode Checking Report: Matched - ' . $matchCount . '; Unmatched - ' . $unMatchCount));
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

    public function markETypeScriptDupicateIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all litho_code related issues to empty first.
        $setStatusToEmptyFirst = DB::table('etype_data')->where('post_code', $currentExam->post_code)->update([
            'duplicate_script' => 0,
        ]);

        //Set all litho_code issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'etype_script_duplicate')->delete();

        $duplicateLithoCodes = DB::table('etype_data')
        ->select('litho_code1')
        ->where('post_code', $currentExam->post_code)
        ->groupBy('litho_code1')
        ->havingRaw('COUNT(*) > 1')
        ->pluck('litho_code1');

        DB::table('etype_data')
        ->where('post_code', $currentExam->post_code)
        ->whereIn('litho_code1', $duplicateLithoCodes)
        ->update(['duplicate_script' => 1]);

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'etype_script_duplicate',
            'run_time' => Carbon::now(),
            'issue_count' => count($duplicateLithoCodes)
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper(count($duplicateLithoCodes) . ' - DUPLICATE SCRIPTS were marked for E-TYPE DATA.'));

    }

    public function markHTypeScriptDupicateIssues()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        $issueCount = 0;

        //Set all litho_code related issues to empty first.
        $setStatusToEmptyFirst = DB::table('htype_data')->where('post_code', $currentExam->post_code)->update([
            'duplicate_script' => 0,
        ]);

        //Set all litho_code issue report to empty first.
        DB::table('issue_generation_report')->where('exam_id', $currentExam->id)->where('issue_type', 'htype_script_duplicate')->delete();

        $duplicateLithoCodes = DB::table('htype_data')
        ->select('litho_code1')
        ->where('post_code', $currentExam->post_code)
        ->groupBy('litho_code1')
        ->havingRaw('COUNT(*) > 1')
        ->pluck('litho_code1');

        DB::table('htype_data')
        ->where('post_code', $currentExam->post_code)
        ->whereIn('litho_code1', $duplicateLithoCodes)
        ->update(['duplicate_script' => 1]);

        //Update issue generation record timestamp and latest issue count
        DB::table('issue_generation_report')->insert([
            'exam_id' => $currentExam->id,
            'file_type' => 'e_type',
            'issue_type' => 'htype_script_duplicate',
            'run_time' => Carbon::now(),
            'issue_count' => count($duplicateLithoCodes)
        ]);

        //Redirect to issue generation page with success status and touched record count.
        return redirect()->back()->with('info', strtoupper(count($duplicateLithoCodes) . ' - DUPLICATE SCRIPTS were marked for H-TYPE DATA.'));

    }

    public function viewEtypeScriptDuplicateData()
    {
        
        $duplicateScripts = DB::table('etype_data')->where('duplicate_script', 1)->get();

        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.view-script-duplicate-data', [
            'data' => $duplicateScripts,
            'exam' => $currentExam,
        ]);

    }

    public function viewHtypeScriptDuplicateData()
    {
        
        $duplicateScripts = DB::table('htype_data')->where('duplicate_script', 1)->get();

        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.view-script-duplicate-data-h', [
            'data' => $duplicateScripts,
            'exam' => $currentExam,
        ]);

    }

    public function markNonDuplicateOnETypeData(Request $request)
    {
        $id = $request->id ?? null;
        
        $duplicateScripts = DB::table('etype_data')->where('id', $id)->update(['duplicate_script' => 0]);

        return redirect()->back()->with('success', strtoupper('Script was marked as non duplicate.'));
    }

     public function markNonDuplicateOnHTypeData(Request $request)
    {
        $id = $request->id ?? null;
        
        $duplicateScripts = DB::table('htype_data')->where('id', $id)->update(['duplicate_script' => 0]);

        return redirect()->back()->with('success', strtoupper('Script was marked as non duplicate.'));
    }

}
