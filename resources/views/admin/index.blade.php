@extends('layouts.admin_layouts')
@section('title', 'Dashboard')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <h1 class="m-0">Welcome to the Admin Panel</h1>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      @php
        $boxes = [
          ['bg-info', $post, 'Blog posts', 'fa-blog', route('post.index')],
          ['bg-success', $client, 'Reviews', 'fa-comments', route('client.index')],
          ['bg-primary', $members, 'Team members', 'fa-user-plus', route('members.index')],
          ['bg-warning', $pending, 'Pending repair requests', 'fa-toolbox', route('repair.index')],
          ['bg-secondary', $repair, 'All repair requests', 'fa-car-burst', route('repair.index')],
          ['bg-danger', $contact, 'Questions', 'fa-circle-question', route('contact.index')],
          ['bg-teal', $cars, 'Cars available for sale', 'fa-car-side', route('cars.index')],
          ['bg-maroon', $carRequests, 'New car requests', 'fa-envelope-open-text', route('car-inquiries.index', ['status' => 'new'])],
          ['bg-orange', $pendingSubscriptions, 'Subscriptions to confirm', 'fa-id-card', route('subscriptions.index', ['status' => 'pending'])],
          ['bg-indigo', $activeSubscriptions, 'Active subscriptions', 'fa-circle-check', route('subscriptions.index', ['status' => 'active'])],
        ];
      @endphp
      @foreach ($boxes as [$color, $count, $label, $icon, $url])
        <div class="col-lg-4 col-6">
          <div class="small-box {{ $color }}">
            <div class="inner">
              <h3>{{ $count }}</h3>
              <p>{{ $label }}</p>
            </div>
            <div class="icon"><i class="fa-solid {{ $icon }}"></i></div>
            <a href="{{ $url }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
