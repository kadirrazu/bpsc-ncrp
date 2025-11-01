<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">List / </span>All Exam</h4>

    <div class="row">
        <div class="col-xl">
            <!-- Basic Bootstrap Table -->
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Post Code</th>
                                <th>Entity & Post Name</th>
                                <th>Exam Date</th>
                                <th>Current Status</th>
                                <th>Action Buttons</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">

                            @foreach($exams as $exam)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $exam->post_code }}</td>
                                <td>{{ $exam->entity }} <br><span class="text-info">[ {{ $exam->post_name }} ]</span></td>
                                <td>{{ $exam->exam_date }}</td>
                                <td class="text-center">{!! ($exam->is_current) ? '<i class="icon-base bx bx-check-circle text-success"></i></span>' : '<span class="icon-base bx bx-x-circle text-danger"></span>' !!}</td>
                                <td>
                                    <x-model-action-buttons model="exam" id="{{ $exam->id }}"/>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>

</x-layout-dashboard>