<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\HomeBanner;

use Carbon\Carbon;

class HomeBannerDetailsController extends Controller
{

    public function index()
    {
        $details = HomeBanner::wherenull('deleted_by')->get();
        return view('backend.home.banner.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.home.banner.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_video' => 'required|mimes:mp4,webm,ogg|max:4096', 
            'section_heading' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image2' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'banner_items' => 'required|array|min:1',
            'banner_items.*.name' => 'required|string|max:255',
            'banner_items.*.count' => 'required|string|max:255',
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_video.required' => 'Please upload a video.',
            'banner_video.mimes' => 'Allowed video formats are mp4, webm, ogg.',
            'banner_video.max' => 'Video must be less than 4MB.',
            'banner_image.required' => 'Please upload the first image.',
            'banner_image2.required' => 'Please upload the second image.',
            'description.required' => 'Description is required.',
            'section_heading.required' => 'Section heading is required.',
            'banner_items.required' => 'At least one detail row is required.',
            'banner_items.*.name.required' => 'Title is required for each row.',
            'banner_items.*.count.required' => 'Count is required for each row.',
        ]);

        // Upload video
        $videoPath = null;
        if ($request->hasFile('banner_video')) {
            $videoFile = $request->file('banner_video');
            $videoName = time() . rand(10, 999) . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->move(public_path('/uploads/home/'), $videoName);
            $videoPath = 'uploads/home/' . $videoName;
        }

        // Upload banner_image
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/home/'), $bannerImageName);
        }

        // Upload banner_image2
        $bannerImage2Name = null;
        if ($request->hasFile('banner_image2')) {
            $imageFile2 = $request->file('banner_image2');
            $bannerImage2Name = time() . rand(10, 999) . '.' . $imageFile2->getClientOriginalExtension();
            $imageFile2->move(public_path('/uploads/home/'), $bannerImage2Name);
        }

        // Save data
        $banner = new HomeBanner();
        $banner->banner_heading = $validatedData['banner_heading'];
        $banner->banner_video = $videoName;
        $banner->section_heading = $validatedData['section_heading'];
        $banner->banner_image = $bannerImageName;
        $banner->banner_image2 = $bannerImage2Name;
        $banner->description = $validatedData['description'];
        $banner->banner_items = json_encode($validatedData['banner_items'], JSON_UNESCAPED_UNICODE);
        $banner->created_at = Carbon::now();
        $banner->created_by = Auth::user()->id;
        $banner->save();

        return redirect()->route('home-banner.index')->with('message', 'Details added successfully!');
    }

    public function edit($id)
    {
        $details = HomeBanner::findOrFail($id);
        $details->banner_items = json_decode($details->banner_items, true);
        return view('backend.home.banner.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_video' => 'nullable|mimes:mp4,webm,ogg|max:4096', 
            'section_heading' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'banner_image2' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'required|string',
            'banner_items' => 'required|array|min:1',
            'banner_items.*.name' => 'required|string|max:255',
            'banner_items.*.count' => 'required|string|max:255',
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_video.mimes' => 'Allowed video formats are mp4, webm, ogg.',
            'banner_video.max' => 'Video must be less than 4MB.',
            'banner_image.image' => 'The first image must be a valid image file.',
            'banner_image2.image' => 'The second image must be a valid image file.',
            'description.required' => 'Description is required.',
            'section_heading.required' => 'Section heading is required.',
            'banner_items.required' => 'At least one detail row is required.',
            'banner_items.*.name.required' => 'Title is required for each row.',
            'banner_items.*.count.required' => 'Count is required for each row.',
        ]);

        $banner = HomeBanner::findOrFail($id);

        // Upload new video if provided
        if ($request->hasFile('banner_video')) {
            $videoFile = $request->file('banner_video');
            $videoName = time() . rand(10, 999) . '.' . $videoFile->getClientOriginalExtension();
            $videoFile->move(public_path('/uploads/home/'), $videoName);
            $banner->banner_video = $videoName;
        }

        // Upload new banner image if provided
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/home/'), $bannerImageName);
            $banner->banner_image = $bannerImageName;
        }

        // Upload new banner image 2 if provided
        if ($request->hasFile('banner_image2')) {
            $imageFile2 = $request->file('banner_image2');
            $bannerImage2Name = time() . rand(10, 999) . '.' . $imageFile2->getClientOriginalExtension();
            $imageFile2->move(public_path('/uploads/home/'), $bannerImage2Name);
            $banner->banner_image2 = $bannerImage2Name;
        }

        // Update other fields
        $banner->banner_heading = $validatedData['banner_heading'];
        $banner->section_heading = $validatedData['section_heading'];
        $banner->description = $validatedData['description'];
        $banner->banner_items = json_encode($validatedData['banner_items'], JSON_UNESCAPED_UNICODE);
        $banner->modified_at = Carbon::now();
        $banner->modified_by = Auth::user()->id;
        $banner->save();

        return redirect()->route('home-banner.index')->with('message', 'Details updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomeBanner::findOrFail($id);
            $industries->update($data);

            return redirect()->route('home-banner.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}