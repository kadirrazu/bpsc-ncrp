@php

    $designations = [
        'System Manager',
        'Senior System Analyst',
        'System Analyst',
        'Senior Programmer',
        'Programmer',
        'Assistant Programmer',
    ];

@endphp

<x-layout-dashboard>

    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add / </span>User</h4>

    <!-- Basic Form -->
     <div class="row mb-6 gy-6">
        <div class="col-xxl">
            <div class="card">
                <div class="card-body">
                <form method="POST" action="{{ url('add-user') }}" enctype="multipart/form-data">

                    @csrf

                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Profile Image</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="icon-base bx bx-image"></i></span>
                                <input class="form-control" type="file" name="profile_image">
                            </div>
                            <div class="form-text">You can upload a 300X300px image. Max size 200kb.</div>
                            @error('profile_image')
                                <p class="text-danger mt-2 mb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"><i class="icon-base bx bx-user"></i></span>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
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

                                    <option>Plese pick a designation</option>

                                    @foreach($designations as $designation)
                                        <option value="{{ $designation }}" {{ old('designation') == $designation ? 'selected' : '' }}>{{ $designation }}</option>
                                    @endforeach
                                    
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
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
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