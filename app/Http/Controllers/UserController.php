<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use App\Models\User;

class UserController extends Controller
{
    /**
    * Menampilkan daftar pengguna.
    * 
    * @return \Illuminate\View\View
    */
    public function index()
    {
        $users = User::all(); // Ambil semua pengguna dari database
        return view('users', compact('users')); // Kirim pengguna ke view
    }
        
    /**
    * Menampilkan preview file yang akan diimpor.
    * 
    * @param Request $request
    * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    */
    public function preview(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:xlsx,xls,csv',
    ]);

    $file = $request->file('file');
    $data = Excel::toArray(new UsersImport, $file);
    $data = $data[0]; // Ambil sheet pertama

    $users = User::all();

    return view('users', compact('data', 'file', 'users'));
}

    /**
    * Mengekspor data pengguna ke file Excel.
    * 
    * @return \Illuminate\Support\Collection
    */
    public function export() 
    {
        return Excel::download(new UsersExport, 'users.xlsx'); // Mengunduh file Excel
    }

    /**
    * Mengimpor data pengguna dari file Excel.
    * 
    * @param Request $request
    * @return \Illuminate\Http\RedirectResponse
    */
    public function import(Request $request)
{
    $request->validate([
        'file_name' => 'required',
        'file' => 'required',
    ]);

    $filePath = $request->file; // Dapatkan path file dari input hidden

    // Muat file Excel dan simpan ke database
    Excel::import(new UsersImport, $filePath);

    return redirect()->back()->with('success', 'Data imported successfully.');
}
}
