<div id="view-data">
    <table class="table table-striped table-bordered">
        <tr>
            <th>Bundle Number</th>
            <td>{{ $data->bnd_number }}</td>
        </tr>
        <tr>
            <th>Scan Serial</th>
            <td>{{ $data->scan_sr }}</td>
        </tr>
        <tr>
            <th>Litho Codes</th>
            <td>
                {{ $data->litho_code1 }}<br>
                {{ $data->litho_code2 }}
            </td>
        </tr>
        <tr>
            <th>Hex Codes</th>
            <td>
                {{ $data->hex_code1 }}<br>
                {{ $data->hex_code2 }}
            </td>
        </tr>
        <tr>
            <th>Center Code</th>
            <td>{{ $data->center }}</td>
        </tr>
        <tr>
            <th>Reg Number</th>
            <td>{{ $data->reg_number }}</td>
        </tr>
        <tr>
            <th>Set Code</th>
            <td>{{ $data->set_code }}</td>
        </tr>
        <tr>
            <th>Error Status</th>
            <td>
                @if(isset($data->center_issue) && $data->center_issue === 1)
                    <span class="text-primary fw-bold">[ CENTER ];</span><br>
                    <span class="text-primary">[ {{ $data->center_status }} ];</span><br>
                @endif

                @if(isset($data->reg_number_issue) && $data->reg_number_issue === 1)
                    <span class="text-warning fw-bold">[ REG ];</span><br>
                    <span class="text-warning text-sm">[ {{ $data->reg_number_status }} ];</span><br>
                @endif

                @if(isset($data->set_code_issue) && $data->set_code_issue === 1)
                    <span class="text-info fw-bold">[ SET ];</span><br>
                    <span class="text-info text-sm">[ {{ $data->set_code_status }} ];</span><br>
                @endif

                @if(isset($data->litho_issue) && $data->litho_issue === 1)
                    <span class="text-danger fw-bold">[ LITHO ];</span><br>
                    <span class="text-danger text-sm">[ {{ $data->litho_status }} ];</span><br>
                @endif

                @if(isset($data->hex_issue) && $data->hex_issue === 1)
                    <span class="text-primary fw-bold">[ HEX ];</span><br>
                    <span class="text-primary text-sm">[ {{ $data->hex_status }} ];</span><br>
                @endif
            </td>
        </tr>
        <tr>
            <th>Hex Status</th>
            <td>{{ $data->hex_status }}</td>
        </tr>
        <tr>
            <th>General Status</th>
            <td>{{ $data->general_status }}</td>
        </tr>
        <tr>
            <th>Solve Status</th>
            <td>
                @if(isset($data->solve_status) && $data->solve_status == '1')
                    <span class="text-success fw-bold">[ SOLVED ];</span>
                @else
                    <span class="text-danger fw-bold">[ PENDING ];</span>
                @endif
            </td>
        </tr>
        
    </table>
</div>