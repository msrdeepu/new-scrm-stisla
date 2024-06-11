@extends('superadmin.layouts.master')

@section('title')
    <title>Super Admin Panel</title>
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Admin</h4>
                        </div>
                        <div class="card-body">
                            10
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="far fa-newspaper"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>News</h4>
                        </div>
                        <div class="card-body">
                            42
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="far fa-file"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Reports</h4>
                        </div>
                        <div class="card-body">
                            1,201
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-circle"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Online Users</h4>
                        </div>
                        <div class="card-body">
                            47
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped">
                    <tr>
                        <th>
                            <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                    class="custom-control-input" id="checkbox-all">
                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                        </th>
                        <th>From</th>
                        <th>Message</th>
                        <th>Attachment</th>
                        <th>To</th>
                        <th>Status</th>
                    </tr>
                    @foreach ($messages as $item)
                        @php
                            $imagePaths = json_decode($item->attachment, true); // Decode JSON as associative array
                        @endphp
                        <tr>
                            <td class="p-0 text-center">
                                <div class="custom-checkbox custom-control">
                                    <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                        id="checkbox-1">
                                    <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                                </div>
                            </td>
                            <td> {{ $item->from_id }}</td>
                            <td class="align-middle">
                                {{ $item->body }}
                            </td>

                            <td>
                                @if (is_array($imagePaths) && !empty($imagePaths))
                                    @foreach ($imagePaths as $imagePath)
                                        <img alt="image" src="{{ asset($imagePath) }}" class="" width="50"
                                            data-toggle="tooltip" title="{{ $item->body }}">
                                    @endforeach
                                @elseif (is_string($imagePaths))
                                    <img alt="image" src="{{ asset($imagePaths) }}" class="" width="50"
                                        data-toggle="tooltip" title="{{ $item->body }}">
                                @endif
                            </td>

                            <td> {{ $item->to_id }}</td>
                            <td>
                                <div class="badge badge-success">Completed</div>
                            </td>
                        </tr>
                    @endforeach


                </table>
                {{ $messages->links() }}
            </div>
        </div>

    </section>
@endsection
