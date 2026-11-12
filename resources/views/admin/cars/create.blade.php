@extends('layouts.admin_layouts')
@section('title', 'Add car')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Add a car for sale</h3></div>
      <form action="{{ route('cars.store') }}" method="post" enctype="multipart/form-data">
        @include('admin.cars._form', ['submit' => 'Add car'])
      </form>
    </div>
  </div>
</section>
@endsection
