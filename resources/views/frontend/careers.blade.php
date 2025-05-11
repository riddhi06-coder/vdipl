<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
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
                    <a href="javascript:void(0);" class="btn-primary" onclick="openModal()">Apply Now</a>
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
            <form>
            <div class="form-group ">
                <input type="text" placeholder="Your Name*" required class="form-group2">
                <input type="email" placeholder="Your Email*" required class="form-group2">
            </div>
            <div class="form-group">
                <input type="text" placeholder="Phone Number*" required class="form-group2">
                <input type="text" placeholder="Subject*" required class="form-group2">
            </div>
            <input type="text" placeholder="Position Applying For*" required class="form-group3">
            
            <input type="file" accept=".pdf,.doc" required class="form-group3">
        
            <textarea placeholder="Write Message"></textarea>
            <button type="submit" class="submit-btn">Submit</button>
            </form>
        </div>
    </div>


    @include('components.frontend.footer')
            
    @include('components.frontend.main-js')

    <script>
        function openModal() {
            document.getElementById('applyModal').style.display = "block";
        }

        function closeModal() {
            document.getElementById('applyModal').style.display = "none";
        }
    </script>
      
      
        
                    
</body>
</html>