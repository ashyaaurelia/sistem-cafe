<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Kopi Senja - Kasir</title>

    <style>
        *{
            box-sizing: border-box;
        }

        body{
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .header{
            height: 80px;
            background: white;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 30px;
        }

        .sidebar{
            width: 220px;
            height: calc(100vh - 80px);
            background: white;
            border-right: 1px solid #ddd;
            padding: 20px;
            position: fixed;
        }

        .sidebar a{
            display: block;
            padding: 12px;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
        }

        .sidebar a:hover{
            background: #eeeeee;
        }

        .content{
            margin-left: 220px;
            padding: 30px;
        }

        .logout-btn{
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Kedai Kopi Senja</h2>
        <div>
            <strong>Kasir</strong>
            &nbsp; | &nbsp;
            {{ Auth::user()->name }}

            <form action="{{ route('logout') }}" method="POST" style="display: inline">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="sidebar">
        <a href="/kasir/dashboard">Dashboard</a>
        <a href="/kasir/menu">Daftar Menu</a>
        <a href="/kasir/transaksi/create">Pesanan</a>
        <a href="/kasir/reset-password-pelanggan">Reset Password Pelanggan</a>
    </div>

    <div class="content">
        @yield('content')
    </div>
</body>
</html>