@extends('superadmin.layouts.master')

@section('title')
    <title>Super Admin Profile</title>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Profile</div>
            </div>
        </div>
        <div class="section-body">


            <div class="row mt-sm-4">

                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate=""
                            action="{{ route('sadmin.updateprofile') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <h4>Edit Profile</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <img src="{{ asset(Auth::user()->avatar) }}" alt="" style="width: 100px">
                                </div>
                                <div class="row">

                                    <div class="form-group col-12">

                                        <label>Avatar</label>
                                        <input type="file" name="avatar" class="form-control" value=""
                                            required="">

                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ Auth::user()->name }}" required="">

                                    </div>

                                    <div class="form-group col-md-6 col-12">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ Auth::user()->email }}" required="">

                                    </div>

                                </div>


                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-12">


                    <div class="card">

                        <form method="post" class="needs-validation" novalidate=""
                            action="{{ route('sadmin.updatepassword') }}">
                            @csrf
                            <div class="card-header">
                                <h4>Update Password</h4>
                            </div>
                            <div class="card-body">

                                <div class="row">



                                    <div class="form-group col-12">
                                        <label>Current Password</label>
                                        <input type="password" class="form-control" name="current_password" value="">

                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>New Password</label>
                                        <input type="password" class="form-control" name="password" value="">

                                    </div>
                                    <div class="form-group col-md-6 col-12">
                                        <label>Confirm Password</label>
                                        <input type="password" class="form-control" name="password_confirmation"
                                            value="">

                                    </div>

                                </div>


                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
