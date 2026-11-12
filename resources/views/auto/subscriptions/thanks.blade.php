@extends('layouts.auto_layouts')

@section('title', 'Request received - Auto Service')
@section('body-class', 'page-plan')

@section('content')
<div class="wrapper">
   <x-page-banner title="Request received" :crumbs="[['Subscription', route('plan')], ['Thank you']]" />

   <section class="thanks">
      <div class="container">
         @include('auto.subscriptions._summary', ['subscription' => $subscription])
      </div>
   </section>
</div>
@include('partials.contact-strip')
@endsection
