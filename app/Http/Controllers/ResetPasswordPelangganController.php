<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordPelangganController extends Controller
{
    public function index()
    {
        $pelanggans = User::where('role', 'pelanggan')
            ->orderBy('name')
            ->get();

        return view('kasir.reset-password.index', compact('pelanggans'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $pelanggan = User::where('role', 'pelanggan')
            ->findOrFail($id);

        $pelanggan->update([
            'password' => $request->password,
            'wajib_ganti_password' => true,
        ]);

        return back()->with('success', 'Password pelanggan berhasil direset!');
    }
}