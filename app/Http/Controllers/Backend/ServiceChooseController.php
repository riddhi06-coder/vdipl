<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\ServiceChoose;
use App\Models\Service;

use Carbon\Carbon;

class ServiceChooseController extends Controller
{

    public function index()
    {
        $details = ServiceChoose::wherenull('deleted_by')->get();
        return view('backend.service.choose.index', compact('details'));
    }

    public function create(Request $request)
    {
        $services = Service::orderBy('id', 'asc')->wherenull('deleted_by')->get(); 
        return view('backend.service.choose.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_whychoose,service_id,NULL,id,deleted_by,NULL',
            'section_heading' => 'required|string|max:255',
            'description' => 'required|string',
            'section_heading2' => 'required|string|max:255',
            'banner_items' => 'required|array|min:1', 
            'banner_items.*.name' => 'required|string|max:255', 
            'banner_items.*.description' => 'required|string', 
            'banner_items.*.image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ], [
            'service_id.required' => 'Please select a service.',
            'section_heading.required' => 'Please enter a Section Heading.',
            'description.required' => 'Please enter a description.',
            'section_heading2.required' => 'Please enter the second Section Heading.',
            'banner_items.required' => 'Please add at least one banner item.',
            'banner_items.*.name.required' => 'Each banner item must have a title.',
            'banner_items.*.description.required' => 'Each banner item must have a description.',
            'banner_items.*.image.required' => 'Each banner item must have an image.',
        ]);

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

        $serviceIntro = new ServiceChoose();
        $serviceIntro->service_id = $request->service_id;
        $serviceIntro->section_heading = $request->section_heading;
        $serviceIntro->description = $request->description;
        $serviceIntro->section_heading2 = $request->section_heading2;
        $serviceIntro->banner_titles = json_encode($titles);
        $serviceIntro->banner_images = json_encode($images);
        $serviceIntro->banner_descriptions = json_encode($descriptions);
        $serviceIntro->created_at = Carbon::now();
        $serviceIntro->created_by = Auth::user()->id;
        $serviceIntro->save();

        return redirect()->route('manage-service-whychoose.index')->with('message', 'Service information stored successfully.');
    }

    public function edit($id)
    {
        $details = ServiceChoose::findOrFail($id);
        $services = Service::whereNull('deleted_by')->get(); 
    
        return view('backend.service.choose.edit', compact('details', 'services'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id|unique:service_whychoose,service_id,NULL,id,deleted_by,NULL', 
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_heading' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'required|string',
            'section_heading2' => 'required|string|max:255',
            'banner_items' => 'required|array|min:1',
            'banner_items.*.name' => 'required|string|max:255',
            'banner_items.*.description' => 'required|string',
            'banner_items.*.image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ], [
            'banner_image.required' => 'The banner image is required.',
            'banner_image.image' => 'The banner image must be a valid image.',
            'section_heading.required' => 'The section heading is required.',
            'image.required' => 'The image is required.',
            'description.required' => 'The description is required.',
            'section_heading2.required' => 'The second section heading is required.',
            'banner_items.required' => 'At least one banner item is required.',
            'banner_items.*.name.required' => 'Each item must have a name.',
            'banner_items.*.description.required' => 'Each item must have a description.',
            'banner_items.*.image.required' => 'Each item must have an image.',
        ]);
        
        $serviceIntro = ServiceChoose::findOrFail($id);

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

        return redirect()->route('manage-service-whychoose.index')->with('message', 'Service intro section updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = ServiceChoose::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-service-whychoose.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}