<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Leadership;

use Carbon\Carbon;

class LeadershipController extends Controller
{

    public function index()
    {
        $details = Leadership::wherenull('deleted_by')->get();
        return view('backend.about_us.leadership.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.about_us.leadership.create');
    }

    public function store(Request $request)
    {
        // Validate form inputs
        $validatedData = $request->validate([
            'banner_title'   => 'nullable|string|max:255',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title'  => 'nullable|string|max:255',
        
            'name'           => 'required|string|max:255',
            'designation'    => 'required|string|max:255',
            'image'          => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'    => 'required|string',
        ], [
            'banner_image.image'       => 'The banner must be an image.',
            'banner_image.mimes'       => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image.max'         => 'The banner image must not be greater than 2MB.',
        
            'name.required'            => 'Please enter the name.',
            'name.max'                 => 'Name must not exceed 255 characters.',
        
            'designation.required'     => 'Please enter the designation.',
            'designation.max'          => 'Designation must not exceed 255 characters.',
        
            'image.required'           => 'Please upload a profile image.',
            'image.image'              => 'The uploaded file must be an image.',
            'image.mimes'              => 'The image must be of type: jpg, jpeg, png, webp.',
            'image.max'                => 'The image must not be greater than 2MB.',
        
            'description.required'     => 'Please enter a description.',
        ]);
        

        // Handle banner image
        $bannerImageName = null;
        if ($request->hasFile('banner_image')) {
            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/about/'), $bannerImageName);
        }

        // Handle profile image
        $profileImageName = null;
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $profileImageName = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/about/'), $profileImageName);
        }

        Leadership::create([
            'banner_title'   => $validatedData['banner_title'],
            'banner_image'   => $bannerImageName,
            'section_title'  => $validatedData['section_title'],
            'name'           => $validatedData['name'],
            'designation'    => $validatedData['designation'],
            'image'          => $profileImageName,
            'description'    => $validatedData['description'],
            'created_at' => Carbon::now(),
            'created_by' => Auth::user()->id,
        ]);

        return redirect()->route('manage-leadership.index')->with('message', 'Leadership profile created successfully.');
    }
    
    public function edit($id)
    {
        $details = Leadership::findOrFail($id);
        return view('backend.about_us.leadership.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $leadership = Leadership::findOrFail($id);

        // Validate form inputs
        $validatedData = $request->validate([
            'banner_title'   => 'nullable|string|max:255',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title'  => 'nullable|string|max:255',

            'name'           => 'required|string|max:255',
            'designation'    => 'required|string|max:255',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'    => 'required|string',
        ], [
            'banner_image.image'       => 'The banner must be an image.',
            'banner_image.mimes'       => 'The banner image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image.max'         => 'The banner image must not be greater than 2MB.',

            'name.required'            => 'Please enter the name.',
            'name.max'                 => 'Name must not exceed 255 characters.',

            'designation.required'     => 'Please enter the designation.',
            'designation.max'          => 'Designation must not exceed 255 characters.',

            'image.image'              => 'The uploaded file must be an image.',
            'image.mimes'              => 'The image must be of type: jpg, jpeg, png, webp.',
            'image.max'                => 'The image must not be greater than 2MB.',

            'description.required'     => 'Please enter a description.',
        ]);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {

            $imageFile = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/about/'), $bannerImageName);
            $leadership->banner_image = $bannerImageName;
        }

        // Handle profile image upload
        if ($request->hasFile('image')) {
           
            $imageFile = $request->file('image');
            $profileImageName = time() . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('/uploads/about/'), $profileImageName);
            $leadership->image = $profileImageName;
        }

        // Update fields
        $leadership->banner_title = $validatedData['banner_title'];
        $leadership->section_title = $validatedData['section_title'];
        $leadership->name = $validatedData['name'];
        $leadership->designation = $validatedData['designation'];
        $leadership->description = $validatedData['description'];
        $leadership->modified_by = Auth::user()->id;
        $leadership->modified_at = Carbon::now();

        $leadership->save();

        return redirect()->route('manage-leadership.index')->with('message', 'Leadership profile updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Leadership::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-leadership.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}