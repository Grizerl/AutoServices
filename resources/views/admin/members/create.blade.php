@extends('layouts.admin_layouts')
@section('title', 'Add team member')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Add team member</h3></div>
      <form action="{{ route('members.store') }}" method="post" enctype="multipart/form-data">
        @include('admin.members._form', ['submit' => 'Create member'])
      </form>
    </div>
  </div>
</section>
@endsection
