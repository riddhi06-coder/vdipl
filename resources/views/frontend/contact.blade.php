<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
    <style>
        .invalid-feedback{
            display: block;
            color: rgb(230, 23, 23);
            font-size: 14px;
        }
    </style>

</head>

<body>
    @include('components.frontend.header')
        
    <div class="about-image-container">
        <img src="{{ asset('uploads/contact/' . $contact->banner_image) }}" alt="Background Image">
        <div class="text">
            <h1 >{{ $contact->banner_title }}</h1>
            <p class="breadcrumb" >
                <a href="index.html" >Home</a>  &nbsp;  &gt; {{ $contact->banner_title }}
            </p>
        </div>
    </div>

    <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
        <h2>{{ $contact->section_title }}</h2>
    </div>
      
    <div class="container32">
        <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-phone"></i></div>
            <p><strong>Phone:</strong><br> <a href="tel:{{ $contact->phone }}">+91 {{ $contact->phone }}</a></p>
        </div>
        <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
            <p><strong>Address:</strong><br> {!! $contact->address !!}</p>
        </div>
    
        <div class="contact-card">
            <div class="contact-icon"><i class="fas fa-paper-plane"></i></div>
            <p><strong>Email:</strong><br> <a href="mailto:{{ $contact->email }}"> {{ $contact->email }}</a></p>
        </div>
    </div>
   
    <div  class="formmain"  style="background-color:#F5F5F7;">     
        <div class="heading text-center  " data-aos="fade-up" data-aos-duration="1000">
            <h2 >Get In Touch </h2>
        </div>
        <div class="new_home_web">
            <div class="responsive-container-block big-container">
                <div class="responsive-container-block container">
                <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-7 wk-ipadp-10 line" id="i69b">

                    <form class="form-box" id="ContactApplicationForm" method="POST" action="{{ route('send.contact') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="container-block form-wrapper">
                            <div class="responsive-container-block">
                            <div class="left4">
                                <div class="responsive-cell-block wk-ipadp-6 wk-tab-12 wk-mobile-12 wk-desk-6" id="i10mt-2">
                                <input class="input" id="FirstName" name="FirstName" placeholder="First Name*" value="{{ old('FirstName') }}">
                                @error('FirstName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                               
                                <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                                <input class="input" id="Email" name="Email" placeholder="Email Address*" value="{{ old('Email') }}">
                                @error('Email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12 lastPhone">
                                <input class="input" id="PhoneNumber" name="PhoneNumber" placeholder="Phone Number*" value="{{ old('PhoneNumber') }}">
                                @error('PhoneNumber')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i634i-2">
                                <textarea class="textinput" id="user_message" name="user_message" placeholder="Message">{{ old('user_message') }}</textarea>
                                @error('user_message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            </div>
                            <button type="submit" class="send" id="w-c-s-bgc_p-1-dm-id">Send</button>
                        </div>
                    </form>

                </div>
                </div>
            </div>
        </div>
    </div>
      
    
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