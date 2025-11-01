<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile / </span>{{ $user->name }}</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-responsive">
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>Profile Photo</td>
                        <td>
                            @if( $user->profile_image != '' || $user->profile_image != NULL )
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="{{ $user->name }}" class="img-thumbnail rounded" width="100">
                            @else
                                <p class="text-info mb-0">Profile Photo is Missing!</p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Designation</td>
                        <td>
                            <strong>{{ $user->designation }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <strong>{{ $user->email }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Profile Creation Date</td>
                        <td>
                            <strong>{{ $user->created_at }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Profile Last Updated On</td>
                        <td>
                            <strong>{{ $user->updated_at }}</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <a href="{{ url('list-user') }}" class="btn btn-primary mt-3">User List</a>
    <a href="{{ url('edit-user/' . $user->id ) }}" class="btn btn-info mt-3">Edit User</a>
    <a href="{{ url('delete-user/' . $user->id ) }}" class="btn btn-danger mt-3">Delete User</a>

</x-layout-dashboard>