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
                  <h4>Add Banner Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('home-banner.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Add Banner</li>
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
                        <h4>Banner Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('home-banner.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                     <!-- Banner Heading -->
                                     <div class="col-md-6">
                                        <label class="form-label" for="banner_heading">Banner Heading <span class="txt-danger">*</span></label>
                                        <input class="form-control" id="banner_heading" type="text" name="banner_heading" placeholder="Enter Banner Heading" required>
                                        <div class="invalid-feedback">Please enter a banner Heading.</div>
                                    </div>

                                    <!-- Video Upload -->
                                    <div class="col-md-6 mt-3">
                                        <label class="form-label" for="banner_video">Upload Video <span class="txt-danger">*</span></label>
                                        <input class="form-control" id="banner_video" type="file" name="banner_video" accept="video/mp4,video/webm,video/ogg" required>
                                        <small class="text-secondary"><b>Note: Maximum file size is 3MB. Allowed formats: .mp4, .webm, .ogg</b></small>
                                        <div class="invalid-feedback">Please upload a video (Max 3MB).</div>

                                        <!-- Video Preview Container -->
                                        <div id="videoPreviewContainer" class="mt-2" style="display: none;">
                                            <label class="form-label">Preview:</label>
                                            <video id="videoPreview" autoplay muted loop controls width="100%" style="border: 1px solid #ccc; border-radius: 5px;"></video>
                                        </div>
                                    </div>

                                    <hr>

                                    <h3># Innovation Section</h3>

                                    <!-- Section Heading -->
                                    <div class="col-md-6">
                                        <label class="form-label" for="section_heading">Section Heading <span class="txt-danger">*</span></label>
                                        <input class="form-control" id="section_heading" type="text" name="section_heading" placeholder="Enter Section Heading" required>
                                        <div class="invalid-feedback">Please enter a Section Heading.</div>
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


                                     <!-- Image Upload -->
                                     <div class="col-md-6">
                                        <label class="form-label" for="banner_image2">Image 2<span class="txt-danger">*</span></label>
                                        <input class="form-control" id="banner_image2" type="file" name="banner_image2" accept=".jpg, .jpeg, .png, .webp" required onchange="previewImage()">
                                        <div class="invalid-feedback">Please upload an image.</div>
                                        <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                        <br>
                                        <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                        <!-- Preview Section (Moved here) -->
                                        <div id="ImagePreviewContainer" style="display: none; margin-top: 10px;">
                                            <img id="image_preview" src="" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                        </div>
                                    </div>


                                    <!-- Description -->
                                    <div class="col-md-12" style="margin-bottom: 20px;">
                                        <label class="form-label" for="description">Description <span class="txt-danger">*</span></label>
                                        <textarea id="summernote" class="form-control" name="description" rows="5" placeholder="Enter Description here" required >{{ old('description') }}</textarea>
                                        <div class="invalid-feedback">Please enter Description here.</div>
                                    </div>


                                    <!-- Banner Details table -->
                                    <div class="table-container mb-4" style="margin-bottom: 20px;">
                                        <h5 class="mb-4"><strong>#Details</strong></h5>
                                        <table class="table table-bordered p-3" id="printsTable" style="border: 2px solid #dee2e6;">
                                            <thead>
                                                <tr>
                                                    <th>Title <span class="txt-danger">*</span></th>
                                                    <th>Count <span class="txt-danger">*</span></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $oldEntries = old('banner_items', [['name' => '', 'description' => '']]);
                                                @endphp

                                                @foreach ($oldEntries as $index => $entry)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="banner_items[{{ $index }}][name]" class="form-control" placeholder="Enter Name" value="{{ $entry['name'] ?? '' }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="banner_items[{{ $index }}][count]" class="form-control" placeholder="Enter Count" value="{{ $entry['count'] ?? '' }}" required>
                                                    </td>
                                                    <td>
                                                        @if($loop->first)
                                                            <button type="button" class="btn btn-primary" id="addPrintRow">Add More</button>
                                                        @else
                                                            <button type="button" class="btn btn-danger removePrintRow">Remove</button>
                                                        @endif
                                                    </td>
                                                </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                                   

                                    <!-- Form Actions -->
                                    <div class="col-12 text-end">
                                        <a href="{{ route('home-banner.index') }}" class="btn btn-danger px-4">Cancel</a>
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

        <!---- For videos---->
        <script>
            document.getElementById('banner_video').addEventListener('change', function () {
                const file = this.files[0];
                const previewContainer = document.getElementById('videoPreviewContainer');
                const videoElement = document.getElementById('videoPreview');

                if (file) {
                    if (file.size > 6 * 1024 * 1024) {
                        alert("File size exceeds 6MB. Please upload a smaller video.");
                        this.value = '';
                        previewContainer.style.display = 'none';
                        videoElement.src = '';
                    } else {
                        const fileURL = URL.createObjectURL(file);
                        videoElement.src = fileURL;
                        previewContainer.style.display = 'block';
                    }
                }
            });
        </script>

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
                const file = document.getElementById('banner_image2').files[0];
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
                        previewContainer.style.display = 'none';
                    }
                }
            }
        </script>

         <!--Card DEtails Preview & Add More Option-->
         <script>
         
         document.addEventListener("DOMContentLoaded", function () {
             let rowIndex = document.querySelectorAll("#printsTable tbody tr").length;

             // Add row functionality
             document.getElementById("addPrintRow").addEventListener("click", function () {
                 const tableBody = document.querySelector("#printsTable tbody");
                 const newRow = document.createElement("tr");

                 newRow.innerHTML = `
                     <td>
                         <input type="text" name="banner_items[${rowIndex}][name]" class="form-control" placeholder="Enter Name" required>
                     </td>
                     <td>
                        <input type="text" name="banner_items[${rowIndex}][count]" class="form-control" placeholder="Enter Count" required>
                     </td>
                     <td>
                         <button type="button" class="btn btn-danger removePrintRow">Remove</button>
                     </td>
                 `;

                 tableBody.appendChild(newRow);
                 rowIndex++;
             });

             // Remove row functionality
             document.querySelector("#printsTable").addEventListener("click", function (e) {
                 if (e.target.classList.contains("removePrintRow")) {
                     e.target.closest("tr").remove();
                 }
             });

             // Image preview functionality (delegated event listener for dynamically added inputs)
             document.querySelector("#printsTable").addEventListener("change", function (e) {
                 if (e.target.classList.contains("image-input")) {
                     const row = e.target.closest("tr"); // Get the row of the file input
                     const imgPreview = row.querySelector(".img-preview"); // Get the image preview inside the same row
                     const file = e.target.files[0];
                     if (file) {
                         const reader = new FileReader();
                         reader.onload = function (e) {
                             imgPreview.src = e.target.result; // Set the image source
                             imgPreview.style.display = "block"; // Show the preview
                         };
                         reader.readAsDataURL(file);
                     } else {
                         imgPreview.src = ""; // Clear the image preview
                         imgPreview.style.display = "none"; // Hide the preview
                     }
                 }
             });
         });


     </script>



</body>

</html>