<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
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
                    <form class="form-box">
                    <div class="container-block form-wrapper">
                        <div class="responsive-container-block">
                        <div class="left4">
                            <div class="responsive-cell-block wk-ipadp-6 wk-tab-12 wk-mobile-12 wk-desk-6" id="i10mt-2">
                            <input class="input" id="ijowk-2" name="FirstName" placeholder="First Name">
                            </div>
                            <!--<div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">-->
                            <!--  <input class="input" id="indfi-2" name="Last Name" placeholder="Last Name">-->
                            <!--</div>-->
                            <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12">
                            <input class="input" id="ipmgh-2" name="Email" placeholder="Email Address">
                            </div>
                            <div class="responsive-cell-block wk-desk-6 wk-ipadp-6 wk-tab-12 wk-mobile-12 lastPhone">
                            <input class="input" id="imgis-2" name="PhoneNumber" placeholder="Phone Number">
                            </div>
                        </div>
                        <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i634i-2">
                            <textarea class="textinput" id="i5vyy-2" placeholder="Message"></textarea>
                        </div>
                        </div>
                        <a class="send" href="#" id="w-c-s-bgc_p-1-dm-id">
                        Send
                        </a>
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