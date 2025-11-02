<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExamManagementRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;

class ExamManagementController extends Controller
{
    public function addNewExam()
    {
        return view('dashboard.exam.add');
    }

    public function addNewExamCommit(StoreExamManagementRequest $request)
    {
        
        $validatedData = $request->validated();

        $exam = new Exam();

        $exam->authority = $validatedData['exam-authority'];
        $exam->entity = $validatedData['exam-entity'];
        $exam->post_code = $validatedData['exam-post-code'];
        $exam->post_name = $validatedData['exam-post-name'];
        $exam->grade = $validatedData['exam-post-grade'];
        $exam->type = $validatedData['exam-type'];
        $exam->exam_date = $validatedData['exam-date'];
        $exam->rp_date = $validatedData['exam-rp-date'];
        $exam->total_candidate = $validatedData['exam-total-candidate'];
        $exam->present_candidate = $validatedData['exam-present-candidate'];
        $exam->rp_status = $validatedData['exam-rp-status'];
        $exam->is_current = $validatedData['exam-rp-current'] == 'on' ? 1 : 0;

        if( $validatedData['exam-rp-current'] == 'on' ){
            $this->setAllExamToNonCurrent();
        }

        $exam->save();

        return redirect('/list-exam')->with('success', 'Exam was added successfully.');
        
    }
    
    public function viewExamList()
    {
        $exams = Exam::paginate(10);

        return view('dashboard.exam.list', ['exams' => $exams]);
    }
    
    public function viewExam(Request $request)
    {
        $exam = Exam::findOrFail($request->id);

        return view('dashboard.exam.show', ['exam' => $exam]);
    }

    public function editExam(Request $request){

        $exam = Exam::findOrFail($request->id);

        return view('dashboard.exam.edit', ['exam' => $exam]);

    }

    public function editExamCommit(StoreExamManagementRequest $request){

        $validatedData = $request->validated();

        $exam = Exam::findOrFail( $request->exam_id );

        $exam->authority = $validatedData['exam-authority'];
        $exam->entity = $validatedData['exam-entity'];
        $exam->post_code = $validatedData['exam-post-code'];
        $exam->post_name = $validatedData['exam-post-name'];
        $exam->grade = $validatedData['exam-post-grade'];
        $exam->type = $validatedData['exam-type'];
        $exam->exam_date = $validatedData['exam-date'];
        $exam->rp_date = $validatedData['exam-rp-date'];
        $exam->total_candidate = $validatedData['exam-total-candidate'];
        $exam->present_candidate = $validatedData['exam-present-candidate'];
        $exam->rp_status = $validatedData['exam-rp-status'];
        $exam->is_current = (isset($validatedData['exam-rp-current']) && $validatedData['exam-rp-current'] == 'on') ? 1 : 0;

        $exam->save();

        return redirect('/list-exam')->with('success', 'Exam information was updated successfully.');

    }

    public function deleteExamCommit(Request $request){

        $exam = Exam::find( $request->id );
 
        $exam->delete();

        return redirect('/list-exam')->with('error', 'Exam information was deleted successfully.');
    }

    public function setExamAsCurrent(Request $request){

        $this->setAllExamToNonCurrent();

        $exam = Exam::where('id', $request->id)->update(['is_current' => 1]);

        return redirect('/list-exam')->with('info', 'Exam status was changed as current successfully.');

    }

    private function setAllExamToNonCurrent()
    {
        Exam::where('id', '>', 0)->update(['is_current' => 0]);
    }

}

