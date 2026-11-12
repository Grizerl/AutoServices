@extends('layouts.admin_layouts')
@section('title', $member->name)
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="portfolio-info">
      <img class="view-img" src="{{ $member->image_url }}" alt="Photo of {{ $member->name }}">
      <div class="text-container">
        <h2 class="view-title">Member information</h2>
        <ul class="view-list">
          <li class="view-item"><b>Name: </b><span>{{ $member->name }}</span></li>
          <li class="view-item"><b>Role: </b><span>{{ $member->role }}</span></li>
          <li class="view-item"><b>Phone number: </b><span>{{ $member->phone_number }}</span></li>
          <li class="view-item"><b>Age: </b><span>{{ $member->age }}</span></li>
          <li class="view-item"><b>Place of residence: </b><span>{{ $member->place_of_residence }}</span></li>
        </ul>
        <a href="{{ route('members.edit', $member) }}" class="btn btn-info"><i class="fas fa-pencil-alt"></i> Edit</a>
        <a href="{{ route('members.index') }}" class="btn btn-default">Back to list</a>
      </div>
    </div>
  </div>
</section>
@endsection
