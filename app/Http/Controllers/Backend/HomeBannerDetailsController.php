<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\HomeBanner;

use Carbon\Carbon;

class HomeBannerDetailsController extends Controller
{

    public function index()
    {
        return view('backend.home.banner.index');
    }

    public function create(Request $request)
    { 
        return view('backend.home.banner.create');
    }
}