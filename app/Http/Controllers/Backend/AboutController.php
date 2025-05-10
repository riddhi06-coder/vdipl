<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\About;

use Carbon\Carbon;

class AboutController extends Controller
{

    public function index()
    {
        $details = About::wherenull('deleted_by')->get();
        return view('backend.about_us.about.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.about_us.about.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'required|string|max:255',
            'description' => 'required|string',
            'section_heading2' => 'required|string|max:255',
            'banner_items.*.name' => 'required|string|max:255',
            'banner_items.*.image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_items.*.description' => 'required|string',
            'section_heading3' => 'required|string|max:255',
            'items.*.name' => 'required|string|max:255',
            'items.*.image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'items.*.description' => 'required|string',
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_image.required' => 'The banner image is required.',
            'banner_image.image' => 'The banner image must be a valid image file.',
            'banner_image.mimes' => 'The banner image must be a JPG, JPEG, PNG, or WEBP file.',
            'banner_image.max' => 'The banner image must not be larger than 2MB.',
            'section_heading.required' => 'The section heading is required.',
            'description.required' => 'The description is required.',
            'section_heading2.required' => 'The Vision & Mission heading is required.',
            'banner_items.*.name.required' => 'Each Vision & Mission item must have a name.',
            'banner_items.*.image.required' => 'Each Vision & Mission item must have an image.',
            'banner_items.*.image.image' => 'Each Vision & Mission image must be a valid image.',
            'banner_items.*.image.mimes' => 'Each Vision & Mission image must be a JPG, JPEG, PNG, or WEBP file.',
            'banner_items.*.image.max' => 'Each Vision & Mission image must not exceed 2MB.',
            'banner_items.*.description.required' => 'Each Vision & Mission item must have a description.',
            'section_heading3.required' => 'The Core Values heading is required.',
            'items.*.name.required' => 'Each Core Value must have a name.',
            'items.*.image.required' => 'Each Core Value must have an image.',
            'items.*.image.image' => 'Each Core Value image must be a valid image.',
            'items.*.image.mimes' => 'Each Core Value image must be a JPG, JPEG, PNG, or WEBP file.',
            'items.*.image.max' => 'Each Core Value image must not exceed 2MB.',
            'items.*.description.required' => 'Each Core Value must have a description.',
        ]);
        

