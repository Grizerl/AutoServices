@extends('layouts.admin_layouts')
@section('title', 'Edit car')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Edit {{ $car->title }}</h3></div>
      <form action="{{ route('cars.update', $car) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.cars._form', ['submit' => 'Save changes'])
      </form>
    </div>
  </div>
</section>
@endsection
