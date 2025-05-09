<!doctype html>
<html lang="en">
    
<head>
    @include('components.backend.head')
</head>
	   
		@include('components.backend.header')

	    <!--start sidebar wrapper-->	
	    @include('components.backend.sidebar')
	   <!--end sidebar wrapper-->


        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h4>Edit Service Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-home-services.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Service</li>
                </ol>

                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                    <div class="card-header">
                        <h4>Service Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-home-services.update', $details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Banner Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_heading">Banner Heading </label>
                                            <input class="form-control" id="banner_heading" type="text" name="banner_heading" placeholder="Enter Banner Heading" value="{{ old('banner_heading', $details->banner_heading) }}">
                                            <div class="invalid-feedback">Please enter a banner Heading.</div>
                                        </div>

                                        <hr>

                                        <div class="col-md-6">
                                            <label class="form-label" for="service_id">Select Service <span class="txt-danger">*</span></label>
                                            <select class="form-control" id="service_id" name="service_id" required>
                                                <option value="" disabled selected>-- Select Service --</option>
                                                @foreach($services as $service)
                                                    <option value="{{ $service->id }}" {{ $details->service_id == $service->id ? 'selected' : '' }}>
                                                        {{ $service->service }}
                                                    </option>
                                                @endforeach

                                            </select>
                                            <div class="invalid-feedback">Please select a service.</div>
                                        </div>


                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" required onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload an image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                            <!-- Preview Section (Moved here) -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>

                                            @if($details->banner_image)
                                                <div id="existingBannerImageContainer" style="margin-top: 10px;">
                                                    <img src="{{ asset('uploads/home/' . $details->banner_image) }}" alt="Existing Image"
                                                        class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                        </div>


                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image2">Image 1<span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image2" type="file" name="banner_image2" accept=".jpg, .jpeg, .png, .webp" required onchange="previewImage()">
                                            <div class="invalid-feedback">Please upload an image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                            <div id="ImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <img id="image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px; background-color: black;">
                                            </div>

                                            <!-- Preview Section (Moved here) -->
                                            @if($details->banner_image2)
                                                <div id="existingImage2Container" style="margin-top: 10px;">
                                                    <img src="{{ asset('uploads/home/' . $details->banner_image2) }}" alt="Existing Image 1"
                                                        class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px; background-color: black;">
                                                </div>
                                            @endif

                                        </div>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-home-services.index') }}" class="btn btn-danger px-4">Cancel</a>
                                            <button class="btn btn-primary" type="submit">Submit</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

          </div>
        </div>
        <!-- footer start-->
        @include('components.backend.footer')
        </div>
        </div>


       
       @include('components.backend.main-js')

        <!---- For Image---->
        <script>
            function previewBannerImage() {
                const fileInput = document.getElementById('banner_image');
                const previewContainer = document.getElementById('bannerImagePreviewContainer');
                const previewImage = document.getElementById('banner_image_preview');

                const existingImage = document.getElementById('existingBannerImageContainer');

                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    // Hide the old image preview
                    if (existingImage) {
                        existingImage.style.display = 'none';
                    }
                }
            }

            function previewImage() {
                const fileInput = document.getElementById('banner_image2');
                const previewContainer = document.getElementById('ImagePreviewContainer');
                const previewImage = document.getElementById('image_preview');
                const existingImage = document.getElementById('existingImage2Container');

                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    };
                    reader.readAsDataURL(fileInput.files[0]);

                    if (existingImage) {
                        existingImage.style.display = 'none';
                    }
                }
            }
        </script>

  
</body>

</html>