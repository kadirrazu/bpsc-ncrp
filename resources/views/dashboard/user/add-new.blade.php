<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add a New </span>User</h4>

    <!-- Basic Form -->
     <div class="row mb-6 gy-6">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body">
                <form method="POST" action="{{ url('add-user') }}">

                    @csrf

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Profile Image</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="icon-base bx bx-image"></i></span>
                                <input class="form-control" type="file" name="profile_image">
                            </div>
                            <div class="form-text">You can upload a 200 X 200 px PNG image.</div>
                            @error('current_password')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="icon-base bx bx-user"></i></span>
                                <input type="text" class="form-control" name="name">
                            </div>
                            @error('name')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-company">Designation</label>
                        <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                <span id="basic-icon-default-company2" class="input-group-text"><i class="icon-base bx bx-badge"></i></span>
                                <select class="form-select" name="designation">
                                    <option selected>Plese pick a designation</option>
                                    <option value="System Manager">System Manager</option>
                                    <option value="Senior System Analyst">Senior System Analyst</option>
                                    <option value="System Analyst">System Analyst</option>
                                    <option value="Senior Programmer">Senior Programmer</option>
                                    <option value="Programmer">Programmer</option>
                                    <option value="Assistant Programmer">Assistant Programmer</option>
                                </select>
                            </div>
                            @error('designation')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="icon-base bx bx-envelope"></i></span>
                                <input type="text" class="form-control" name="email">
                            </div>
                            @error('email')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-phone">Password</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="icon-base bx bx-fingerprint"></i></span>
                                <input type="password"  class="form-control" name="password">
                            </div>
                            @error('password')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-phone">Password Confirmation</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-phone2" class="input-group-text"><i class="icon-base bx bx-fingerprint"></i></span>
                                <input type="password" class="form-control phone-mask" name="password_confirmation">
                            </div>
                            @error('password_confirmation')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
     </div>
    <!--/ Basic Form -->

</x-layout-dashboard>