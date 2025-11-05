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
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Set Code Issue</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lithocode Issue</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hexcode Issue</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6 mb-4">
                                <h4><span class="text-warning">H-TYPE</span> DATA ISSUES -</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Lithocode Issue</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hexcode Issue</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4><span class="text-warning">Hexcode Missmatch</span> ISSUES -</h4>
                                <table class="table table-bordered">
                                    <tr>
                                        <td>E-Type Hexcode Missmatch</td>
                                        <td class="text-center">5</td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-primary btn-sm">View List</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>H-Type Hexcode Missmatch</td>
                                        <td class="text-center">5</td>
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