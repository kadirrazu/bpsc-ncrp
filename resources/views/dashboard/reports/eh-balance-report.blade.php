<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Report / </span>E-H Balance
    </h4>

    <div class="report-body" id="div-to-print">

        <div class="e-unmatched mb-3">

            <p class="text-info">
                E/H BALANCE SHEET - 
            </p>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">E-TYPE SCRIPTS</th>
                        </tr>
                        <tr class="text-center">
                            <th>SR.</th>  
                            <th>BND NUMBER</td>    
                            <th>SCRIPT COUNT</td>
                            <th>REMARKS</td>
                        </tr>
                        @foreach($eTypeBalance as $data)
                        <tr class="text-center">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                            {{ $data->bnd_number }}
                            </td>
                            <td>{{ $data->script_count }}</td>
                            <td style="min-width: 100px;"></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th colspan="4" class="text-center">H-TYPE SCRIPTS</th>
                        </tr>
                        <tr class="text-center">
                            <th>SR.</th>  
                            <th>BND NUMBER</td>    
                            <th>SCRIPT COUNT</td>
                            <th>REMARKS</td>
                        </tr>
                        @foreach($hTypeBalance as $data)
                        <tr class="text-center">
                            <td>{{ $loop->index + 1 }}</td>
                            <td>
                            {{ $data->bnd_number }}
                            </td>
                            <td>{{ $data->script_count }}</td>
                            <td style="min-width: 100px;"></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

        </div>

    </div>

    @if( isset($eTypeBalance) && $eTypeBalance->count() > 0 )

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