<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Exam;
use App\Models\Datafile;
use App\Models\Regifile;
use App\Models\Candidate;

use Carbon\Carbon;

class DataProcessingController extends Controller
{

    public function configureRawDataLines()
    {
        return view('dashboard.preli-processing.configure-data-line');
    }

    public function configureETypeRawDataLines()
    {
        $eTypeParts = DB::table('datalines')->where('script_type', 'e_type')->orderBy('part_sequence', 'ASC')->get();
        return view('dashboard.preli-processing.parts.configure-data-line-view-etype', ['parts' => $eTypeParts]);
    }

    public function configureHTypeRawDataLines()
    {
        $hTypeParts = DB::table('datalines')->where('script_type', 'h_type')->orderBy('part_sequence', 'ASC')->get();

        return view('dashboard.preli-processing.parts.configure-data-line-view-htype', ['parts' => $hTypeParts]);
    }

    public function updateETypeRawDataLine(Request $request)
    {
       $data = $request->validate([
            'scripts' => 'required|array',
            'scripts.*.script_type' => 'required|string',
            'scripts.*.part_title' => 'required|string',
            'scripts.*.part_sequence' => 'required|integer',
            'scripts.*.length' => 'required|integer',
        ]);

         DB::table('datalines')->where('script_type', 'e_type')->delete();

        foreach ($data['scripts'] as $row) {
            DB::table('datalines')->insert($row);
        }

        return redirect()->back()->with('success', 'E-TYPE DATA LINE PARTS WERE SAVED SUCCESSFULLY.');
    }

    public function updateHTypeRawDataLine(Request $request)
    {
       $data = $request->validate([
            'scripts' => 'required|array',
            'scripts.*.script_type' => 'required|string',
            'scripts.*.part_title' => 'required|string',
            'scripts.*.part_sequence' => 'required|integer',
            'scripts.*.length' => 'required|integer',
        ]);

         DB::table('datalines')->where('script_type', 'h_type')->delete();

        foreach ($data['scripts'] as $row) {
            DB::table('datalines')->insert($row);
        }

        return redirect()->back()->with('success', 'H-TYPE DATA LINE PARTS WERE SAVED SUCCESSFULLY.');
    }

