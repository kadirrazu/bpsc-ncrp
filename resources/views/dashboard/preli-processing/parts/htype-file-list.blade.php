
<div id="htype-file-list" class="mb-2">

    @php 
        $conversionStatus = true; 
        $examId = ''; 
        $postCode = ''; 
    @endphp

    @if( $datafiles->count() > 0 )

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
                    <td class="text-center text-info">{{ strtoupper( $file->file_type ) }}</td>
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
                <a href="{{ url('convert-due-data-files/' . $examId . '/'. $postCode .'/h_type') }}" class="btn btn-warning">Convert Due H-Type Files</a>
            </div>
        @endif

    @else

        <p class="alert alert-warning mb-1">There are no H-TYPE file(s) in the conversion queue.</p>

    @endif

    

</div>