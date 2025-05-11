<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

use App\Models\CareerIntro;
use App\Models\Job;

use Carbon\Carbon;

class CareersController extends Controller
{

    public function career()
    {
        $career = CareerIntro::whereNull('deleted_by')->latest()->first();
        $job = Job::whereNull('deleted_by')->get();
        return view('frontend.careers', compact('career','job'));
    }

    public function submit(Request $request)
    {
        // dd($request);
        $request->validate([
            'name'    => 'required|regex:/^[A-Za-z\s]+$/',
            'email'   => 'required|email',
            'phone'   => 'required|digits_between:10,15|numeric',
            'subject' => 'required',
            'role'    => 'required',
            'doc'     => 'required|mimes:pdf,doc|max:2048',
            'message' => 'required|string',
        ], [
            'name.required' => 'Name is required.',
            'name.regex'    => 'Name should contain only letters and spaces.',
            
            'email.required' => 'Email is required.',
            'email.email'    => 'Please enter a valid email address.',
            
            'phone.required' => 'Phone number is required.',
            'phone.digits_between' => 'Phone number must be between 10 and 15 digits.',
            'phone.numeric' => 'Phone number must contain only digits.',
            
            'subject.required' => 'Subject is required.',
            
            'role.required' => 'Position is required.',
            
            'doc.required' => 'Please upload a document.',
            'doc.mimes' => 'Only .pdf and .doc files are allowed.',
            'doc.max' => 'The document size should not exceed 2MB.',
            
            'message.required' => 'Message is required.',
            'message.string'   => 'Message should be a valid string.',
        ]);
        
    
        $fullName = $request->name;
        $names = explode(' ', $fullName, 2);
        $first_name = $names[0] ?? '';
        $last_name = $names[1] ?? '';
    
        $data = [
            'first_name'   => $first_name,
            'last_name'    => $last_name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'job_role'     => $request->role,
            'user_message' => $request->message ?? '',
        ];
    
        $doc = $request->file('doc');
    
        Mail::send('frontend.career_mail', $data, function ($message) use ($request, $doc) {
            $message->to('riddhi@matrixbricks.com')
                    ->cc('shweta@matrixbricks.com')
                    ->subject('New Job Application: ' . $request->role);
    
            if ($doc) {
                $message->attach($doc->getRealPath(), [
                    'as' => $doc->getClientOriginalName(),
                    'mime' => $doc->getMimeType(),
                ]);
            }
        });

        Mail::send('frontend.job_mail_confirmation', [], function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Application Received - SRDC');
        });
    
        return back()->with('message', 'Your application has been sent successfully!');
    }

}
