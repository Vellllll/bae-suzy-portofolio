@extends('admin.admin_master')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Add Blog Category</h4>
                        <form action="{{ route('store.blog.category') }}" method="POST" id="blog_category_form">
                            @csrf

                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Blog Category</label>
                                <div class="form-group col-sm-10">
                                    <input name="blog_category" class="form-control" type="text" id="example-text-input">
                                    @error('blog_category')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <input type="submit" class="btn btn-info waves-effect waves-light" value="Add Blog Category">
                        </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#blog_category_form').validate({
            rules: {
                blog_category: {
                    required: true,
                },
            },
            messages: {
                blog_category: {
                    required: 'Please enter blog category!',
                },
            },
            errorElement: 'span',
            errorPlacement: function(error,element){
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight : function(element, errorClass, validClass){
                $(element).addClass('is-invalid');
            },
            unhighlight : function(element, errorClass, validClass){
                $(element).removeClass('is-invalid');
            },
        })
    })
</script>

@endsection

