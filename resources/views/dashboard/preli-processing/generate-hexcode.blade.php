@php

$fileTypes = [
    'e_type',    
    'h_type',    
];

@endphp

<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Hexcode / </span>Generate Hexcode</h4>

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

            </form>

            <div class="row mb-4">
                <label class="col-sm-2"></label>
                <div class="col-sm-10">
                    <div class="row hexcode-handling">
                        <div class="col-md-6">
                            <div id="mark-regi-issues">
                                <table class="table border table-borderless mb-2">
                                    <tr>
                                        <th>Hexcode Generation (E-TYPE)</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="btn btn-sm btn-primary my-2" href="{{ url('generate-etype-hexcodes/' . $exam->post_code) }}">
                                                Generate E-Type Hexcode
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="mark-regi-issues">
                                <table class="table border table-borderless mb-2">
                                    <tr>
                                        <th>Hexcode Generation (H-TYPE)</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <a class="btn btn-sm btn-info my-2" href="{{ url('generate-htype-hexcodes/' . $exam->post_code) }}">
                                                Generate H-Type Hexcode
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>