<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Assets;

use Carbon\Carbon;

class AssetsController extends Controller
{

    public function index()
    {
        $details = Assets::wherenull('deleted_by')->get();
        return view('backend.assets.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.assets.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banner_title' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title' => 'nullable|string|max:255',
            'header' => 'required|array|min:1',
            'header.*' => 'required|string|max:255',
            'assets_type' => 'nullable|array',
            'assets_type.*' => 'nullable|string|max:255',
            'no_assets' => 'nullable|array',
            'no_assets.*' => 'nullable|string|max:255',
        ], [
            'banner_title.max' => 'The banner title must not exceed 255 characters.',
            'banner_image.image' => 'The uploaded file must be an image.',
            'banner_image.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'banner_image.max' => 'The banner image must not be larger than 2MB.',
            'section_title.max' => 'The section title must not exceed 255 characters.',
        
            'header.required' => 'Please provide at least one table header.',
            'header.*.required' => 'Each header field is required.',
            'header.*.max' => 'Header names must not exceed 255 characters.',
        
            'assets_type.*.max' => 'Each asset type must not exceed 255 characters.',
            'no_assets.*.max' => 'Each asset quantity must not exceed 255 characters.',
        ]);
        

       $bannerImageName = null;
       if ($request->hasFile('banner_image')) {
           $imageFile = $request->file('banner_image');
           $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
           $imageFile->move(public_path('/uploads/assets/'), $bannerImageName);
       }

        $headerData = json_encode($request->header);
        $assetTypesJson = json_encode($request->assets_type ?? []);
        $noAssetsJson = json_encode($request->no_assets ?? []);

        $asset = new Assets();
        $asset->banner_title = $validatedData['banner_title'];
        $asset->section_title = $validatedData['section_title'];
        $asset->banner_image = $bannerImageName;
        $asset->header_data = $headerData;
        $asset->assets_types = $assetTypesJson;
        $asset->no_assets_list = $noAssetsJson;
        $asset->created_at = Carbon::now();
        $asset->created_by = Auth::user()->id;
        $asset->save();

        return redirect()->route('manage-assets.index')->with('message', 'Asset data saved successfully!');
    }

    public function edit($id)
    {
        $details = Assets::findOrFail($id);
        return view('backend.assets.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'banner_title' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title' => 'nullable|string|max:255',
            'header' => 'required|array|min:1',
            'header.*' => 'required|string|max:255',
            'assets_type' => 'nullable|array',
            'assets_type.*' => 'nullable|string|max:255',
            'no_assets' => 'nullable|array',
            'no_assets.*' => 'nullable|string|max:255',
        ], [
            'banner_title.max' => 'The banner title must not exceed 255 characters.',
            'banner_image.image' => 'The uploaded file must be an image.',
            'banner_image.mimes' => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'banner_image.max' => 'The banner image must not be larger than 2MB.',
            'section_title.max' => 'The section title must not exceed 255 characters.',

            'header.required' => 'Please provide at least one table header.',
            'header.*.required' => 'Each header field is required.',
            'header.*.max' => 'Header names must not exceed 255 characters.',

            'assets_type.*.max' => 'Each asset type must not exceed 255 characters.',
            'no_assets.*.max' => 'Each asset quantity must not exceed 255 characters.',
        ]);

        $asset = Assets::findOrFail($id);

        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/assets/'), $bannerImageName);
            $asset->banner_image = $bannerImageName;
        }

        $asset->banner_title = $validatedData['banner_title'];
        $asset->section_title = $validatedData['section_title'];
        $asset->header_data = json_encode($request->header);
        $asset->assets_types = json_encode($request->assets_type ?? []);
        $asset->no_assets_list = json_encode($request->no_assets ?? []);
        $asset->modified_at = Carbon::now();
        $asset->modified_by = Auth::user()->id;

        $asset->save();

        return redirect()->route('manage-assets.index')->with('message', 'Asset data updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Assets::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-assets.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}