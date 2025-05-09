<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Clientele; 

use Carbon\Carbon;

class PartnersController extends Controller
{

    public function index()
    {
        $details = Clientele::wherenull('deleted_by')->get();
        return view('backend.home.partners.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.home.partners.create');
    }

    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'heading' => 'required|string|max:255',
            'section_heading' => 'required|string|max:255',
            'section_heading2' => 'required|string|max:255',

            'banner_items.*.image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
            'items.*.image' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'heading.required' => 'Please enter a heading.',
            'section_heading.required' => 'Please enter Section Heading.',
            'section_heading2.required' => 'Please enter Section Heading 2.',

            'banner_items.*.image.required' => 'Each image is required in the first table.',
            'items.*.image.required' => 'Each image is required in the second table.',
            'banner_items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'banner_items.*.image.max' => 'Each image must be less than 2MB.',
            'items.*.image.max' => 'Each image must be less than 2MB.',
        ]);

        // Upload banner_items images
        $bannerItems = [];
        if ($request->has('banner_items')) {
            foreach ($request->file('banner_items') as $item) {
                $imageFile = $item['image'];
                $imageName = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('/uploads/home/'), $imageName);
                $bannerItems[] = ['image' => $imageName];
            }
        }

        // Upload items images
        $sectionItems = [];
        if ($request->has('items')) {
            foreach ($request->file('items') as $item) {
                $imageFile = $item['image'];
                $imageName = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('/uploads/home/'), $imageName);
                $sectionItems[] = ['image' => $imageName];
            }
        }

        $clientele = new Clientele(); 
        $clientele->heading = $validatedData['heading'];
        $clientele->section_heading = $validatedData['section_heading'];
        $clientele->section_heading2 = $validatedData['section_heading2'];
        $clientele->banner_items = json_encode($bannerItems);
        $clientele->items = json_encode($sectionItems);
        $clientele->created_by = Auth::user()->id;
        $clientele->created_at = Carbon::now();
        $clientele->save();

        return redirect()->route('manage-clientele.index')->with('message', 'Clientele details added successfully!');
    }

    public function edit($id)
    {
        $details = Clientele::findOrFail($id);
        return view('backend.home.partners.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'heading' => 'required|string|max:255',
            'section_heading' => 'required|string|max:255',
            'section_heading2' => 'required|string|max:255',

            'banner_items.*.image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'items.*.image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'heading.required' => 'Please enter a heading.',
            'section_heading.required' => 'Please enter Section Heading.',
            'section_heading2.required' => 'Please enter Section Heading 2.',

            'banner_items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'items.*.image.mimes' => 'Only .jpg, .jpeg, .png, .webp formats are allowed.',
            'banner_items.*.image.max' => 'Each image must be less than 2MB.',
            'items.*.image.max' => 'Each image must be less than 2MB.',
        ]);

        $clientele = Clientele::findOrFail($id);

        // Process banner_items
        $bannerItems = [];
        if ($request->has('banner_items')) {
            foreach ($request->banner_items as $index => $item) {
                if (isset($item['image'])) {
                    $imageFile = $item['image'];
                    $imageName = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/home/'), $imageName);
                    $bannerItems[] = ['image' => $imageName];
                } elseif (isset($item['old_image'])) {
                    $bannerItems[] = ['image' => $item['old_image']];
                }
            }
        }

        // Process items
        $sectionItems = [];
        if ($request->has('items')) {
            foreach ($request->items as $index => $item) {
                if (isset($item['image'])) {
                    $imageFile = $item['image'];
                    $imageName = time() . '_' . Str::random(10) . '.' . $imageFile->getClientOriginalExtension();
                    $imageFile->move(public_path('/uploads/home/'), $imageName);
                    $sectionItems[] = ['image' => $imageName];
                } elseif (isset($item['old_image'])) {
                    $sectionItems[] = ['image' => $item['old_image']];
                }
            }
        }

        // Update fields
        $clientele->heading = $validatedData['heading'];
        $clientele->section_heading = $validatedData['section_heading'];
        $clientele->section_heading2 = $validatedData['section_heading2'];
        $clientele->banner_items = json_encode($bannerItems);
        $clientele->items = json_encode($sectionItems);
        $clientele->modified_by = Auth::user()->id;
        $clientele->modified_at = Carbon::now();
        $clientele->save();

        return redirect()->route('manage-clientele.index')->with('message', 'Clientele details updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Clientele::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-clientele.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}