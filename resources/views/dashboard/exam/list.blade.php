<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">List / </span>All Exam</h4>

    @if( $exams->count() > 0 )

    <div class="row">
        <div class="col-xl">
            <!-- Basic Bootstrap Table -->
            <div class="card">
                
                <div class="table-responsive text-nowrap">
                    <table class="table table-responsive dataTable">
                        <thead>
                            <tr>
                                <th>Sr.</th>
                                <th>Post Code</th>
                                <th>Entity & Post Name</th>
                                <th>Exam Date</th>
                                <th class="text-center">Current Status</th>
                                <th></th>
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
                                <td x-data="{
                                    confirmAction : function(event){
                                        result = confirm('Sure? You want to set this exam as current?');
                                        if( result === false){
                                            event.preventDefault()
                                        }
                                    }
                                }">
                                    @if( $exam->is_current == 0 )
                                    <a href="{{ url('set-exam-as-current/' . $exam->id) }}" class="btn btn-xs btn-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Change Exam Status as Current" @click="confirmAction">
                                        <span class="bx bx-check"></span>
                                    </a>
                                    @endif
                                </td>
                                <td>
                                    <x-model-action-buttons model="exam" id="{{ $exam->id }}"/>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>

                    <div class="pagination-area">
                        {{ $exams->links() }}
                    </div>

                </div>

            </div>
            <!--/ Basic Bootstrap Table -->
        </div>
    </div>

    @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-danger mb-4" role="alert">
                    Currently there is no exam information in the database!
                </div>
                <a href="{{ url('add-exam') }}" class="btn btn-primary">Add Exam</a>
            </div>
        </div>
    @endif

</x-layout-dashboard>