    public function uploadDataFile()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.upload-data-file', ['exam' => $currentExam]);
    }

    public function uploadDataFileProcessor(Request $request)
    {
        $validated = $request->validate([
            'exam-id' => 'required',
            'post-code' => 'required',
            'file-type' => 'required',
            'datafiles' => 'required|array',
            'datafiles.*' => 'extensions:dat,txt',
        ]);

        $fileNames = [];

        $examInfo = [
            'exam_id' => $request->input('exam-id'),
            'post_code' => $request->input('post-code'),
            'file_type' => $request->input('file-type'),
        ];

        if ($request->hasFile('datafiles')) {

            foreach ($request->file('datafiles') as $file) {
                $filename = $request->input('exam-id') . '_' . $request->input('post-code') . '_' . $file->getClientOriginalName();
                $fileNames[] = $filename;
                $file->storeAs( 'datafiles/' . $request->input('post-code') . '/' . strtoupper($request->input('file-type')), $filename, 'public' );
            }

            $this->addDataFilesToDatabase($examInfo, $fileNames);

            return redirect()->back()->with('success', 'Data file was uploaded successfully!');

        }

        return redirect()->back()->with('error', 'No files were uploaded! Check for issues and try again.');

    }

    public function convertDataFile()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.convert-data-file', ['exam' => $currentExam]);
    }

    public function getEtypeData(){

        $currentExam = Exam::where('is_current', 1)->first();

        $datafiles = Datafile::where('exam_id', $currentExam->id)->where('file_type', 'e_type')->get();

        return view('dashboard.preli-processing.parts.etype-file-list', ['datafiles' => $datafiles]);

    }

    public function getHtypeData(){

        $currentExam = Exam::where('is_current', 1)->first();

        $datafiles = Datafile::where('exam_id', $currentExam->id)->where('file_type', 'h_type')->get();

        return view('dashboard.preli-processing.parts.htype-file-list', ['datafiles' => $datafiles]);

    }

    public function convertDueDataFilesToSQL(Request $request)
    {
        $exam_id = $request->exam_id;
        $post_code = $request->post_code;
        $file_type = $request->file_type;

        $files = Datafile::where('exam_id', $exam_id)->where('post_code', $post_code)->where('file_type', $file_type)->where('conversion_status', 0)->get();

        $result = null;

        foreach($files as $file)
        {
            $result = $this->processRawDataFileToSQL($file->post_code, $file->bnd_number,$file->file_type, $file->file_name);

            Datafile::where('id', $file->id)->update(['conversion_status' => 1]);
        }

        if( $result ){
            return redirect('convert-data-file')->with('success', 'Data files were converted successfully.');
        }

        return redirect('convert-data-file')->with('error', 'There were some issues converting data files!');
    }

    public function generateHexcodeView()
    {
        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.generate-hexcode', ['exam' => $currentExam]);
    }

    public function generateETypeHexcode(Request $request)
    {
        $postCode = $request->postcode;

        $eTypeDataByPostCode = DB::table('etype_data')->where('post_code', $postCode)->where('litho_issue', '!==', 1)->get();

        $hexArray = [];

        foreach( $eTypeDataByPostCode as $row )
        {
            $hexcode1 = '';
            $hexcode2 = '';

            if( !empty($row->litho_code1) && empty($row->hex_code1) )
            {
                $hexcode1 = $this->convertLithoCodeToHexCode($row->litho_code1);
            }
            else{
                continue;
            }

            if( !empty($row->litho_code2) && empty($row->hex_code2) )
            {
                $hexcode2 = $this->convertLithoCodeToHexCode($row->litho_code2);
            }
            else{
                continue;
            }

            $hexArray[] = [
                'id' => $row->id,
                'hex_code1' => $hexcode1,
                'hex_code2' => $hexcode2,
            ];
        }

        DB::transaction(function () use ($hexArray) {
            foreach ($hexArray as $data) {
                DB::table('etype_data')->where('id', $data['id'])
                ->update([
                    'hex_code1' => strtoupper($data['hex_code1']),
                    'hex_code2' => strtoupper($data['hex_code2'])
                ]);
            }
        });

        return redirect()->back()->with('success', 'All E-TYPE LITHO CODE were successfully converted to HEX CODE.');

    }

    public function generateHTypeHexcode(Request $request)
    {
        $postCode = $request->postcode;

        $hTypeDataByPostCode = DB::table('htype_data')->where('post_code', $postCode)->where('litho_issue', '!==', 1)->get();

        $hexArray = [];

        foreach( $hTypeDataByPostCode as $row )
        {
            $hexcode1 = '';
            $hexcode2 = '';

            if( !empty($row->litho_code1) && empty($row->hex_code1))
            {
                $hexcode1 = $this->convertLithoCodeToHexCode($row->litho_code1);
            }

            if( !empty($row->litho_code2) && empty($row->hex_code2) )
            {
                $hexcode2 = $this->convertLithoCodeToHexCode($row->litho_code2);
            }

            $hexArray[] = [
                'id' => $row->id,
                'hex_code1' => $hexcode1,
                'hex_code2' => $hexcode2,
            ];

        }

        DB::transaction(function () use ($hexArray) {
            foreach ($hexArray as $data) {
                DB::table('htype_data')->where('id', $data['id'])
                ->update([
                    'hex_code1' => strtoupper($data['hex_code1']),
                    'hex_code2' => strtoupper($data['hex_code2'])
                ]);
            }
        });

        return redirect()->back()->with('success', 'All H-TYPE LITHO CODE were successfully converted to HEX CODE.');

    }

    public function solveDataView(Request $request)
    {
        $fileType = $request->file_type ?? 'e_type';
        $issueType = $request->issue_type ?? 'all';
        $tableName = 'etype_data';

        if($fileType == 'h_type'){
            $tableName = 'htype_data';
        }

        $query = DB::table($tableName);

        if( $issueType == 'center_issue' ){
           $query->where('center_issue', 1);
        }
        else if( $issueType == 'set_code_issue' ){
            $query->where('set_code_issue', 1);
        }
        else if( $issueType == 'reg_number_issue' ){
            $query->where('reg_number_issue', 1);
        }
        else if( $issueType == 'litho_issue' ){
            $query->where('litho_issue', 1);
        }
        else if( $issueType == 'hex_issue' ){
            $query->where('hex_issue', 1);
        }
        else{
            $query->where('center_issue', 1)->orWhere('reg_number_issue', 1)->orWhere('set_code_issue', 1)->orWhere('litho_issue', 1)->orWhere('hex_issue', 1);
        }

        $returnedData = $query->get();

        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.solve-data', [
            'data' => $returnedData,
            'exam' => $currentExam,
        ]);

    }

    public function solveDataViewH(Request $request)
    {
        $fileType = $request->file_type ?? 'h_type';
        $issueType = $request->issue_type ?? 'all';
        $tableName = 'htype_data';

        $returnedData = DB::table($tableName)->where('litho_issue', 1)->orWhere('hex_issue', 1)->get();

        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.solve-data-h', [
            'data' => $returnedData,
            'exam' => $currentExam,
        ]);

    }

    public function issueDataView(Request $request)
    {
        $id = $request->id ?? '';
        $fileType = $request->file_type ?? 'e_type';
        $tableName = 'etype_data';

        if($fileType == 'h_type'){
            $tableName = 'htype_data';
        }
        
        $data = DB::table($tableName)->where('id', $id)->first();

        $currentExam = Exam::where('is_current', 1)->first();

        if($fileType == 'h_type'){
            return view('dashboard.preli-processing.view-data-h', [
                'data' => $data,
                'exam' => $currentExam,
            ]);
        }
        else{
            return view('dashboard.preli-processing.view-data', [
                'data' => $data,
                'exam' => $currentExam,
            ]);
        }
    }

    public function editIssueDataView(Request $request)
    {
        $id = $request->id ?? '';
        $fileType = $request->file_type ?? 'e_type';
        $tableName = 'etype_data';

        if($fileType == 'h_type'){
            $tableName = 'htype_data';
        }
        
        $data = DB::table($tableName)->where('id', $id)->first();

        $currentExam = Exam::where('is_current', 1)->first();

        if($fileType == 'h_type'){
            return view('dashboard.preli-processing.edit-data-h', [
                'data' => $data,
                'exam' => $currentExam,
                'file_type' => $fileType,
            ]);
        }
        else{
             return view('dashboard.preli-processing.edit-data', [
                'data' => $data,
                'exam' => $currentExam,
                'file_type' => $fileType,
            ]);
        }
    }

    public function editDataProcessing(Request $request)
    {
        $receivedData = json_decode( $request->input('allFormData') );

        $dataId = $receivedData->data_id;
        $dataType = $receivedData->data_type;
        $bndNumber = $receivedData->bnd_number;
        $scanSr = $receivedData->scan_sr;
        $lithoCode1 = $receivedData->litho_code1;
        $lithoCode2 = $receivedData->litho_code2;
        $centerCode = $receivedData->center ?? '';
        $regNumber = $receivedData->reg_number ?? '';
        $setCode = $receivedData->set_code ?? '';

        $tableName = 'etype_data';

        $result = DB::table($tableName)->where('id', $dataId)->update([
            'bnd_number' => $bndNumber,
            'litho_code1' => $lithoCode1,
            'litho_code2' => $lithoCode2,
            'center' => $centerCode,
            'reg_number' => $regNumber,
            'set_code' => $setCode,
            'update_status' => 'UPDATED',
            'solve_status' => '1',
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        $status = [];

        if($result){
            $status['status'] = 'success';
        }
        else{
            $status['status'] = 'error';
        }

        return $status;

    }

    public function editDataProcessingH(Request $request)
    {
        $receivedData = json_decode( $request->input('allFormData') );

        $dataId = $receivedData->data_id;
        $dataType = $receivedData->data_type;
        $bndNumber = $receivedData->bnd_number;
        $scanSr = $receivedData->scan_sr;
        $lithoCode1 = $receivedData->litho_code1;
        $lithoCode2 = $receivedData->litho_code2;

        $tableName = 'htype_data';

        $result = DB::table($tableName)->where('id', $dataId)->update([
            'bnd_number' => $bndNumber,
            'litho_code1' => $lithoCode1,
            'litho_code2' => $lithoCode2,
            'update_status' => 'CHANGED',
            'solve_status' => '1',
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now()
        ]);

        $status = [];

        if($result){
            $status['status'] = 'success';
        }
        else{
            $status['status'] = 'error';
        }

        return $status;

    }

    private function convertLithoCodeToHexCode( $lithoCode )
    {

        if( strlen($lithoCode) !== 31 ){
            return '';
        }

        //Split lithocode
        $lithoDirection = 'ltr';

        $lithoPart1 = str_replace( ' ', '0', substr($lithoCode, 0, 4) );
        $lithoPart2 = str_replace( ' ', '0', substr($lithoCode, 4, 4) );
        $lithoPart3 = str_replace( ' ', '0', substr($lithoCode, 8, 4) );
        $lithoPart4 = str_replace( ' ', '0', substr($lithoCode, 12, 4) );
        $lithoPart5 = str_replace( ' ', '0', substr($lithoCode, 16, 4) );
        $lithoPart6 = str_replace( ' ', '0', substr($lithoCode, 20, 4) );
        $lithoPart7 = str_replace( ' ', '0', substr($lithoCode, 24, 4) );
        $lithoPart8 = str_pad( str_replace( ' ', '0', substr($lithoCode, 28, 3) ), 4, '0' );

        $hexCode = dechex( bindec($lithoPart1) ) . dechex( bindec($lithoPart2) ) . dechex( bindec($lithoPart3) ) . dechex( bindec($lithoPart4) ) . dechex( bindec($lithoPart5) ) . dechex( bindec($lithoPart6) ) . dechex( bindec($lithoPart7) ) . dechex( bindec($lithoPart8) );

        return $hexCode;

    }

    private function addDataFilesToDatabase(array $examInfo, array $fileNames)
    {
        foreach($fileNames as $file){

            $fileNameParts = explode(".", $file);
            $bndNo = substr($fileNameParts[0], -3);

            $inserted = Datafile::create([
                'exam_id' => $examInfo['exam_id'],
                'post_code' => $examInfo['post_code'],
                'bnd_number' => $bndNo,
                'file_type' => $examInfo['file_type'],
                'file_name' => $file,
            ]);

        }
    }

    private function processRawDataFileToSQL($post_code, $bnd_number, $file_type, $file_name)
    {
        $contents = null;
        $data = [];
        $table = 'etype_data';

        if( Storage::disk('public')->exists('datafiles/'.$post_code.'/'.strtoupper($file_type).'/'.$file_name) ) 
        {
            $contents = Storage::disk('public')->get('datafiles/'.$post_code.'/'.strtoupper($file_type).'/'.$file_name);
        }

        if( $contents != null && $file_type == 'e_type' )
        {
            $lines = explode("\n", $contents);

            $dataLineConfigs = DB::table('datalines')->where('script_type', 'e_type')->orderBy('part_sequence', 'ASC')->get();

            foreach ($lines as $line) 
            {
                $start = 0;

                $scan_sr = null;
                $litho1 = null;
                $center = null;
                $reg = null;
                $set = null;
                $litho2 = null;
                $bullet = null;
                $lithDirection = 'LTR';
                
                if(trim($line) != "" && trim($line) != null)
                {
                    foreach( $dataLineConfigs as $config )
                        {
                        if( $config->part_title === 'scan_sr' )
                        {
                            $scan_sr = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'litho_code1' )
                        {
                            $litho1 = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'center' )
                        {
                            $center = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'reg_number' )
                        {
                            $reg = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'set_code' )
                        {
                            $set = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'litho_code2' )
                        {
                            $litho2 = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'bullet' )
                        {
                            $bullet = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'litho_direction' )
                        {
                            if($config->length === 2)
                            {
                                $lithDirection = 'RTL';
                            }
                            
                        }
                    }

                    $data[] = [
                        'post_code' => $post_code,
                        'bnd_number' => $bnd_number,
                        'scan_bnd_number' => $bnd_number,
                        'scan_sr' => $scan_sr,
                        'litho_code1' => $litho1,
                        'scan_litho_code1' => $litho1,
                        'hex_code1' => '',
                        'center' => $center,
                        'scan_center' => $center,
                        'center_status' => '',
                        'reg_number' => $reg,
                        'scan_reg_number' => $reg,
                        'reg_number_status' => '',
                        'set_code' => $set,
                        'scan_set_code' => $set,
                        'litho_code2' => $litho2,
                        'scan_litho_code2' => $litho2,
                        'hex_code2' => '',
                        'bullet' => $bullet,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }
        }

        if( $contents != null && $file_type == 'h_type' )
        {
            $table = 'htype_data';

            $dataLineConfigs = DB::table('datalines')->where('script_type', 'h_type')->orderBy('part_sequence', 'ASC')->get();
            
            $lines = explode("\n", $contents);

            foreach ($lines as $line) 
            {
                $start = 0;

                $scan_sr = null;
                $litho1 = null;
                $answers = null;
                $litho2 = null;
                $bullet = null;
                $lithDirection = 'LTR';

                if(trim($line) != "" && trim($line) != null)
                {
                    foreach( $dataLineConfigs as $config )
                        {
                        if( $config->part_title === 'scan_sr' )
                        {
                            $scan_sr = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'litho_code1' )
                        {
                            $litho1 = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'answers' )
                        {
                            $answers = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'litho_code2' )
                        {
                            $litho2 = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'bullet' )
                        {
                            $bullet = substr($line, $start, $config->length);
                            $start += $config->length;
                        }
                        else if( $config->part_title === 'litho_direction' )
                        {
                            if($config->length === 2)
                            {
                                $lithDirection = 'RTL';
                            }
                            
                        }
                    }

                    $data[] = [
                        'post_code' => $post_code,
                        'bnd_number' => $bnd_number,
                        'scan_bnd_number' => $bnd_number,
                        'scan_sr' => $scan_sr,
                        'litho_code1' => $litho1,
                        'scan_litho_code1' => $litho1,
                        'hex_code1' => '',
                        'answers' => $answers,
                        'litho_code2' => $litho2,
                        'scan_litho_code2' => $litho2,
                        'hex_code2' => '',
                        'bullet' => $bullet,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];
                }
            }
        }

        DB::table( $table )->insert( $data );

        return true;

    }

    public function uploadRegiFileView()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $regiFile = Regifile::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->first();

        return view('dashboard.preli-processing.upload-regi-file', [
            'exam' => $currentExam,
            'regiFile' => $regiFile,
        ]);
    }

    public function uploadRegiFileProcessor(Request $request)
    {
        $validated = $request->validate([
            'exam-id' => 'required',
            'post-code' => 'required',
            'file-type' => 'required',
            'regifile' => 'required|file',
            'regifile.*' => 'extensions:csv',
        ]);

        $examInfo = [
            'exam_id' => $request->input('exam-id'),
            'post_code' => $request->input('post-code'),
            'file_type' => $request->input('file-type'),
        ];

        if ($request->hasFile('regifile')) {

            $filename = $request->input('exam-id') . '_' . $request->input('post-code') . '_' . $request->file('regifile')->getClientOriginalName();
            
            $request->file('regifile')->storeAs( 'datafiles/' . $request->input('post-code') . '/' . strtoupper($request->input('file-type')), $filename, 'public' );

            $inserted = Regifile::create([
                'exam_id' => $examInfo['exam_id'],
                'post_code' => $examInfo['post_code'],
                'file_type' => $examInfo['file_type'],
                'file_name' => $filename,
            ]);

            return redirect()->back()->with('success', 'Regi file was uploaded successfully!');

        }

        return redirect()->back()->with('error', 'No file was uploaded! Check for issues and try again.');

    }

    public function convertRegiFile()
    {
        $currentExam = Exam::where('is_current', 1)->first();
        $regiFile = Regifile::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->first();

        $post_code = $regiFile->post_code;
        $file_type = $regiFile->file_type;
        $file_name = $regiFile->file_name;

        $contents = '';

        if( Storage::disk('public')->exists('datafiles/'.$post_code.'/'.strtoupper($file_type).'/'.$file_name) ) 
        {
            $contents = Storage::disk('public')->get('datafiles/'.$post_code.'/'.strtoupper($file_type).'/'.$file_name);
        }
        else{
            return redirect()->back()->with('error', '404 - File not found.');
        }

        // Get file content
        $csvData = $contents;

        // Convert CSV string to array
        $rows = array_map('str_getcsv', explode("\n", trim($csvData)));

        // Optionally extract headers
        $header = array_shift($rows);

        // Combine headers with data rows (associative array)
        $data = [];
        $count = 0;
        foreach ($rows as $row) {
            if (count($row) == count($header)) {
                $data[$count] = array_combine($header, $row);
                $data[$count]['exam_id'] = $currentExam->id;
                $data[$count]['post_code'] = $currentExam->post_code;
                $count++;
            }
        }

        DB::table('candidates')->truncate();

        $result = Candidate::insert($data);

        if($result){
            Regifile::where('exam_id', $currentExam->id)->where('post_code', $currentExam->post_code)->update([
                'conversion_status' => 1
            ]);
        }

        return redirect()->back()->with('success', 'CSV files data were converted and placed to database table successfully.');
    }

}
