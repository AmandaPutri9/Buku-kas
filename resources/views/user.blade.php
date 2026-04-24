<!DOCTYPE html>
<html>
<head>
    <title>Settings User</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            background: #f0f9ff;
        }

        .sidebar {
            width: 220px;
            background: #0c4a6e;
            color: white;
            height: 100vh;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 40px;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background: #38bdf8;
        }

        .active {
            background: #38bdf8;
        }

        .main {
            flex: 1;
        }

        .navbar {
            background: #0ea5e9;
            padding: 15px 25px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 26px;
        }

        .logout {
            background: white;
            color: #0ea5e9;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
        }

        .container {
            padding: 30px;
        }

        .header {
            margin-bottom: 20px;
            font-size: 28px;
        }

        .box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        input {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .add {
            background: #0ea5e9;
            color: white;
        }

        .edit {
            background: #f59e0b;
            color: white;
        }

        .delete {
            background: #ef4444;
            color: white;
        }

       table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        th {
            background: #0ea5e9;
            color: white;
            font-size: 13px;
        }

        tr:hover {
            background: #f1f5f9;
        }

        td:last-child {
            white-space: nowrap;
        }
    </style>
</head>

<body>

<div class="sidebar">
    <h2>Buku Kas</h2>
    <a href="/dashboard">Dashboard</a>
    <a href="/pemasukan">Pemasukan</a>
    <a href="/pengeluaran">Pengeluaran</a>
    <a href="/catatan">Catatan</a>
    <a href="/user" class="active"><strong>User</strong></a>
</div>

<div class="main">

    <div class="navbar">
        <div><strong>Settings User</strong></div>

        <form method="POST" action="/logout">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </div>

    <div class="container">

        <div class="header"><strong>Manajemen User</strong</div>

        <div class="box">
            <form method="POST" action="/user">
                @csrf

                <input type="text" name="name" placeholder="Nama" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>

                <button class="add">Tambah User</button>
            </form>
        </div>

        <div class="box">
            <table>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Aksi</th>
                </tr>

                @foreach($data as $item)
                <tr>

                    <form method="POST" action="/user/update/{{ $item->id }}">
                    @csrf

                    <td>
                        <input type="text" name="name" value="{{ $item->name }}">
                    </td>

                    <td>
                        <input type="email" name="email" value="{{ $item->email }}">
                    </td>

                    <td>
                        <input type="password" name="password" placeholder="••••••">
                    </td>

                    <td>
                        <button class="edit" type="submit">Update</button>
                    </form>

                        <form method="POST" action="/user/delete/{{ $item->id }}" style="display:inline;">
                            @csrf
                            <button class="delete" onclick="return confirm('Hapus user ini?')">
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
                @endforeach

            </table>
        </div>

    </div>
</div>

</body>
</html>