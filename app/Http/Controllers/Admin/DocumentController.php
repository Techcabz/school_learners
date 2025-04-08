<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function recordsView(Request $request)
    {

        return view('admin.records.index');
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
