@extends('layouts.auto_layouts')
@section('title', 'Page Not Found - Auto Service')
@section('body-class', 'page-error')
@section('content')
<div>
   <div class="section-error-area">
      <div class="section-media-container">
         <h1 class="media-title">404</h1>
         <h2 class="media-text-info">Page <br><span>not found</span></h2>
         <h3 class="media-text">Sorry, this page does not exist on our website.<br> You may have entered the wrong address.</h3>
         <ul>
            <li>
               <a class="media-psevdo-btn" href="{{ route('home_auto') }}">Go to the home page</a>
            </li>
         </ul>
      </div>
   </div>
</div>
@endsection
