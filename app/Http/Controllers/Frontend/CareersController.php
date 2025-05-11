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
}
