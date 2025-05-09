<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Service; 

use Carbon\Carbon;

class ServicesController extends Controller
{

    public function index()
    {
        $details = Service::wherenull('deleted_by')->get();
        return view('backend.service.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.service.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'service' => 'required|string|max:255|unique:services,service',
        ], [
            'service.required' => 'Please enter a Service.',
            'service.max' => 'The Service must not exceed 255 characters.',
            'service.unique' => 'This Service already exists.',
        ]);
    
        $slug = Str::slug($validatedData['service']);
    
        $originalSlug = $slug;
        $counter = 1;
        while (Service::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }
    
        $service = new Service();
        $service->service = $validatedData['service'];
        $service->slug = $slug;
        $service->created_by = Auth::user()->id;
        $service->created_at = Carbon::now();
        $service->save();
    
        return redirect()->route('manage-services.index')->with('message', 'Service added successfully!');
    }

    public function edit($id)
    {
        $details = Service::findOrFail($id);
        return view('backend.service.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $validatedData = $request->validate([
            'service' => 'required|string|max:255|unique:services,service,' . $id,
        ], [
            'service.required' => 'Please enter a Service.',
            'service.max' => 'The Service must not exceed 255 characters.',
            'service.unique' => 'This Service already exists.',
        ]);

        if ($validatedData['service'] !== $service->service) {
            $slug = Str::slug($validatedData['service']);
            $originalSlug = $slug;
            $counter = 1;
            while (Service::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $service->slug = $slug;
        }

        $service->service = $validatedData['service'];
        $service->modified_by = Auth::id(); 
        $service->modified_at = Carbon::now();
        $service->save();

        return redirect()->route('manage-services.index')->with('message', 'Service updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Service::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-services.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
    
}