@extends('superadmin.layouts.master')

@section('title')
    <title>Super Admin Panel</title>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Create New Setting</h1>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('settings.store') }}" method="POST">
                        @csrf
                        <div class="card col-12">
                            <div class="card-header">
                                <h4>Setting Form</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select name="type" class="form-control select2">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="name">Name</label>
                                        <input name="name" type="text" class="form-control" id="name"
                                            placeholder="Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="value">Value</label>
                                        <input name="value" type="text" class="form-control" id="value"
                                            placeholder="Name">
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="parent">Parent Code</label>
                                        <input name="parent" type="text" class="form-control" id="parent"
                                            placeholder="Parent Code">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="dorder">Display Order</label>
                                        <input name='dorder' class="form-control" id="dorder"
                                            placeholder="Display Order">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control select2">
                                                <option>Option 1</option>
                                                <option>Option 2</option>
                                                <option>Option 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <button class="btn btn-primary mt-0 mr-3" type="submit">Save</button>
                                <a href="{{ route('settings.index') }}" class="btn btn-danger mt-0 ml-3"
                                    type="reset">Cancel</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