        // Store Banner Image
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/about/'), $bannerImageName);
        }

        // Store Vision & Mission Table Images
        $bannerItems = [];
        if ($request->has('banner_items')) {
            foreach ($request->file('banner_items') as $index => $item) {
                $imageName = null;
                if (isset($item['image']) && $item['image']->isValid()) {
                    $imageName = time() . rand(1000, 9999) . '.' . $item['image']->getClientOriginalExtension();
                    $item['image']->move(public_path('/uploads/about/'), $imageName);
                }

                $bannerItems[] = [
                    'name' => $request->banner_items[$index]['name'],
                    'image' => $imageName,
                    'description' => $request->banner_items[$index]['description'],
                ];
            }
        }

        // Store Core Values Table Images
        $items = [];
        if ($request->has('items')) {
            foreach ($request->file('items') as $index => $item) {
                $imageName = null;
                if (isset($item['image']) && $item['image']->isValid()) {
                    $imageName = time() . rand(1000, 9999) . '.' . $item['image']->getClientOriginalExtension();
                    $item['image']->move(public_path('/uploads/about/'), $imageName);
                }

                $items[] = [
                    'name' => $request->items[$index]['name'],
                    'image' => $imageName,
                    'description' => $request->items[$index]['description'],
                ];
            }
        }

        About::create([
            'banner_heading' => $validatedData['banner_heading'],
            'banner_image' => $bannerImageName,
            'section_heading' => $validatedData['section_heading'],
            'description' => $validatedData['description'],
            'section_heading2' => $validatedData['section_heading2'],
            'vision_mission_names' => json_encode(array_column($bannerItems, 'name')),
            'vision_mission_images' => json_encode(array_column($bannerItems, 'image')),
            'vision_mission_descriptions' => json_encode(array_column($bannerItems, 'description')),
            'section_heading3' => $validatedData['section_heading3'],
            'core_values_names' => json_encode(array_column($items, 'name')),
            'core_values_images' => json_encode(array_column($items, 'image')),
            'core_values_descriptions' => json_encode(array_column($items, 'description')),
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('manage-about.index')->with('message', 'About section saved successfully!');
    }

    public function edit($id)
    {
        $details = About::findOrFail($id);

        $bannerItems = [];
        $names = json_decode($details->vision_mission_names, true) ?? [];
        $images = json_decode($details->vision_mission_images, true) ?? [];
        $descriptions = json_decode($details->vision_mission_descriptions, true) ?? [];

        foreach ($names as $i => $name) {
            $bannerItems[] = [
                'name' => $name,
                'image' => $images[$i] ?? '',
                'description' => $descriptions[$i] ?? '',
            ];
        }

        $items = [];
        $coreNames = json_decode($details->core_values_names, true) ?? [];
        $coreImages = json_decode($details->core_values_images, true) ?? [];
        $coreDescriptions = json_decode($details->core_values_descriptions, true) ?? [];

        foreach ($coreNames as $i => $name) {
            $items[] = [
                'name' => $name,
                'image' => $coreImages[$i] ?? '',
                'description' => $coreDescriptions[$i] ?? '',
            ];
        }

        return view('backend.about_us.about.edit', compact('details', 'bannerItems', 'items'));
    }

    public function update(Request $request, $id)
    {
        $about = About::findOrFail($id);

        $validatedData = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'required|string|max:255',
            'description' => 'required|string',
            'section_heading2' => 'required|string|max:255',
            'banner_items.*.name' => 'required|string|max:255',
            'banner_items.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_items.*.description' => 'required|string',
            'section_heading3' => 'required|string|max:255',
            'items.*.name' => 'required|string|max:255',
            'items.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'items.*.description' => 'required|string',
        ]);

        // Update Banner Image
        $bannerImageName = $about->banner_image;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/about/'), $bannerImageName);
        }


        $oldBannerImages = json_decode($about->vision_mission_images, true) ?? [];
        $oldCoreValueImages = json_decode($about->core_values_images, true) ?? [];
        
        // Update Vision & Mission Table Images
        $bannerItems = [];
        foreach ($request->input('banner_items', []) as $index => $item) {
            $imageName = $oldBannerImages[$index] ?? null;
        
            if ($request->hasFile("banner_items.$index.image")) {
                $imageFile = $request->file("banner_items.$index.image");
                if ($imageFile->isValid()) {
                    $imageName = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/about/'), $imageName);
                }
            }
        
            $bannerItems[] = [
                'name' => $item['name'],
                'image' => $imageName,
                'description' => $item['description'],
            ];
        }
        
        // Update Core Values Table Images
        $items = [];
        foreach ($request->input('items', []) as $index => $item) {
            $imageName = $oldCoreValueImages[$index] ?? null;
        
            if ($request->hasFile("items.$index.image")) {
                $imageFile = $request->file("items.$index.image");
                if ($imageFile->isValid()) {
                    $imageName = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/about/'), $imageName);
                }
            }
        
            $items[] = [
                'name' => $item['name'],
                'image' => $imageName,
                'description' => $item['description'],
            ];
        }
        

        $about->update([
            'banner_heading' => $validatedData['banner_heading'],
            'banner_image' => $bannerImageName,
            'section_heading' => $validatedData['section_heading'],
            'description' => $validatedData['description'],
            'section_heading2' => $validatedData['section_heading2'],
            'vision_mission_names' => json_encode(array_column($bannerItems, 'name')),
            'vision_mission_images' => json_encode(collect($bannerItems)->pluck('image')->toArray()),
            'vision_mission_descriptions' => json_encode(array_column($bannerItems, 'description')),
            'section_heading3' => $validatedData['section_heading3'],
            'core_values_names' => json_encode(array_column($items, 'name')),
            'core_values_images' => json_encode(collect($items)->pluck('image')->toArray()),
            'core_values_descriptions' => json_encode(array_column($items, 'description')),
            'updated_at' => Carbon::now(),
            'updated_by' => Auth::user()->id,
        ]);

        return redirect()->route('manage-about.index')->with('message', 'About section updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = About::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-about.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}