@extends('admin.dashboard.master')

@section('main_content')

<section class="content-body" style="background-color: #f8f9fa;">
<div class="container-fluid">

```
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-primary"><i class="fa fa-plus-circle me-2"></i>Add Menu</h2>
    <a class="btn btn-dark" href="{{ route('menus.index') }}">
        <i class="fa fa-arrow-left"></i> Back
    </a>
</div>

@if ($errors->any())
<div class="alert alert-danger shadow-sm">
    <strong class="text-danger">Whoops!</strong> Please correct the following:
    <ul class="mt-2 mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card shadow-lg border-0 rounded-4">
    <div class="card-body p-4">
        {!! Form::open(['route' => 'menus.store','method' => 'POST','id'=>'menuForm']) !!}
        <div class="row g-4">

            <div class="col-md-6">
                <label class="fw-bold">Menu Name <span class="text-danger">*</span></label>
                {!! Form::text('menu_name', null, ['class'=>'form-control form-control-lg rounded-3','id'=>'menu_name','placeholder'=>'Enter menu name']) !!}
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Menu URL / Slug</label>
                {!! Form::text('menu_url', null, ['class'=>'form-control form-control-lg rounded-3','id'=>'menu_url','placeholder'=>'Auto-generated from name']) !!}
            </div>

            <div class="col-md-12">
                <label class="fw-bold">Menu Parent</label>
                <select class="form-select form-select-lg rounded-3 select2" name="menu_parent">
                    <option value="0">No Parent</option>
                    @foreach($menus as $menu)
                    <option value="{{$menu->id}}">{{$menu->menu_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Permission</label>
                <select class="form-select form-select-lg select2" name="menu_permission">
                    <option value="0">Select Permission</option>
                    @foreach($permission_lists as $list)
                    <option value="{{$list->name}}">{{$list->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 d-flex align-items-center">
                <a class="btn btn-outline-primary btn-sm mt-1" href="{{ route('permissions.create')}}">
                    <i class="fa fa-plus"></i> Add Permission
                </a>
            </div>

            <div class="col-md-12">
                <label class="fw-bold">Menu Type</label><br>
                <label class="me-3"><input class="menu_location_backend" type="checkbox" name="menu_type" value="backend"><strong class="ms-1">Backend</strong></label>
                <label><input class="menu_location" type="checkbox" name="menu_type" value="frontend"><strong class="ms-1">Frontend</strong></label>
            </div>

            <div class="col-md-12 menu_location_div">
                <label class="fw-bold">Menu Location</label>
                <select class="form-select form-select-lg rounded-3" name="menu_location">
                    <option value="Header">Header</option>
                    <option value="Footer">Footer</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Menu Icon</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i id="iconPreview"></i></span>
                    <input type="text" name="menu_icon" class="form-control form-control-lg" placeholder="Type or pick icon" id="iconInput">
                    <!-- <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#iconModal"><i class="fa fa-icons"></i> Pick</button> -->
                </div>
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Menu Highlight Color</label>
                <input type="color" name="menu_color" class="form-control form-control-lg rounded-3" value="#0d6efd">
            </div>

            <div class="col-md-6">
                <label class="fw-bold">Status</label>
                <select name="status" class="form-select form-select-lg rounded-3">
                    <option value="1" selected>Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                <i class="fa fa-save me-2"></i> Save Menu
            </button>
        </div>
        {!! Form::close() !!}
    </div>
</div>

<!-- ICON MODAL -->
<div class="modal" id="iconModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Select FontAwesome Icon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="text" id="iconSearch" class="form-control mb-3" placeholder="Search icons...">
        <div class="row g-2" id="iconList"></div>
      </div>
    </div>
  </div>
</div>
```

</div>

<!-- CSS/JS -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function(){

    // Select2 initialization
    // $('.select2').select2({ placeholder:'Select an option', allowClear:true });

    // Menu type toggle
    $(".menu_location_div").hide();
    $(".menu_location").click(function(){ 
        $(".menu_location_div").show(300); 
        $('.menu_location_backend').prop('checked', false); 
    });
    $(".menu_location_backend").click(function(){ 
        $(".menu_location_div").hide(); 
        $('.menu_location').prop('checked', false); 
    });

    // Auto-generate slug
    $('#menu_name').on('keyup', function(){ 
        $('#menu_url').val($(this).val().toLowerCase().trim().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'')); 
    });

    // FontAwesome icons array
    const faIcons = [
        'fa-solid fa-house','fa-solid fa-user','fa-solid fa-cog','fa-solid fa-chart-line','fa-solid fa-envelope',
        'fa-solid fa-bell','fa-solid fa-book','fa-solid fa-camera','fa-solid fa-heart','fa-solid fa-star',
        'fa-solid fa-trash','fa-solid fa-edit','fa-solid fa-search','fa-solid fa-lock','fa-solid fa-globe',
        'fa-solid fa-file','fa-solid fa-folder','fa-solid fa-tag','fa-solid fa-cart-shopping','fa-solid fa-comments',
        'fa-solid fa-paper-plane','fa-solid fa-calendar','fa-solid fa-play','fa-solid fa-pause','fa-solid fa-stop',
        'fa-solid fa-upload','fa-solid fa-download','fa-solid fa-magnifying-glass','fa-solid fa-microphone',
        'fa-solid fa-shield','fa-solid fa-phone','fa-solid fa-map','fa-solid fa-location-dot','fa-solid fa-clock',
        'fa-solid fa-rss','fa-solid fa-link','fa-solid fa-lock-open','fa-solid fa-key','fa-solid fa-gift'
    ];

    function renderIcons(filter=''){
        $('#iconList').html('');
        let filtered = faIcons.filter(i => i.includes(filter));
        if(filtered.length === 0){
            $('#iconList').html('<p class="text-muted">No icons found.</p>');
        } else {
            filtered.forEach(icon => {
                $('#iconList').append(`
                    <div class="col-2 text-center mb-3">
                        <i class="${icon} fs-2 iconPicker" style="cursor:pointer"></i>
                        <div class="small mt-1 text-truncate">${icon}</div>
                    </div>
                `);
            });
        }
    }

    // // Bootstrap 5 modal API
    // const iconModalEl = document.getElementById('iconModal');
    // const iconModal = new bootstrap.Modal(iconModalEl);

    // Bootstrap 5 modal API
const iconModalEl = document.getElementById('iconModal');
const iconModal = new bootstrap.Modal(iconModalEl, { backdrop: 'static', keyboard: false });

    // Render icons on modal show
    $('#iconModal').on('shown.bs.modal', function () {
        renderIcons();
        $('#iconSearch').val('');
    });

    // Search icons
    $('#iconSearch').on('input', function(){
        renderIcons($(this).val().trim());
    });

// Pick icon
$(document).on('click','.iconPicker',function(){
    let classes = $(this).attr('class').split(' ')
                    .filter(c => c !== 'iconPicker' && c !== 'fs-2')
                    .join(' ');
    $('#iconInput').val(classes);
    $('#iconPreview').attr('class', classes);

    iconModal.hide(); // THIS WILL NOW WORK
});

    // Live preview typing
    $('#iconInput').on('input', function(){
        $('#iconPreview').attr('class', $(this).val().trim());
    });

});
</script>

@endsection
