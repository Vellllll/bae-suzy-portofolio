@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Portofolios</h4>
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                            default, so all you need to do to use it with your own tables is to call
                            the construction function: <code>$().DataTable();</code>.
                        </p> --}}

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Portfolio Name</th>
                                <th>Portfolio Title</th>
                                <th>Portfolio Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($portfolios as $portfolio)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $portfolio->portfolio_name }}</td>
                                        <td>{{ $portfolio->portfolio_title }}</td>
                                        <td><img src="{{ asset($portfolio->portfolio_image) }}" style="width: 100px; height:100px;" alt=""></td>
                                        <td>
                                            <a href="{{ route('edit.portfolio.page', $portfolio->id) }}" class="btn btn-info btn-sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('delete.portfolio', $portfolio->id) }}" class="btn btn-danger btn-sm" title="Delete Data" id="delete">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

    </div> <!-- container-fluid -->
</div>

@endsection
