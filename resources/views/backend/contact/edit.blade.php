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
                  <h4>Edit Contact Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-contact.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Details</li>
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
                        <h4>Contact Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-contact.update', $details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')  

                                        
                                        <!-- Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_title">Banner Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_title" type="text" name="banner_title" placeholder="Enter Banner Title" value="{{ old('banner_title', $details->banner_title) }}" required>
                                            <div class="invalid-feedback">Please enter a Banner Title.</div>
                                        </div>


                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="banner_image">Banner Image <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="banner_image" type="file" name="banner_image" accept=".jpg, .jpeg, .png, .webp" onchange="previewBannerImage()" required>
                                            <div class="invalid-feedback">Please upload an image.</div>
                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                                            <br>
                                            <small class="text-secondary"><b>Only .jpg, .jpeg, .png, .webp formats are allowed.</b></small>

                                            <!-- Preview Section (Moved here) -->
                                            @if($details->banner_image)
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" src="{{ asset('uploads/contact/' . $details->banner_image) }}" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>

                                         <!-- Section Title-->
                                         <div class="col-md-6">
                                            <label class="form-label" for="section_title">Section Title <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_title" type="text" name="section_title" placeholder="Enter Section Title" value="{{ old('section_title', $details->section_title) }}" required>
                                            <div class="invalid-feedback">Please enter a Section Title.</div>
                                        </div>


                                        <hr>


                                        <!-- Email -->
                                        <div class="col-6">
                                            <label class="form-label" for="email">Email <span class="txt-danger">*</span></label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address"  value="{{ old('email', $details->email) }}" required>
                                            <div class="invalid-feedback">Please enter a valid Email address.</div>
                                        </div>

                                        
                                        <!-- Email2 -->
                                        <div class="col-6">
                                            <label class="form-label" for="email2">Email 2 </label>
                                            <input type="email2" class="form-control" id="email2" name="email2" placeholder="Enter Email Address" value="{{ old('email2', $details->email2) }}">
                                            <div class="invalid-feedback">Please enter a valid Email address.</div>
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="col-6">
                                            <label class="form-label" for="phone">Phone Number <span class="txt-danger">*</span></label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                placeholder="Enter Phone Number" maxlength="12" pattern="\d{10,12}"  value="{{ old('phone', $details->phone) }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);" required>
                                            <div class="invalid-feedback">Please enter a valid Phone Number (up to 12 digits only).</div>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-12">
                                            <label class="form-label" for="address">Address <span class="txt-danger">*</span></label>
                                            <textarea class="form-control" id="address" name="address" placeholder="Enter Address" rows="3"  value="{{ old('address', $details->address) }}" required >{{ old('address', $details->address) }}</textarea>
                                            <div class="invalid-feedback">Please enter an Address.</div>
                                        </div>


                                        <!-- Location URl -->
                                        <div class="col-12">
                                            <label class="form-label" for="url">Location URL </label>
                                            <input type="text" class="form-control" id="url" name="url" placeholder="Enter Location URL"  value="{{ old('url', $details->url) }}">
                                            <div class="invalid-feedback">Please enter a Location URl.</div><br><br><br>
                                        </div>

                                        <h4># Social Media Links</h4>
                                        <div class="text-end mb-2">
                                            <button type="button" class="btn btn-success add-row">Add Row</button>
                                        </div>


                                         <!-- Social Media Links Table -->
                                        <table class="table table-bordered p-3" id="socialMediaTable" style="border: 2px solid #dee2e6;">
                                            <thead>
                                                <tr>
                                                    <th>Social Media Platform <span class="txt-danger">*</span></th>
                                                    <th>URL <span class="txt-danger">*</span></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $platforms = json_decode($details->social_platforms ?? '[]', true);
                                                    $urls = json_decode($details->social_urls ?? '[]', true);
                                                @endphp


                                                @if(!empty($platforms) && !empty($urls))
                                                    @foreach($platforms as $index => $platform)
                                                        <tr>
                                                            <td>
                                                                <select class="form-control" name="social_media_platform[]" required>
                                                                    <option value="">Select Platform</option>
                                                                    <option value="Facebook" {{ $platform == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                                                                    <option value="Twitter" {{ $platform == 'Twitter' ? 'selected' : '' }}>Twitter</option>
                                                                    <option value="Instagram" {{ $platform == 'Instagram' ? 'selected' : '' }}>Instagram</option>
                                                                    <option value="LinkedIn" {{ $platform == 'LinkedIn' ? 'selected' : '' }}>LinkedIn</option>
                                                                    <option value="Youtube" {{ $platform == 'Youtube' ? 'selected' : '' }}>YouTube</option>
                                                                    <option value="Watsapp" {{ $platform == 'Watsapp' ? 'selected' : '' }}>Watsapp</option>
                                                                    <option value="Pinterest" {{ $platform == 'Pinterest' ? 'selected' : '' }}>Pinterest</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="url" name="social_media_url[]" value="{{ $urls[$index] ?? '' }}" placeholder="Enter URL" required>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger remove-row">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif

                                            
                                            </tbody>

                                        </table><br><br>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-contact.index') }}" class="btn btn-danger px-4">Cancel</a>
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


    <!-- JavaScript to add rows dynamically -->
    <script>
        // Handle "Add Row" button click
        document.querySelector('.add-row').addEventListener('click', function () {
            var tableBody = document.querySelector('#socialMediaTable tbody');
            var newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <select class="form-control" name="social_media_platform[]" required>
                        <option value="">Select Platform</option>
                        <option value="Facebook">Facebook</option>
                        <option value="Twitter">Twitter</option>
                        <option value="Instagram">Instagram</option>
                        <option value="LinkedIn">LinkedIn</option>
                        <option value="Youtube">YouTube</option>
                        <option value="Watsapp">Watsapp</option>
                        <option value="Pinterest">Pinterest</option>
                    </select>
                </td>
                <td>
                    <input class="form-control" type="url" name="social_media_url[]" placeholder="Enter URL" required>
                </td>
                <td>
                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                </td>
            `;

            tableBody.appendChild(newRow);
        });

        // Use event delegation to handle "Remove" buttons even for prefilled rows
        document.querySelector('#socialMediaTable tbody').addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    </script>




</body>

</html>