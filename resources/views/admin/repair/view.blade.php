@extends('layouts.admin_layouts')
@section('title', 'Repair request')
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="header-view-container">
      <div class="view-content">
        <div>
          <img class="view-img-car" src="{{ asset('assets/images/Car-repaire.png') }}" alt="Car">
        </div>
        <div>
          <h2 class="view-title">Repair request #{{ $repair->id }}</h2>
          <ul class="view-list">
            <li class="view-item"><b>Customer name: </b><span>{{ $repair->name }}</span></li>
            <li class="view-item"><b>Phone number: </b><a href="tel:{{ preg_replace('/[^\d+]/', '', $repair->telephone) }}">{{ $repair->telephone }}</a></li>
            <li class="view-item"><b>Car: </b><span>{{ $repair->car }}</span></li>
            <li class="view-item"><b>Problem: </b><span>{{ $repair->comment }}</span></li>
            <li class="view-item"><b>Price: </b><span>${{ number_format($repair->price) }}</span></li>
            <li class="view-item"><b>Status: </b><span>{{ $repair->status_label }}</span></li>
            <li class="view-item"><b>Received: </b><span>{{ $repair->created_at?->format('Y-m-d H:i') }}</span></li>
          </ul>
          <a href="{{ route('repair.edit', $repair) }}" class="btn btn-info"><i class="fas fa-pencil-alt"></i> Edit</a>
          <a href="{{ route('repair.index') }}" class="btn btn-default">Back to list</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
