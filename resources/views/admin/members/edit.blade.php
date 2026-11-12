@extends('layouts.admin_layouts')
@section('title', 'Edit team member')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Edit team member</h3></div>
      <form action="{{ route('members.update', $member) }}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.members._form', ['submit' => 'Save changes'])
      </form>
    </div>
  </div>
</section>
@endsection
