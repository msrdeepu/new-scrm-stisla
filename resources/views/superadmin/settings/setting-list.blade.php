@extends('superadmin.layouts.master')

@section('title')
    <title>Super Admin Panel</title>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Settings List</h1>
        </div>

        <div class="row">

            <div class="col-12 d-flex flex-row justify-content-end mb-3">
                <a href="{{ route('settings.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> New
                    Setting</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Settings Table</h4>
                        <div class="card-header-form">
                            <form>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>

                                    <th>Sl</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>P-Code</th>
                                    <th>Dorder</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($data as $item)
                                    <tr>

                                        <td>{{ ++$loop->index }}</td>
                                        <td class="align-middle">
                                            {{ $item->type }}
                                        </td>

                                        <td> {{ $item->name }}</td>
                                        <td> {{ $item->parent }}</td>
                                        <td> {{ $item->dorder }}</td>
                                        <td> {{ $item->status }}</td>
                                        <td> {{ $item->status }}</td>

                                        <td><a href="#" class="btn btn-primary">Detail</a></td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $data->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
