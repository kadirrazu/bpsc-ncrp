<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Change Password / </span>{{ $user->name }}</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-responsive">
                <tbody class="table-border-bottom-0">
                    <tr>
                        <td>Name</td>
                        <td>
                            <strong>{{ $user->name }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>
                            <strong>{{ $user->email }}</strong>
                        </td>
                    </tr>

                    <form method="POST" action="{{ url('change-password') }}">

                        @csrf

                        <tr>
                            <td>Current Password</td>
                            <td>
                                <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="form-control">
                                @error('current_password')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>New Password</td>
                            <td>
                                <input id="new_password" type="password" name="new_password" required autocomplete="new-password" class="form-control">
                                @error('new_password')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td>Confirm New Password</td>
                            <td>
                                <input id="new_password_confirmation" type="password" name="new_password_confirmation" required autocomplete="new-password" class="form-control">
                                @error('new_password_confirmation')
                                    <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-success mb-3">Update Password</button>
                            </td>
                        </tr>

                    </form>

                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

</x-layout-dashboard>