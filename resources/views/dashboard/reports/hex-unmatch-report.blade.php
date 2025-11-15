<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Report / </span>Hexcode Unmatch Summary
    </h4>

    <div class="report-body" id="div-to-print">

        @include('partials.report-header')

        <div class="e-unmatched mb-3">

            @if(isset($e_unmatched) && $e_unmatched > 0)

                <p class="text-info">
                    E-TYPE HEXCODE UNMATCH COUNT: <span class="text-danger">{{ $e_unmatched }}</span>
                </p>

                <table class="table table-striped table-bordered">
                    <tr class="text-center">
                        <th>Sr.</th>  
                        <th>PART TYPE</td>    
                        <th>BND NUMBER</td>
                        <th>SCAN SR</td>
                        <th>HEXCODE</td>
                    </tr>
                    @foreach($e_unmatched_array as $key => $unmatch)
                    <tr class="text-center">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $unmatch['script_part'] }}</td>
                        <td>{{ $unmatch['bnd_number'] }}</td>
                        <td>{{ $unmatch['scan_sr'] }}</td>
                        <td>{{ $unmatch['hexcode'] }}</td>
                    </tr>
                    @endforeach
                </table>
            @else
                <p class="text-success">
                    No hexcode unmatch record found for E-TYPE data.
                </p>
            @endif

        </div>

        <div class="e-unmatched mb-3">

            @if(isset($h_unmatched) && $h_unmatched > 0)

                <p class="text-info">
                    H-TYPE HEXCODE UNMATCH COUNT: <span class="text-danger">{{ $h_unmatched }}</span>
                </p>

                <table class="table table-striped table-bordered">
                    <tr class="text-center">
                        <th>Sr.</th>  
                        <th>PART TYPE</td>    
                        <th>BND NUMBER</td>
                        <th>SCAN SR</td>
                        <th>HEXCODE</td>
                    </tr>
                    @foreach($h_unmatched_array as $key => $unmatch)
                    <tr class="text-center">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $unmatch['script_part'] }}</td>
                        <td>{{ $unmatch['bnd_number'] }}</td>
                        <td>{{ $unmatch['scan_sr'] }}</td>
                        <td>{{ $unmatch['hexcode'] }}</td>
                    </tr>
                    @endforeach
                </table>
            @else
                <p class="text-success">
                    No hexcode unmatch record found for H-TYPE data.
                </p>
            @endif
            
        </div>

    </div>

    @if( (isset($e_unmatched) && $e_unmatched > 0) || (isset($h_unmatched) && $h_unmatched > 0))

        @include('partials.report-print-btn')

    @endif

</x-layout-dashboard>