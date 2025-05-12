<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\CareerIntro;

use Carbon\Carbon;

class CareerIntroController extends Controller
{

    public function index()
    {
        $details = CareerIntro::wherenull('deleted_by')->get();
        return view('backend.career.intro.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.career.intro.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'required|string|max:255',
            'banner_image2' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required|string',
            'description1' => 'required|string',
            'section_heading2' => 'required|string|max:255',
            'banner_items.*.image' => 'required|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'banner_items.*.description' => 'required|string',
        ], [
            'banner_heading.required' => 'The banner heading is required.',
            'banner_heading.max' => 'The banner heading may not be greater than 255 characters.',
        
            'banner_image.required' => 'The first banner image is required.',
            'banner_image.image' => 'The first banner image must be a valid image.',
            'banner_image.mimes' => 'The first banner image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image.max' => 'The first banner image must not exceed 2MB.',
        
            'section_heading.required' => 'The section heading is required.',
            'section_heading.max' => 'The section heading may not be greater than 255 characters.',
        
            'banner_image2.required' => 'The second banner image is required.',
            'banner_image2.image' => 'The second banner image must be a valid image.',
            'banner_image2.mimes' => 'The second banner image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image2.max' => 'The second banner image must not exceed 2MB.',
        
            'description.required' => 'The description field is required.',
            'description1.required' => 'The description field is required.',
        
            'section_heading2.required' => 'The "Why Work" section heading is required.',
            'section_heading2.max' => 'The "Why Work" section heading may not be greater than 255 characters.',
        
            'banner_items.*.image.required' => 'Each "Why Work" item must have an image.',
            'banner_items.*.image.image' => 'Each "Why Work" image must be a valid image.',
            'banner_items.*.image.mimes' => 'Each "Why Work" image must be of type: jpg, jpeg, png, webp.',
            'banner_items.*.image.max' => 'Each "Why Work" image must not exceed 2MB.',
        
            'banner_items.*.description.required' => 'Each "Why Work" item must have a description.',
        ]);
        
    
        // Upload banner_image
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 99) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/career/'), $bannerImageName);
        }
    
        // Upload banner_image2
        $bannerImage2Name = null;
        if ($request->hasFile('banner_image2')) {
            $imageFile2 = $request->file('banner_image2');
            $bannerImage2Name = time() . rand(100, 999) . '.' . $imageFile2->getClientOriginalExtension();
            $imageFile2->move(public_path('/uploads/career/'), $bannerImage2Name);
        }
    
        
        $bannerItems = [];
        if ($request->has('banner_items')) {
            foreach ($request->file('banner_items') as $index => $item) {
                $imageName = null;
                if (isset($item['image']) && $item['image']->isValid()) {
                    $imageName = time() . rand(1000, 9999) . '.' . $item['image']->getClientOriginalExtension();
                    $item['image']->move(public_path('/uploads/about/'), $imageName);
                }

                $bannerItems[] = [
                    'image' => $imageName,
                    'description' => $request->banner_items[$index]['description'],
                ];
            }
        }
    
        CareerIntro::create([
            'banner_heading' => $validatedData['banner_heading'],
            'banner_image' => $bannerImageName,
            'section_heading' => $validatedData['section_heading'],
            'banner_image2' => $bannerImage2Name,
            'description' => $validatedData['description'],
            'description2' => $validatedData['description1'],
            'section_heading2' => $validatedData['section_heading2'],
            'images' => json_encode(array_column($bannerItems, 'image')),
            'descriptions' => json_encode(array_column($bannerItems, 'description')),
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
        ]);
    
        return redirect()->route('manage-career-intro.index')->with('message', 'Career Intro section saved successfully!');
    }

    public function edit($id)
    {
        $details = CareerIntro::findOrFail($id);

        $bannerItems = [];
        $images = json_decode($details->images, true) ?? [];
        $descriptions = json_decode($details->descriptions, true) ?? [];

        foreach ($images as $i => $name) {
            $bannerItems[] = [
                'image' => $images[$i] ?? '',
                'description' => $descriptions[$i] ?? '',
            ];
        }

       
        return view('backend.career.intro.edit', compact('details', 'bannerItems'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'banner_heading' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'required|string|max:255',
            'banner_image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required|string',
            'description1' => 'required|string',
            'section_heading2' => 'required|string|max:255',
            'banner_items.*.image' => 'nullable|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'banner_items.*.description' => 'required|string',
        ]);

        $careerIntro = CareerIntro::findOrFail($id);

        // Update banner_image if a new file is uploaded
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 99) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/career/'), $bannerImageName);
            $careerIntro->banner_image = $bannerImageName;
        }

        // Update banner_image2 if a new file is uploaded
        if ($request->hasFile('banner_image2')) {
            $imageFile2 = $request->file('banner_image2');
            $bannerImage2Name = time() . rand(100, 999) . '.' . $imageFile2->getClientOriginalExtension();
            $imageFile2->move(public_path('/uploads/career/'), $bannerImage2Name);
            $careerIntro->banner_image2 = $bannerImage2Name;
        }

        $oldBannerImages = json_decode($careerIntro->images, true) ?? [];
        
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
                'image' => $imageName,
                'description' => $item['description'],
            ];
        }

        // Update fields
        $careerIntro->banner_heading = $validatedData['banner_heading'];
        $careerIntro->section_heading = $validatedData['section_heading'];
        $careerIntro->description = $validatedData['description'];
        $careerIntro->description2 = $validatedData['description1'];
        $careerIntro->section_heading2 = $validatedData['section_heading2'];
        $careerIntro->images = json_encode(array_column($bannerItems, 'image'));
        $careerIntro->descriptions = json_encode(array_column($bannerItems, 'description'));
        $careerIntro->modified_at = Carbon::now();
        $careerIntro->modified_by = Auth::user()->id;

        $careerIntro->save();

        return redirect()->route('manage-career-intro.index')->with('message', 'Career Intro section updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = CareerIntro::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-career-intro.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

    
}