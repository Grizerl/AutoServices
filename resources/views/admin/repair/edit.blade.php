@extends('layouts.admin_layouts')
@section('title', 'Edit repair request')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="card card-primary">
      <div class="card-header"><h3 class="card-title">Repair request #{{ $repair->id }}</h3></div>
      <form action="{{ route('repair.update', $repair) }}" method="post">
        @csrf
        @method('PUT')
        <div class="card-body">
          <div class="row">
            <div class="col-md-6"><x-admin.input name="name" label="Customer name" :value="$repair->name" maxlength="60" /></div>
            <div class="col-md-6"><x-admin.input name="phone" label="Phone number" type="tel" :value="$repair->telephone" /></div>
            <div class="col-md-6"><x-admin.input name="car" label="Car" :value="$repair->car" maxlength="100" /></div>
            <div class="col-md-3"><x-admin.input name="price" label="Price ($)" type="number" min="0" step="1" :value="$repair->price" /></div>
            <div class="col-md-3"><x-admin.select name="done" label="Status" :options="\App\Models\Repair::STATUSES" :value="$repair->done" /></div>
          </div>
          <x-admin.textarea name="problem" label="Problem description" :value="$repair->comment" rows="4" maxlength="500" />
        </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
          <a href="{{ route('repair.index') }}" class="btn btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection
