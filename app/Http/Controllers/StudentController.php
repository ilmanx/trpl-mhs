<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "http://127.0.0.1:8000/api/students";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $students = $contentArray['data'];

        return view('student.index', [
            'students' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $parameter = [
            'nim'            => $request->nim,
            'nama'           => $request->nama,
            'prodi'          => $request->prodi,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'email'          => $request->email,
            'alamat'         => $request->alamat,
        ];

        $client = new Client();
        $url = "http://127.0.0.1:8000/api/students";

        $response = $client->request('POST', $url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];

            return redirect()->to('student')
                ->withErrors($error)
                ->withInput();
        } else {
            return redirect()->to('student')
                ->with('success', $contentArray['message']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client(); // class client yang mengarah ke library GuzzleHTTP
        $url = "http://localhost:8000/api/students/$id"; // URL API yang akan diakses

        $response = $client->request('GET', $url); // mengirimkan request ke API
        $content = $response->getBody()->getContents(); // mendapatkan isi dari response

        $contentArray = json_decode($content, true); // mengubah isi response ke dalam bentuk array

        if ($contentArray['status'] != true) { // jika status tidak true
            // menuju halaman student dengan membawa pesan error
            return redirect()->to('student')->withErrors($contentArray['message']);
        } else {
            // mengirimkan data ke view
            return view('student.index', ['student' => $contentArray['data']]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        // parameter yang akan dikirimkan ke API
        $parameter = [
            'nim'            => $request->nim,
            'nama'           => $request->nama,
            'prodi'          => $request->prodi,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'email'          => $request->email,
            'alamat'         => $request->alamat,
        ];

        // class client Guzzle
        $client = new Client();

        // URL API (sesuaikan dengan resource)
        $url = "http://127.0.0.1:8000/api/students/" . $id;

        // kirim request ke API
        $response = $client->request('PUT', $url, [
            'headers' => [
                'Content-Type' => 'application/json'
            ],

            // 🔥 WAJIB pakai ini (bukan body)
            'json' => $parameter
        ]);

        // ambil response
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        // jika gagal
        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];

            return redirect()->to('student')
                ->withErrors($error)
                ->withInput();
        } 
        // jika sukses
        else {
            return redirect()->to('student')
                ->with('success', 'Data Berhasil Diupdate');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();

        // URL API (resource)
        $url = "http://127.0.0.1:8000/api/students/" . $id;

        // kirim request DELETE
        $response = $client->request('DELETE', $url);

        // ambil response
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        // jika gagal
        if ($contentArray['status'] != true) {
            return redirect()->to('student')
                ->withErrors($contentArray['data'])
                ->withInput();
        } 
        // jika sukses
        else {
            return redirect()->to('student')
                ->with('success', 'Data Berhasil Dihapus');
        }
    }
}
