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

use App\Models\Solutions;
use App\Models\Description;
use App\Models\HomeBanner;
use App\Models\WeOffer;

use Carbon\Carbon;

class HomeController extends Controller
{

    public function index()
    {
        return view('frontend.home');
    }

}