<div class="form-parent-div">
    <form id="edit-data-{{ $data->id }}" method="post" action="{{ url('edit-data-processing') }}" aria-label="Edit Data">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <input type="hidden" name="data_id" value="{{ $data->id }}">
        <input type="hidden" name="data_type" value="{{ $file_type }}">

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Bundle Number
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" name="bnd_number" value="{{ $data->bnd_number }}">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Scan Serial
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" name="scan_sr" value="{{ $data->scan_sr }}" readonly>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Litho Code 1
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" name="litho_code1" value="{{ $data->litho_code1 }}">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Litho Code 2
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" name="litho_code2" value="{{ $data->litho_code2 }}">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Geneal Status
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" name="general_status" value="{{ $data->general_status }}">
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Issue Flags
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">

                    @if(isset($data->litho_issue) && $data->litho_issue === 1)
                        <span class="text-danger fw-bold">[ LITHO-H ];</span>
                    @endif

                    @if(isset($data->hex_issue) && $data->hex_issue === 1)
                        <span class="text-primary fw-bold">[ HEX-H ];</span>
                    @endif

                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4 col-form-label">
                Solve Status
            </div>
            <div class="col-md-8">
                <div class="input-group input-group-merge">
                    @if(isset($data->solve_status) && $data->solve_status == '1')
                        <span class="text-success fw-bold">[ SOLVED ];</span>
                    @else
                        <span class="text-danger fw-bold">[ PENDING ];</span>
                    @endif
                </div>
            </div>
        </div>

        <button class="btn btn-success" id="editDataBtn">Save Changes</button>

    </form>

    <div class="status-result text-info">

    </div>
</div>

