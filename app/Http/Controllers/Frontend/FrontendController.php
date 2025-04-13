<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{


    public function index()
    {

        return view('frontend.index');
    }

    public function record()
    {
        return view('frontend.records.index');
    }

    public function pdfTemplate(Request $request)
    {
        $page = $request->query('page', 'front'); // Default to 'front'

        if ($page === 'front') {
            return view('file_layout.front_template');
        } else {
            return view('file_layout.back_template');
        }
    }
}
