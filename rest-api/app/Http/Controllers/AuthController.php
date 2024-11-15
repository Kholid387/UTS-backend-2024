<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Registrasi pengguna baru
    public function register(Request $request)
    {
        // Validasi input request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Menyimpan pengguna baru
        $input = [
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ];

        $user = User::create($input);

        // Menyiapkan data respon sukses
        $data = [
            'message' => 'User berhasil dibuat',
            'user' => $user,
        ];

        return response()->json($data, 201);
    }

    // Login pengguna
    public function login(Request $request)
    {
        // Validasi input request
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Mencari pengguna berdasarkan email
        $user = User::where('email', $validatedData['email'])->first();

        if ($user && Hash::check($validatedData['password'], $user->password)) {
            // Membuat token jika login berhasil
            $token = $user->createToken('auth_token')->plainTextToken;

            // Data respons jika login berhasil
            $data = [
                'message' => 'Login berhasil',
                'token' => $token,
            ];

            return response()->json($data, 200);
        } else {
            // Data respons jika login gagal
            $data = [
                'message' => 'Email atau password salah',
            ];

            return response()->json($data, 401);
        }
    }
}
