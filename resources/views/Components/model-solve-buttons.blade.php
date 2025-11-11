@props(['model', 'id', 'edit' => true])

<div class="action-buttons">
    
    <span x-data="{ viewContentPlaceholder: 'Loading...', loadViewContent: async function() {
        this.viewContentPlaceholder = 'Loading...'; // Optional: show a loading state
        try {
            let response = await fetch('{{ url('view-issue-data/' . $id . '/' . $model) }}');
            let data = await response.text(); // or .json() if expecting JSON
            this.viewContentPlaceholder = data;
        } catch (error) {
            console.error('Error fetching content:', error);
            this.viewContentPlaceholder = 'Failed to load content.';
        }
    }}">
        <a class="btn btn-sm btn-secondary" href="{{ url('view-issue-data/' . $id . '/' . $model) }}" data-bs-toggle="modal" data-bs-target="#myModalView-{{ $id }}"  x-on:click="loadViewContent()">View</a>

        <div class="modal fade" id="myModalView-{{ $id }}" tabindex="-1" aria-labelledby="EditData" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditData">View Data <span class="text-info">[E-TYPE]</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div x-html="viewContentPlaceholder"></div>
                    </div>
                </div>
            </div>
        </div>
    </span>

    &nbsp;

    @if($edit != false )
        <span x-data="{ editContentPlaceholder: 'Loading...', loadEditContent: async function() {
            this.editContentPlaceholder = 'Loading...'; // Optional: show a loading state
            try {
                let response = await fetch('{{ url('edit-issue-data/' . $id . '/' . $model) }}');
                let data = await response.text(); // or .json() if expecting JSON
                this.editContentPlaceholder = data;
            } catch (error) {
                console.error('Error fetching content:', error);
                this.editContentPlaceholder = 'Failed to load content.';
            }
        }}">
            <a class="btn btn-sm btn-primary" href="{{ url('edit-issue-data/' . $id . '/' . $model) }}" data-bs-toggle="modal" data-bs-target="#myModalEdit-{{ $id }}"  x-on:click="loadEditContent()">Solve</a>

            <div class="modal fade" id="myModalEdit-{{ $id }}" tabindex="-1" aria-labelledby="EditData" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="EditData">Edit Data <span class="text-info">[E-TYPE]</span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div x-html="editContentPlaceholder"></div>
                        </div>
                    </div>
                </div>
            </div>
        </span>
    @endif

</div>