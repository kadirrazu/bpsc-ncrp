<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Report / </span>Score Frequency
    </h4>

    <div class="report-body" id="div-to-print">

        @include('partials.report-header')

        <div class="e-unmatched mb-3">

            @if(isset($scoreFrequencyData) && $scoreFrequencyData->count() > 0)

                <p class="text-info">
                    SCORE FREQUENCY - 
                </p>

                @php $cumulativeCount = 0; @endphp

                <table class="table table-striped table-bordered">
                    <tr class="text-center">
                        <th>Sr.</th>  
                        <th>Scored Mark</td>    
                        <th>Candidate Count</td>
                        <th>Gross Candidate Count</td>
                        <th>Remarks</td>
                    </tr>
                    @foreach($scoreFrequencyData as $data)
                    <tr class="text-center">
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            @if( $data->final_mark > 0 )
                                <span class="fw-bold">{{ $data->final_mark }}</span>
                            @else
                                <span class="text-danger fw-bold">{{ $data->final_mark }}</span>
                            @endif
                        </td>
                        <td>{{ $data->candidate_count }}</td>
                        <td>{{ $cumulativeCount += $data->candidate_count }}</td>
                        <td style="min-width: 300px;"></td>
                    </tr>
                    @endforeach
                </table>
            @else
                <p class="text-warning">
                    Score frequency report is empty!
                </p>
            @endif

        </div>

    </div>

    @if( isset($scoreFrequencyData) && $scoreFrequencyData->count() > 0 )

        @include('partials.report-print-btn')

    @endif

</x-layout-dashboard>