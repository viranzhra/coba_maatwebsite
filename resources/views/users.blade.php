<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 11 Import Export Excel Example</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card mt-5">
        <h3 class="card-header p-3 text-center">
            <i class="fa fa-star"></i> Laravel 11 Import Export Excel to Database Example
        </h3>
        <div class="card-body">

            <!-- Success Message -->
            @if(session('success'))
                <div class="alert alert-success" role="alert"> 
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Handling -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form untuk Upload, Preview, dan Konfirmasi Import -->
<form action="{{ route('users.preview') }}" method="POST" enctype="multipart/form-data" class="mb-4">
    @csrf
    <div class="mb-3">
        <label for="file">Upload File Excel</label>
        <input type="file" name="file" class="form-control" required>
    </div>
    <button class="btn btn-primary"><i class="fa fa-eye"></i> Preview File</button>
</form>

@if(isset($data))
    <div class="container mt-5">
        <h3>Preview File</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Password</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $key => $row)
                        <tr>
                            @foreach ($row as $cell)
                                <td>{{ $cell }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Form untuk Konfirmasi Import -->
        <form action="{{ route('users.import') }}" method="POST" class="mt-4" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file">File yang akan diimpor:</label>
                <span class="badge bg-secondary">{{ $file->getClientOriginalName() }}</span>
                <input type="hidden" name="file_name" value="{{ $file->getClientOriginalName() }}">
                <input type="hidden" name="file" value="{{ $file->store('uploads') }}"> <!-- Simpan file sementara jika perlu -->
            </div>
            <button class="btn btn-success"><i class="fa fa-file"></i> Import User Data</button>
        </form>
    </div>
@endif


            <!-- List of Users -->
            <table class="table table-bordered mt-5">
                <thead class="table-light">
                    <tr>
                        <th colspan="3" class="text-center">
                            List Of Users
                            <a class="btn btn-warning float-end" href="{{ route('users.export') }}">
                                <i class="fa fa-download"></i> Export User Data
                            </a>
                        </th>
                    </tr>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
