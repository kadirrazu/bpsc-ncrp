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

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add / </span>Exam</h4>

    <!-- Basic Form -->
     <div class="row mb-6 gy-6">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ url('add-exam') }}">

                        @csrf

                        <div class="row mb-4">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Exam Management Authority:</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <input type="text" class="form-control" name="exam-authority" value="{{ old('exam-authority') ? old('exam-authority') : 'BPSC' }}">
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
                                    <input type="text" class="form-control" name="exam-entity" value="{{ old('exam-entity') ? old('exam-entity') : '' }}">
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
                                    <input type="text" class="form-control" name="exam-post-code" value="{{ old('exam-post-code') ? old('exam-post-code') : '' }}">
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
                                    <input type="text" class="form-control" name="exam-post-name" value="{{ old('exam-post-name') ? old('exam-post-name') : '' }}">
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
                                    <input type="number" class="form-control" name="exam-post-grade" value="{{ old('exam-post-grade') ? old('exam-post-grade') : '' }}">
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
                                            <option value="{{ $examType }}" {{ old('exam-type') == $examType ? 'selected' : '' }}>{{ $examType }}</option>
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
                                    <input type="date" class="form-control" name="exam-date" value="{{ old('exam-date') ? old('exam-date') : '' }}">
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
                                    <input type="date" class="form-control" name="exam-rp-date" value="{{ old('exam-rp-date') ? old('exam-rp-date') : '' }}">
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
                                    <input type="number" class="form-control" name="exam-total-candidate" value="{{ old('exam-total-candidate') ? old('exam-total-candidate') : '' }}">
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
                                    <input type="number" class="form-control" name="exam-present-candidate" value="{{ old('exam-present-candidate') ? old('exam-present-candidate') : '' }}">
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
                                            <option value="{{ $status }}" {{ old('exam-rp-status') == $status ? 'selected' : '' }}>{{ $status }}</option>
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
                                    <input type="checkbox" name="exam-rp-current" id="exam-rp-current" class="form-check-input" {{ old('exam-rp-current') ? 'checked="checked"' : '' }}>
                                </div>
                                @error('exam-rp-current')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-success">Add Exam</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
     </div>
    <!--/ Basic Form -->

</x-layout-dashboard>