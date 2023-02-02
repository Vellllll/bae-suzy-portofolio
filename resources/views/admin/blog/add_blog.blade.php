@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<style type="text/css">
    .bootstrap-tagsinput .tag{
        margin-right: 2px;
        color: #b70000;
        font-weight: 700px;
    }
</style>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Blog</h4>
                        <form action="{{ route('store.blog') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Blog Category</label>
                                <div class="col-sm-10">
                                    <select name="blog_category_id" class="form-select" aria-label="Default select example">
                                        <option selected="">Open this select menu</option>
                                        @foreach ($blogcategories as $blogcategory)
                                            <option value="{{ $blogcategory->id }}">{{ $blogcategory->blog_category }}</option>
                                        @endforeach
                                        </select>
                                </div>
                            </div>
                            <!-- end row -->

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Title</label>
                                <div class="col-sm-10">
                                    <input name="blog_title" class="form-control" type="text" id="example-text-input">
                                    @error('blog_title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Blog Tags</label>
                                <div class="col-sm-10">
                                    <input type="text" name="blog_tags" class="form-control" data-role="tagsinput" value="">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Description</label>
                                <div class="col-sm-10">
                                    <textarea name="blog_description" id="elm1"></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Image</label>
                                <div class="col-sm-10">
                                    <input name="blog_image" class="form-control" type="file" id="image">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-3">
                                    <img id="showImage" class="card-img-top img-fluid" src="{{ url('upload/no_image.jpg') }}" alt="Card image cap">
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Blog">
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#image').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>

@endsection

