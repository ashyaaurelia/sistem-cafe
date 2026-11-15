<!DOCTYPE html>
<html>
<head>
    <title>Kedai Kopi Senja</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            height: 100px;
            border-bottom: 2px solid black;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
        }

        .logo h2 {
            margin: 0;
        }

        .user {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .sidebar {
            width: 230px;
            min-height: calc(100vh - 100px);
            border-right: 2px solid black;
            padding: 30px 20px;
            position: fixed;
        }

        .sidebar a {
            display: block;
            color: black;
            text-decoration: none;
            padding: 12px;
        }

        .sidebar a:hover {
            background: #eeeeee;
        }

        .content {
            margin-left: 230px;
            padding: 30px 40px;
        }

        .logout-btn {
            background: none;
            border: none;
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="logo">
            <h2>Kedai Kopi Senja</h2>
        </div>

        <div class="user">
            <strong>Manajer</strong>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <div class="sidebar">
        <a href="/manajer/dashboard">Dashboard</a>
        <a href="/manajer/menu">Menu</a>
        <a href="/manajer/resep">Resep</a>
        <a href="/manajer/bahan">Bahan</a>
        <a href="#">Stok Masuk</a>
        <a href="#">Import CSV</a>
        <a href="#">Supplier</a>
        <a href="#">Laporan</a>
    </div>

    <div class="content">
        @yield('content')
    </div>

</body>
</html>