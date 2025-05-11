<footer>
      <div class="container">
        <div class="row">
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
            <a href="{{ route('home.page') }}"><img src="{{ asset('frontend/assets/images/home/vdipl-footer-logo.webp') }}" alt="footer-logo"></a>
            <p class="morbi">VAIBHAVDESHMUKH INFRAPROJECTS PVT LTD (VDIPL) was founded in 2007 under the visionary leadership of Mr. Vaibhav Deshmukh, who relentlessly pursued his dream to create an enterprise that would leave a lasting impact on India’s infrastructure landscape. Initially established as M/s Vaibhav Construction, the company has since evolved into VDIPL, a trusted name in the industry.
            </p>
          </div> 
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
            <div class="row two-rows-wrap">
              <div class="col-6">
            <h2 class="useful-link-text">Useful Links</h2>
                <ul class="usefulLinks-List">
                  <li><a href="{{ route('home.page') }}">Home</a></li>
                  <li><a href="{{ route('about.us') }}">About Us</a></li>
                  <li><a href="#">Services</a></li>
                  <li><a href="{{ route('projects') }}">Projects</a></li>
                  <li><a href="{{ route('our.assets') }}">Our Assesets</a></li>
                  <li><a href="careers.html">Careers</a></li>
                  <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
              </div>
              <div class="col-6">
            <h2 class="useful-link-text">Services</h2>
              <ul class="usefulLinks-List">
                  @php
                      use App\Models\Service;
                      $services = Service::whereNull('deleted_by')->get();
                  @endphp

                  @foreach($services as $service)
                      <li><a href="{{ route('services', $service->slug) }}">{{ $service->service }}</a></li>
                  @endforeach
              </ul>

              </div>
            </div>
          </div>
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12">
            <h2 class="useful-link-text">Contact Us</h2>
            <div class="head-phone-white-main">
              <div class="headphone-white">
                <img src="{{ asset('frontend/assets/images//icons/contact/webp/phone-white.webp') }}" alt="headphone-white">
              </div>

              @php
                  $contact = \App\Models\Contact::latest()->first(); // Adjust query if needed
              @endphp
              <div>
                <p class="CallUs">Call Us</p>
                <a href="tel:+91 {{ $contact->phone }} " class="CallUs-phone">
                  +91 {{ $contact->phone }} 
                </a>
              </div>
            </div>
            <div class="head-phone-white-main">
              <div class="headphone-white">
                <img src="{{ asset('frontend/assets/images//icons/contact/webp/email-white.webp') }}" alt="email-White">
              </div>
              <div>
                <p class="CallUs">Email Us</p>
                <a href="mailto:{{ $contact->email }}" class="CallUs-phone">
                  {{ $contact->email }}
                </a>
              </div>
            </div>
            <div class="head-phone-white-main">
              <div class="headphone-white">
                <img src="{{ asset('frontend/assets/images//icons/contact/webp/maps-white.webp') }}" alt="loaction-white">
              </div>
              <div>
                <p class="CallUs">Find Us</p>
                <p class="CallUs-phone">{!! $contact->address !!}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <!-- ====================================== Copyright ===================================== -->
    <div class="copyright-main">
      <div class="container">
        <div class="rights-reserved">
          <h2>
            <div id="copyright">
                Copyright © <?php echo date('Y'); ?> VDIPL. All rights reserved. Designed By <a href="http://www.matrixbricks.com" target="_blank">Matrix Bricks</a></div>
            </h2>
            @php
                $contact = \App\Models\Contact::latest()->first(); // Adjust this query as needed
                $platforms = json_decode($contact->social_platforms ?? '[]', true);
                $urls = json_decode($contact->social_urls ?? '[]', true);

                // Mapping platform to Font Awesome icon class
                $iconMap = [
                    'Facebook' => 'fa-facebook-f',
                    'Twitter' => 'fa-x-twitter',
                    'Instagram' => 'fa-instagram',
                    'LinkedIn' => 'fa-linkedin-in',
                    'Youtube' => 'fa-youtube',
                    'Watsapp' => 'fa-whatsapp',
                    'Pinterest' => 'fa-pinterest-p'
                ];
            @endphp
            @if(!empty($platforms) && !empty($urls))
                <div class="social-links">
                    <ul>
                        @foreach($platforms as $index => $platform)
                            @php
                                $url = $urls[$index] ?? '#';
                                $icon = $iconMap[$platform] ?? 'fa-share-alt'; // fallback icon
                            @endphp
                            <a href="{{ $url }}" target="_blank"><i class="fa-brands {{ $icon }}"></i></a>
                        @endforeach
                    </ul>
                </div>
            @endif

        </div>
      </div>
    </div>