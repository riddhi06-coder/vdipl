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
                  <h4>Add Project Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-projects.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Project Details</li>
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
                        <h4>Project Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-projects.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf

                                        <!-- Banner Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_heading">Banner Heading </label>
                                            <input class="form-control" id="banner_heading" type="text" name="banner_heading" placeholder="Enter Banner Heading" value="{{ old('banner_heading') }}">
                                            <div class="invalid-feedback">Please enter a banner Heading.</div>
                                        </div>

                                        <hr>

                                        <!-- Location -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="location">Location <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="location" type="text" name="location" placeholder="Enter Location" value="{{ old('location') }}" required>
                                            <div class="invalid-feedback">Please enter a Location.</div>
                                        </div>


                                        <!-- Cost -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="cost">Cost <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="cost" type="text" name="cost" placeholder="Enter Cost" value="{{ old('cost') }}" required>
                                            <div class="invalid-feedback">Please enter a Cost.</div>
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
                                        </div>

                                        <!-- Description -->
                                        <div class="col-md-12" style="margin-bottom: 20px;">
                                            <label class="form-label" for="description">Description <span class="txt-danger">*</span></label>
                                            <textarea id="description" class="form-control" name="description" rows="5" placeholder="Enter Description here" required>{{ old('description') }}</textarea>
                                            <div class="invalid-feedback">Please enter Description here.</div>
                                        </div>



                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-projects.index') }}" class="btn btn-danger px-4">Cancel</a>
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
                const file = document.getElementById('banner_image').files[0];
                const previewContainer = document.getElementById('bannerImagePreviewContainer');
                const previewImage = document.getElementById('banner_image_preview');

                // Clear the previous preview
                previewImage.src = '';
                
                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                    if (validImageTypes.includes(file.type)) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            // Display the image preview
                            previewImage.src = e.target.result;
                            previewContainer.style.display = 'block';  // Show the preview section
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