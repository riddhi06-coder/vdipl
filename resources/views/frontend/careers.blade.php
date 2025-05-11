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
        <img src="{{ asset('uploads/career/' . $career->banner_image) }}" alt="Background Image">
        <div class="text">
            <h1 >{{ $career->banner_heading }}</h1>
            <p class="breadcrumb" >
                <a href="{{ route('home.page') }}" >Home</a>  &nbsp;  &gt; {{ $career->banner_heading }}
            </p>
        </div>
    </div>   

    <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
        <h2>{{ $career->section_heading }}</h2>
    </div>
  
    <section class="career-section">
        <div class="career-image">
            <img src="{{ asset('uploads/career/' . $career->banner_image2) }}" alt="Background Image">
        </div>
        <div class="career-content">
            <p>{!! $career->description !!}</p>
        </div>
    </section>
      
    <section class="why-work-with-us">
        <div class="container">
            <div class="heading text-center " data-aos="fade-up" data-aos-duration="1000">
                <h2>{{ $career->section_heading2 }}</h2>
            </div>
            @php
                $images = json_decode($career->images ?? '[]', true);
                $descriptions = json_decode($career->descriptions ?? '[]', true);
            @endphp

            <div class="features-wrapper">
                @foreach($images as $index => $image)
                    <div class="feature-card">
                        <div class="icon-circle">
                            <img src="{{ asset('uploads/about/' . $image) }}" alt="Why Work Image">
                        </div>
                        <p>{{ $descriptions[$index] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
        
      
    <section class="openings-section">
        <div class="container122">
            <div class="header">
                <h1>{{ $job->first()->section_heading }}</h1>

                <div class="search-bar">
                    <input type="text" placeholder="Search for a job title..." />
                    <button><i class="fa fa-search"></i></button>
                </div>

            </div>

            @forelse($job as $item)
            <div class="job-card">
                <div class="job-info">
                    <h2>{{ $item->job_role }}</h2>
                    <p class="location" style="margin:8px 8px 8px 0px;">
                        <i class="fa-solid fa-clock" style="color: #813b3a;"></i> 
                        <strong>{{ $item->job_type }}</strong>
                    </p>
                    <p class="location">
                        <i class="fa-solid fa-location-dot" style="color: #813b3a;"></i> 
                        <strong>Location</strong> - {{ $item->job_location }}
                    </p>
                    {{-- Uncomment if you want to display a job summary --}}
                    {{-- <p class="description">{{ $item->summary }}</p> --}}
                </div>
                <div class="job-actions">
                    @if($item->job_description)
                    <a href="{{ asset('uploads/career/' . $item->job_description) }}" class="btn-outline" download>Download</a>
                    @endif
                    <a href="javascript:void(0);" class="btn-primary" onclick="openModal('{{ $item->job_role }}')">Apply Now</a>
                </div>
            </div>
            @empty
            <p>No job openings available right now.</p>
            @endforelse
        </div>
    </section>


    <section class="join-us">
        <div class="container1231">
           <p>{!! $career->description2 !!}</p>
        </div>
    </section>


    <!-- Modal -->
    <div id="applyModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 style="margin-bottom:15px;">Apply Now</h2>

            <form id="jobApplicationForm" method="POST" action="{{ route('job.apply') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group ">
                    <input type="text" id="name" name="name" placeholder="Your Name*" class="form-group2" value="{{ old('name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="email" id="email"  name="email" placeholder="Your Email*" class="form-group2" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <input type="text" id="phone" name="phone" placeholder="Phone Number*" class="form-group2" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <input type="text" id="subject" name="subject" placeholder="Subject*" class="form-group2" value="{{ old('subject') }}">
                    @error('subject')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                </div>
                <input type="text" id="role" name="role" placeholder="Position Applying For*" class="form-group3" value="{{ old('role') }}"> 
                @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                
                <input type="file" id="doc" name="doc" accept=".pdf,.doc" class="form-group3" value="{{ old('doc') }}">
                @error('doc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            
                <textarea id="message"  name="message" placeholder="Write Message">{{ old('message') }}</textarea>
                @error('message')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <button type="submit" class="submit-btn">Submit</button>
            </form>

        </div>
    </div>


    @include('components.frontend.footer')
            
    @include('components.frontend.main-js')

    
    <!----modal jo role fetching---->
    <script>
       function openModal(role = '') {
            const modal = document.getElementById('applyModal');
            const roleInput = modal.querySelector('#role'); 

            if (roleInput) {
                roleInput.value = role;
                roleInput.readOnly = true; 
            }

            modal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('applyModal');
            const roleInput = modal.querySelector('#role');

            if (roleInput) {
                roleInput.disabled = false; 
            }

            modal.style.display = 'none';
        }

    </script>

    <!----- search filter--->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('.search-bar input');
            const searchBtn = document.querySelector('.search-bar button');
            const jobCards = document.querySelectorAll('.job-card');

            searchBtn.addEventListener('click', function () {
                const query = searchInput.value.toLowerCase().trim();

                jobCards.forEach(card => {
                    const title = card.querySelector('h2').textContent.toLowerCase();
                    if (title.includes(query)) {
                        card.style.display = 'flex'; 
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
    </script>

                   
</body>
</html>