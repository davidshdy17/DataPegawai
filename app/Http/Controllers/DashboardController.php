<?php

namespace App\Http\Controllers;

use App\Models\Employee;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung total seluruh pegawai
        $totalEmployees = Employee::count();

        // Menghitung jumlah jabatan yang berbeda
        $totalJabatan = Employee::distinct()
            ->count('jabatan');

        // Mengambil 5 pegawai terbaru
        $latestEmployees = Employee::latest()
            ->take(5)
            ->get();

        // Mengirim data ke halaman dashboard
        return view('dashboard', compact(
            'totalEmployees',
            'totalJabatan',
            'latestEmployees'
        ));
    }
}
