<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Report / </span>Answer Key Verification
    </h4>

    <div class="report-body" id="div-to-print">

        <p class="text-info">
            ANSWER KEY VERIFICATION REPORT - 
        </p>

        <div class="ak-report mb-3">

            <table class="table tablr-bordered table-striped">
                <tr>
                    <th>Set - 1</th>
                </tr>
                <tr>
                    <td>
                        @if( $set1Answers != null )

                            @for( $set1Answers as $ans )
                                {{ $loop->index + 1 }} - {{ $ans }}
                            @endforeach

                        @endif
                    </td>
                </tr>
                <tr>
                    <td>
                        A = {{ $set1Count['a_count'] }},
                        B = {{ $set1Count['b_count'] }},
                        C = {{ $set1Count['c_count'] }},
                        D = {{ $set1Count['d_count'] }},
                    </td>
                </tr>
            </table>

        </div>

    </div>

    @if(isset($a_count) )

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