<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index() {
        return view('fileUpload');
    }

    public function store(Request $request) {
        $request->validate([
            'file' => 'required|mimes:jpg,png,bmp'
        ]);

        // Ha az eredeti nevét szeretnéd megtartani, akkor:
        // $request->file->getClientOriginalName();

        $fileName = time().'.'.$request->file->extension();

        $request->file->move(public_path('uploads'), $fileName);

        return back()->with('success', 'Sikeres fájlfeltöltés.')->with('file', $fileName);
    }
}
