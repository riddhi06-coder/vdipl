<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\HomeService;
use App\Models\Service;

use Carbon\Carbon;

class HomeServicesController extends Controller
{

    public function index()
    {
        $details = HomeService::wherenull('deleted_by')->get();
        return view('backend.home.service.index', compact('details'));
    }

    public function create(Request $request)
    { 
        $services = Service::orderBy('id')->get(); 
        return view('backend.home.service.create', compact('services'));
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'banner_heading' => 'nullable|string|max:255',
            'service_id' => 'required|exists:services,id',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image2' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'service_id.required' => 'Please select a service.',
            'banner_image.required' => 'Please upload Banner Image.',
            'banner_image2.required' => 'Please upload Image 1.',
        ]);
    
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
            $bannerImage2Name = time() . rand(1000, 9999) . '.' . $imageFile2->getClientOriginalExtension();
            $imageFile2->move(public_path('/uploads/home/'), $bannerImage2Name);
        }
    
        // Save the banner record
        $banner = new HomeService();
        $banner->banner_heading = $validatedData['banner_heading'];
        $banner->service_id = $validatedData['service_id'];
        $banner->banner_image = $bannerImageName;
        $banner->banner_image2 = $bannerImage2Name;
        $banner->created_at = Carbon::now();
        $banner->created_by = Auth::user()->id;
        $banner->save();
    
        return redirect()->route('manage-home-services.index')->with('message', 'Details added successfully!');
    }

    public function edit($id)
    {
        $details = HomeService::findOrFail($id);
        $services = Service::whereNull('deleted_by')->get(); 
        return view('backend.home.service.edit', compact('details', 'services'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'banner_heading' => 'nullable|string|max:255',
            'service_id' => 'required|exists:services,id',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'banner_image2' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'service_id.required' => 'Please select a service.',
            'banner_image.required' => 'Please upload Banner Image.',
            'banner_image2.required' => 'Please upload Image 1.',
        ]);
        
        $banner = HomeService::findOrFail($id);

        if ($request->hasFile('banner_image')) {
           
            // Upload new banner_image
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/home/'), $bannerImageName);
            $banner->banner_image = $bannerImageName;
        }

        if ($request->hasFile('banner_image2')) {
           
            // Upload new banner_image2
            $imageFile2 = $request->file('banner_image2');
            $bannerImage2Name = time() . rand(1000, 9999) . '.' . $imageFile2->getClientOriginalExtension();
            $imageFile2->move(public_path('/uploads/home/'), $bannerImage2Name);
            $banner->banner_image2 = $bannerImage2Name;
        }

        // Update other details
        $banner->banner_heading = $validatedData['banner_heading'];
        $banner->service_id = $validatedData['service_id'];
        $banner->modified_at = Carbon::now();
        $banner->modified_by = Auth::user()->id;

        // Save the updated banner record
        $banner->save();

        return redirect()->route('manage-home-services.index')->with('message', 'Details updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomeService::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-home-services.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    } 

}