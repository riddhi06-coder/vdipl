<header>
      <section class="topbar-section">
        <div class="container">
          <div class="row">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6 dnone">
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
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-6">
            @php
                $contact = \App\Models\Contact::latest()->first(); // Adjust query if needed
            @endphp

            @if($contact)
                <div class="topbar-info">
                    <ul>
                        @if($contact->phone)
                            <li>
                                <img src="{{ asset('frontend/assets/images/icons/contact/webp/phone-white.webp') }}">
                                <a href="tel:{{ $contact->phone }}">+91 {{ $contact->phone }}</a>
                            </li>
                        @endif
                        @if($contact->email)
                            <li>
                                <img src="{{ asset('frontend/assets/images/icons/contact/webp/email-white.webp') }}">
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif

            </div>
          </div>
        </div>
      </section>
      <!-- header start -->
      <section class="main_menu">
        <div class="container">
          <div class="row v-center">
            <div class="header-item item-left">
              <div class="logo">
                <a href="{{ route('home.page') }}"><img src="{{ asset('frontend/assets/images/home/vdipl-logo.webp') }}"></a>
              </div>
            </div>
            <!-- menu start here -->
            <div class="header-item item-center">
              <div class="menu-overlay"></div>
              <nav class="menu">
                <div class="mobile-menu-head">
                  <div class="go-back"><i class="fa fa-angle-left"></i></div>
                  <div class="current-menu-title"></div>
                  <div class="mobile-menu-close">×</div>
                </div>
                <ul class="menu-main">
                  <li><a href="{{ route('home.page') }}">Home</a></li>
                 <li class="menu-item-has-children">
                    <a href="{{ route('about.us') }}">About Us  <i class="fa fa-angle-down"></i></a>
                    <div class="sub-menu single-column-menu">
                      <ul>
                        
                        <li><a href="{{ route('our.leadership') }}">Our Leadership</a></li>
                       
                      </ul>
                    </div>
                  </li>
                  @php
                      use App\Models\Service;
                      $services = Service::whereNull('deleted_by')->get();
                  @endphp

                  <li class="menu-item-has-children">
                    <a href="#">Services <i class="fa fa-angle-down"></i></a>
                    <div class="sub-menu single-column-menu">
                      <ul>
                        @foreach($services as $service)
                          <li><a href="{{ route('services', $service->slug) }}">{{ $service->service }}</a></li>
                        @endforeach
                      </ul>
                    </div>
                  </li>

                  <li><a href="{{ route('projects') }}">Projects</a></li>
                  <li><a href="{{ route('our.assets') }}">Our Assesets</a></li>
                  <li><a href="{{ route('careers') }}">Careers</a></li>
                  <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
              </nav>
            </div><!-- menu end here -->
            <div class="header-item header-right-item item-right">
              <!-- mobile menu trigger -->
              <div class="mobile-menu-trigger">
                <span></span>
              </div>
            </div>
          </div>
        </div>
      </section>
    </header>