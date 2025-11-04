
<div id="etype-file-list">

    @php 
        $conversionStatus = true; 
        $examId = ''; 
        $postCode = ''; 
    @endphp

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">BND NUMBER</th>
                <th class="text-center">FILE TYPE</th>
                <th>FILE NAME</th>
                <th class="text-center">CONVERSION STATUS</th>
            </tr>
        </thead>
        <tbody>
            @foreach($datafiles as $file)
            <tr>
                <td class="text-center">{{ $file->bnd_number }}</td>
                <td class="text-center">{{ strtoupper( $file->file_type ) }}</td>
                <td>{{ $file->file_name }}</td>
                <td class="text-center">

                    @if($file->conversion_status == 1) 
                        <span class="text-success">
                            <i class="icon-base bx bx-check-circle"></i> DONE
                        </span>
                    @else
                        <span class="text-danger">
                            <i class="icon-base bx bx-x-circle"></i> NOT DONE
                        </span>
                        @php  
                            $conversionStatus = false; 
                            $examId = $file->exam_id; 
                            $postCode = $file->post_code; 
                        @endphp
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if( $conversionStatus == false )
        <div class="text-end mt-4">
            <a href="{{ url('convert-due-data-files/' . $examId . '/'. $postCode .'/e_type') }}" class="btn btn-success">Convert Due E-Type Files</a>
        </div>
    @endif

</div>