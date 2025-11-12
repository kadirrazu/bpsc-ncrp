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
            <th>Error Status</th>
            <td>
                @if(isset($data->litho_issue) && $data->litho_issue === 1)
                    <span class="text-danger fw-bold">[ LITHO-H ];</span>
                @endif

                @if(isset($data->hex_issue) && $data->hex_issue === 1)
                    <span class="text-primary fw-bold">[ HEX-H ];</span>
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