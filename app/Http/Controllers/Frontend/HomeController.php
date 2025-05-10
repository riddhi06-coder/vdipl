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
    
    

}