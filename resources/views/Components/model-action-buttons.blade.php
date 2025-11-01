@props(['model', 'id', 'edit' => true])

<div class="action-buttons" x-data="{
    confirm : function(event){
        result = confirm('Sure? You want to delete this record?');
        if( result === false){
            event.preventDefault()
        }
    }
}">
    <a class="btn btn-sm btn-primary" href="{{ url('view-' . $model . '/' . $id) }}">View</a> &nbsp;

    @if($edit != false )
        <a class="btn btn-sm btn-secondary" href="{{ url('edit-' . $model . '/' . $id) }}">Edit</a> &nbsp;
    @endif

    <form class="d-inline" method="POST" action="{{ url('delete-' . $model . '/' . $id) }}">
        @csrf 
        <button class="btn btn-sm btn-danger" confirm="Sure? You really want to Delete?"
        @click="confirm"
        >
            Delete
        </button>
    </form>
</div>