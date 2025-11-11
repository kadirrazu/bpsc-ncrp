<script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>

<x-layout-dashboard>

    <h4 class="fw-bold pt-3">
        <span class="text-muted fw-light">Data Solving / </span>E-TYPE
    </h4>

    <hr>

    <h5 class="fw-bold mb-2">
        <span class="text-info">{{ $exam->post_code .' - '. $exam->post_name}}</span> [ {{ $exam->entity }} ]</td>
    </h5>

    <hr class="mb-3">

    <!-- Card -->
    <div class="card">
        <div class="card-body">

            @if( !isset($data) || $data == null)

                <p class="alert alert-danger mb-0">Please add an exam first and set that as Current Task for processing.</p>

            @else

            <div class="table-responsive text-nowrap">
                <table class="table table-responsive table-striped dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">Bundle</th>
                            <th>Scan Sr.</th>
                            <th>Litho Code</th>
                            <th>Reg</th>
                            <th class="text-center">Set Code</th>
                            <th class="text-center">Issue Flags</th>
                            <th>Action Buttons</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach($data as $row)
                        <tr>
                            <td class="text-center">{{ $row->bnd_number }}</td>
                            <td>{{ $row->scan_sr }}</td>
                            <td>{{ $row->litho_code1 }}</td>
                            <td>{{ $row->reg_number }}</td>
                            <td class="text-center">{{ $row->set_code }}</td>
                            <td class="text-center">
                                @if(isset($row->center_issue) && $row->center_issue === 1)
                                    <span class="text-primary">[ CENTER ];</span>
                                @endif

                                @if(isset($row->reg_number_issue) && $row->reg_number_issue === 1)
                                    <span class="text-warning">[ REG ];</span>
                                @endif

                                @if(isset($row->set_code_issue) && $row->set_code_issue === 1)
                                    <span class="text-info">[ SET ];</span>
                                @endif

                                @if(isset($row->litho_issue) && $row->litho_issue === 1)
                                    <span class="text-danger">[ LITHO ];</span>
                                @endif

                                @if(isset($row->hex_issue) && $row->hex_issue === 1)
                                    <span class="text-primary">[ HEX ];</span>
                                @endif
                            </td>
                            <td>
                                <x-model-solve-buttons model="e_type" id="{{ $row->id }}"/>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>

                <dialog class="border-none" x-init @dialog:open.window="$el.showModal()">
                    <div id="view-data"></div>
                    <div class="text-right mt-2">
                        <form method="dialog" novalidate class="mb-2">
                        <button class="btn btn-primary">Close</button>
                    </form>
                    </div>
                </dialog>

            </div>

            @endif

        </div>

    </div>
    <!--/ Card -->

    <script>
        $(document).ready(function(){
            $(document).on('click', '#editDataBtn', function(e) {

                e.preventDefault();

                let formField = [];

                let parentForm = $(this).closest('form'); 

                parentForm.find('input').each(function() {
                    let fieldName = $(this).attr('name');
                    let fieldValue = $(this).val();
                    formField[fieldName] = fieldValue;
                });

                var formData = new FormData(parentForm);
                formData.append('formField', JSON.stringify(formField));

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN':  parentForm.find('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('edit-data-processing') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        console.log("Success:", response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error:", textStatus, errorThrown);
                    }
                });

            });
        });
    </script>

</x-layout-dashboard>