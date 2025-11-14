<x-layout-dashboard>

    <h4 class="fw-bold pt-3">
        <span class="text-muted fw-light">Final Result / </span>Printing Choices
    </h4>

    <hr>

    <h5 class="fw-bold mb-2">
        <span class="text-info">{{ $exam->post_code .' - '. $exam->post_name}}</span> [ {{ $exam->entity }} ]</td>
    </h5>

    <hr class="mb-3">

    <!-- Card -->
    <div class="card">

        <div class="card-body">

            <a href="{{ url('print-result-report') }}" class="btn btn-primary">
                Final Result with Marks
            </a>
            <a href="{{ url('bnd-wise-result-print') }}" class="btn btn-secondary">
                BND/CENTER wise Result Print
            </a>
            <a href="{{ url('generate-txt-file-result') }}" class="btn btn-info" target="_blank">
                Generate TXT File of Final Result
            </a>

        </div>

    </div>
    <!--/ Card -->

</x-layout-dashboard>