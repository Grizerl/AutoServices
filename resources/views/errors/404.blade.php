@extends('layouts.auto_layouts')
@section('title', 'Автосервіс - Car Services and Mechanic')
@section('body-class', 'page-error')
@section('content')
<div>
   <div class="section-error-area">
      <div class="section-media-container">
         <h1 class="media-title">404</h1>
         <h2 class="media-text-info">Сторінка <br><span>не знайдена</span></h2>
         <h3 class="media-text">Вибачте, але такої сторінки немає на нашому сайті.<br> Можливо, ви ввели неправильну адресу.</h3>
         <ul>
            <li>
               <a class="media-psevdo-btn" href="{{ route('home_auto') }}">Перейти на головну</a>
            </li>
         </ul>
      </div>
   </div>
</div>
@endsection
