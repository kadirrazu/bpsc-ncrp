<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Upload Amswer Key File / </span>PLAIN TEXT FILE</h4>

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            @if( !isset($exam) || $exam == null) 

                <p class="alert alert-danger mb-0">Please add an exam first and set that as Current Task for processing.</p>

            @else

                @if( isset($answerFile) && $answerFile->post_code === $exam->post_code )

                    <h5 class="fw-bold mb-2">
                        <span class="text-info">{{ $exam->post_code .' - '. $exam->post_name}}</span> [ {{ $exam->entity }} ]</td>
                    </h5>

                    <h6 class="text-success mt-3">EXISTING ANSWER KEY FILE FOR THIS EXAM - </h6>

                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>File Name</th>
                            <th>Conversion Status</th>
                            <th>Action Button</th>
                        </tr>
                        <tr class="text-center">
                            <td>{{ $answerFile->file_name }}</td>
                            <td>
                                {!! ($answerFile->conversion_status === 1) ? '<i class="icon-base bx bx-check-circle text-success"></i></span>' : '<span class="icon-base bx bx-x-circle text-danger"></span>' !!}
                            </td>
                            <td>
                                @if( $answerFile->conversion_status === 0 )    
                                    <a href="{{ url('convert-answer-file') }}" class="btn btn-sm btn-primary">Convert DATA and Import to MySQL</a>
                                @else
                                    <span class="text-info">CONVERSION DONE</span>
                                @endif
                            </td>
                        </tr>
                    </table>

                    @if($answerFile->conversion_status === 1)
                        <div class="mark-generation mt-4" x-data="{
                            confirm : function(event){
                                result = confirm('Sure? You want to calculate candidates mark?');
                                if( result === false){
                                    event.preventDefault()
                                }
                            }
                        }">
                            <a href="{{ url('calculate-marks') }}" class="btn btn-success" @click="confirm">Calculate Marks</a>
                        </div>
                    @endif

                @else

                <form method="POST" action="{{ url('upload-answer-file') }}" enctype="multipart/form-data">

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
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">File Type</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="file-type" value="ANSWER_FILE" readonly>
                            </div>
                            @error('file-type')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Choose Answer Key File</label>
                        <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i class="icon-base bx bx-file"></i></span>
                                <input class="form-control" type="file" name="answerfile" id="answer-file">
                            </div>
                            @error('answerfile')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Upload Answer Key File</button>
                        </div>
                    </div>

                </form>

                <div class="text-info mt-5 mb-3">
                    <p class="text-warning text-decoration-underline">Answer Key File Format:</p>
                    <em>For each set, there will be a single line in the Answer Key File.</em>
                    <br>
                    <em>In each line, 1st character will be the set number; Rest characters will be the correct answers.</em>
                </div>

                @endif

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>