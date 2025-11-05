@php

$fileTypes = [
    'e_type',    
    'h_type',    
];

@endphp

<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Issues Marking / </span>Generate Issue Status</h4>

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            @if( !isset($exam) || $exam == null) 

                <p class="alert alert-danger mb-0">Please add an exam first and set that as Current Task for processing.</p>

            @else

            <form method="POST" action="{{ url('upload-data-file') }}" enctype="multipart/form-data">

                @csrf

                <input type="hidden" name="exam-id" value="{{ $exam->id }}">

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
                            <input type="text" class="form-control" name="post-code" value="{{ $exam->post_code .' - '. $exam->post_name}}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <div id="mark-regi-issues">
                            <a class="btn btn-secondary my-2" href="{{ url('mark-regi-issues') }}" x-target="mark-regi-issues">
                                MARK REG NUMBER ISSUES (E-TYPE DATA)
                            </a>
                        </div>
                        <div id="mark-setcode-issues">
                            <a class="btn btn-secondary my-2" href="{{ url('mark-setcode-issues') }}" x-target="mark-setcode-issues">
                                MARK SET CODE ISSUES (E-TYPE DATA)
                            </a>
                        </div>                        
                        <div id="mark-center-issues">
                            <a class="btn btn-secondary my-2" href="{{ url('mark-center-issues') }}" x-target="mark-center-issues">
                                MARK CENTER CODE ISSUES (E-TYPE DATA)
                            </a>
                        </div>
                        <div id="mark-lithocode-issues">
                            <a class="btn btn-secondary my-2" href="{{ url('mark-lithocode-issues') }}" x-target="mark-lithocode-issues">
                                MARK LITHO CODE ISSUES (E-TYPE DATA)
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <div id="mark-lithocode-issues-htype">
                            <a class="btn btn-info my-2" href="{{ url('mark-lithocode-issues-htype') }}" x-target="mark-lithocode-issues-htype">
                                MARK LITHO CODE ISSUES (H-TYPE DATA)
                            </a>
                        </div>
                    </div>
                </div>

            </form>

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>