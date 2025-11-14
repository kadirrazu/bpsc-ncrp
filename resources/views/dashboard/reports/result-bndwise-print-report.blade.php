<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Report / </span>Result Printing
    </h4>

    <div class="report-body" id="div-to-print">

        <div class="e-unmatched mb-3">

            @if(isset($groupedResults) && $groupedResults->count() > 0)

                <p class="text-info">
                    BND/CENTER WISE FINAL RESULT - 
                </p>

                @foreach($groupedResults as $bndNumber => $items)

                    <h4>BND/CENTER NUMBER: {{ $bndNumber }}</h4>

                    <table class="table table-striped table-bordered">
                        <tr class="text-center">
                            <th>SR.</th>  
                            <th>REG NUMBER</td>    
                            <th class="text-start">NAME</td> 
                            <th>RESULT STATUS</td>
                            <th>REMARKS</td>
                        </tr>

                        @foreach($items as $data)
                        <tr class="text-center">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $data->reg_number }}</td>
                            <td class="text-start">{{ strtoupper($data->name) }}</td>
                            <td>{{ $data->result_status }}</td>
                            <td style="min-width: 100px;"></td>
                        </tr>
                        @endforeach

                    </table>
                @endforeach
            @else
                <p class="text-warning">
                    Result table is empty!
                </p>
            @endif

        </div>

    </div>

    @if( isset($resultTable) && $resultTable->count() > 0 )

    <button class="btn btn-secondary" onclick="printReportDiv('div-to-print')">Print Report</button>

    <script>
        function printReportDiv(divId) {
            var printContents = document.getElementById(divId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    @endif

</x-layout-dashboard>