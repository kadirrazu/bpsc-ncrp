<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">List / </span>All Users</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        <th>Action Buttons</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">

                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->designation }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ url('view-user/' . $user->id ) }}" class="btn btn-primary btn-sm">View</a>
                            <a href="{{ url('edit-user/' . $user->id ) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <a href="{{ url('delete-user/' . $user->id ) }}" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

</x-layout-dashboard>