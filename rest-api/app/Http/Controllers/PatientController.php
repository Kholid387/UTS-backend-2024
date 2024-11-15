<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    // Menampilkan semua data pasien
    public function index()
    {
        $patients = Patient::all();

        if($patients) {
            $data = [
                'message' => 'Menampilkan semua pasien',
                'data' => $patients
            ];
        } else {
            $data = [
                'message' => 'Tidak ada pasien ditemukan'
            ];
        }

        return response()->json($data, 200);
    }

    // Menyimpan data pasien baru
    public function store(Request $request)
    {
        // Validasi input data pasien
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'address' => 'required|string',
            'phone_number' => 'required|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Terjadi kesalahan pada validasi',
                'error' => $validator->errors()
            ], 422);
        }

        // Menyimpan data pasien baru
        $patient = Patient::create($request->all());
        $data = [
            'message' => 'Pasien berhasil dibuat',
            'data' => $patient
        ];

        return response()->json($data, 201);
    }

    // Menampilkan data pasien berdasarkan ID
    public function show($id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            return response()->json($patient, 200);
        } else {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }
    }

    // Mengupdate data pasien berdasarkan ID
    public function update(Request $request, $id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $patient->update($request->all());
            return response()->json($patient, 200);
        } else {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }
    }

    // Menghapus data pasien berdasarkan ID
    public function destroy($id)
    {
        $patient = Patient::find($id);

        if ($patient) {
            $patient->delete();
            return response()->json(['message' => 'Pasien berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }
    }

    // Mencari data pasien berdasarkan nama
    public function search($name)
    {
        $patients = Patient::where('name', 'like', '%' . $name . '%')->get();

        if (count($patients) > 0) {
            return response()->json($patients, 200);
        } else {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }
    }
}
