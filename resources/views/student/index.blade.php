<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
<main class="container">

    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        @if ($errors->any())
            <div class="alert alert-danger">    
                <ul>
                    @foreach ($errors->all() as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="" method="post">
            @csrf

            @if (Route::current()->uri=='student/{id}')
                    @method('PUT')
            @endif
            <div class="row">

                <!-- Kolom Kiri -->
                <div class="col-md-6">

                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-4 col-form-label">NIM</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nim" id="nim"
                                value="{{ isset($students['nim']) ? $students['nim'] : old('nim') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-4 col-form-label">Nama</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="nama" id="nama"
                                value="{{ isset($students['nama']) ? $students['nama'] : old('nama') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="prodi" class="col-sm-4 col-form-label">Prodi</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="prodi" id="prodi">
                                <option value="">pilih prodi</option>
                                <option value="TRM" {{ old('prodi', $students['prodi'] ?? '') == 'TRM' ? 'selected' : '' }}>TRM</option>
                                <option value="TRMK" {{ old('prodi', $students['prodi'] ?? '') == 'TRMK' ? 'selected' : '' }}>TRMK</option>
                                <option value="TRPL" {{ old('prodi', $students['prodi'] ?? '') == 'TRPL' ? 'selected' : '' }}>TRPL</option>
                                <option value="TL" {{ old('prodi', $students['prodi'] ?? '') == 'TL' ? 'selected' : '' }}>TL</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="tanggal_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-8">
                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control w-50"
                                value="{{ isset($students['tanggal_lahir']) ? $students['tanggal_lahir'] : old('tanggal_lahir') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ isset($students['email']) ? $students['email'] : old('email') }}">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                        <div class="col-sm-8">
                            <textarea name="alamat" id="alamat" cols="30" rows="4" class="form-control">{{ isset($students['alamat']) ? $students['alamat'] : old('alamat') }}</textarea>
                        </div>
                    </div>

                </div>
                <!-- akhir kolom kanan -->

            </div>

            <div class="mb-3 row">
                <div class="col-sm-6 d-grid gap-2">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
                </div>
            </div>

        </form>
    </div>
    <!-- AKHIR FORM -->


    <!-- START DATA -->
    @if (Route::current()->uri == 'student')
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Tanggal Lahir</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>

                @foreach ($students as $data)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $data['nim'] }}</td>
                    <td>{{ $data['nama'] }}</td>
                    <td>{{ $data['prodi'] }}</td>
                    <td>{{ date('d/m/Y', strtotime($data['tanggal_lahir'])) }}</td>
                    <td>{{ $data['email'] }}</td>
                    <td>{{ $data['alamat'] }}</td>
                    <td>
                        <a href="{{ url('student/' . $data['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ url('student/' . $data['id']) }}" 
                                method="post"
                                onsubmit="return confirm('Yakin hapus data?')" 
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="submit" 
                                    class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
    @endif
    <!-- AKHIR DATA -->

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>