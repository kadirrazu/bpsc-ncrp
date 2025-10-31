<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile / </span>{{ $user->name }}</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-responsive">
                <tr>
                        <th>Field Name</th>
                        <th>Data</th>
                      </tr>
                    </thead>
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>Profile Photo</td>
                        <td>
                            <img src="{{ asset('assets/img/avatars/' . $user->id . '.png') }}" alt="{{ $user->name }}" class="img-thumbnail rounded">
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

    <a href="{{ url('change-password') }}" class="btn btn-secondary mt-3">Change Password</a>

</x-layout-dashboard>