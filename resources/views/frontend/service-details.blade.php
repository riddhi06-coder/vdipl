<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')

    <style>

    .test
        {
        display: block !important;
        }
    </style>

</head>

<body>
    @include('components.frontend.header')


    @if($intro)
        <div class="about-image-container">
            <img src="{{ asset('uploads/service/' . $intro->banner_image) }}" alt="{{ $intro->banner_heading }}">
            <div class="text">
              <h1>{{ $service->service }}</h1>
                <p class="breadcrumb">
                    <a href="{{ route('home.page') }}">Home</a> &nbsp; &gt; {{ $service->service }}
                </p>
            </div>
        </div>
    @endif


    @if(!empty($intro))
        <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
            <h2>{{ $intro->section_heading ?? '' }}</h2>
        </div>          
        
        <section class="container123">
            <div class="container mt-5">
                <div class="row d-flex justify-content-around">
                    
                    <div class="col-xl-6 col-lg-6 col-md-12 p-2"> 
                        @if(!empty($intro->image))
                            <img src="{{ asset('uploads/service/' . $intro->image) }}" alt="{{ $service->service ?? 'Image' }}" class="img-fluid w-100">
                        @endif
                    </div>
                        
                    <div class="col-xl-6 col-lg-6 col-md-12 bg-row2 test">
                        <p class="text-p">
                            {!! $intro->description ?? '' !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    @endif


  
  
  
    @if(!empty($intro) && !empty($intro->section_heading2))
        <section class="accordion-main"> 

            <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                    <h2>{{ $intro->section_heading2 ?? '' }}</h2>
            </div>

            @if(!empty($bannerTitles) && !empty($bannerImages) && !empty($bannerDescriptions))
                <div class="container my-5">
                    <div class="row g-4">
                        @foreach($bannerTitles as $index => $title)
                            <div class="col-md-3 card-main11">
                                <div class="service-card">
                                    <img src="{{ asset('uploads/service/' . ($bannerImages[$index] ?? 'default.jpg')) }}" alt="{{ $title }}">
                                    <h4 class="service-title">{{ $title }}</h4>
                                    <p class="service-desc">{{ $bannerDescriptions[$index] ?? '' }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </section>
    @endif

  
  
   
    @if(!empty($choose))
        <section class="URBAN-main mt-5"> 

            @if(!empty($choose->section_heading))
                <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                    @php
                        $words = explode(' ', $choose->section_heading);
                    @endphp
                    @foreach(array_chunk($words, 2) as $chunk)
                        <h2>{{ implode(' ', $chunk) }}</h2>
                    @endforeach
                </div>
            @endif

            <section class="container123">
                <div class="container mt-5">
                    <div class="row row-main bg-row">
                        @if(!empty($choose->description))
                            <p class="text-p">{!! $choose->description !!}</p>
                        @endif
                    </div>
                </div>
            </section>

            @if(!empty($choose->section_heading2))
                <section class="way pb-5">
                    <div class="container py-3">
                        <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                            <h2>{{ $choose->section_heading2 }}</h2>
                        </div>

                        @if(!empty($bannerchooseTitles) && !empty($bannerchooseImages) && !empty($bannerchooseDescriptions))
                            <div class="row text-left">
                                @foreach ($bannerchooseTitles as $index => $title)
                                    <div class="col-lg-4 col-md-6 mt-5 card-main1">
                                        <div class="icon-box">
                                            <div class="icon-container">
                                                <img src="{{ asset('uploads/service/' . ($bannerchooseImages[$index] ?? 'default.jpg')) }}" alt="Service Banner" style="height:50px; width:50px">
                                            </div>
                                            <p class="feature-title">{{ $title }}</p>
                                            <p>{{ $bannerchooseDescriptions[$index] ?? '' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </section>
            @endif

        </section>
    @endif

      

    <button
            type="button"
            class="btn btn-danger btn-floating btn-lg"
            id="btn-back-to-top"
            >
        <i class="fas fa-arrow-up"></i>
    </button>


    @include('components.frontend.footer')
            
    @include('components.frontend.main-js')
        
                    
</body>
</html>