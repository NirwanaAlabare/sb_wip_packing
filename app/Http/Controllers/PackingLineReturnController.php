<?php

namespace App\Http\Controllers;

use App\Models\SignalBit\MasterPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use DB;

class PackingLineReturnController extends Controller
{
    public function waiting()
    {
        return view('return-waiting');
    }

    public function defect()
    {
        return view('return-defect');
    }

    public function rework()
    {
        return view('return-rework');
    }

    public function reject()
    {
        return view('return-reject');
    }
}