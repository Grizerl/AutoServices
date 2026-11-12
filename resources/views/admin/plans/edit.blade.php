@extends('layouts.admin_layouts')
@section('title', 'Edit plan')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Edit {{ $plan->name }}</h3></div>
      <form action="{{ route('plans.update', $plan) }}" method="post">
        @method('PUT')
        @include('admin.plans._form', ['submit' => 'Save changes'])
      </form>
    </div>
  </div>
</section>
@endsection
