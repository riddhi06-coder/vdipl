<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Associates; 

use Carbon\Carbon;

class AssociateController extends Controller
{

    public function index()
    {
        $details = Associates::wherenull('deleted_by')->get();
        return view('backend.home.associate.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.home.associate.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'heading' => 'required|string|max:255',
            'section_heading' => 'required|string|max:255',
            'section_heading2' => 'required|string|max:255',
            'section_heading3' => 'required|string|max:255',

            'banner_items.*.image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'items.*.image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'items1.*.image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'heading.required' => 'Please enter a heading.',
            'section_heading.required' => 'Please enter Section Heading.',
            'section_heading2.required' => 'Please enter Section Heading 2.',
            'section_heading3.required' => 'Please enter Section Heading 3.',

            'banner_items.*.image.required' => 'Each image is required in the first table.',
            'items.*.image.required' => 'Each image is required in the second table.',
            'items1.*.image.required' => 'Each image is required in the third table.',

            'banner_items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'items1.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',

            'banner_items.*.image.max' => 'Each image must be less than 2MB.',
            'items.*.image.max' => 'Each image must be less than 2MB.',
            'items1.*.image.max' => 'Each image must be less than 2MB.',
        ]);

        // Upload banner_items images
        $bannerItems = [];
        if ($request->has('banner_items')) {
            foreach ($request->file('banner_items') as $item) {
                $imageFile = $item['image'];
                $imageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('/uploads/home/'), $imageName);
                $bannerItems[] = ['image' => $imageName];
            }
        }

        // Upload items images
        $sectionItems = [];
        if ($request->has('items')) {
            foreach ($request->file('items') as $item) {
                $imageFile = $item['image'];
                $imageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('/uploads/home/'), $imageName);
                $sectionItems[] = ['image' => $imageName];
            }
        }

        // Upload items1 images
        $sectionItems1 = [];
        if ($request->has('items1')) {
            foreach ($request->file('items1') as $item) {
                $imageFile = $item['image'];
                $imageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('/uploads/home/'), $imageName);
                $sectionItems1[] = ['image' => $imageName];
            }
        }

        // Save data
        $associates = new Associates(); 
        $associates->heading = $validatedData['heading'];
        $associates->section_heading = $validatedData['section_heading'];
        $associates->section_heading2 = $validatedData['section_heading2'];
        $associates->section_heading3 = $validatedData['section_heading3'];
        $associates->banner_items = json_encode($bannerItems);
        $associates->items = json_encode($sectionItems);
        $associates->items1 = json_encode($sectionItems1);
        $associates->created_by = Auth::user()->id;
        $associates->created_at = Carbon::now();
        $associates->save();

        return redirect()->route('manage-associates.index')->with('message', 'Associates details added successfully!');
    }

    public function edit($id)
    {
        $details = Associates::findOrFail($id);
        return view('backend.home.associate.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'heading' => 'required|string|max:255',
            'section_heading' => 'required|string|max:255',
            'section_heading2' => 'required|string|max:255',
            'section_heading3' => 'required|string|max:255',
    
            'banner_items.*.image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'items.*.image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'items1.*.image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'heading.required' => 'Please enter a heading.',
            'section_heading.required' => 'Please enter Section Heading.',
            'section_heading2.required' => 'Please enter Section Heading 2.',
            'section_heading3.required' => 'Please enter Section Heading 3.',
    
            'banner_items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'items1.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
    
            'banner_items.*.image.max' => 'Each image must be less than 2MB.',
            'items.*.image.max' => 'Each image must be less than 2MB.',
            'items1.*.image.max' => 'Each image must be less than 2MB.',
        ]);
    
        $associates = Associates::findOrFail($id);
    
        // Process banner_items (replace entire array)
        $processedBannerItems = [];
        if ($request->has('banner_items')) {
            foreach ($request->banner_items as $item) {
                if (!empty($item['image'])) {
                    $imageFile = $item['image'];
                    $imageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/home/'), $imageName);
                    $processedBannerItems[] = ['image' => $imageName];
                } elseif (!empty($item['old_image'])) {
                    $processedBannerItems[] = ['image' => $item['old_image']];
                }
            }
        }
    
        // Process items
        $processedItems = [];
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                if (!empty($item['image'])) {
                    $imageFile = $item['image'];
                    $imageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/home/'), $imageName);
                    $processedItems[] = ['image' => $imageName];
                } elseif (!empty($item['old_image'])) {
                    $processedItems[] = ['image' => $item['old_image']];
                }
            }
        }
    
        // Process items1
        $processedItems1 = [];
        if ($request->has('items1')) {
            foreach ($request->items1 as $item) {
                if (!empty($item['image'])) {
                    $imageFile = $item['image'];
                    $imageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/home/'), $imageName);
                    $processedItems1[] = ['image' => $imageName];
                } elseif (!empty($item['old_image'])) {
                    $processedItems1[] = ['image' => $item['old_image']];
                }
            }
        }
    
        // Update DB
        $associates->heading = $validatedData['heading'];
        $associates->section_heading = $validatedData['section_heading'];
        $associates->section_heading2 = $validatedData['section_heading2'];
        $associates->section_heading3 = $validatedData['section_heading3'];
        $associates->banner_items = json_encode($processedBannerItems);
        $associates->items = json_encode($processedItems);
        $associates->items1 = json_encode($processedItems1);
        $associates->modified_by = Auth::user()->id;
        $associates->modified_at = now();
        $associates->save();
    
        return redirect()->route('manage-associates.index')->with('message', 'Associates details updated successfully!');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Associates::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-associates.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
    


    

}