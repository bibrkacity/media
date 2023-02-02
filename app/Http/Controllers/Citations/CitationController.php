<?php

namespace App\Http\Controllers\Citations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitationController extends Controller
{

    public function index()
    {
        return view('citations.index');
    }

}
