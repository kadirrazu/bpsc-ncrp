@php

$fileTypes = [
    'e_type',    
    'h_type',    
];

@endphp

<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Issue Logs / </span>At a glance</h4>

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
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h4><span class="text-info">E-TYPE</span> DATA ISSUES -</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Reg Number Issue</td>
                                        <td class="text-center">
                                            @php $regIssue = $issueReportTable->where('issue_type', 'reg_issue')->first(); @endphp
                                                    
                                            @if( isset($regIssue->issue_count) && $regIssue->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $regIssue->issue_count }}
                                                </span>
                                            @elseif( !isset($regIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $regIssue->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($regIssue->issue_count) && $regIssue->issue_count > 0 )
                                                <a href="{{ url('solve-data/reg_number_issue/e_type') }}" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($regIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Set Code Issue</td>
                                        <td class="text-center">
                                            @php $setIssue = $issueReportTable->where('issue_type', 'set_issue')->first(); @endphp
                                                    
                                            @if( isset($setIssue->issue_count) && $setIssue->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $setIssue->issue_count }}
                                                </span>
                                            @elseif( !isset($setIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $setIssue->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($setIssue->issue_count) && $setIssue->issue_count > 0 )
                                                <a href="{{ url('solve-data/set_code_issue/e_type') }}" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($setIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Center Issue</td>
                                        <td class="text-center">
                                            @php $centerIssue = $issueReportTable->where('issue_type', 'center_issue')->first(); @endphp
                                                    
                                            @if( isset($centerIssue->issue_count) && $centerIssue->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $centerIssue->issue_count }}
                                                </span>
                                            @elseif( !isset($centerIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $centerIssue->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($centerIssue->issue_count) && $centerIssue->issue_count > 0 )
                                                <a href="{{ url('solve-data/center_issue/e_type') }}" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($centerIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Litho Code Issue</td>
                                        <td class="text-center">
                                            @php $lithoIssue = $issueReportTable->where('issue_type', 'litho_issue')->first(); @endphp
                                                    
                                            @if( isset($lithoIssue->issue_count) && $lithoIssue->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $lithoIssue->issue_count }}
                                                </span>
                                            @elseif( !isset($lithoIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $lithoIssue->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($lithoIssue->issue_count) && $lithoIssue->issue_count > 0 )
                                                <a href="{{ url('solve-data/litho_issue/e_type') }}" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($lithoIssue->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hexcode Issue</td>
                                        <td class="text-center">
                                            @php $hexIssueE = $issueReportTable->where('issue_type', 'hexcode_issue')->first(); @endphp
                                                    
                                            @if( isset($hexIssueE->issue_count) && $hexIssueE->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $hexIssueE->issue_count }}
                                                </span>
                                            @elseif( !isset($hexIssueE->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $hexIssueE->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($hexIssueE->issue_count) && $hexIssueE->issue_count > 0 )
                                                <a href="{{ url('solve-data/hex_issue/e_type') }}" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($hexIssueE->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4><span class="text-primary">H-TYPE</span> DATA ISSUES -</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Lithocode Issue</td>
                                        <td class="text-center">
                                            @php $lithoIssueH = $issueReportTable->where('issue_type', 'litho_issue_htype')->first(); @endphp
                                                    
                                            @if( isset($lithoIssueH->issue_count) && $lithoIssueH->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $lithoIssueH->issue_count }}
                                                </span>
                                            @elseif( !isset($lithoIssueH->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $lithoIssueH->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($lithoIssueH->issue_count) && $lithoIssueH->issue_count > 0 )
                                                <a href="{{ url('solve-data-h/litho_issue/h_type') }}" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($lithoIssueH->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hexcode Issue</td>
                                        <td class="text-center">
                                            @php $hexIssueH = $issueReportTable->where('issue_type', 'hexcode_issue_htype')->first(); @endphp
                                                    
                                            @if( isset($hexIssueH->issue_count) && $hexIssueH->issue_count > 0 )
                                                <span class="text-danger">
                                                    {{ $hexIssueH->issue_count }}
                                                </span>
                                            @elseif( !isset($hexIssueH->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="text-success">{{ $hexIssueH->issue_count ?? 0 }}</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if( isset($hexIssueH->issue_count) && $hexIssueH->issue_count > 0 )
                                                <a href="#" class="btn btn-primary btn-sm">View List</a>
                                            @elseif( !isset($hexIssueH->issue_count) )
                                                <span class="text-warning">N/A</span>
                                            @else
                                                <span class="icon-base bx bx-check-circle text-success"></span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4><span class="text-danger">Hexcode Missmatch</span> ISSUES [Combined Upper and Lower Part] -</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>E-Type Hexcode Missmatch</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>H-Type Hexcode Missmatch</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                </table>
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