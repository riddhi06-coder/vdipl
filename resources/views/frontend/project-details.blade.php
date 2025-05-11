<!DOCTYPE html>
<html lang="en">

<head>
    @include('components.frontend.head')
</head>

<body>
    @include('components.frontend.header')

        @php
            $firstService = $services->first();
            $firstProject = $firstService->projects->first();
        @endphp

        @if($firstProject)
            <div class="about-image-container">
                <img src="{{ asset('uploads/projects/' . $firstProject->banner_image) }}" alt="Background Image">
                <div class="text">
                    <h1>{{ $firstProject->banner_heading }}</h1>
                    <p class="breadcrumb">
                        <a href="{{ route('home.page') }}">Home</a> &nbsp; &gt; {{ $firstProject->banner_heading }}</p>
                </div>
            </div>

            <div class="heading text-center mt-5" data-aos="fade-up" data-aos-duration="1000">
                <h2>{{ $firstProject->section_heading }}</h2>
            </div>
        @endif



        <div class="container mt-5 project-container-main">
            <ul class="nav nav-tabs" id="projectTabs">
                @foreach($services as $index => $service)
                    <li class="nav-item">
                        <a class="nav-link {{ $index == 0 ? 'active' : '' }}" data-bs-toggle="tab" href="#type{{ $service->id }}">
                            {{ strtoupper($service->service) }}
                        </a>
                    </li>
                @endforeach

            </ul>

            <div class="tab-content">
                @foreach($services as $index => $service)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="type{{ $service->id }}">
                        <div class="container">
                            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 main-row-product-page mt-2">
                                @foreach($service->projects as $pIndex => $project)
                                    <div class="col">
                                        <div class="card">
                                            <img src="{{ asset('uploads/projects/' . $project->image) }}" class="card-img-top" alt="Project Image">
                                            <div class="card-body">
                                                <p><strong>Project Name:</strong> {{ $project->project_name }}</p>
                                                <p><strong>Location:</strong> {{ $project->location }}</p>
                                                <p><strong>Cost:</strong> {{ $project->cost }} CR</p>
                                                <!-- <button class="btn btn-primary mt-2" onclick="openImageSlider({{ $service->id }}, {{ $pIndex }})">View Gallery</button> -->
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
  
        <!-- Bootstrap Modal -->
        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" id="carouselInner">
                                <!-- Images go here -->
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const projectImageMap = @json($services->mapWithKeys(function ($service) {
            return [
                $service->id => $service->projects->map(function ($project) {
                    return explode(',', $project->image); // assuming comma-separated filenames
                })
            ];
        }));

        function openImageSlider(serviceId, projectIndex) {
            let images = projectImageMap[serviceId][projectIndex];
            let carouselInner = document.getElementById("carouselInner");
            carouselInner.innerHTML = "";

            images.forEach((img, i) => {
                let activeClass = i === 0 ? 'active' : '';
                carouselInner.innerHTML += `
                    <div class="carousel-item ${activeClass}">
                        <img src="/uploads/projects/gallery/${img.trim()}" class="d-block w-100" alt="Project Image">
                    </div>`;
            });

            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll('#projectTabs .nav-link');
            tabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    const serviceId = this.getAttribute('href').replace('#type', '');

                    // Hide/show banners
                    document.querySelectorAll('.banner-section').forEach(b => b.classList.add('d-none'));
                    document.getElementById('banner-service-' + serviceId)?.classList.remove('d-none');
                    document.getElementById('section-heading-' + serviceId)?.classList.remove('d-none');
                });
            });
        });
    </script>

        
                    
</body>
</html>