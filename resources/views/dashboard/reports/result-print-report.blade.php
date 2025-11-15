<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Report / </span>Result Printing
    </h4>

    <div class="report-body" id="div-to-print">

        @include('partials.report-header')

        <div class="e-unmatched mb-3">

            @if(isset($resultTable) && $resultTable->count() > 0)

                <p class="text-info">
                    FINAL RESULT - 
                </p>

                <table class="table table-striped table-bordered">
                    <tr class="text-center">
                        <th>SR.</th>  
                        <th>REG NUMBER</td>    
                        <th class="text-start">NAME</td>    
                        <th>DISTRICT</td>    
                        <th>MARK</td>
                        <th>RESULT STATUS</td>
                        <th>REMARKS</td>
                    </tr>
                    @foreach($resultTable as $data)
                    <tr class="text-center">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $data->reg_number }}</td>
                        <td class="text-start">{{ strtoupper($data->name) }}</td>
                        <td>{{ strtoupper($data->district) }}</td>
                        <td>{{ $data->final_mark }}</td>
                        <td>{{ $data->result_status }}</td>
                        <td style="min-width: 100px;"></td>
                    </tr>
                    @endforeach
                </table>
            @else
                <p class="text-warning">
                    Result table is empty!
                </p>
            @endif

        </div>

    </div>

    @if( isset($resultTable) && $resultTable->count() > 0 )

        @include('partials.report-print-btn')

    @endif

</x-layout-dashboard>