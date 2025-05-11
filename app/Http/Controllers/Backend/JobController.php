<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Job;

use Carbon\Carbon;

class JobController extends Controller
{

    public function index()
    {
        $details = Job::wherenull('deleted_by')->get();
        return view('backend.career.job.index', compact('details'));
    }

    public function create(Request $request)
    { 
        return view('backend.career.job.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'section_heading'    => 'nullable|string|max:255',
            'job_role'           => 'required|string|max:255',
            'job_type'           => 'required|string|max:255',
            'job_location'       => 'required|string|max:255',
            'job_description'    => 'required|mimes:pdf|max:3072', 
        ], [
            'job_description.required' => 'Please upload a job description document.',
            'job_description.mimes'    => 'Only PDF files are allowed.',
            'job_description.max'      => 'The file size must be less than 3MB.',
        ]);
    
        $jobDocumentName = null;
        if ($request->hasFile('job_description')) {
            $file = $request->file('job_description');
            $jobDocumentName = time() . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/uploads/career/'), $jobDocumentName);
            $validatedData['job_description'] = $jobDocumentName;
        }
    
        Job::create($validatedData);
    
        return redirect()->route('manage-Job.index')->with('message', 'Job details saved successfully.');
    }

    public function edit($id)
    {
        $details = Job::findOrFail($id);
        return view('backend.career.job.edit', compact('details'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'section_heading'    => 'nullable|string|max:255',
            'job_role'           => 'required|string|max:255',
            'job_type'           => 'required|string|max:255',
            'job_location'       => 'required|string|max:255',
            'job_description'    => 'nullable|mimes:pdf|max:3072', // optional during edit
        ], [
            'job_description.mimes' => 'Only PDF files are allowed.',
            'job_description.max'   => 'The file size must be less than 3MB.',
        ]);

        $job = Job::findOrFail($id);

        // If a new file is uploaded, replace the old one
        if ($request->hasFile('job_description')) {

            $file = $request->file('job_description');
            $jobDocumentName = time() . rand(100, 999) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/uploads/career/'), $jobDocumentName);
            $validatedData['job_description'] = $jobDocumentName;
        }

        $job->update($validatedData);

        return redirect()->route('manage-Job.index')->with('message', 'Job details updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Job::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-Job.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}