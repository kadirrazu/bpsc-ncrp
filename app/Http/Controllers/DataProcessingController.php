<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Datafile;

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

}
