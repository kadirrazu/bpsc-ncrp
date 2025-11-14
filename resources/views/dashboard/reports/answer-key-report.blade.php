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
                        
                        <p>
                            @if( $set1Answers != null )

                                @for( $i = 0; $i < strlen($set1Answers); $i++ )
                                    {{ $i + 1 }} - {{ $set1Answers[$i] }}
                
                                    @if( $i+1 % 10 == 0 )
                                        <br>
                                    @endif
                                @endfor

                            @endif
                        </p>

                        <p class="mt-2 border-top pt-2">
                            A = {{ $set1Count['a_count'] }},
                            B = {{ $set1Count['b_count'] }},
                            C = {{ $set1Count['c_count'] }},
                            D = {{ $set1Count['d_count'] }}
                        </p>
                    </td>
                </tr>
            </table>

            <table class="table tablr-bordered table-striped">
                <tr>
                    <th>Set - 2</th>
                </tr>
                <tr>
                    <td>
                        
                        <p>
                            @if( $set2Answers != null )

                                @for( $i = 0; $i < strlen($set2Answers); $i++ )
                                    {{ $i + 1 }} - {{ $set2Answers[$i] }}
                
                                    @if( $i+1 % 10 == 0 )
                                        <br>
                                    @endif
                                @endfor

                            @endif
                        </p>

                        <p class="mt-2 border-top pt-2">
                            A = {{ $set2Count['a_count'] }},
                            B = {{ $set2Count['b_count'] }},
                            C = {{ $set2Count['c_count'] }},
                            D = {{ $set2Count['d_count'] }}
                        </p>
                    </td>
                </tr>
            </table>

            <table class="table tablr-bordered table-striped">
                <tr>
                    <th>Set - 3</th>
                </tr>
                <tr>
                    <td>
                        
                        <p>
                            @if( $set3Answers != null )

                                @for( $i = 0; $i < strlen($set3Answers); $i++ )
                                    {{ $i + 1 }} - {{ $set3Answers[$i] }}
                
                                    @if( $i+1 % 10 == 0 )
                                        <br>
                                    @endif
                                @endfor

                            @endif
                        </p>

                        <p class="mt-2 border-top pt-2">
                            A = {{ $set3Count['a_count'] }},
                            B = {{ $set3Count['b_count'] }},
                            C = {{ $set3Count['c_count'] }},
                            D = {{ $set3Count['d_count'] }}
                        </p>
                    </td>
                </tr>
            </table>

            <table class="table tablr-bordered table-striped">
                <tr>
                    <th>Set - 4</th>
                </tr>
                <tr>
                    <td>
                        
                        <p>
                            @if( $set4Answers != null )

                                @for( $i = 0; $i < strlen($set4Answers); $i++ )
                                    {{ $i + 1 }} - {{ $set4Answers[$i] }}
                
                                    @if( $i+1 % 10 == 0 )
                                        <br>
                                    @endif
                                @endfor

                            @endif
                        </p>

                        <p class="mt-2 border-top pt-2">
                            A = {{ $set4Count['a_count'] }},
                            B = {{ $set4Count['b_count'] }},
                            C = {{ $set4Count['c_count'] }},
                            D = {{ $set4Count['d_count'] }}
                        </p>
                    </td>
                </tr>
            </table>

        </div>

    </div>


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

</x-layout-dashboard>