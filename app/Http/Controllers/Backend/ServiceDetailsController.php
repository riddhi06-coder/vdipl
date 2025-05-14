<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ServiceIntro;
use App\Models\Service;

use Carbon\Carbon;

class ServiceDetailsController extends Controller
{

    public function index()
    {
        $details = ServiceIntro::wherenull('deleted_by')->get();
        return view('backend.service.details.index', compact('details'));
    }

    public function create(Request $request)
    {
        $services = Service::orderBy('id', 'asc')->wherenull('deleted_by')->get(); 
        return view('backend.service.details.create', compact('services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_intro,service_id,NULL,id,deleted_by,NULL',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'section_heading2' => 'nullable|string|max:255',
            'banner_items' => 'nullable|array|min:1',
            'banner_items.*.name' => 'nullable|string|max:255',
            'banner_items.*.description' => 'nullable|string',
            'banner_items.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'banner_image.image' => 'The banner image must be a valid image.',
           
        ]);
        
    
        // Store banner_image manually
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/service/'), $bannerImageName);
        }
    
        // Store main image manually
        $mainImageName = null;
        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $mainImageName = time() . rand(1000, 9999) . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('/uploads/service/'), $mainImageName);
        }
    
        // Prepare JSON arrays
        $titles = [];
        $descriptions = [];
        $images = [];
    
        foreach ($request->banner_items as $index => $item) {
            $titles[] = $item['name'];
            $descriptions[] = $item['description'];
    
            if (isset($item['image'])) {
                $file = $item['image'];
                $fileName = time() . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/uploads/service/'), $fileName);
                $images[] = $fileName;
            }
        }
    
        ServiceIntro::create([
            'service_id' => $request->service_id,
            'banner_image' => $bannerImageName,
            'section_heading' => $request->section_heading,
            'image' => $mainImageName,
            'description' => $request->description,
            'section_heading2' => $request->section_heading2,
            'banner_titles' => json_encode($titles),
            'banner_images' => json_encode($images),
            'banner_descriptions' => json_encode($descriptions),
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
        ]);
    
        return redirect()->route('manage-service-intro.index')->with('message', 'Service intro section added successfully.');
    }

    public function edit($id)
    {
        $details = ServiceIntro::findOrFail($id);
        $services = Service::whereNull('deleted_by')->get(); 
    
        return view('backend.service.details.edit', compact('details', 'services'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_intro,service_id,NULL,id,deleted_by,NULL', 
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'section_heading2' => 'nullable|string|max:255',
            'banner_items' => 'nullable|array|min:1',
            'banner_items.*.name' => 'nullable|string|max:255',
            'banner_items.*.description' => 'nullable|string',
            'banner_items.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ], [
            'banner_image.image' => 'The banner image must be a valid image.',
        ]);
        
        $serviceIntro = ServiceIntro::findOrFail($id);

        // Store banner_image manually if new image is uploaded
        if ($request->hasFile('banner_image')) {
            
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/service/'), $bannerImageName);
            $serviceIntro->banner_image = $bannerImageName;
        }

        // Store main image manually if new image is uploaded
        if ($request->hasFile('image')) {
            
            $mainImage = $request->file('image');
            $mainImageName = time() . rand(1000, 9999) . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('/uploads/service/'), $mainImageName);
            $serviceIntro->image = $mainImageName;
        }

        // Prepare JSON arrays
        $titles = [];
        $descriptions = [];
        $images = [];

        foreach ($request->banner_items as $index => $item) {
            $titles[] = $item['name'];
            $descriptions[] = $item['description'];

            if (isset($item['image'])) {
                $file = $item['image'];
                $fileName = time() . rand(10000, 99999) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('/uploads/service/'), $fileName);
                $images[] = $fileName;
            } else if (isset($item['old_image'])) {
                // If no new image is uploaded, retain the old image
                $images[] = $item['old_image'];
            }
        }

        // Update the existing record
        $serviceIntro->update([
            'service_id' => $request->service_id,
            'section_heading' => $request->section_heading,
            'description' => $request->description,
            'section_heading2' => $request->section_heading2,
            'banner_titles' => json_encode($titles),
            'banner_images' => json_encode($images),
            'banner_descriptions' => json_encode($descriptions),
            'modified_at' => Carbon::now(),
            'modified_by' => Auth::user()->id,
        ]);

        return redirect()->route('manage-service-intro.index')->with('message', 'Service intro section updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ServiceIntro::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-service-intro.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}