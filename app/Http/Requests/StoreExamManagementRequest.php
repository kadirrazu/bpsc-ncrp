<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExamManagementRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'exam-authority' => 'required|string',
            'exam-entity' => 'required|string',
            'exam-post-code' => 'required|numeric',
            'exam-post-name' => 'required|string',
            'exam-post-grade' => 'required|numeric|max:20',
            'exam-type' => 'required|string',
            'exam-date' => 'nullable|date',
            'exam-rp-date' => 'nullable|date',
            'exam-total-candidate' => 'nullable|string',
            'exam-present-candidate' => 'nullable|string',
            'exam-rp-status' => 'nullable|string',
            'exam-rp-current' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'exam-authority' => 'Exam Management Authority',
            'exam-entity' => 'Exam Entity',
            'exam-post-code' => 'Post Code',
            'exam-post-name' => 'Post Name',
            'exam-post-grade' => 'Grade',
            'exam-type' => 'Exam Type',
            'exam-date' => 'Exam Date',
            'exam-rp-date' => 'Result Processing Date',
            'exam-total-candidate' => 'Total Candidate',
            'exam-present-candidate' => 'Present Candidate',
            'exam-rp-status' => 'Result Processing Status',
            'exam-rp-current' => 'Current Status',
        ];
    }
}
