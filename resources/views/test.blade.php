@extends('user.master')
@section('content')
    @include('user.includes.slide')
@section('title', 'Oil and Gas industrial and marine engineering RAL offshore')
@section('keywords', 'Oil and Gas industrial , marine engineering services , RAL offshore , marine engineering in Middle East')
@section('description', 'Oil and Gas industrial and marine engineering RAL offshore | you can find RAL offshore Services and marine engineering in RAL offshore website')


<section class="home-company">
    <div class="container">
        <div class="row company">
            <div class="col-md-5 col-sm-8">
                <div class="company-details">
                    <h2 class="company-title color-title"> THE COMPANY </h2>
                    <h4 class="company-subtitle subtitle">As an integrated subsea contractor, RAL provides a range of subsea services to support the delivery to technical reliable and viable solution to clients in all environments. </h4>
                    <p>Combining staff experience with RAL’s subsea assets and system, we are able to deliver various projects depending in client’s requirements.</p>
                    <a href="#" class="btn btn-primary" role="button"> READ OUR MISSION </a>
                </div>
            </div>
            <div class="col-md-7 col-sm-12">
                <div class="company-image">
                    <div class="img-left hover-effect">
                        <img src="{{ asset('assets/user/images/company-image2.jpg') }}" alt="Company Image" />
                    </div>
                    <div class="img-right hover-effect">
                        <img src="{{ asset('assets/user/images/company-image1.jpg') }}" alt="Company Image" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{--<section class="home-ceo">--}}
{{--<div class="container">--}}
{{--<div class="row ceo">--}}
{{--<div class="col-md-6">--}}
{{--<div class="ceo-photo">--}}
{{--<img src="{{ asset('assets/user/images/ceo.png') }}" alt="CEO" />--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-6">--}}
{{--<div class="ceo-details">--}}
{{--<h2 class="ceo-title color-title"> WORD FROM CEO </h2>--}}
{{--<h4 class="ceo-subtitle subtitle"> READ THE MESSAGE FROM OUR CEO </h4>--}}
{{--<p> Proactively incubate enterprise total linkage without sustainable leadership skills. Monotonectally strategize user-centric interfaces whereas low-risk high-yield materials. Efficiently syndicate web-enabled portals for principle centered partnerships.--}}
{{--</p>--}}
{{--<p>Proactively whiteboard revolutionary processes after scalable testing procedures. Holisticly reinvent seamless after business.</p>--}}
{{--<h4 class="ceo-sign"> <img src="{{ asset('assets/user/images/ceo-sign.png') }}" alt="signature" /> </h4>--}}
{{--<p class="ceo-name">Gregory Walker, CEO</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
{{--<section class="home-services">--}}
{{--<div class="container">--}}
{{--<div class="row services">--}}
{{--<div class="col-md-4">--}}
{{--<div class="hover-effect">--}}
{{--<img src="{{ asset('assets/user/images/services-one.jpg') }}" alt="technology-innovation" />--}}
{{--</div>--}}
{{--<h4 class="services-title-one subtitle">TECHNOLOGY &amp; INNOVATION</h4>--}}
{{--<p>Professionally drive clicks-and-mortar web readiness after progressive e-commerce. Dramatically unleash cross functional.</p>--}}
{{--<a href="#" class="btn btn-default btn-normal">Read More</a>--}}
{{--</div>--}}
{{--<div class="col-md-4">--}}
{{--<div class="hover-effect">--}}
{{--<img src="{{ asset('assets/user/images/services-two.jpg') }}" alt="our-operations" />--}}
{{--</div>--}}
{{--<h4 class="services-title-one subtitle">OUR OPERATIONS</h4>--}}
{{--<p>Energistically productize wireless mindshare for emerging experiences. Myocardinate enabled alignments and magnetic scenarios. </p>--}}
{{--<a href="#" class="btn btn-default btn-normal">Read More</a>--}}
{{--</div>--}}
{{--<div class="col-md-4">--}}
{{--<div class="hover-effect">--}}
{{--<img src="{{ asset('assets/user/images/services-three.jpg') }}" alt="social-resposibility" />--}}
{{--</div>--}}
{{--<h4 class="services-title-one subtitle">SOCIAL RESPONIBILITY</h4>--}}
{{--<p>Globally incubate principle-centered e-markets with standards compliant catalysts for change. Efficiently extend highly efficient products.</p>--}}
{{--<a href="#" class="btn btn-default btn-normal">Read More</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
{{--<section class="home-links">--}}
{{--<div class="container">--}}
{{--<div class="row links">--}}
{{--<div class="col-md-2">--}}
{{--<h4 class="links-title subtitle">Quick Links</h4>--}}
{{--</div>--}}
{{--<div class="col-md-2">--}}
{{--<a href="#" class="btn btn-primary" role="button">CAREERS</a>--}}
{{--</div>--}}
{{--<div class="col-md-2">--}}
{{--<a href="#" class="btn btn-primary" role="button">CONTACT</a>--}}
{{--</div>--}}
{{--<div class="col-md-2">--}}
{{--<a href="#" class="btn btn-primary" role="button">MARKET INFO</a>--}}
{{--</div>--}}
{{--<div class="col-md-2">--}}
{{--<a href="#" class="btn btn-primary" role="button">TECHNOLOGY</a>--}}
{{--</div>--}}
{{--<div class="col-md-2">--}}
{{--<a href="#" class="btn btn-primary" role="button">LATEST NEWS</a>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
{{--<section class="home-process">--}}
{{--<div class="container">--}}
{{--<div class="row process">--}}
{{--<div class="col-sm-6">--}}
{{--<h2 class="process-title title-2"> OUR PROCESS </h2>--}}
{{--<h4 class="process-subtitle subtitle-2"> Interactively empower diverse imperatives after prospective convergence. </h4>--}}
{{--<p> Interactively fashion functional action items after 24/365 results. Dynamically redefine world-class metrics without leading-edge markets. Progressively orchestrate enabled "outside the box" thinking via scalable quality vectors. Objectively unleash optimal core competencies. </p>--}}
{{--<a href="#" class="btn btn-primary" role="button">READ THE STORY</a>--}}
{{--</div>--}}
{{--<div class="col-sm-6">--}}
{{--<div id="skills" class="process-bar">--}}
{{--<div class="skillbar-title"> FEUL AND MISCELLANEOUS </div>--}}
{{--<div class="skillbar" data-percent="46%">--}}
{{--<div class="skillbar-bar"> </div>--}}
{{--<div class="skill-bar-percent">46%</div>--}}
{{--</div>--}}
{{--<div class="skillbar-title"> LIQUID CHEMICALS </div>--}}
{{--<div class="skillbar" data-percent="78%">--}}
{{--<div class="skillbar-bar"> </div>--}}
{{--<div class="skill-bar-percent">78%</div>--}}
{{--</div>--}}
{{--<div class="skillbar-title"> MONOMERS / POLYMERS </div>--}}
{{--<div class="skillbar" data-percent="70%">--}}
{{--<div class="skillbar-bar"> </div>--}}
{{--<div class="skill-bar-percent">70%</div>--}}
{{--</div>--}}
{{--<div class="skillbar-title"> ISOCYANATE </div>--}}
{{--<div class="skillbar" data-percent="80%">--}}
{{--<div class="skillbar-bar"> </div>--}}
{{--<div class="skill-bar-percent">80%</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
{{--<section class="home-stats">--}}
{{--<div class="container">--}}
{{--<div class="row stats">--}}
{{--<div class="col-md-3 col-xs-6">--}}
{{--<img src="{{ asset('assets/user/images/globe.png')}} " alt="" />--}}
{{--<div class="stats-info">--}}
{{--<h4 class="counter">26</h4>--}}
{{--<p>Offices Worldwide</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-3 col-xs-6">--}}
{{--<img src="{{ asset('assets/user/images/friends.png')}} " alt="" />--}}
{{--<div class="stats-info">--}}
{{--<h4 class="counter">10000</h4>--}}
{{--<p>Satisfied Employees</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-3 col-xs-6">--}}
{{--<img src="{{ asset('assets/user/images/fire.png')}} " alt="" />--}}
{{--<div class="stats-info">--}}
{{--<h4 class="counter">126</h4>--}}
{{--<p>Refineries &amp; Operations</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-3 col-xs-6">--}}
{{--<img src="{{ asset('assets/user/images/badge.png')}} " alt="" />--}}
{{--<div class="stats-info">--}}
{{--<h4 class="counter">35</h4>--}}
{{--<p>Awards &amp; Recognitions</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
{{--<section class="home-services-other">--}}
{{--    <div class="container">--}}
{{--        <div class="section-title text-center">--}}
{{--            <h2 class="title-services-other title-2">Why to choose RAL?</h2>--}}
{{--            <p class="subtitle-services-other subtitle-2">We have extensive industry knowledge and experience in various installation areas.</p>--}}
{{--            <p class="subtitle-services-other subtitle-2">We are able to offer our clients expertise in all areas of offshore design, project management transpiration and installation which further enhance our services to our customers.</p>--}}
{{--            <div class="spacer-50"> </div>--}}
{{--        </div>--}}
{{--        <div class="row services-other">--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon1.png') }}" alt="SHELL CHEMICALS" />--}}
{{--                </div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Offshore platforms installation.</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon2.png') }}" alt="COMMERCIAL FUELS" />--}}
{{--                </div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Riser Installation.</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon3.png') }}" alt="AVIATION FUELS" />--}}
{{--                </div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">PLEM & SBM Installation.</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="clearfix spacer-70"></div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon4.png') }}" alt="LUBRICANTS" />--}}
{{--                </div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Revamping and Existing Platforms maintenance.</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon5.png') }}" alt="MARINE FUELS" />--}}
{{--                </div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Offshore projects managements.</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon6.png') }}" alt="LIQUIFIED PETROLIUM GAS" />--}}
{{--                </div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Offshore Platforms renovation and maintenance.</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="clearfix spacer-70"></div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon7.png') }}" alt="SHELL SULPHUR" /></div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">PLEM & SBM installation </h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon8.png') }}" alt="SHELL TRADING" /></div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Riser replacement and Installation </h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-sm-4">--}}
{{--                <div class="img-box">--}}
{{--                    <img src="{{ asset('assets/user/images/service-icon9.png') }}" alt="SHELL FOR SUPPLIERS" /></div>--}}
{{--                <div class="services-info">--}}
{{--                    <h4 class="services-title-one subtitle">Shore Pull</h4>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<section class="home-testimonials">--}}
{{--<div class="container">--}}
{{--<div class="section-title text-center">--}}
{{--<h2 class="title-testimonials color-title">DON’T TAKE OUR WORD</h2>--}}
{{--<h2 class="subtitle-testimonials title-2">CLIENT TESTIMONIALS</h2>--}}
{{--<div class="spacer-50"> </div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--<div class="col-md-4">--}}
{{--<blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget leo ac nisi porta consectetur. Duis sit amet ligula turpis. Suspendisse eget hendrerit justo. Suspendisse elementum eleifend arcu in consequat. Nullam imperdiet, mauris a consequat pharetra, quam quam malesuada nisi, non scelerisque.</blockquote>--}}
{{--<h4 class="client-name">Calvin Sims</h4>--}}
{{--<p class="designation">Marketing Head, ABC Chemicals</p>--}}
{{--</div>--}}
{{--<div class="col-md-4">--}}
{{--<blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget leo ac nisi porta consectetur. Duis sit amet ligula turpis. Suspendisse eget hendrerit justo. Suspendisse elementum eleifend arcu in consequat. Nullam imperdiet, mauris a consequat pharetra, quam quam malesuada nisi, non scelerisque.</blockquote>--}}
{{--<h4 class="client-name">Bertha Gonzales</h4>--}}
{{--<p class="designation">Divisional Manager, Corpo Inc.</p>--}}
{{--</div>--}}
{{--<div class="col-md-4">--}}
{{--<blockquote>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean eget leo ac nisi porta consectetur. Duis sit amet ligula turpis. Suspendisse eget hendrerit justo. Suspendisse elementum eleifend arcu in consequat. Nullam imperdiet, mauris a consequat pharetra, quam quam malesuada nisi, non scelerisque.</blockquote>--}}
{{--<h4 class="client-name">Brianna Hernandez</h4>--}}
{{--<p class="designation">Founder &amp; CEO, Marine Engineering</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
{{--<section class="home-publications">--}}
{{--<div class="container">--}}
{{--<div class="row publications">--}}
{{--<div class="col-md-7 col-sm-6">--}}
{{--<div class="panel-group" id="accordion">--}}
{{--<div class="panel panel-default">--}}
{{--<div class="panel-heading">--}}
{{--<h4 class="panel-title">--}}
{{--<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Petrolium Engineering</a>--}}
{{--</h4>--}}
{{--</div>--}}
{{--<div id="collapseOne" class="panel-collapse collapse in">--}}
{{--<div class="panel-body">--}}
{{--<p>Synergistically build professional communities vis-a-vis best-of-breed paradigms. Quickly empower world-class networks with prospective methodologies. Enthusiastically morph cross functional web-readiness via virtual niche markets. Synergistically enhance one-to-one partnerships after go forward metrics. Competently facilitate alternative networks for fully tested internal or "organic" sources. Synergistically disintermediate an expanded array of niche markets through value-added value. Dynamically communicate cost effective results after intuitive scenarios. Distinctively impact synergistic experiences. </p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="panel panel-default">--}}
{{--<div class="panel-heading">--}}
{{--<h4 class="panel-title">--}}
{{--<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">International Trade </a> </h4>--}}
{{--</div>--}}
{{--<div id="collapseTwo" class="panel-collapse collapse">--}}
{{--<div class="panel-body">--}}
{{--<p>Synergistically build professional communities vis-a-vis best-of-breed paradigms. Quickly empower world-class networks with prospective methodologies. Enthusiastically morph cross functional web-readiness via virtual niche markets. Synergistically enhance one-to-one partnerships after go forward metrics. Competently facilitate alternative networks for fully tested internal or "organic" sources. Synergistically disintermediate an expanded array of niche markets through value-added value. Dynamically communicate cost effective results after intuitive scenarios. Distinctively impact synergistic experiences.</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="panel panel-default">--}}
{{--<div class="panel-heading">--}}
{{--<h4 class="panel-title">--}}
{{--<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Chemicals and Refining </a> </h4>--}}
{{--</div>--}}
{{--<div id="collapseThree" class="panel-collapse collapse">--}}
{{--<div class="panel-body">--}}
{{--<p>Synergistically build professional communities vis-a-vis best-of-breed paradigms. Quickly empower world-class networks with prospective methodologies. Enthusiastically morph cross functional web-readiness via virtual niche markets. Synergistically enhance one-to-one partnerships after go forward metrics. Competently facilitate alternative networks for fully tested internal or "organic" sources. Synergistically disintermediate an expanded array of niche markets through value-added value. Dynamically communicate cost effective results after intuitive scenarios. Distinctively impact synergistic experiences.--}}
{{--</p>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="col-md-5 col-sm-6">--}}
{{--<div class="plubication-downloads">--}}
{{--<h2 class="publish">Publications</h2>--}}
{{--<div class="download-file">--}}
{{--<a href="#"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download PDF <span>1.5 MB</span> </a>--}}
{{--</div>--}}
{{--<p class="download-title">Other Downloads</p>--}}
{{--<ul class="download-list">--}}
{{--<li><a href="#"> Annual Report </a> <span>2.4 MB</span></li>--}}
{{--<li><a href="#"> Sustainability Report </a> <span>150 KB</span></li>--}}
{{--<li><a href="#"> Statistical Report </a> <span>250 KB</span></li>--}}
{{--<li><a href="#"> Energy Outlook </a> <span>1.8 MB</span></li>--}}
{{--<li><a href="#"> Chairman’s Message </a> <span>550 KB</span></li>--}}
{{--</ul>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</section>--}}
<section class="home-news">
    <div class="container">
        <div class="section-title text-center">
            {{--<h2 class="title-blog color-title"> NEWS AND MEDIA </h2>--}}
            <h2 class="subtitle-blog title-2"> LATEST NEWS </h2>
            <div class="spacer-50"> </div>
        </div>

        <div class="row news">
            @foreach( $articles as $single )
                <div class="col-md-4">
                    <div class="blog-img-box">
                        <div class="blog-date"> <span class="month">{{ $single->created_at->format('M') }} </span> <span class="date"> {{ $single->created_at->format('d') }}</span> </div>
                        <a class="hover-effect" href="#">
                            <img src="{{ url('/storage/app/public/article_covers/'.$single->image) }}" alt="{{ $single->title }}" />
                        </a>
                    </div>
                    <div class="blog-content">
                        <h3><a href="#"> {{ $single->title }} </a> </h3>
                        {{--<p>By <a href="#">Eduardo Flores</a> in Transportation</p>--}}
                    </div>
                </div>
            @endforeach
        </div>


        <div class="blog-btn text-center">
            <a href="#" class="btn btn-primary" role="button">READ MORE NEWS</a>
        </div>
    </div>
</section>

</main>
@endsection
