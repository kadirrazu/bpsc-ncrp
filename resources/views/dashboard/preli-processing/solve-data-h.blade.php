<x-layout-dashboard>

    <h4 class="fw-bold pt-3">
        <span class="text-muted fw-light">Data Solving / </span>H-TYPE
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
                            <th class="text-center">Issue Flags</th>
                            <th class="text-center">Solve Status</th>
                            <th>Action Buttons</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach($data as $row)
                        <tr id="row-id-{{ $row->id }}" class="tr-parent">
                            <td class="text-center">{{ $row->bnd_number }}</td>
                            <td>{{ $row->scan_sr }}</td>
                            <td>{{ $row->litho_code1 }}</td>
                            <td class="text-center">
                                @if(isset($row->litho_issue) && $row->litho_issue === 1)
                                    <span class="text-danger">[ LITHO-H ];</span>
                                @endif

                                @if(isset($row->hex_issue) && $row->hex_issue === 1)
                                    <span class="text-primary">[ HEX-H ];</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(isset($row->solve_status) && $row->solve_status == '1')
                                    <i class="icon-base bx bx-check-circle text-success"></i>
                                @else
                                    <i class="icon-base bx bx-x-circle text-danger"></i>
                                @endif
                            </td>
                            <td>
                                <x-model-solve-buttons-h model="h_type" id="{{ $row->id }}"/>
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

                let formFields = {};
                let parentForm = $(this).closest('form'); 

                parentForm.find('input').each(function() {
                    formFields[$(this).attr('name')] = $(this).val();
                });

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN':  parentForm.find('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "{{ url('edit-data-processing-h') }}",
                    type: "POST",
                    data: {
                        allFormData: JSON.stringify(formFields)
                    },
                    success: function(response) {
                        if(response.status == 'success'){
                            sibling = parentForm.parent('.form-parent-div');
                            sibling.html('<span class="text-success fw-bold">Data was solved successfully.</span>');
                            parentForm.hide();
                            $('tr#row-id-'+formFields.data_id).addClass('data-solved');
                            $('a#edit-btn-'+formFields.data_id).fadeOut();
                        }
                        else{
                            alert("Error in processing request! No data were updated.");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error:", textStatus, errorThrown);
                    }
                });

            });
        });
    </script>

</x-layout-dashboard>