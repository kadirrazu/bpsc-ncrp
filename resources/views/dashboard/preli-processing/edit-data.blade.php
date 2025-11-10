<form id="edit-data" x-target method="put" action="{{ url('edit-data-processing') }}" aria-label="Edit Data Line" x-merge.transition>

    @csrf

    <input type="hidden" name="data-id" value="{{ $data->id }}">
    <input type="hidden" name="data-type" value="{{ $file_type }}">

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Bundle Number
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="bnd_number" value="{{ $data->bnd_number }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Scan Serial
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="scan_sr" value="{{ $data->scan_sr }}" readonly>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Litho Code 1
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="litho_code1" value="{{ $data->litho_code1 }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Litho Code 2
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="litho_code1" value="{{ $data->litho_code2 }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Center Code
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="center" value="{{ $data->center }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Reg Number
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="reg_number" value="{{ $data->reg_number }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Set Code
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="set_code" value="{{ $data->set_code }}">
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <label class="col-sm-2 col-form-label">
            Geneal Status
        </label>
        <div class="col-sm-10">
            <div class="input-group input-group-merge">
                <input type="text" class="form-control" name="general_status" value="{{ $data->general_status }}">
            </div>
        </div>
    </div>

    <button class="btn btn-success">Update</button>

</form>