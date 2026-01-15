@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add Page</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('pages.index') }}"> Back</a>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


{!! Form::open(array('route' => 'pages.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">

            <div class="form-group">
                <strong>Page Name:</strong>
                {!! Form::text('page_name', null, array('placeholder' => 'Page Name','class' => 'form-control')) !!}
            </div>

            <div class="form-group">
                <strong>Page Description</strong>
              <textarea class="form-control"  name="page_description" placeholder="Enter Page Description"></textarea>
            </div>
            <br>

          <div class="form-group">
              <strong>Page Link:</strong>
              {!! Form::text('page_link', null, array('placeholder' => 'Page Link','class' => 'form-control')) !!}
          </div>

              <div class="form-group">
                  <strong>Page Image:</strong>
              {{--     {!! Form::file('slider_image', null, array('placeholder' => 'Slider Image','class' => 'form-control')) !!} --}}
                <input type="file" name="page_image" class="form-control" onchange="previewFile(this);">
                   <img src="" height="55" alt="Page Image" id="previewImg" />
              </div>

            <div class="form-group">
                <strong>Page Status</strong>
               <select name="status" class="form-control">
                   <option value="1">Active</option>
                   <option value="0">In Active</option>
               </select>
            </div>
            
        </div>
{{--     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="https://cdn.tiny.cloud/1/yfnw3w8klca6fy8agnjalelwtx9hgo92c7q5fq7kz47pjqgl/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

  <script>
    tinymce.init({
      selector: 'textarea',
      plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
      toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    });


       function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }
  </script>

@endsection