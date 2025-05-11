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
                </div>
                <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">                                       
                        <svg class="stroke-icon">
                          <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                        </svg></a></li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('projects-details.index') }}">Projects</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Projects List</li>
                            </ol>
                        </nav>

                        <a href="{{ route('projects-details.create') }}" class="btn btn-primary px-5 radius-30">+ Add Projects Details</a>
                    </div>


                    <div class="table-responsive custom-scrollbar">
                      <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Project Type</th>
                            <th>Location</th>
                            <th>Cost</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $grouped = $details->groupBy('service.service');
                            @endphp

                            @foreach($grouped as $serviceName => $projects)
                                <tr>
                                    <td colspan="5" class="fw-bold bg-body-secondary">{{ $serviceName ?? 'N/A' }}</td>
                                </tr>
                                @foreach($projects as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->service->service ?? 'N/A' }}</td>
                                        <td>{{ $item->location }}</td>
                                        <td>{{ $item->cost }}</td>
                                        <td>
                                            <a href="{{ route('projects-details.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                            <form action="{{ route('projects-details.destroy', $item->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>

                      </table>
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