@php

    $examTypes = [
        'Preliminary (MCQ)',    
        'Written (General Post)',    
        'Written (Technical Post)',    
    ];

    $rpStatus = [
        'Initiated',    
        'Ongoing',    
        'Finalized',    
    ];

@endphp

<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit Exam / </span>{{ $exam->post_name }} ({{ $exam->post_code }}) - {{ $exam->entity }}</h4>

    <!-- Basic Form -->
     <div class="row mb-6 gy-6">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body">
                        <form method="POST" action="{{ url('edit-exam') }}">

                        @csrf

                        <input type="hidden" name="exam_id" value="{{ $exam->id }}">

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Exam Management Authority:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="exam-authority" value="{{ $exam->authority ? $exam->authority : old('exam-authority') }}">
                                </div>
                                @error('exam-authority')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Ministry / Division / Organization:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="exam-entity" value="{{ $exam->entity ? $exam->entity : old('exam-entity') }}">
                                </div>
                                @error('exam-entity')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Post Code:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="exam-post-code" value="{{ $exam->post_code ? $exam->post_code : old('exam-post-code') }}">
                                </div>
                                @error('exam-post-code')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Post Name:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="exam-post-name" value="{{ $exam->post_name ? $exam->post_name : old('exam-post-name') }}">
                                </div>
                                @error('exam-post-name')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Post Grade:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" name="exam-post-grade" value="{{ $exam->grade ? $exam->grade : old('exam-post-grade') }}">
                                </div>
                                @error('exam-post-grade')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Exam Type</label>
                            <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i class="icon-base bx bx-badge"></i></span>
                                    <select class="form-select" name="exam-type">

                                        <option value="">Plese pick a Type</option>

                                        @foreach($examTypes as $examType)
                                            <option value="{{ $examType }}" {{ ( ($exam->type == $examType) || (old('exam-type') == $examType))  ? 'selected' : '' }}>{{ $examType }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                @error('exam-type')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Exam Date:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="date" class="form-control" name="exam-date" value="{{ $exam->exam_date ? $exam->exam_date : old('exam-date') }}">
                                </div>
                                @error('exam-date')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Result Processing Date:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="date" class="form-control" name="exam-rp-date" value="{{ $exam->rp_date ? $exam->rp_date : old('exam-rp-date') }}">
                                </div>
                                @error('exam-rp-date')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Total Candidates:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" name="exam-total-candidate" value="{{ $exam->total_candidate ? $exam->total_candidate : old('exam-total-candidate') }}">
                                </div>
                                @error('exam-total-candidate')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Present Candidates:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="number" class="form-control" name="exam-present-candidate" value="{{ $exam->present_candidate ? $exam->present_candidate : old('exam-present-candidate') }}">
                                </div>
                                @error('exam-present-candidate')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Result Processing Status</label>
                            <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-company2" class="input-group-text"><i class="icon-base bx bx-abacus"></i></span>
                                    <select class="form-select" name="exam-rp-status">

                                        <option value="">Plese pick a Status</option>

                                        @foreach($rpStatus as $status)
                                            <option value="{{ $status }}" {{ (($exam->rp_status == $status) || (old('exam-rp-status') == $status)) ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                        
                                    </select>
                                </div>
                                @error('exam-rp-status')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Set as Current Task:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="checkbox" name="exam-rp-current" id="exam-rp-current" class="form-check-input" {{ (($exam->is_current == 1) || (old('exam-rp-current') == 'on')) ? 'checked="checked"' : '' }}>
                                </div>
                                @error('exam-rp-current')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Update Exam</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
     </div>
    <!--/ Basic Form -->

</x-layout-dashboard>