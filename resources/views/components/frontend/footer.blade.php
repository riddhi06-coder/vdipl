<footer class="footer-section">
    <div class="upper-footer">
        <div class="container">
            <div class="row">
                <div class="col col-xl-4 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="widget about-widget pe-0">
                        <p>For any issues related to any products give us a call or connect with us here</p>
                        <div class="contact-ft">
                            <ul>
                                @php
                                    $footer = \App\Models\HomeFooter::first();
                                @endphp
                                <li><i class="fa fa-envelope"></i>Email: <a href="mailto:{{ $footer->email }}">{{ $footer->email }}</a></li>
                                <li><i class="fa fa-phone"></i>  Call: <a href="tel:{{ $footer->contact_number }}">{{ $footer->contact_number }}</a></li>
                                <li>
                                    <i class="fa fa-map-marker"></i> 
                                    <a href="https://maps.app.goo.gl/1n97eYHCXh4vM7QV7" target="_blank" rel="noopener noreferrer">
                                        {!! $footer->address !!}
                                    </a>
                                </li>
                                <li><i class="fa fa-clock-o"></i> {{ $footer->time }}</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col col-lg-1 col-md-12 col-sm-12 col-12"></div>

                <div class="col col-lg-3 col-md-6 col-sm-12 col-12">
                    <div class="widget link-widget">
                        <div class="widget-title">
                            <h3>Quick Links</h3>
                        </div>
                        <ul>
                            <li><a href="{{ route('about-us.page') }}">About Us</a></li>
                            <li><a href="{{ route('products.category') }}">Products</a></li>
                            <li><a href="{{ route('photo.gallery') }}">Photo Gallery</a></li>
                            <li><a href="{{ route('career.resources') }}">Career Resources</a></li>
                            <li><a href="{{ route('blogs') }}">Blogs</a></li>
                            <li><a href="{{ route('shopping.guide') }}">Shopping Guide</a></li>
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('contact.us') }}">Contact Us</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col col-xl-4 col-lg-4 col-md-6 col-sm-12 col-12">
                    <div class="widget subscribe">
                        <div class="widget-title">
                            <h3>Newsletter</h3>
                        </div>
                        <p>Subscribe to our newsletters now and stay up to date with new collections, the latest lookbooks and exclusive offers.</p>
                        <form action="{{ route('subscribe') }}" method="POST">
                            @csrf
                            <div class="form-field">
                                <input type="email" name="email" placeholder="Enter Your Email Address" required>
                                <button type="submit" class="small-btn-style">SUBSCRIBE!</button>
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- end container -->
    </div>

    <div class="lower-footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="text-center">
                        <p>Copyright © {{ date('Y') }} Jha Electricals. All rights reserved. Designed By 
                            <a href="https://matrixbricks.com/" target="_blank">Matrix Bricks</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
