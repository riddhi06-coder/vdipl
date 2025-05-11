<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Projects;
use App\Models\Service;

use Carbon\Carbon;

class ProjectController extends Controller
{

    public function index()
    {
        $details = Projects::wherenull('deleted_by')->get();
        return view('backend.projects.index', compact('details'));
    }

    public function create(Request $request)
    {
        $services = Service::orderBy('id', 'asc')->wherenull('deleted_by')->get(); 
        return view('backend.projects.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service_id'       => 'required|exists:services,id',
            'banner_heading'   => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading'  => 'nullable|string|max:255',
            'project_name'     => 'required|string',
            'location'         => 'required|string|max:255',
            'cost'             => 'required|string|max:255',
            'image'            => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'service_id.required'      => 'Please select a project type.',
            'service_id.exists'        => 'Selected project type does not exist.',
            'banner_image.image'       => 'The banner image must be an image.',
            'banner_image.mimes'       => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for banner image.',
            'banner_image.max'         => 'The banner image size must not exceed 2MB.',
            'image.required'           => 'The image is required.',
            'image.image'              => 'The image must be a valid image file.',
            'image.mimes'              => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for the image.',
            'image.max'                => 'The image size must not exceed 2MB.',
            'project_name.required'    => 'Please enter the project name.',
            'location.required'        => 'Please enter the project location.',
            'cost.required'            => 'Please enter the project cost.',
        ]);

        // Handle banner_image upload
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/projects/'), $bannerImageName);
        }

        // Handle image upload (required)
        $imageName = null;
        if ($request->hasFile('image')) {
            $mainImageFile = $request->file('image');
            $imageName = time() . rand(1000, 9999) . '.' . $mainImageFile->getClientOriginalExtension();
            $mainImageFile->move(public_path('/uploads/projects/'), $imageName);
        }

        $project = new Projects();
        $project->service_id       = $validatedData['service_id'];
        $project->banner_heading   = $validatedData['banner_heading'];
        $project->banner_image     = $bannerImageName;
        $project->section_heading  = $validatedData['section_heading'];
        $project->project_name     = $validatedData['project_name'];
        $project->location         = $validatedData['location'];
        $project->cost             = $validatedData['cost'];
        $project->image            = $imageName;
        $project->created_at = Carbon::now();
        $project->created_by = Auth::user()->id;
        $project->save();

        return redirect()->route('manage-projects.index')->with('message', 'Project added successfully.');
    }

    public function edit($id)
    {
        $details = Projects::findOrFail($id);
        $services = Service::whereNull('deleted_by')->get(); 
        return view('backend.projects.edit', compact('details','services'));
    }

    public function update(Request $request, $id)
    {
        $project = Projects::findOrFail($id);

        $validatedData = $request->validate([
            'service_id'       => 'required|exists:services,id',
            'banner_heading'   => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading'  => 'nullable|string|max:255',
            'project_name'     => 'required|string',
            'location'         => 'required|string|max:255',
            'cost'             => 'required|string|max:255',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'service_id.required'      => 'Please select a project type.',
            'service_id.exists'        => 'Selected project type does not exist.',
            'banner_image.image'       => 'The banner image must be an image.',
            'banner_image.mimes'       => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for banner image.',
            'banner_image.max'         => 'The banner image size must not exceed 2MB.',
            'image.image'              => 'The image must be a valid image file.',
            'image.mimes'              => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for the image.',
            'image.max'                => 'The image size must not exceed 2MB.',
            'project_name.required'    => 'Please enter the project name.',
            'location.required'        => 'Please enter the project location.',
            'cost.required'            => 'Please enter the project cost.',
        ]);

        // Handle banner_image upload
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/projects/'), $bannerImageName);

            $project->banner_image = $bannerImageName;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $mainImageFile = $request->file('image');
            $imageName = time() . rand(1000, 9999) . '.' . $mainImageFile->getClientOriginalExtension();
            $mainImageFile->move(public_path('/uploads/projects/'), $imageName);

            $project->image = $imageName;
        }

        // Update other fields
        $project->service_id       = $validatedData['service_id'];
        $project->banner_heading   = $validatedData['banner_heading'];
        $project->section_heading  = $validatedData['section_heading'];
        $project->project_name     = $validatedData['project_name'];
        $project->location         = $validatedData['location'];
        $project->cost             = $validatedData['cost'];
        $project->modified_at       = Carbon::now();
        $project->modified_by       = Auth::user()->id;
        $project->save();

        return redirect()->route('manage-projects.index')->with('message', 'Project updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Projects::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-projects.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}