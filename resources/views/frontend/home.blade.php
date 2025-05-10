<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
</head>

<body>
    @include('components.frontend.header')

    <section class="banner slider-fade">
        <div class="video-banner">
            @if(!empty($banner->banner_video))
                <video autoplay muted loop playsinline>
                    <source src="{{ asset('uploads/home/' . $banner->banner_video) }}" type="video/mp4">
                </video>
            @endif
            <div class="video-overlay"></div>
            <div class="banner-content">
                <h1>{{ $banner->banner_heading ?? 'Default Heading' }}</h1>
            </div>
        </div>
    </section>

    <div class="product-section">
      <div class="container-fluid">
        <div class="heading text-center" data-aos="fade-up" data-aos-duration="1000">
            <h2>{{ $homeServices->first()->banner_heading ?? 'Default Heading' }}</h2>
        </div>

        <div class="row gx-lg-5">
          <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="owl-carousel owl-theme productslider">

              @foreach($homeServices as $item)
              <div class="item">
                <div class="single-serv-item">
                  <div class="service-bg">
                    <div class="service-icon">
                      <img src="{{ asset('uploads/home/' . $item->banner_image2) }}">
                    </div>
                    <img src="{{ asset('uploads/home/' . $item->banner_image) }}" alt="">
                  </div>
                  <div class="service-info">
                    <h5>{{ $services[$item->service_id]->service ?? 'Service Name' }}</h5>
                    <a href="#" class="details-icon">
                      <i class="fa fa-arrow-right-long"></i>
                    </a>
                  </div>
                </div>
              </div>
              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="about-section gray-bg">
      <div class="container">
        <div class="row gx-lg-5 align-center">
          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="about-img-wrap">
              @if(!empty($banner->banner_image))
                <img class="image-one img-fluid" src="{{ asset('uploads/home/' . $banner->banner_image) }}">
              @endif
              @if(!empty($banner->banner_image2))
                <img class="image-two img-fluid" src="{{ asset('uploads/home/' . $banner->banner_image2) }}">
              @endif
            </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="about-content-wrap">
              <div class="heading heading-left" data-aos="fade-up" data-aos-duration="1000">
                <h2>{{ $banner->section_heading ?? 'Section Heading' }}</h2>
              </div>

              <p>{!! $banner->description !!}</p>

              <div class="row mT60">
                @foreach(json_decode($banner->banner_items ?? '[]', true) as $item)
                  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 col-4">
                    <div class="single-counter-box">
                      <p class="counter-number"><span class="purecounter counter">{{ $item['count'] }}</span>+</p>
                      <h6>{{ $item['name'] }}</h6>
                    </div>
                  </div>
                @endforeach
              </div>

              <a href="{{ url('/about') }}" class="theme-btn" data-aos="fade-up" data-aos-duration="1000">Learn More</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="projects-section">
        <div class="container-fluid">
            <div class="heading text-center" data-aos="fade-up" data-aos-duration="1400">
                <h2>{{ $projects->first()->banner_heading ?? 'Default Heading' }}</h2>
            </div>
            <div class="row gx-lg-5">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="owl-carousel owl-theme projectslider">
                        @foreach($projects as $project)
                            <div class="item">
                                <div class="single-project-item">
                                    <div class="project-img">
                                        <!-- Display project image -->
                                        <img src="{{ asset('uploads/home/' . $project->banner_image) }}" class="img-fluid">
                                    </div>
                                    <div class="project-content">
                                        <p><span style="font-weight: bold;">Project :</span> {{ $project->description }}</p>
                                        <p><span style="font-weight: bold;">Location&nbsp;:</span> {{ $project->location }}</p>
                                        <p><span style="font-weight: bold;">Cost&nbsp;:</span> {{ $project->cost }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clients-section">
        <div class="container">
            <div class="clients-wrap">
                <div class="heading text-center" data-aos="fade-up" data-aos-duration="1000">
                    <h2>{{ $clientele->heading }}</h2>
                </div>
                <div class="row gx-lg-5 mt-5">
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <h6><span>{{ $clientele->section_heading }}</span></h6>
                        <div class="owl-carousel owl-theme clientsliderone">
                            @if($clientele && $clientele->banner_items)
                                @foreach(json_decode($clientele->banner_items, true) as $item)
                                    <div class="item">
                                        <img src="{{ asset('uploads/home/' . $item['image']) }}" class="img-fluid" alt="client logo">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6">
                        <h6><span>{{ $clientele->section_heading2 }}</span></h6>
                        <div class="owl-carousel owl-theme clientslidertwo">
                            @if($clientele && $clientele->items)
                                @foreach(json_decode($clientele->items, true) as $item)
                                    <div class="item">
                                        <img src="{{ asset('uploads/home/' . $item['image']) }}" class="img-fluid" alt="client logo">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="clients-section mb-5">
      <div class="container">
        <div class="clients-wrap">
          <div class="heading text-center" data-aos="fade-up" data-aos-duration="1000">
            <h2>{{ $associates->heading }}</h2>
          </div>
          <div class="row gx-lg-5 owl-carousel-items-row">
            <div class="col-xl-4 col-lg-6 col-md-6 p-0 mr-1 owl-carousel-items">
              <h6><span>{{ $associates->section_heading }}</span></h6>
              <div class="owl-carousel owl-theme clientslider123">
                @foreach(json_decode($associates->banner_items, true) as $item)
                  <div class="item">
                    <img src="{{ asset('uploads/home/' . $item['image']) }}" class="img-fluid" alt="client logo">
                  </div>
                @endforeach
              </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 p-0 mr-1 owl-carousel-items">
              <h6><span>{{ $associates->section_heading2 }}</span></h6>
              <div class="owl-carousel owl-theme clientslider123">
                @foreach(json_decode($associates->items, true) as $item)
                  <div class="item">
                    <img src="{{ asset('uploads/home/' . $item['image']) }}" class="img-fluid" alt="client logo">
                  </div>
                @endforeach
              </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-md-6 p-0 mr-1 owl-carousel-items">
              <h6><span>{{ $associates->section_heading3 }}</span></h6>
              <div class="owl-carousel owl-theme clientslider123">
                @foreach(json_decode($associates->items1, true) as $item)
                  <div class="item">
                    <img src="{{ asset('uploads/home/' . $item['image']) }}" class="img-fluid" alt="client logo">
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button
        type="button" class="btn btn-danger btn-floating btn-lg"
            id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    @include('components.frontend.footer')
            
    @include('components.frontend.main-js')

            
</body>
</html>