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

                <li class="sidebar-list"> <i class="fa fa-thumb-tack"> </i><a class="sidebar-link sidebar-title" href="{{ route('manage-services.index') }}">
                    <svg class="stroke-icon"> 
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-sample-page') }}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{ asset('admin/assets/svg/icon-sprite.svg#stroke-sample-page') }}"></use>
                    </svg><span>Service</span></a>
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
                    <li><a href="{{ route('home-banner.index') }}">Service</a></li>
                    <li><a href="{{ route('manage-projects.index') }}">Our Projects</a></li>
                    <li><a href="{{ route('manage-clientele.index') }}">Clientele</a></li>
                    <li><a href="{{ route('manage-associates.index') }}">Associates</a></li>
                  </ul>
                </li>

              </ul>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
          </nav>
        </div>