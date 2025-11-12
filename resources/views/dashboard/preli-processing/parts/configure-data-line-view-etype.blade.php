<x-layout-dashboard>

    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>

    @php 

        $scripts = $parts;

    @endphp

    <div class="data-reorder-container">

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">E-Type Dataline Parts / </span>Reorder || Add Rows</h4>

        <form method="POST" method="POST" action="{{ url('update-data-line-etype') }}">

            @csrf

            <table class="table table-bordered" id="scriptsTable">
                <thead class="table-light">
                    <tr class="text-center">
                        <th style="width: 40px;">#</th>
                        <th>Script Type</th>
                        <th>Part Title</th>
                        <th>Part Sequence</th>
                        <th>Length</th>
                        <th style="width: 80px;">Action</th>
                    </tr>
                </thead>
                <tbody id="sortableRows">
                    {{-- Existing rows --}}
                    @foreach($scripts as $script)
                        <tr>
                            <td class="drag-handle text-center" style="cursor: grab;">☰</td>
                            <td><input type="text" name="scripts[{{ $loop->index }}][script_type]" value="{{ $script->script_type }}" class="form-control" readonly></td>
                            <td><input type="text" name="scripts[{{ $loop->index }}][part_title]" value="{{ $script->part_title }}" class="form-control"></td>
                            <td><input type="number" name="scripts[{{ $loop->index }}][part_sequence]" value="{{ $script->part_sequence }}" class="form-control sequence"></td>
                            <td><input type="number" name="scripts[{{ $loop->index }}][length]" value="{{ $script->length }}" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" id="addRow" class="btn btn-secondary">Add New Row</button>
            <button type="submit" class="btn btn-success">Save</button>
        </form>

        <div class="text-info mt-3 mb-3">
            <em>"litho_direction" field should be as last entry. Length value in this case shall be "1" for "LTR" and "2" for "RTL". This value decides litho code conversion direction from LeftToRight or RightToLeft.</em>
            <br>
            <br>
            <em>For E-Type data, other parts title can be: scan_sr, litho_code1, center, reg_number, set_code, litho_code2, bullet</em>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {

        let index = {{ count($scripts) }};

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
                    <td><input type="text" name="scripts[${index}][script_type]" class="form-control" value="e_type" readonly></td>
                    <td><input type="text" name="scripts[${index}][part_title]" class="form-control"></td>
                    <td><input type="number" name="scripts[${index}][part_sequence]" value="${index + 1}" class="form-control sequence"></td>
                    <td><input type="number" name="scripts[${index}][length]" class="form-control"></td>
                    <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
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

