<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Upload Regi File / </span>CSV ONLY</h4>

    <!-- Card -->
    <div class="card">
        <div class="card-body">
            @if( !isset($exam) || $exam == null) 

                <p class="alert alert-danger mb-0">Please add an exam first and set that as Current Task for processing.</p>

            @else

                @if( isset($cutmark) && $cutmark != null )

                    <h5 class="fw-bold mb-2">
                        <span class="text-info">{{ $exam->post_code .' - '. $exam->post_name}}</span> [ {{ $exam->entity }} ]</td>
                    </h5>

                    <h6 class="text-success mt-3">EXISTING CUT MARK VALUE FOR THIS EXAM - </h6>

                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>Field Name</th>
                            <th>Field Value</th>
                            <th>
                                Action
                            </th>
                        </tr>
                        <tr class="text-center">
                            <td>Cut Mark</td>
                            <td>{{ $cutmark }}</td>
                            <td>
                                <a href="{{ url('delete-cut-mark') }}" class="btn btn-sm btn-danger">Delete</a>
                            </td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <a href="{{ url('generate-result-status') }}" class="btn btn-info">Generate Result Status [Finalize Result]</a>
                    </div>

                @else

                <form method="POST" action="{{ url('cut-mark-posting') }}" enctype="multipart/form-data">

                    @csrf

                    <input type="hidden" name="exam-id" value="{{ $exam->id }}">
                    <input type="hidden" name="post-code" value="{{ $exam->post_code }}">

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
                                <input type="text" class="form-control" name="pc" value="{{ $exam->post_code }} - {{ $exam->post_name }}" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Decision Type</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="mark_type" value="CUT_MARK" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Cut Mark Value</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control" name="cut_mark" value="{{ old('cut_mark') ? old('cut_mark') : '' }}">
                            </div>
                            @error('cut_mark')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-success">Set Cut Mark</button>
                        </div>
                    </div>

                </form>

                <div class="text-info mt-4 mb-3">
                    <em>Info: Value can be integer or a float number.</em>
                </div>

                @endif

            @endif

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>