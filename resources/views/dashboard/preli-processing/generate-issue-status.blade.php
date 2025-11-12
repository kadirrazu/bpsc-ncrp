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
                        <div class="row issue-handling">
                            <div class="col-md-6">
                                <div id="mark-regi-issues">
                                    <table class="table border table-borderless mb-2">
                                        <tr>
                                            <th>REG NUMBER ISSUE CHECKING (E-TYPE)</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-info">
                                                    Last Run:  

                                                    @php $regIssue = $issueReportTable->where('issue_type', 'reg_issue')->first(); @endphp
                                                    
                                                    @if( isset($regIssue->run_time) && $regIssue->run_time != '' )
                                                        {{ $regIssue->run_time }},
                                                        <span class="text-secondary">
                                                            Count: <a href="{{ url('solve-data/reg_number_issue/e_type') }}" class="text-danger text-decoration-underline" title="View Issues">{{ $regIssue->issue_count }}</a>
                                                        </span>
                                                    @else
                                                        <span class="text-danger">Never</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-primary my-2" href="{{ url('mark-regi-issues') }}">
                                                    MARK REG NUMBER ISSUES (E-TYPE DATA)
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="mark-setcode-issues">
                                    <table class="table border table-borderless mb-2">
                                        <tr>
                                            <th>SET CODE ISSUE CHECKING (E-TYPE)</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-info">
                                                    Last Run:  

                                                    @php $setIssue = $issueReportTable->where('issue_type', 'set_issue')->first(); @endphp
                                                    
                                                    @if( isset($setIssue->run_time) && $setIssue->run_time != '' )
                                                        {{ $setIssue->run_time }},
                                                        <span class="text-secondary">
                                                            Count: <a href="{{ url('solve-data/set_code_issue/e_type') }}" class="text-danger text-decoration-underline" title="View Issues">{{ $setIssue->issue_count }}</a>
                                                        </span>
                                                    @else
                                                        <span class="text-danger">Never</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-primary my-2" href="{{ url('mark-setcode-issues') }}">
                                                    MARK SET CODE ISSUES (E-TYPE DATA)
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>                        
                                <div id="mark-center-issues">
                                    <table class="table border table-borderless mb-2">
                                        <tr>
                                            <th>CENTER CODE ISSUE CHECKING (E-TYPE)</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-info">
                                                    Last Run:  

                                                    @php $centerIssue = $issueReportTable->where('issue_type', 'center_issue')->first(); @endphp
                                                    
                                                    @if( isset($centerIssue->run_time) && $centerIssue->run_time != '' )
                                                        {{ $centerIssue->run_time }},
                                                        <span class="text-secondary">
                                                            Count: <a href="{{ url('solve-data/center_issue/e_type') }}" class="text-danger text-decoration-underline" title="View Issues">{{ $centerIssue->issue_count }}</a>
                                                        </span>
                                                    @else
                                                        <span class="text-danger">Never</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-primary my-2" href="{{ url('mark-center-issues') }}">
                                                    MARK CENTER CODE ISSUES (E-TYPE DATA)
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div id="mark-lithocode-issues">
                                    <table class="table border table-borderless mb-2">
                                        <tr>
                                            <th>LITHO CODE ISSUE CHECKING (E-TYPE)</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-info">
                                                    Last Run:  

                                                    @php $lithoIssue = $issueReportTable->where('issue_type', 'litho_issue')->first(); @endphp
                                                    
                                                    @if( isset($lithoIssue->run_time) && $lithoIssue->run_time != '' )
                                                        {{ $lithoIssue->run_time }},
                                                        <span class="text-secondary">
                                                            Count: <a href="{{ url('solve-data/litho_issue/e_type') }}" class="text-danger text-decoration-underline" title="View Issues">{{ $lithoIssue->issue_count }}</a>
                                                        </span>
                                                    @else
                                                        <span class="text-danger">Never</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-primary my-2" href="{{ url('mark-lithocode-issues') }}">
                                                    MARK LITHO CODE ISSUES (E-TYPE DATA)
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="mark-lithocode-issues-htype">
                                    <table class="table border table-borderless mb-2">
                                        <tr>
                                            <th>LITHO CODE ISSUE CHECKING (H-TYPE)</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="text-info">
                                                    Last Run:  

                                                    @php $lithoIssueH = $issueReportTable->where('issue_type', 'litho_issue_htype')->first(); @endphp
                                                    
                                                    @if( isset($lithoIssueH->run_time) && $lithoIssueH->run_time != '' )
                                                        {{ $lithoIssueH->run_time }},
                                                        <span class="text-secondary">
                                                            Count: <a href="{{ url('solve-data-h/litho_issue/h_type') }}" class="text-danger text-decoration-underline" title="View Issues">{{ $lithoIssueH->issue_count }}</a>
                                                        </span>
                                                    @else
                                                        <span class="text-danger">Never</span>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a class="btn btn-sm btn-secondary my-2" href="{{ url('mark-lithocode-issues-htype') }}">
                                                    MARK LITHO CODE ISSUES (H-TYPE DATA)
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>