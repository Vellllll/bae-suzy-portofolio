@extends('admin.admin_master')
@section('admin')

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Blogs</h4>
                        {{-- <p class="card-title-desc">DataTables has most features enabled by
                            default, so all you need to do to use it with your own tables is to call
                            the construction function: <code>$().DataTable();</code>.
                        </p> --}}

                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Blog Category</th>
                                <th>Blog Title</th>
                                <th>Blog Tags</th>
                                <th>Blog Image</th>
                                <th>Action</th>
                            </tr>
                            </thead>


                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $blog['blogcategory']['blog_category'] }}</td>
                                        <td>{{ $blog->blog_title }}</td>
                                        <td>{{ $blog->blog_tags }}</td>
                                        <td><img src="{{ asset($blog->blog_image) }}" style="width: 100px; height:100px;" alt=""></td>
                                        <td>
                                            <a href="{{ route('edit.blog.page', $blog->id) }}" class="btn btn-info btn-sm" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('delete.blog', $blog->id) }}" class="btn btn-danger btn-sm" title="Delete Data" id="delete">
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
