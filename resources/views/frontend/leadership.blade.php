<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
</head>

<body>
    @include('components.frontend.header')

    
    <div class="about-image-container">
        @if($leadership->isNotEmpty())
            <img src="{{ asset('uploads/about/' . $leadership->first()->banner_image) }}" alt="Background Image">
            <div class="text">
                <h1>{{ $leadership->first()->banner_title }}</h1>
                <p class="breadcrumb">
                    <a href="{{ route('home.page') }}">Home</a> &nbsp; &gt; {{ $leadership->first()->banner_title }}
                </p>
            </div>
        @else
            <p>No leadership data available.</p>
        @endif
    </div>

       
    <div class="heading text-center mt-3"   style="background-color:#F5F5F7; padding:50px 0% 0%; margin:0% !important; margin-bottom:0% important;">
        <h2 data-aos="fade-up" data-aos-duration="1000">{{ $leadership->first()->section_title }}</h2>
    </div>
    
    <div class="container12" style="background-color:#F5F5F7;">
        @foreach ($leadership as $leader)
            <div class="profile-card">
                <img src="{{ asset('uploads/about/' . $leader->image) }}" alt="Profile Image">
                <h2>{{ $leader->name }}</h2>
                <p class="text-center" style="color:#3b3b3b;">{{ $leader->role }}</p>
                <button class="read-more-btn" data-profile="{{ $leader->id }}">Read More</button>
            </div>
        @endforeach
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
    

    <script>
        const leadershipData = @json($leadership);

        document.querySelectorAll(".read-more-btn").forEach(button => {
            button.addEventListener("click", (event) => {
                const profileId = event.target.getAttribute("data-profile");

                const leaderData = leadershipData.find(leader => leader.id == profileId);

                if (!leaderData) return;

                const moreContent = document.createElement("div");
                moreContent.classList.add("more-content");

                let content = `
                    <p style="color:white">${leaderData.description}</p>
                    <button class="close-btn">Close</button>
                `;

                moreContent.innerHTML = content;
                document.body.appendChild(moreContent);

                setTimeout(() => {
                    moreContent.classList.add("show");
                }, 10);

                moreContent.querySelector(".close-btn").addEventListener("click", () => {
                    moreContent.classList.remove("show");
                    setTimeout(() => moreContent.remove(), 300);
                });
            });
        });
    </script>
                        
</body>
</html>