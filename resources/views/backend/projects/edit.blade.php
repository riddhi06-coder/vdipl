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
                  <h4>Edit Projects Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('projects-details.index') }}">Projects</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Projects</li>
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
                        <h4>Projects Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('projects-details.update', $details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="col-md-6">
                                            <label for="service_id" class="form-label">Select Project Type <span class="txt-danger">*</span></label>
                                            <select name="service_id" id="service_id" class="form-select" required>
                                                <option value="">-- Select a Project Type --</option>
                                                @foreach($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ old('service_id', $details->service_id) == $service->id ? 'selected' : '' }}>
                                                    {{ $service->service }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">Please select a service.</div>
                                        </div>

                                        <!-- Banner Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_heading">Banner Heading</label>
                                            <input class="form-control" id="banner_heading" type="text" name="banner_heading" placeholder="Enter Banner Heading" value="{{ old('banner_heading', $details->banner_heading) }}">
                                            <div class="invalid-feedback">Please enter a Banner Heading.</div>
                                        </div>
                                        

                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image</label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()">
                                            <div class="invalid-feedback">Please upload an image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                          <!-- Preview Section (Moved here) -->
                                          <div id="bannerImagePreviewContainer" style="{{ $details->banner_image ? 'display: block; margin-top: 10px;' : 'display: none; margin-top: 10px;' }}">
                                                @if($details->banner_image)
                                                    <img id="banner_image_preview" src="{{ asset('uploads/projects/' . $details->banner_image) }}" alt="Banner Image" style="max-height: 200px;" class="mt-2">
                                                @endif
                                            </div>
                                        </div>


                                        <!-- Section Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_heading">Section Heading </label>
                                            <input class="form-control" id="section_heading" type="text" name="section_heading" placeholder="Enter Section Heading" value="{{ old('section_heading', $details->section_heading) }}">
                                            <div class="invalid-feedback">Please enter a Section Heading.</div>
                                        </div>
                                      
                                        <hr>
                                        
                                        <!-- Project Name -->
                                        <div class="col-md-12" style="margin-bottom: 20px;">
                                            <label class="form-label" for="project_name">Project Name <span class="txt-danger">*</span></label>
                                            <textarea id="project_name" class="form-control" name="project_name" rows="5" placeholder="Enter Project Name here" required >{{ old('project_name', $details->project_name) }}</textarea>
                                            <div class="invalid-feedback">Please enter Project Name here.</div>
                                        </div>

                              
                                        <!-- Project Location-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="location">Project Location <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="location" type="text" name="location" placeholder="Enter Project Location" value="{{ old('location', $details->location) }}" required>
                                            <div class="invalid-feedback">Please enter a Project Location.</div>
                                        </div>


                                        <!-- Project Cost-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="cost">Project Cost <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="cost" type="text" name="cost" placeholder="Enter Project Cost" value="{{ old('cost', $details->cost) }}" required>
                                            <div class="invalid-feedback">Please enter a Project Cost.</div>
                                        </div>


                                        <!-- Image-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="image">Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="image" type="file" name="image" accept=".jpg, .jpeg, .png, .webp" required onchange="previewImage()">
                                            <div class="invalid-feedback">Please upload a Image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>

                                            <!-- Preview Section placed right below -->
                                            <div id="ImagePreviewContainer" style="{{ $details->image ? 'margin-top: 10px;' : 'display: none; margin-top: 10px;' }}">
                                                @if($details->image)
                                                    <img id="image_preview" src="{{ asset('uploads/projects/' . $details->image) }}" alt="Image" style="max-height: 200px;" class="mt-2">
                                                @endif
                                            </div>
                                        </div>

                                          <!-- Gallery Image Upload -->
                                            <div class="table-container" style="margin-bottom: 20px;">
                                                <div class="d-flex align-items-center">
                                                    <h5 class="mb-4 me-3"><strong>Gallery Image Upload</strong></h5>
                                                    <button type="button" class="btn btn-primary ms-auto" id="addGalleryRow">Add More</button>
                                                </div>

                                                <table class="table table-bordered p-3" id="galleryTable" style="border: 2px solid #dee2e6;">
                                                    <thead>
                                                        <tr>
                                                            <th>Uploaded Gallery Image: <span class="text-danger">*</span></th>
                                                            <th>Preview</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if(isset($details->gallery_images) && $galleryImages = json_decode($details->gallery_images, true))
                                                            @foreach($galleryImages as $key => $galleryImage)
                                                                <tr>
                                                                    <td>
                                                                        <input type="file" onchange="previewGalleryImage(this, {{ $key }})" accept=".png, .jpg, .jpeg, .webp" name="gallery_image[]" id="gallery_image_{{ $key }}" class="form-control" placeholder="Upload Gallery Image">
                                                                        @error('gallery_image')
                                                                            <div class="text-danger">{{ $message }}</div>
                                                                        @enderror
                                                                        <small class="form-text text-muted">Note: The file size should be less than 2MB.</small><br>
                                                                        <small class="form-text text-muted">Note: Only files in .jpg, .jpeg, .png, .webp format are allowed.</small>
                                                                        <input type="hidden" name="existing_gallery_images[]" value="{{ $galleryImage }}">
                                                                    </td>
                                                                    <td>
                                                                        <img id="gallery-preview-container-{{ $key }}" src="{{ asset('/uploads/projects/' . $galleryImage) }}" alt="Preview" style="max-height: 150px; border: 1px solid #ddd; padding: 5px;">
                                                                    </td>
                                                                    <td>
                                                                        <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('projects-details.index') }}" class="btn btn-danger px-4">Cancel</a>
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

            function previewImage() {
                const file = document.getElementById('image').files[0];
                const previewContainer = document.getElementById('ImagePreviewContainer');
                const previewImage = document.getElementById('image_preview');

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
                    }
                }
            }

        </script>


        <!--Gallery Image Preview & Add More Option-->
        <script>
               $(document).ready(function () {
                let rowId = {{ isset($galleryImages) ? count($galleryImages) : 0 }};

                // Add a new gallery image row
                $('#addGalleryRow').click(function () {
                    rowId++;
                    const newRow = `
                        <tr>
                            <td>
                                <input type="file" onchange="previewGalleryImage(this, ${rowId})" accept=".png, .jpg, .jpeg, .webp" name="gallery_image[]" id="gallery_image_${rowId}" class="form-control" placeholder="Upload Gallery Image">
                                <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                <br>
                                <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                            </td>
                           <td>
                                <div id="gallery-preview-container-${rowId}" style="max-height: 150px; border: 1px solid #ddd; padding: 5px;"></div>
                            </td>

                            <td>
                                <button type="button" class="btn btn-danger removeGalleryRow">Remove</button>
                            </td>
                        </tr>`;
                    $('#galleryTable tbody').append(newRow);
                });

                // Remove a gallery image row
                $(document).on('click', '.removeGalleryRow', function () {
                    $(this).closest('tr').remove();
                });
            });

            // Preview function for gallery images
            function previewGalleryImage(input, rowId) {
                const file = input.files[0];
                const previewContainer = document.getElementById(`gallery-preview-container-${rowId}`);

                // Clear previous preview
                previewContainer.innerHTML = '';

                if (file) {
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];

                    if (validImageTypes.includes(file.type)) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            // Create an image element for preview
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxWidth = '120px';
                            img.style.maxHeight = '100px';
                            img.style.objectFit = 'cover';

                            previewContainer.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    } else {
                        previewContainer.innerHTML = '<p>Unsupported file type</p>';
                    }
                }
            }
        </script>


</body>

</html>