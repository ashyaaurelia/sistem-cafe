@extends('layouts.kasir')
@section('content')

<h2>Reset Password Pelanggan</h2>

@if(session('success'))
    <p style="color: green;">{{ session('success') }}</p>
@endif

@if($errors->any())
    <p style="color: red;">{{ $errors->first() }}</p>
@endif

<table border="1" cellpadding="10" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Username</th>
            <th>Email</th>
            <th>Password Baru</th>
        </tr>
    </thead>

    <tbody>
        @forelse($pelanggans as $pelanggan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pelanggan->name }}</td>
                <td>{{ $pelanggan->username }}</td>
                <td>{{ $pelanggan->email }}</td>
                <td>
                    <form action="/kasir/reset-password-pelanggan/{{ $pelanggan->id }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="password" name="password" placeholder="Password baru" required minlength="8">

                        <input type="password" name="password_confirmation" placeholder="Ulangi password" required minlength="8">

                        <button type="submit">Reset Password</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Belum ada adata pelanggan</td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection