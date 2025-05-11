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

use App\Models\HomeBanner;
use App\Models\HomeService;
use App\Models\Service;
use App\Models\HomeProjects;
use App\Models\Clientele; 
use App\Models\Associates; 
use App\Models\About;
use App\Models\Leadership;
use App\Models\Assets;
use App\Models\ServiceIntro;
use App\Models\ServiceChoose;
use App\Models\Projects;
use App\Models\Contact;

use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        $banner = HomeBanner::whereNull('deleted_by')->latest()->first();
        $homeServices = HomeService::whereNull('deleted_by')->get();
        $services = Service::whereNull('deleted_by')->get()->keyBy('id');
        $projects = HomeProjects::whereNull('deleted_by')->get();
        $clientele = Clientele::whereNull('deleted_by')->latest()->first();
        $associates = Associates::whereNull('deleted_by')->latest()->first();  

        return view('frontend.home', compact('banner', 'homeServices', 'services', 'projects', 'clientele','associates'));
    }

    public function about_us()
    {
        $about = About::whereNull('deleted_by')->latest()->first();

        // Decode vision and mission data
        $about->vision_names = json_decode($about->vision_mission_names, true);
        $about->vision_images = json_decode($about->vision_mission_images, true);
        $about->vision_descriptions = json_decode($about->vision_mission_descriptions, true);

        // Decode core values data
        $about->core_values_names = json_decode($about->core_values_names, true);
        $about->core_values_images = json_decode($about->core_values_images, true);
        $about->core_values_descriptions = json_decode($about->core_values_descriptions, true);

        return view('frontend.about', compact('about'));
    }

    public function leadership()
    {
        $leadership = Leadership::whereNull('deleted_by')->get();
        return view('frontend.leadership', compact('leadership'));
    }

    public function assets()
    {
        $assets = Assets::whereNull('deleted_by')->first();
        return view('frontend.assets', compact('assets'));
    }

    public function service($slug)
    {
        $service = Service::where('slug', $slug)->whereNull('deleted_by')->firstOrFail();
        
        $intro = ServiceIntro::where('service_id', $service->id)->whereNull('deleted_by')->first();
        $choose = ServiceChoose::where('service_id', $service->id)->whereNull('deleted_by')->first();
        
        $bannerTitles = json_decode($intro->banner_titles, true);
        $bannerDescriptions = json_decode($intro->banner_descriptions, true);
        $bannerImages = json_decode($intro->banner_images, true);

        $bannerchooseTitles = json_decode($choose->banner_titles, true);
        $bannerchooseDescriptions = json_decode($choose->banner_descriptions, true);
        $bannerchooseImages = json_decode($choose->banner_images, true);
    
        return view('frontend.service-details', compact('intro', 'service', 'bannerTitles', 'bannerDescriptions', 'bannerImages','choose',
                    'bannerchooseTitles', 'bannerchooseDescriptions', 'bannerchooseImages'));
    }

    public function projects()
    {
        $services = Service::has('projects')->with(['projects' => function($query) {
            $query->whereNull('deleted_by');
        }])->get();
        
        return view('frontend.project-details', compact('services'));
    }

    public function contact()
    {
        $contact = Contact::whereNull('deleted_by')->first();
        return view('frontend.contact', compact('contact'));
    }
    
    
    public function contact_send(Request $request)
    {
        $request->validate([
            'FirstName' => 'required|string|max:255',
            'Email' => 'required|email',
            'PhoneNumber' => 'required|digits_between:7,15',
            'user_message' => 'required|string',
        ]);

        $data = [
            'name' => $request->FirstName,
            'email' => $request->Email,
            'phone' => $request->PhoneNumber,
            'user_message' => $request->user_message,
        ];

        Mail::send('frontend.contact_mail', $data, function ($message) use ($request) {
            $message->to('riddhi@matrixbricks.com')
                    ->cc('shweta@matrixbricks.com')
                    ->subject('New Contact Form Enquiry');
        });

        // Confirmation email to user (generalized)
         Mail::send('frontend.contact_mail_confirmation', [], function ($message) use ($data) {
            $message->to($data['email'])
                    ->subject('Thanks for Reaching Out!');
        });

        return back()->with('message', 'Your message has been sent successfully!');
    }
    

}