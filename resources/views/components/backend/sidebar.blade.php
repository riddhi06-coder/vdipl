 <!-- Page Body Start-->
 <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
          <div class="logo-wrapper">
          <div style="text-align: center;">
              <a href="{{ route('admin.dashboard') }}">
                  <img src="{{ asset('admin/assets/images/logo/logo.webp') }}"
                      alt=""
                      style="width: 100px; height: 60px; object-fit: contain;">
              </a>
          </div>

		  <div class="back-btn"><i class="fa fa-angle-left"> </i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
          </div>
          <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/favicon.webp') }}" alt=""  style="width: 60px; height: 40px; object-fit: contain;"></a></div>
          <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
              <ul class="sidebar-links" id="simple-bar">
                <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="{{ asset('admin/assets/images/logo/logo.webp') }}" alt=""></a>
                  <div class="mobile-back text-end"> <span>Back </span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                </li>
                <li class="pin-title sidebar-main-title">
                  <div> 
                    <h6>Pinned</h6>
                  </div>
                </li>
                <li class="sidebar-main-title">
                  <div>
                    <h6 class="lan-1">General</h6>
                  </div>
                </li>

                <li class="sidebar-list"><i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}">
                    <svg class="stroke-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#fill-home') }}"></use>
                    </svg><span class="lan-3">Dashboard </span>
                  </a>
                </li>


                <li class="sidebar-list {{ request()->is('manage-services*','manage-service-details.index*') ? 'active' : '' }}">
                  <i class="fa fa-thumb-tack"> </i>
                  <a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#cart') }}"></use>
                    </svg>
                    <span>Service</span>
                  </a>
                  <ul class="sidebar-submenu">
                    <li>
                      <a href="{{ route('manage-services.index') }}" class="{{ request()->routeIs('manage-services.index') ? 'active' : '' }}">
                      Service
                      </a>
                    </li>

                    <li>
                      <a class="submenu-title" href="#">
                      Service Details
                        <span class="sub-arrow"><i class="fa fa-angle-right"></i></span>
                      </a>
                      <ul class="nav-sub-childmenu submenu-content">
                        <li><a href="{{ route('manage-service-intro.index') }}" class="{{ request()->routeIs('manage-service-intro.index') ? 'active' : '' }}">Introduction</a></li>
                        <li><a href="{{ route('manage-service-whychoose.index') }}" class="{{ request()->routeIs('manage-service-whychoose.index') ? 'active' : '' }}">Why Choose</a></li>
                      </ul>
                    </li>

                  </ul>
                </li>

                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-widget') }}"></use>
                    </svg><span>Home</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('home-banner.index') }}">Banner & Innovation</a></li>
                    <li><a href="{{ route('manage-home-services.index') }}">Service</a></li>
                    <li><a href="{{ route('manage-projects.index') }}">Our Projects</a></li>
                    <li><a href="{{ route('manage-clientele.index') }}">Clientele</a></li>
                    <li><a href="{{ route('manage-associates.index') }}">Associates</a></li>
                  </ul>
                </li>


                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-file') }}"></use>
                    </svg><span>About Us</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-about.index') }}">About Us</a></li>
                    <li><a href="{{ route('manage-leadership.index') }}">Leadership</a></li>
                  </ul>
                </li>

                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="{{ route('projects-details.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-to-do') }}"></use>
                    </svg><span>Projects</span></a>
                </li>

                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="{{ route('manage-assets.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use>
                    </svg><span>Our Assets</span></a>
                </li>

                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="#">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#expense') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#expense') }}"></use>
                    </svg><span>Careers</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{ route('manage-career-intro.index') }}">Introduction</a></li>
                    <li><a href="{{ route('manage-Job.index') }}">Job Details</a></li>
                  </ul>
                </li>

                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="{{ route('manage-contact.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-contact') }}"></use>
                    </svg><span>Contact</span></a>
                </li>

              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>