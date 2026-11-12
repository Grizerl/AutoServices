@extends('layouts.admin_layouts')
@section('title', 'Add review')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Add review</h3></div>
      <form action="{{ route('client.store') }}" method="post">
        @include('admin.client._form', ['submit' => 'Create review'])
      </form>
    </div>
  </div>
</section>
@endsection
