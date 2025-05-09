<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\HomeProjects;

use Carbon\Carbon;

class ProjectsController extends Controller
{

    public function index()
    {
        $details = HomeProjects::wherenull('deleted_by')->get();
        return view('backend.home.projects.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.home.projects.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banner_heading' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'cost' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
        ], [
            'location.required' => 'Please enter a location.',
            'cost.required' => 'Please enter a cost.',
            'banner_image.required' => 'Please upload an image.',
            'banner_image.image' => 'The uploaded file must be an image.',
            'banner_image.mimes' => 'Allowed image formats: jpg, jpeg, png, webp.',
            'banner_image.max' => 'Image must be less than 2MB.',
            'description.required' => 'Please enter the description.',
        ]);

        // Upload banner_image
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/home/'), $bannerImageName);
        }

        // Save data to DB
        $banner = new HomeProjects();
        $banner->banner_heading = $validatedData['banner_heading'];
        $banner->location = $validatedData['location'];
        $banner->cost = $validatedData['cost'];
        $banner->banner_image = $bannerImageName;
        $banner->description = $validatedData['description'];
        $banner->created_at = Carbon::now();
        $banner->created_by = Auth::user()->id;
        $banner->save();

        return redirect()->route('manage-projects.index')->with('message', 'Details added successfully!');
    }

    public function edit($id)
    {
        $details = HomeProjects::findOrFail($id);
        return view('backend.home.projects.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $banner = HomeProjects::findOrFail($id);

        $validatedData = $request->validate([
            'banner_heading' => 'nullable|string|max:255',
            'location' => 'required|string|max:255',
            'cost' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'description' => 'required|string',
            ], [
            'location.required' => 'Please enter a location.',
            'cost.required' => 'Please enter a cost.',
            'banner_image.image' => 'The uploaded file must be an image.',
            'banner_image.mimes' => 'Allowed image formats: jpg, jpeg, png, webp.',
            'banner_image.max' => 'Image must be less than 2MB.',
            'description.required' => 'Please enter the description.',
        ]);

        $bannerImageName = $banner->banner_image; 

        if ($request->hasFile('banner_image')) {
           
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/home/'), $bannerImageName);
        }

        $banner->banner_heading = $validatedData['banner_heading'];
        $banner->location = $validatedData['location'];
        $banner->cost = $validatedData['cost'];
        $banner->banner_image = $bannerImageName;
        $banner->description = $validatedData['description'];
        $banner->modified_at = Carbon::now();
        $banner->modified_by = Auth::user()->id;
        $banner->save();

        return redirect()->route('manage-projects.index')->with('message', 'Details updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomeProjects::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-projects.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}