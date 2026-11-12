@extends('layouts.auto_layouts')

@section('title', 'Partners - Auto Service')
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
                <h1 class="section-licenses-content-title">Licenses</h1>
            </div>
            <div class="section-charter-container">
                <div class="charter-box-first-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Official distributor of ELF materials</span></div>
                <div class="charter-box-first-img"> <img src="/assets/partners/charter.png" alt="Charter"><span>Official distributor of Moly materials</span></div>
                <div class="charter-box-first-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Official distributor of Castrol materials</span></div>
                
                <div class="charter-box-second-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Official distributor of Shell materials</span></div>
                <div class="charter-box-second-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Official distributor of Mobil materials</span></div>
                <div class="charter-box-second-img"> <img  src="/assets/partners/charter.png" alt="Charter"><span>Official distributor of Motul materials</span></div>
            </div>
        </div>
    </div>
</section>
<section>
    <div>
        <div class="section-partners-container">
            <div class="section-partners-container">
                <div class="container">
                    <div style="display: flex; align-items: center; justify-content: center;"><h1 class="section-partners-title">Partners</h1></div>
                    <div  style="display: flex; align-items: center; justify-content: center;">
                        <div class="grid-partners">
                            <div class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/ArmTek.png" alt="ARMTEK logo"><span class="title-company">ARMTEK</span></div>
                            <div  class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/Sachs.png" alt="Sachs logo"><span  class="title-company">Sachs</span></div>
                            <div  class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/Kyb.png" alt="Kyb logo"><span  class="title-company">Kyb</span></div>
                            <div class="partners-box-first-img"><img class="logo-partners" src="/assets/partners/partners-company/Smotor.png" alt="SMotor logo"><span  class="title-company">SMotor</span></div>
                            <div  class="partners-box-second-img"><img class="logo-partners" src="/assets/partners/partners-company/avtoExperet.png" alt="AvtoExpert logo"><span  class="title-company">AvtoExpert</span></div>
                            <div class="partners-box-second-img"><img class="logo-partners" src="/assets/partners/partners-company/Smile.png" alt="Smile logo"><span  class="title-company">Smile</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection