<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary">BPSC Result Processing Platform 🎉</h5>
                    <p class="mb-4">
                    Using this platform you can process BPSC exam data. Data import, solving, matching, posting and reporting are available in this platform to perform confidently.
                    </p>

                    <a href="{{ url('list-exam') }}" class="btn btn-sm btn-outline-primary">Exam List</a>
                </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img
                    src="{{ asset('assets/img/illustrations/man-with-laptop-light.png') }}"
                    height="140"
                    alt="View Badge User"
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png"
                    />
                </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="d-flex align-items-end row">
                <div class="card-body">
                @if( isset( $currentExam ) )

                    <table class="table table-bordered table-striped">
                        <tr class="text-center">
                            <th  colspan="2" class="text-info fw-bold">Currently Processing the below Exam Data</th>
                        </tr>    
                        <tr>
                            <th>Ministry / Division / Organization</th>
                            <td>{{ $currentExam->entity }}</td>
                        </tr>
                        <tr>
                            <th>Post Code</th>
                            <td>{{ $currentExam->post_code }}</td>
                        </tr>
                        <tr>
                            <th>Post Name & Grade</th>
                            <td>{{ $currentExam->post_name }} (Grade {{ $currentExam->grade }})</td>
                        </tr>
                        <tr>
                            <th>Exam Type</th>
                            <td>{{ $currentExam->type }}</td>
                        </tr>
                        <tr>
                            <th>Uploaded E-TYPE Script</th>
                            <td>
                                {{ \Illuminate\Support\Facades\DB::table('etype_data')->where('litho_issue', '!==', 1)->where('duplicate_script', '!==', 1)->get()->count(); }}
                            </td>
                        </tr>
                        <tr>
                            <th>Uploaded H-TYPE Script</th>
                            <td>
                                {{ \Illuminate\Support\Facades\DB::table('htype_data')->where('litho_issue', '!==', 1)->where('duplicate_script', '!==', 1)->get()->count(); }}
                            </td>
                        </tr>
                    </table>

    <hr class="mb-3">
                @else
                    <p class="alert alert-warning fw-bold text-center">Currently no exam is set for start processing. Please set anyone of the exam as current.</p>     
                @endif
                </div>
            </div>
        </div>

    </div>
</div>