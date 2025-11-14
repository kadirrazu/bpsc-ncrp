<x-layout-dashboard>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    <div class="data-reorder-container">

        <div class="row">
            <div class="col-md-12">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Configurations / </span>Reorder || Add New</h4>
            </div>
        </div>

        <form method="POST" method="POST" action="{{ url('master-configs') }}">

            @csrf

            <table class="table table-bordered" id="scriptsTable">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 40px;">#</th>
                        <th>Key</th>
                        <th>Value</th>
                        <th>Remarks</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody id="sortableRows">
                    {{-- Existing rows --}}
                    @foreach($configs as $config)
                        <tr>
                            <td class="drag-handle text-center" style="cursor: grab;">☰</td>
                            <td>
                                <input type="text" name="configs[{{ $loop->index }}][key]" value="{{ $config->key }}" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="configs[{{ $loop->index }}][value]" value="{{ $config->value }}" class="form-control">
                            </td>
                            <td>
                                <input type="text" name="configs[{{ $loop->index }}][remarks]" value="{{ $config->remarks }}" class="form-control">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" id="addRow" class="btn btn-secondary">Add New Config</button>
            <button type="submit" class="btn btn-success">Save</button>
        </form>

        <div class="text-info mt-3 mb-3">
            <em>
                [key => value] pair for storing various master configuration decisions. Remarks field is optional
            </em>
            <br>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {

        let index = {{ count($configs) }};

        // Function to reindex part_sequence after reorder or removal
        function updateSequences() {
            $('#sortableRows tr').each(function(i, row) {
                $(row).find('.sequence').val(i + 1); // auto number from 1
            });
        }

        // Add new row
        $('#addRow').click(function() {
            $('#sortableRows').append(`
                <tr>
                    <td class="drag-handle text-center" style="cursor: grab;">☰</td>
                    <td>
                        <input type="text" name="configs[${index}][key]" class="form-control" value="">
                    </td>
                    <td>
                        <input type="text" name="configs[${index}][value]" class="form-control" value="">
                    </td>
                    <td>
                        <input type="text" name="configs[${index}][remarks]" class="form-control" value="">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeRow">Remove</button>
                    </td>
                </tr>
            `);
            index++;
            updateSequences();
        });

        // Remove row
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
            updateSequences();
        });

        // Make rows sortable
        $('#sortableRows').sortable({
            handle: '.drag-handle',
            update: function() {
                updateSequences(); // reindex sequence numbers
            }
        }).disableSelection();

        // Ensure initial sequence is consistent
        updateSequences();
    });
    </script>

</x-layout-dashboard>

