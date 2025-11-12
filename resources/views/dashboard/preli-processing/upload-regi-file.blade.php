<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Upload Regi File / </span>CSV ONLY</h4>

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            @if( !isset($exam) || $exam == null) 

                <p class="alert alert-danger mb-0">Please add an exam first and set that as Current Task for processing.</p>

            @else

                @if( isset($regiFile) && $regiFile->post_code === $exam->post_code )

                <h5>Existing registration file for this exam - </h5>

                <table class="table table-bordered">
                    <tr class="text-center">
                        <th>File Name</th>
                        <th>Conversion Status</th>
                        <th>Action Button</th>
                    </tr>
                    <tr class="text-center">
                        <td>{{ $regiFile->file_name }}</td>
                        <td>
                            {!! ($regiFile->conversion_status === 1) ? '<i class="icon-base bx bx-check-circle text-success"></i></span>' : '<span class="icon-base bx bx-x-circle text-danger"></span>' !!}
                        </td>
                        <td>
                            @if( $regiFile->conversion_status === 0 )    
                                <a href="{{ url('convert-regi-file') }}" class="btn btn-sm btn-primary">Convert File to SQL</a>
                            @else
                                <span class="text-info">CONVERSION DONE</span>
                            @endif
                        </td>
                    </tr>
                </table>

                @else

                <form method="POST" action="{{ url('upload-regi-file') }}" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="exam-id" value="{{ $exam->id }}">
                    <input type="hidden" name="post-code" value="{{ $exam->post_code }}">

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Ministry / Division / Organization</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="exam-entity" value="{{ $exam->entity }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Post Code & Title</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="pc" value="{{ $exam->post_code }} - {{ $exam->post_name }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-company">File Type</label>
                        <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i class="icon-base bx bx-abacus"></i></span>
                                <select class="form-select" name="file-type">
                                    <option value="">Plese pick a File Type</option>
                                    <option value="REGI_FILE" {{ old('file-type') == 'REGI_FILE' ? 'selected' : '' }}>REGI_FILE</option>
                                </select>
                            </div>
                            @error('file-type')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Choose Regi File</label>
                        <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i class="icon-base bx bx-file"></i></span>
                                <input class="form-control" type="file" name="regifile" id="regi-file">
                            </div>
                            @error('regifile')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Upload Regi File</button>
                        </div>
                    </div>

                </form>

                <div class="text-info mt-4 mb-3">
                    <em>Mandatory Columns of CSV File: reg_number, name</em>
                    <br><br>
                    <em>Optional Columns of CSV File: user_id, dob, district, center_code</em>
                </div>

                @endif

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>