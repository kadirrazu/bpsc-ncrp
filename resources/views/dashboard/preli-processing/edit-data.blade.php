<form id="edit-data-{{ $data->id }}" x-target method="post" action="{{ url('edit-data-processing') }}" aria-label="Edit Data">

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
            Center Code
        </div>
        <div class="col-md-8">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="center" value="{{ $data->center }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 col-form-label">
            Reg Number
        </div>
        <div class="col-md-8">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="reg_number" value="{{ $data->reg_number }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 col-form-label">
            Set Code
        </div>
        <div class="col-md-8">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="set_code" value="{{ $data->set_code }}">
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
                @if(isset($data->center_issue) && $data->center_issue === 1)
                    <span class="text-primary fw-bold">[ CENTER ];</span>
                @endif

                @if(isset($data->reg_number_issue) && $data->reg_number_issue === 1)
                    <span class="text-warning fw-bold">[ REG ];</span>
                @endif

                @if(isset($data->set_code_issue) && $data->set_code_issue === 1)
                    <span class="text-info fw-bold">[ SET ];</span>
                @endif

                @if(isset($data->litho_issue) && $data->litho_issue === 1)
                    <span class="text-danger fw-bold">[ LITHO ];</span>
                @endif

                @if(isset($data->hex_issue) && $data->hex_issue === 1)
                    <span class="text-primary fw-bold">[ HEX ];</span>
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
                @if(isset($data->solve_status) && $data->solve_status === 1)
                    <span class="text-success fw-bold">[ SOLVED ];</span>
                @else
                    <span class="text-danger fw-bold">[ PENDING ];</span>
                @endif
            </div>
        </div>
    </div>

    <button class="btn btn-success">Save Changes</button>

</form>

