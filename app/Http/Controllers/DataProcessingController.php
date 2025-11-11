<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Exam;
use App\Models\Datafile;

use Carbon\Carbon;

class DataProcessingController extends Controller
{

    public function configureRawDataLines()
    {
        return view('dashboard.preli-processing.configure-data-line');
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

            $updated = DB::table('etype_data')->where('id', $row->id)->update([
                'hex_code1' => strtoupper($hexcode1),
                'hex_code2' => strtoupper($hexcode2)
            ]);
        }

        return redirect()->back()->with('success', 'All E-TYPE LithoCodes were converted to HexCodes successfully.');

    }

    public function generateHTypeHexcode(Request $request)
    {
        $postCode = $request->postcode;

        $hTypeDataByPostCode = DB::table('htype_data')->where('post_code', $postCode)->where('litho_issue', '!==', 1)->get();

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

            $updated = DB::table('htype_data')->where('id', $row->id)->update([
                'hex_code1' => strtoupper($hexcode1),
                'hex_code2' => strtoupper($hexcode2)
            ]);
        }

        return redirect()->back()->with('success', 'All H-TYPE LithoCodes were converted to HexCodes successfully.');

    }

    public function solveDataView(Request $request)
    {
        $fileType = $request->file_type ?? 'e_type';
        $issueType = $request->issue_type ?? 'all';
        $tableName = 'etype_data';

        if($fileType == 'h_type'){
            $tableName = 'htype_data';
        }

        $eTypeData = DB::table($tableName)->where('center_issue', 1)->orWhere('reg_number_issue', 1)->orWhere('set_code_issue', 1)->orWhere('litho_issue', 1)->orWhere('hex_issue', 1)->get();

        $currentExam = Exam::where('is_current', 1)->first();

        return view('dashboard.preli-processing.solve-data', [
            'data' => $eTypeData,
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

        return view('dashboard.preli-processing.view-data', [
            'data' => $data,
            'exam' => $currentExam,
        ]);
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

        return view('dashboard.preli-processing.edit-data', [
            'data' => $data,
            'exam' => $currentExam,
            'file_type' => $fileType,
        ]);
    }

    public function editDataProcessing(Request $request)
    {
        // Validate the incoming data
        /*$request->validate([
            'data_id' => 'required|integer',
            'data_type' => 'required|string',
            'bnd_number' => 'required|string',
            'scan_sr' => 'required|integer',
            'litho_code1' => 'required|string',
            'litho_code2' => 'required|string',
        ]);*/

        // Return a JSON response
        return response()->json(['message' => $request->all()]);
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

            foreach ($lines as $line) 
            {
                if(trim($line) != "" && trim($line) != null)
                {
                    $scan_sr = substr($line, 0, 10);
                    $litho1 = substr($line, 10, 31);
                    $center = substr($line, 41, 1);
                    $reg = substr($line, 42, 6);
                    $set = substr($line, 48, 1);
                    $litho2 = substr($line, 49, 31);
                    $bullet = substr($line, 80, 9);

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
                        'set_code_status' => $set,
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
            
            $lines = explode("\n", $contents);

            foreach ($lines as $line) 
            {
                if(trim($line) != "" && trim($line) != null)
                {
                    $scan_sr = substr($line, 0, 10);
                    $litho1 = substr($line, 10, 31);
                    $answers = substr($line, 41, 100);
                    $litho2 = substr($line, 141, 31);
                    $bullet = substr($line, 177, 9);

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

}
