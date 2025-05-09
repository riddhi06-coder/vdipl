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
                  <h4>Edit Associates Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-associates.index') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Associates</li>
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
                        <h4>Associates Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-associates.update', $details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')


                                        <h3># Associates Section</h3>

                                        <!-- Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="heading">Heading <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="heading" type="text" name="heading" placeholder="Enter Heading" value="{{ old('heading', $details->heading) }}" required>
                                            <div class="invalid-feedback">Please enter a Heading.</div>
                                        </div>

                                        <hr>

                                        <!-- Section Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_heading">Section Heading <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_heading" type="text" name="section_heading" placeholder="Enter Section Heading" value="{{ old('section_heading', $details->section_heading) }}" required>
                                            <div class="invalid-feedback">Please enter a Section Heading.</div>
                                        </div>


                                        <!-- Banner Details table -->
                                        <div class="table-container mb-4" style="margin-bottom: 20px;">
                                            <h5 class="mb-4"><strong># Images</strong></h5>
                                            <table class="table table-bordered p-3" id="printsTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Image <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $bannerItems = old('banner_items', json_decode($details->banner_items ?? '[]', true));
                                                        
                                                    @endphp

                                                    @foreach ($bannerItems as $index => $item)
                                                    <tr>
                                                        <td>
                                                            <input type="file" name="banner_items[{{ $index }}][image]" class="form-control image-input">
                                                            <input type="hidden" name="banner_items[{{ $index }}][old_image]" value="{{ $item['image'] ?? '' }}">
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small><br>

                                                            @if (!empty($item['image']))
                                                                <img src="{{ asset('uploads/home/' . $item['image']) }}" alt="Current Image" class="mt-2" style="max-width: 100px;">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($loop->first)
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

                                        <hr>

                                        
                                        <!-- Section Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_heading2">Section Heading 2<span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_heading2" type="text" name="section_heading2" placeholder="Enter Section Heading 2" value="{{ old('section_heading2', $details->section_heading2) }}" required>
                                            <div class="invalid-feedback">Please enter a Section Heading 2.</div>
                                        </div>


                                        <!-- Banner Details table -->
                                        <div class="table-container mb-4" style="margin-bottom: 20px;">
                                            <h5 class="mb-4"><strong># Images</strong></h5>
                                            <table class="table table-bordered p-3" id="sectionTable" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Image <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tbody>
                                                    @php
                                                        $sectionItems = old('items', json_decode($details->items ?? '[]', true));
                                                    @endphp

                                                    @foreach ($sectionItems as $index => $item)
                                                    <tr>
                                                        <td>
                                                            <input type="file" name="items[{{ $index }}][image]" class="form-control image-input" {{ empty($item['image']) ? 'required' : '' }}>
                                                            <input type="hidden" name="items[{{ $index }}][old_image]" value="{{ $item['image'] ?? '' }}">
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small><br>

                                                            {{-- Image preview if exists --}}
                                                            @if (!empty($item['image']))
                                                                <img src="{{ asset('uploads/home/' . $item['image']) }}" alt="Preview" class="img-preview mt-2" style="max-width: 100px;">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($loop->first)
                                                                <button type="button" class="btn btn-primary" id="addsectionRow">Add More</button>
                                                            @else
                                                                <button type="button" class="btn btn-danger removesectionRow">Remove</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                                </tbody>
                                            </table>
                                        </div>


                                        <hr>

                                        
                                        <!-- Section Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_heading3">Section Heading 3<span class="txt-danger">*</span></label>
                                            <input class="form-control" id="section_heading3" type="text" name="section_heading3" placeholder="Enter Section Heading 3" value="{{ old('section_heading3', $details->section_heading3) }}" required>
                                            <div class="invalid-feedback">Please enter a Section Heading 3.</div>
                                        </div>


                                        <!-- Banner Details table -->
                                        <div class="table-container mb-4" style="margin-bottom: 20px;">
                                            <h5 class="mb-4"><strong># Images</strong></h5>
                                            <table class="table table-bordered p-3" id="section1Table" style="border: 2px solid #dee2e6;">
                                                <thead>
                                                    <tr>
                                                        <th>Image <span class="txt-danger">*</span></th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $section1Items = old('items1', json_decode($details->items1 ?? '[]', true));
                                                    @endphp

                                                    @foreach ($section1Items as $index => $item)
                                                    <tr> 
                                                        <td>
                                                            <input type="file" name="items1[{{ $index }}][image]" class="form-control image-input" {{ empty($item['image']) ? 'required' : '' }}>
                                                            <input type="hidden" name="items1[{{ $index }}][old_image]" value="{{ $item['image'] ?? '' }}">
                                                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small><br>
                                                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small><br>

                                                            {{-- Image preview if exists --}}
                                                            @if (!empty($item['image']))
                                                                <img src="{{ asset('uploads/home/' . $item['image']) }}" alt="Preview" class="img-preview mt-2" style="max-width: 100px;">
                                                            @else
                                                                <img src="#" alt="Preview" class="img-preview mt-2" style="max-width: 100px; display: none;">
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($loop->first)
                                                                <button type="button" class="btn btn-primary" id="addsection1Row">Add More</button>
                                                            @else
                                                                <button type="button" class="btn btn-danger removesection1Row">Remove</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>


                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-associates.index') }}" class="btn btn-danger px-4">Cancel</a>
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

        <!--Our Associates both sections Preview & Add More Option-->
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let rowIndex = document.querySelectorAll("#printsTable tbody tr").length;

                // Add row functionality
                document.getElementById("addPrintRow").addEventListener("click", function () {
                    const tableBody = document.querySelector("#printsTable tbody");
                    const newRow = document.createElement("tr");

                    newRow.innerHTML = `
                        <td>
                            <input type="file" name="banner_items[${rowIndex}][image]" class="form-control image-input" required>
                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                            <br>
                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                            <!-- Image Preview Element -->
                            <img src="#" alt="Preview" class="img-preview mt-2" style="max-width: 100px; display: none; background-color:rgb(5, 184, 244);"">
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


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let rowIndex = document.querySelectorAll("#sectionTable tbody tr").length;

                // Add row functionality
                document.getElementById("addsectionRow").addEventListener("click", function () {
                    const tableBody = document.querySelector("#sectionTable tbody");
                    const newRow = document.createElement("tr");

                    newRow.innerHTML = `
                        <td>
                            <input type="file" name="items[${rowIndex}][image]" class="form-control image-input" required>
                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                            <br>
                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                            <!-- Image Preview Element -->
                            <img src="#" alt="Preview" class="img-preview mt-2" style="max-width: 100px; display: none; background-color:rgb(5, 184, 244);"">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removesectionRow">Remove</button>
                        </td>
                    `;

                    tableBody.appendChild(newRow);
                    rowIndex++;
                });

                // Remove row functionality
                document.querySelector("#sectionTable").addEventListener("click", function (e) {
                    if (e.target.classList.contains("removesectionRow")) {
                        e.target.closest("tr").remove();
                    }
                });

                // Image preview functionality (delegated event listener for dynamically added inputs)
                document.querySelector("#sectionTable").addEventListener("change", function (e) {
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


        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let rowIndex = document.querySelectorAll("#section1Table tbody tr").length;

                // Add row functionality
                document.getElementById("addsection1Row").addEventListener("click", function () {
                    const tableBody = document.querySelector("#section1Table tbody");
                    const newRow = document.createElement("tr");

                    newRow.innerHTML = `
                        <td>
                            <input type="file" name="items1[${rowIndex}][image]" class="form-control image-input" required>
                            <small class="text-secondary"><b>Note: The file size should be less than 2MB.</b></small>
                            <br>
                            <small class="text-secondary"><b>Note: Only files in .jpg, .jpeg, .png, .webp format can be uploaded.</b></small>
                            <!-- Image Preview Element -->
                            <img src="#" alt="Preview" class="img-preview mt-2" style="max-width: 100px; display: none; background-color:rgb(5, 184, 244);"">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger removesection1Row">Remove</button>
                        </td>
                    `;

                    tableBody.appendChild(newRow);
                    rowIndex++;
                });

                // Remove row functionality
                document.querySelector("#section1Table").addEventListener("click", function (e) {
                    if (e.target.classList.contains("removesection1Row")) {
                        e.target.closest("tr").remove();
                    }
                });

                // Image preview functionality (delegated event listener for dynamically added inputs)
                document.querySelector("#section1Table").addEventListener("change", function (e) {
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