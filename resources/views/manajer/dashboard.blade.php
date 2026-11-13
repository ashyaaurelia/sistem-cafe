@extends('layouts.app')

@section('content')

    <h1>Dashboard Manajer</h1>

    <div style="display: flex; gap; 30px">

        <div style="border: 2px solid black; padding: 20px; width: 200px; text-align: center;">
            <h3>Total Menu</h3>
            <h1>3</h1>
        </div>

        <div style="border: 2px solid black; padding: 20px; width: 200px; text-align: center;">
            <h3>Total Bahan</h3>
            <h1>3</h1>
        </div>

    </div>

    <h1 style="margin-top: 50px;">Bahan Menipis</h1>

    <table border="1" cellpadding="10">

        <tr>
            <th>Nama</th>
            <th>Stok</th>
            <th>Minimum</th>
            <th>Status</th>
        </tr>

        <tr>
            <td>Susu</td>
            <td>500 ml</td>
            <td>1000 ml</td>
            <td>Menipis</td>
        <tr>

        <tr>
            <td>Biji Kopi</td>
            <td>150 g</td>
            <td>200 g</td>
            <td>Cukup</td>
        <tr>

    </table>
@endsection