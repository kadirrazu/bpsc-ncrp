<x-layout-dashboard>

    <h4 class="fw-bold pt-3">
        <span class="text-muted fw-light">Data Solving / </span>H-TYPE SCRIPT DUPLICATION
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

                <p class="alert alert-danger mb-0">There is no scipt duplication.</p>

            @else

            <div class="table-responsive text-nowrap">
                <table class="table table-responsive table-striped dataTable">
                    <thead>
                        <tr>
                            <th class="text-center">Bundle</th>
                            <th class="text-center">Scan Sr.</th>
                            <th>Litho Code</th>
                            <th class="text-center">Reg</th>
                            <th class="text-center">Set Code</th>
                            <th class="text-center">Action Buttons</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">

                        @foreach($data as $row)
                        <tr id="row-id-{{ $row->id }}" class="tr-parent">
                            <td class="text-center">{{ $row->bnd_number }}</td>
                            <td class="text-center">{{ $row->scan_sr }}</td>
                            <td>
                                {{ $row->litho_code1 }}<br>
                                {{ $row->litho_code2 }}
                            </td>
                            <td class="text-center">{{ $row->reg_number }}</td>
                            <td class="text-center">{{ $row->set_code }}</td>
                            <td class="text-center">
                                <a href="{{ url('/mark-non-duplicate-etype/' . $row->id) }}" class="btn btn-success">Mark as Non Duplicate</a>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>

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
                    url: "{{ url('edit-data-processing') }}",
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

<div id="view-data">
    <table class="table table-striped table-bordered">

        <tr>
            <th>BND NUMBER</th>
            <th>SCAN SR</th>
            <th>
                LITHO CODES
            </th>
            <th>
                HEC CODES
            </th>
            <th>REGI NUMBER</th>
        </tr> 

        @foreach($data as $row)
        <tr>
            <td>{{ $row->bnd_number }}</td>
            <td>{{ $row->scan_sr }}</td>
            <td>
                {{ $row->litho_code1 }}<br>
                {{ $row->litho_code2 }}
            </td>
            <td>
                {{ $row->hex_code1 }}<br>
                {{ $row->hex_code2 }}
            </td>
            <td>{{ $row->reg_number }}</td>
        </tr> 
        @endforeach    
    </table>
</div>