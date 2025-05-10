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
                  <h4>Edit Leadership Details</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-leadership.index') }}">Leadership</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Leadership Details</li>
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
                        <h4>Leadership Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-leadership.update', $details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title</label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title" value="{{ old('banner_title', $details->banner_title) }}">
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>


                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image</label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload an image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                            <!-- Existing Image Preview -->
                                            @if ($details->banner_image)
                                                <div style="margin-top: 10px;">
                                                    <p class="text-muted mb-1">Current Banner Image:</p>
                                                    <img src="{{ asset('uploads/about/' . $details->banner_image) }}" alt="Banner Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                            <!-- New Upload Preview (Hidden until JS loads a file) -->
                                            <div id="bannerImagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <p class="text-muted mb-1">Selected New Banner Image Preview:</p>
                                                <img id="banner_image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>

                                        </div>

                                        <!-- Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_title">Section Title</label>
                                            <input class="form-control" id="section_title" type="text" name="section_title" placeholder="Enter Section Title" value="{{ old('section_title', $details->section_title) }}">
                                            <div class="invalid-feedback">Please enter a Section Title.</div>
                                        </div>
     

                                        <hr>
                                      
                                        <!-- Name-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="name">Name <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="name" type="text" name="name" placeholder="Enter Name" value="{{ old('name', $details->name) }}" required>
                                            <div class="invalid-feedback">Please enter a Name.</div>
                                        </div>

                                        <!-- Designation-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="designation">Designation <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="designation" type="text" name="designation" placeholder="Enter Designation" value="{{ old('designation', $details->designation) }}" required>
                                            <div class="invalid-feedback">Please enter a Designation.</div>
                                        </div>
                                        

                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="image">Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="image" type="file" name="image" accept=".jpg, .jpeg, .png, .webp" required onchange="previewImage()">
                                            <div class="invalid-feedback">Please upload an image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                            <!-- Existing Image Preview -->
                                            @if ($details->image)
                                                <div style="margin-top: 10px;">
                                                    <p class="text-muted mb-1">Current Profile Image:</p>
                                                    <img src="{{ asset('uploads/about/' . $details->image) }}" alt="Image" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif

                                            <!-- New Upload Preview (Hidden until JS loads a file) -->
                                            <div id="imagePreviewContainer" style="display: none; margin-top: 10px;">
                                                <p class="text-muted mb-1">Selected New Image Preview:</p>
                                                <img id="image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                            </div>

                                        </div>


                                        <!-- Description -->
                                        <div class="col-md-12" style="margin-bottom: 20px;">
                                            <label class="form-label" for="description">Description <span class="txt-danger">*</span></label>
                                            <textarea id="summernote" class="form-control" name="description" rows="6" placeholder="Enter Description here" required >{{ old('description', $details->description) }}</textarea>
                                            <div class="invalid-feedback">Please enter Description here.</div>
                                        </div>
                         
                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-leadership.index') }}" class="btn btn-danger px-4">Cancel</a>
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


        <script>
            function previewBannerImage() {
                const file = document.getElementById('banner_image').files[0];
                const previewContainer = document.getElementById('bannerImagePreviewContainer');
                const previewImage = document.getElementById('banner_image_preview');
                const existingImage = document.querySelector('img[src*="uploads/about"][alt="Banner Image"]'); // Targets only banner image

                // Clear the previous preview
                previewImage.src = '';

                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                    if (validImageTypes.includes(file.type)) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';

                            // Hide the existing banner image preview
                            if (existingImage) {
                                existingImage.closest('div').style.display = 'none';
                            }
                        };

                        reader.readAsDataURL(file);
                    } else {
                        alert('Please upload a valid image file (jpg, jpeg, png, webp).');
                        previewContainer.style.display = 'none';
                    }
                }
            }


            function previewImage() {
                const file = document.getElementById('image').files[0];
                const previewContainer = document.getElementById('imagePreviewContainer');
                const previewImage = document.getElementById('image_preview');
                const existingImage = document.querySelector('img[src*="uploads/about"][alt="Image"]'); // Targets only the profile image

                // Clear previous preview
                previewImage.src = '';

                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                    if (validImageTypes.includes(file.type)) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';

                            // Hide the existing profile image preview
                            if (existingImage) {
                                existingImage.closest('div').style.display = 'none';
                            }
                        };

                        reader.readAsDataURL(file);
                    } else {
                        alert('Please upload a valid image file (jpg, jpeg, png, webp).');
                        previewContainer.style.display = 'none';
                    }
                }
            }
        </script>

              
      

</body>

</html>