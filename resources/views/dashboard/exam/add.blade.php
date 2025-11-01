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
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Exam Conducting Authority:</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="exam-authority" value="BPSC">
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
                                <input type="text" class="form-control" name="exam-entity">
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
                                <input type="text" class="form-control" name="exam-post-code">
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
                                <input type="text" class="form-control" name="exam-post-name">
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
                                <input type="number" class="form-control" name="exam-post-grade">
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

                                    <option>Plese pick a Type</option>
                                    <option value="Preliminary (MCQ)">Preliminary (MCQ)</option>
                                    <option value="Written (General Post)">Written (General Post)</option>
                                    <option value="Written (Technical Post)">Written (Technical Post)</option>
                                    
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
                                <input type="date" class="form-control" name="exam-date">
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
                                <input type="date" class="form-control" name="exam-rp-date">
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
                                <input type="number" class="form-control" name="exam-total-candidate">
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
                                <input type="number" class="form-control" name="exam-present-candidate">
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

                                    <option>Plese pick a Status</option>
                                    <option value="Initiated">Initiated</option>
                                    <option value="Ongoint">Ongoint</option>
                                    <option value="Processed">Processed</option>
                                    
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
                                <input type="checkbox" name="exam-rp-current" id="exam-rp-current" class="form-check-input">
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