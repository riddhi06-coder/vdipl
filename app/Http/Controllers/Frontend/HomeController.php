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

}