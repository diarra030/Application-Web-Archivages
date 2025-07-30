<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;


class PdfView extends Controller
{
   
    
    public function index($id)
    {
        $document = Document::findOrFail($id);
        $accessGranted="false";
        return view('PDF.pdfview', compact('document','accessGranted'));
    }
}
