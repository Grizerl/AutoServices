@extends('layouts.auto_layouts')

@section('title', 'Автосервіс - Car Services and Mechanic')
@section('body-class', 'page-partners')


@section('content')

<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">Partner</h2>
         <div>
            <ul class="container-nav-item">
               <li>
                  <a  class="cont-list" href="{{ route('home_auto') }}">Home</a>
               </li>
               <li  class="cont-list"><i class="fas fa-angle-right"></i></li>
               <li>
                  <a  class="cont-list">Partner</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
<section>
    <div class="section-licenses-container">
        <div class="container">
            <div class="section-licenses-content">
                <h1 class="section-licenses-content-title">Ліцензії</h1>
            </div>
            <div class="section-charter-container">
                <div class="charter-box-first-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Офіційний дистриб'ютор матеріалів марки ELF</span></div>
                <div class="charter-box-first-img"> <img src="/assets/partners/charter.png" alt="Charter"><span>Офіційний дистриб'ютор матеріалів марки Moly</span></div>
                <div class="charter-box-first-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Офіційний дистриб'ютор матеріалів марки Castrol</span></div>
                
                <div class="charter-box-second-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Офіційний дистриб'ютор матеріалів марки ШЕЛЛ</span></div>
                <div class="charter-box-second-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Офіційний дистриб'ютор матеріалів марки Mobil</span></div>
                <div class="charter-box-second-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Офіційний дистриб'ютор матеріалів марки Motul</span></div>
            </div>
        </div>
    </div>
</section>
<section>
    <div>
        <div class="section-partners-container">
            <div class="section-partners-container">
                <div class="container">
                    <div style="display: flex; align-items: center; justify-content: center;"><h1 class="section-partners-title">Партнери</h1></div>
                    <div  style="display: flex; align-items: center; justify-content: center;">
                        <div class="grid-partners">
                            <div class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/ArmTek.png" alt="Компанія «АРМТЕК»"><span class="title-company">Компанія «АРМТЕК»</span></div>
                            <div  class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/Sachs.png" alt="Компанія «Sachs"><span  class="title-company">Компанія «Sachs»</span></div>
                            <div  class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/Kyb.png" alt="Компанія «Kyb»"><span  class="title-company">Компанія «Kyb»</span></div>
                            <div class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/Smotor.png" alt="Компанія «SMotor»"><span  class="title-company">Компанія «SMotor»</span></div>
                            <div  class="partners-box-second-img"><img class="logo-partners" src="/assets/partners/partners-company/avtoExperet.png" alt="Компанія «AvtoExpert»"><span  class="title-company">Компанія «AvtoExpert»</span></div>
                            <div class="partners-box-second-img"><img class="logo-partners" src="/assets/partners/partners-company/Smile.png" alt="Компанія «Smile»"><span  class="title-company">Компанія «Smile»</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection