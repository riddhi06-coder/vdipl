<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
</head>

<body>
    @include('components.frontend.header')


    <div class="about-image-container">
        <img src="{{ asset('uploads/about/' . $about->banner_image) }}" alt="Background Image">
        <div class="text">
            <h1>{{ $about->banner_heading }}</h1>
            <p class="breadcrumb">
                <a href="{{ route('home.page') }}">Home</a> &nbsp; &gt; {{ $about->banner_heading }}
            </p>
        </div>
    </div>

    <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
        <h2>{{ $about->banner_heading }}</h2>
    </div>
  

    <section class="container-p">
        <div class="container mt-5">
            <div class="row row-main">
                <p> {!! $about->description !!}</p>
            </div>
        </div>
    </section>


    <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000" style="margin:0; padding-top: 60px; background-color:#F5F5F7;">
        <h2>{{ $about->section_heading2 }}</h2>
    </div>

    <div class="container24">
        @foreach($about->vision_names as $index => $name)
            <div class="service-card24">
                <div class="icom-main">
                    <img src="{{ asset('uploads/about/' . $about->vision_images[$index]) }}" alt="{{ $name }}">
                </div>
                <h3>{{ $name }}</h3>
                <p>{{ $about->vision_descriptions[$index] }}</p>
            </div>
        @endforeach
    </div>

 
    <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
        <h2>{{ $about->section_heading3 }}</h2>
    </div>

    <div class="container container25 py-5">
        <div class="row row-main-25 gy-4">
            @foreach($about->core_values_names as $index => $name)
                <div class="col-md-6 for-card-main">
                    <div class="service-card25">
                        <div class="service-icon25">
                            <img src="{{ asset('uploads/about/' . $about->core_values_images[$index]) }}" alt="{{ $name }}">
                        </div>
                        <div class="content-card-service25">
                            <h5>{{ $name }}</h5>
                            <p>{{ $about->core_values_descriptions[$index] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <button
            type="button"
            class="btn btn-danger btn-floating btn-lg"
            id="btn-back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>


    @include('components.frontend.footer')
            
    @include('components.frontend.main-js')
        
                    
</body>
</html>