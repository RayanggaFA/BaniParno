<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Member;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page with family overview
     */
    public function index()
    {
        // Ambil data families dengan jumlah members
        $families = Family::withCount('members')
                         ->orderBy('name')
                         ->get();

        // Hitung statistik untuk dashboard
        $totalFamilies = $families->count();
        $totalMembers = Member::count();
        $totalGenerations = 4; // Atau bisa diambil dari database jika ada tabel generations

        return view('welcome', compact('families', 'totalFamilies', 'totalMembers', 'totalGenerations'));
    }
}