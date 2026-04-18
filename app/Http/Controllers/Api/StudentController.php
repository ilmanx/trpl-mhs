<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // mengambil data student berdasarkan NIM (ascending)
        $data = Student::orderBy('nim', 'asc')->get();

        // response dalam bentuk JSON
        return response()->json([
            'status'  => true,
            'message' => 'Data ditemukan',
            'data'    => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataStudent = new Student;

        // aturan validasi
        $rules = [
            'nim'            => 'required|unique:students,nim|max:10',
            'nama'           => 'required',
            'prodi'          => 'required',
            'tanggal_lahir'  => 'required|date',
            'email'          => 'nullable|email|unique:students,email',
            'alamat'         => 'nullable',
        ];

        // proses validasi
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal simpan data',
                'data'    => $validator->errors(),
            ], 422);
        }

        // simpan data
        $dataStudent->nim            = $request->nim;
        $dataStudent->nama           = $request->nama;
        $dataStudent->prodi          = $request->prodi;
        $dataStudent->tanggal_lahir  = $request->tanggal_lahir;
        $dataStudent->email          = $request->email;
        $dataStudent->alamat         = $request->alamat;
        $dataStudent->save();

        return response()->json([
            'status'  => true,
            'message' => 'Sukses menyimpan data',
            'data'    => $dataStudent,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // ambil data berdasarkan ID
        $student = Student::find($id);

        if ($student) {
            return response()->json([
                'status'  => true,
                'message' => 'Data ditemukan',
                'data'    => $student,
            ], 200);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Data tidak ditemukan',
        ], 404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        // aturan validasi
        $rules = [
            'nim'            => 'required|max:10|unique:students,nim,' . $id,
            'nama'           => 'required',
            'prodi'          => 'required',
            'tanggal_lahir'  => 'required|date',
            'email'          => 'nullable|email|unique:students,email,' . $id,
            'alamat'         => 'nullable',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Gagal update data',
                'data'    => $validator->errors(),
            ], 422);
        }

        // update data
        $student->nim            = $request->nim;
        $student->nama           = $request->nama;
        $student->prodi          = $request->prodi;
        $student->tanggal_lahir  = $request->tanggal_lahir;
        $student->email          = $request->email;
        $student->alamat         = $request->alamat;
        $student->save();

        return response()->json([
            'status'  => true,
            'message' => 'Sukses update data',
            'data'    => $student,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $student->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Sukses hapus data',
        ], 200);
    }
}
