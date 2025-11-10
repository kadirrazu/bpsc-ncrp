@props(['model', 'id', 'edit' => true])

<div class="action-buttons">

    <span x-init @ajax:before="$dispatch('dialog:open')">
        <a class="btn btn-sm btn-primary" href="{{ url('view-issue-data/' . $id . '/' . $model) }}" x-target="view-data">View</a>
    </span>    

    &nbsp;

    @if($edit != false )
        <span x-init @ajax:before="$dispatch('dialog:open')">
            <a class="btn btn-sm btn-secondary" href="{{ url('edit-issue-data/' . $id . '/' . $model) }}" x-target="edit-data">Solve</a>
        </span>
         &nbsp;
    @endif

</div>