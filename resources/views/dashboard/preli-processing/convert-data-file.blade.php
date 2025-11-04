@php

$fileTypes = [
    'e_type',    
    'h_type',    
];

@endphp

<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Data File / </span>Conversion Wizard</h4>

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
                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Post Code</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control" name="post-code" value="{{ $exam->post_code }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Post Title</label>
                    <div class="col-sm-10">
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control" name="post-title" value="{{ $exam->post_name }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <div id="etype-file-list">
                            <a class="btn btn-secondary" href="{{ url('get-etype-data') }}" x-target="etype-file-list">LOAD E-TYPE DATA FILE INFORMATION</a>
                        </div>
                    </div>
                </div>

            </form>

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>