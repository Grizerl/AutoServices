@extends('layouts.admin_layouts')
@section('title', 'Add plan')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Add subscription plan</h3></div>
      <form action="{{ route('plans.store') }}" method="post">
        @include('admin.plans._form', ['submit' => 'Create plan'])
      </form>
    </div>
  </div>
</section>
@endsection
