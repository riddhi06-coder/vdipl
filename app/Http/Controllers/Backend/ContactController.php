<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Contact;

use Carbon\Carbon;

class ContactController extends Controller
{

    public function index()
    {
        $details = Contact::wherenull('deleted_by')->get();
        return view('backend.contact.index', compact('details'));
    }

    public function create(Request $request)
    {
        return view('backend.contact.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title' => 'required|string|max:255',
            'email' => 'required|email',
            'email2' => 'nullable|email',
            'phone' => 'required|regex:/^\d{10,12}$/',
            'address' => 'required|string',
            'url' => 'nullable|url',

            'social_media_platform.*' => 'required|string',
            'social_media_url.*' => 'required|url',
        ], [
            'banner_title.required' => 'The banner title is required.',
            'section_title.required' => 'The banner title is required.',
            'banner_image.required' => 'The banner image is required.',
            'banner_image.image' => 'The banner must be an image.',
            'banner_image.max' => 'The image must be less than 2MB.',
            'email.required' => 'The email is required.',
            'email.email' => 'Enter a valid email address.',
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be 10 to 12 digits.',
            'address.required' => 'The address is required.',
            'social_media_platform.*.required' => 'Select a social media platform.',
            'social_media_url.*.required' => 'Enter the URL for each platform.',
            'social_media_url.*.url' => 'Enter a valid URL for each platform.',
        ]);

        // Handle Image Upload
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/contact'), $imageName);
        }

        // JSON encode social media data
        $platforms = $request->input('social_media_platform');
        $urls = $request->input('social_media_url');

        $contact = new Contact(); 
        $contact->banner_title = $validatedData['banner_title'];
        $contact->section_title = $validatedData['section_title'];
        $contact->banner_image = $imageName;
        $contact->email = $validatedData['email'];
        $contact->email2 = $request->input('email2');
        $contact->phone = $validatedData['phone'];
        $contact->address = $validatedData['address'];
        $contact->url = $request->input('url');

        $contact->social_platforms = json_encode($platforms);
        $contact->social_urls = json_encode($urls);
        $contact->created_at = Carbon::now();
        $contact->created_by = Auth::user()->id;

        $contact->save();

        return redirect()->route('manage-contact.index')->with('message', 'Contact details saved successfully!');
    }

    public function edit($id)
    {
        $details = Contact::findOrFail($id);
        return view('backend.contact.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'banner_title' => 'required|string|max:255',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'section_title' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'email2' => 'nullable|email|max:255',
            'phone' => 'required|digits_between:10,12',
            'address' => 'required|string|max:1000',
            'url' => 'nullable|url|max:1000',
            'social_media_platform' => 'required|array',
            'social_media_platform.*' => 'required|string',
            'social_media_url' => 'required|array',
            'social_media_url.*' => 'required|url'
        ], [
            'banner_title.required' => 'The banner title is required.',
            'section_title.required' => 'The banner title is required.',
            'banner_image.required' => 'The banner image is required.',
            'banner_image.image' => 'The banner must be an image.',
            'banner_image.max' => 'The image must be less than 2MB.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email2.email' => 'Please enter a valid email address.',
            'phone.required' => 'Phone number is required.',
            'phone.digits_between' => 'Phone number must be between 10 to 12 digits.',
            'address.required' => 'Address is required.',
            'url.url' => 'Please enter a valid Location URL.',
            'social_media_platform.*.required' => 'Please select a social media platform.',
            'social_media_url.*.required' => 'Please enter a valid URL for the selected platform.'
        ]);

        $footerContact = Contact::findOrFail($id);

        // Handle Image Upload
        if ($request->hasFile('banner_image')) {
            $image = $request->file('banner_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/contact'), $imageName);
        }

        $footerContact->update([
            'banner_title' => $validated['banner_title'],
            'section_title' => $validated['section_title'],
            'banner_image' => $imageName,
            'email' => $validated['email'],
            'email2' => $validated['email2'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'url' => $validated['url'],
            'social_platforms' => json_encode($validated['social_media_platform']),
            'social_urls' => json_encode($validated['social_media_url']),
            'modified_at' => Carbon::now(),
            'modified_by' => Auth::user()->id,
        ]);

        return redirect()->route('manage-contact.index')->with('message', 'Contact details updated successfully.');
    }
    
    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Contact::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-contact.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}