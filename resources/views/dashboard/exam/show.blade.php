<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Exam / </span>{{ $exam->post_name }} ({{ $exam->post_code }}) - {{ $exam->entity }}</h4>

    <div class="row">
        <div class="col-md-8">
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table table-responsive">
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>Exam Management Authority</td>
                                <td><strong>{{ $exam->authority }}</strong></td>
                            </tr>
                            <tr>
                                <td>Ministry / Division / Organization</td>
                                <td>
                                    <strong>{{ $exam->entity }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Post Code</td>
                                <td>
                                    <strong>{{ $exam->post_code }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Post Name</td>
                                <td>
                                    <strong>{{ $exam->post_name }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Post Grade</td>
                                <td>
                                    <strong>{{ $exam->grade }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Exam Type</td>
                                <td>
                                    <strong>{{ $exam->type }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Exam Date</td>
                                <td>
                                    <strong>{{ $exam->exam_date }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Result Processing Date</td>
                                <td>
                                    <strong>{{ $exam->rp_date }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Total Candidate</td>
                                <td>
                                    <strong>{{ $exam->total_candidate }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Present Candidate</td>
                                <td>
                                    <strong>{{ $exam->present_candidate }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Result Processing Status</td>
                                <td>
                                    <strong>{{ $exam->rp_status }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Marked as Current Task</td>
                                <td>
                                    <strong>{!! ($exam->is_current) ? '<i class="icon-base bx bx-check-circle text-success"></i></span> YES' : '<span class="icon-base bx bx-x-circle text-danger"></span> NO' !!}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>

    <x-model-show-action-buttons model="exam" id="{{ $exam->id }}"/>

</x-layout-dashboard>