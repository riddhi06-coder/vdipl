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
                  <h4>Edit Job Details Form</h4>
                </div>
                <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                    <a href="{{ route('manage-Job.index') }}">Job</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Job Details</li>
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
                        <h4>Job Details Form</h4>
                        <p class="f-m-light mt-1">Fill up your true details and submit the form.</p>
                    </div>
                    <div class="card-body">
                        <div class="vertical-main-wizard">
                        <div class="row g-3">    
                            <!-- Removed empty col div -->
                            <div class="col-12">
                            <div class="tab-content" id="wizard-tabContent">
                                <div class="tab-pane fade show active" id="wizard-contact" role="tabpanel" aria-labelledby="wizard-contact-tab">
                                    <form class="row g-3 needs-validation custom-input" novalidate action="{{ route('manage-Job.update', $details->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <!-- Section Heading -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="section_heading">Section Heading </label>
                                            <input class="form-control" id="section_heading" type="text" name="section_heading" placeholder="Enter Section Heading" value="{{ old('section_heading', $details->section_heading) }}">
                                            <div class="invalid-feedback">Please enter a Section Heading.</div>
                                        </div>

                                        <hr>

                                        <!-- Job Role-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="job_role">Job Role <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="job_role" type="text" name="job_role" placeholder="Enter Job Role" value="{{ old('job_role', $details->job_role) }}" required>
                                            <div class="invalid-feedback">Please enter a Job Role.</div>
                                        </div>


                                        <!-- Job Type-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="job_type">Job Type <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="job_type" type="text" name="job_type" placeholder="Enter Job Type" value="{{ old('job_type', $details->job_type) }}" required>
                                            <div class="invalid-feedback">Please enter a Job Type.</div>
                                        </div>


                                        <!-- Job Location-->
                                        <div class="col-md-6">
                                            <label class="form-label" for="job_location">Job Location <span class="txt-danger">*</span></label>
                                            <input class="form-control" id="job_location" type="text" name="job_location" placeholder="Enter Job Location" value="{{ old('job_location', $details->job_location) }}" required>
                                            <div class="invalid-feedback">Please enter a Job Location.</div>
                                        </div>


                                        <!-- Upload Job Description -->
                                        <div class="col-md-6">
                                            <label class="form-label" for="job_description">Upload Job Document <span class="txt-danger">*</span></label>
                                            <input class="form-control" type="file" id="job_description" name="job_description" accept="application/pdf">

                                            <small class="text-secondary d-block mt-1"><b>Note: The file size should be less than 3MB.</b></small>
                                            <small class="text-secondary d-block"><b>Only .pdf formats are allowed.</b></small><br>

                                            @if (!empty($details->job_description))
                                                <div class="mt-2">
                                                    <a href="{{ asset('uploads/career/' . $details->job_description) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        View Current Job Document
                                                    </a>
                                                </div>
                                            @endif

                                            @error('job_description')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>



                                        <!-- Form Actions -->
                                        <div class="col-12 text-end">
                                            <a href="{{ route('manage-Job.index') }}" class="btn btn-danger px-4">Cancel</a>
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
        
</body>

</html>