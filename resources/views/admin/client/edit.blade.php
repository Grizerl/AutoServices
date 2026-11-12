@extends('layouts.admin_layouts')
@section('title', 'Edit review')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Edit review</h3></div>
      <form action="{{ route('client.update', $client) }}" method="post">
        @method('PUT')
        @include('admin.client._form', ['submit' => 'Save changes'])
      </form>
    </div>
  </div>
</section>
@endsection
