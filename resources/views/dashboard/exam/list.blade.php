<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">List / </span>All Users</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-responsive">
                <thead>
                    <tr>
                        <th>Sr.</th>
                        <th>Photo</th>
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
                        <td>
                          <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar pull-up" title="{{ $user->name }}" data-bs-original-title="{{ $user->name }}">
                                @if( $user->profile_image != '' || $user->profile_image != NULL )
                                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Avatar" class="rounded-circle">
                                @else
                                    <p class="text-danger mb-0">Empty!</p>
                                @endif
                            </li>
                          </ul>
                        </td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->designation }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <x-model-action-buttons model="user" id="{{ $user->id }}"/>
                        </td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

</x-layout-dashboard>