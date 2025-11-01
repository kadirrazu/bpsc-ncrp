@props(['model', 'id', 'edit' => true])

<div class="action-buttons mt-3" x-data="{
    confirm : function(event){
        result = confirm('Sure? You want to delete this record?');
        if( result === false){
            event.preventDefault()
        }
    }
}">
    <a class="btn btn-primary" href="{{ url('list-' . $model ) }}">List {{ ucfirst($model) }}</a> &nbsp;

    @if($edit != false )
        <a class="btn btn-secondary" href="{{ url('edit-' . $model . '/' . $id) }}">Edit {{ ucfirst($model) }}</a> &nbsp;
    @endif

    <form class="d-inline" method="POST" action="{{ url('delete-' . $model . '/' . $id) }}">
        @csrf 
        <button class="btn btn-danger" confirm="Sure? You really want to Delete?"
        @click="confirm"
        >
            Delete {{ ucfirst($model) }}
        </button>
    </form>
</div>