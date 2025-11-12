<x-layout-dashboard>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

    <div class="form-parent-div">

        <form method="POST" action="">
            @csrf

            <table class="table table-bordered" id="scriptsTable">
                <thead>
                    <tr>
                        <th>Script Type</th>
                        <th>Part Title</th>
                        <th>Part Sequence</th>
                        <th>Length</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Existing data --}}
                    @php $scripts = $parts; @endphp
                    @foreach($scripts as $script)
                        <tr>
                            <td><input type="text" name="scripts[{{ $loop->index }}][script_type]" value="{{ $script->script_type }}" class="form-control"></td>
                            <td><input type="text" name="scripts[{{ $loop->index }}][part_title]" value="{{ $script->part_title }}" class="form-control"></td>
                            <td><input type="number" name="scripts[{{ $loop->index }}][part_sequence]" value="{{ $script->part_sequence }}" class="form-control"></td>
                            <td><input type="number" name="scripts[{{ $loop->index }}][length]" value="{{ $script->length }}" class="form-control"></td>
                            <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" id="addRow" class="btn btn-secondary">Add New Row</button>
            <button type="submit" class="btn btn-primary mt-3">Save</button>
        </form>

    </div>

    <script>
        jQuery(document).ready(function($) {
            let index = {{ count($scripts) }};

            $('#addRow').click(function() {
                $('#scriptsTable tbody').append(`
                    <tr>
                        <td><input type="text" name="scripts[${index}][script_type]" class="form-control"></td>
                        <td><input type="text" name="scripts[${index}][part_title]" class="form-control"></td>
                        <td><input type="number" name="scripts[${index}][part_sequence]" class="form-control"></td>
                        <td><input type="number" name="scripts[${index}][length]" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
                    </tr>
                `);
                index++;
            });

            $(document).on('click', '.removeRow', function() {
                $(this).closest('tr').remove();
            });
        });
    </script>

</x-layout-dashboard>

