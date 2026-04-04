@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body bg-white">
<div class="container">

<h4>Edit Plan – {{ $plan->name }}</h4>

<form method="POST" action="{{ route('admin.plans.update',$plan) }}">
@csrf
@method('PUT')

@include('admin.dashboard.plans.create', ['plan' => $plan])

</form>

</div>
</section>
@endsection
