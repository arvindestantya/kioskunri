<?php

namespace App\Http\Controllers;

use App\Models\Faculty;

class KioskController extends Controller
{
    public function show(Faculty $faculty)
    {
        // Muat flyer yang hanya milik fakultas ini
        $flyers = $faculty->flyers()->latest()->get();
        
        return view('kiosk', compact('faculty', 'flyers'));
    }
}