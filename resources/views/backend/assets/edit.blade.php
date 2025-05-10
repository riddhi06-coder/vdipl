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
                  <h4>Edit Assets Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-assets.index') }}">Assets</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Assets</li>
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
                        <h4>Assets Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-assets.update', $details->id) }}" method="POST" enctype="multipart/form-data">
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

                                            <!-- Preview Section (Moved here) -->
                                            @if($details->banner_image)
                                                <div id="bannerImagePreviewContainer" style="margin-top: 10px;">
                                                    <img id="banner_image_preview" src="{{ asset('uploads/assets/' . $details->banner_image) }}" alt="Preview" class="img-fluid" style="max-height: 200px; border: 1px solid #ddd; padding: 5px;">
                                                </div>
                                            @endif
                                        </div>


                                        <!-- Title-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_title">Section Title</label>
                                            <input class="form-control" id="section_title" type="text" name="section_title" placeholder="Enter Section Title" value="{{ old('section_title', $details->section_title) }}">
                                            <div class="invalid-feedback">Please enter a Section Title.</div>
                                        </div>

                                        <hr>


                                        <!-- Product Headers Table -->
                                        <h4># Assets Table Headers</h4>
                                        <table class="table table-bordered p-3" id="headerTable" style="border: 2px solid #dee2e6;">
                                            <thead>
                                                <tr>
                                                    <th>Header Name <span class="txt-danger">*</span></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            @php
                                                $headers = json_decode($details->header_data, true) ?? [];
                                            @endphp
                                            <tbody>
                                                @forelse($headers as $i => $header)
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="header[]" placeholder="Enter Name" value="{{ $header }}" required></td>
                                                        <td>
                                                            @if($loop->first)
                                                                <button type="button" class="btn btn-success" onclick="addHeaderRow()">Add More</button>
                                                            @else
                                                                <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td><input type="text" class="form-control" name="header[]" placeholder="Enter Name" required></td>
                                                        <td><button type="button" class="btn btn-success" onclick="addHeaderRow()">Add More</button></td>
                                                    </tr>
                                                @endforelse
                                            </tbody>

                                        </table>

                                        <div class="mb-4"></div>

                                        <hr>
                                        
                                        <div class="mb-4"></div>


                                        <!-- Product Specification Table -->
                                        <h4># Assets Details</h4>
                                        <table class="table table-bordered p-3" id="specsTable" style="border: 2px solid #dee2e6;">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                                @php
                                                    $assetTypes = json_decode($details->assets_types, true) ?? [];
                                                    $noAssets = json_decode($details->no_assets_list, true) ?? [];
                                                @endphp
                                                <tbody>
                                                    @forelse($assetTypes as $index => $type)
                                                        <tr>
                                                            <td><input type="text" class="form-control" name="assets_type[]" value="{{ $type }}" placeholder="Enter Data"></td>
                                                            <td><input type="text" class="form-control" name="no_assets[]" value="{{ $noAssets[$index] ?? '' }}" placeholder="Enter Data"></td>
                                                            <td>
                                                                @if($loop->first)
                                                                    <button type="button" class="btn btn-success" onclick="addSpecRow()">Add More</button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td><input type="text" class="form-control" name="assets_type[]" placeholder="Enter Data"></td>
                                                            <td><input type="text" class="form-control" name="no_assets[]" placeholder="Enter Data"></td>
                                                            <td><button type="button" class="btn btn-success" onclick="addSpecRow()">Add More</button></td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>

                                        </table>

                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-assets.index') }}" class="btn btn-danger px-4">Cancel</a>
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


      
       <!--Banner Heading Preview & Add More Option-->
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

        <!-- JavaScript to Add and Remove Rows for Assets -->
        <script>
            function addSpecRow() {
                let table = document.getElementById('specsTable').getElementsByTagName('tbody')[0];
                let rowCount = table.rows.length;
                let row = table.insertRow(rowCount);

                row.innerHTML = `
                    <td><input type="text" class="form-control" name="assets_type[]" placeholder="Enter Data"></td>
                    <td><input type="text" class="form-control" name="no_assets[]" placeholder="Enter Data"></td>
                    <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                `;
            }

            function addHeaderRow() {
                let table = document.getElementById('headerTable').getElementsByTagName('tbody')[0];
                let rowCount = table.rows.length;
                let row = table.insertRow(rowCount);

                row.innerHTML = `
                    <td><input type="text" class="form-control" name="header[]" placeholder="Enter Name"></td>
                    <td><button type="button" class="btn btn-danger" onclick="removeRow(this)">Remove</button></td>
                `;
            }

            function removeRow(button) {
                let row = button.closest('tr');
                row.remove();
            }

        </script>






</body>

</html>