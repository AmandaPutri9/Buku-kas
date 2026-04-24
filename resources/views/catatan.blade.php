<!DOCTYPE html>
<html>
<head>
    <title>Catatan</title>
    <style>
        body {
            margin:0;
            font-family:'Segoe UI', sans-serif;
            display:flex;
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

        .container {
            padding: 25px;
        }

        .form-box, .table-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }

        input, textarea {
            width: 97%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: none;
            height: 80px;
        }

        button {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-add { background: #0ea5e9; color:white; }
        .btn-delete { background: #ef4444; color:white; }
        .btn-edit { background: #f59e0b; color:white; }
        .btn-update { background: #22c55e; color:white; }

        table {
            width:100%;
            border-collapse:collapse;
        }

        th, td {
            padding:12px;
            border-bottom:1px solid #eee;
        }

        th {
            background:#0ea5e9;
            color:white;
        }

        tr:hover {
            background:#f1f5f9;
        }

        td:last-child {
            text-align:center;
            white-space:nowrap;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Buku Kas</h2>
    <a href="/dashboard">Dashboard</a>
    <a href="/pemasukan">Pemasukan</a>
    <a href="/pengeluaran">Pengeluaran</a>
    <a href="/catatan" class="active"><strong>Catatan</strong></a>
    <a href="/user">User</a>
</div>

<div class="main">

    <div class="navbar">
        <div><strong>Catatan</strong></div>

        <form method="POST" action="/logout">
            @csrf
            <button>Logout</button>
        </form>
    </div>

    <div class="container">

        <h3>Catatan Keuangan</h3>

        <div class="form-box">
            <form method="POST" action="/catatan">
                @csrf

                <input type="date" name="tanggal" required>
                <textarea name="isi" placeholder="Tulis catatan..." required></textarea>

                <button class="btn-add">Tambah Catatan</button>
            </form>
        </div>

        <div class="table-box">
            <table>
                <tr>
                    <th style="text-align:left;">Tanggal</th>
                    <th style="text-align:left;">Catatan</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>

                @foreach($data as $item)
                <tr>
                    <td>
                        <form method="POST" action="/catatan/update/{{ $item->id }}">
                            @csrf
                            <span class="text">{{ $item->tanggal }}</span>
                            <input type="date" name="tanggal" value="{{ $item->tanggal }}" style="display:none;">
                    </td>

                    <td>
                            <span class="text">{{ $item->isi }}</span>
                            <textarea name="isi" style="display:none;">{{ $item->isi }}</textarea>
                    </td>

                    <td>
                            <button type="button" class="btn-edit" onclick="editRow(this)">Edit</button>
                            <button type="submit" class="btn-update" style="display:none;">Update</button>
                        </form>

                        <form action="/catatan/delete/{{ $item->id }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn-delete" onclick="return confirm('Hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </table>
        </div>

    </div>
</div>

<script>
function editRow(btn){
    let row = btn.closest('tr');

    row.querySelectorAll('.text').forEach(e => e.style.display = 'none');
    row.querySelectorAll('input, textarea').forEach(e => e.style.display = 'block');

    btn.style.display = 'none';
    row.querySelector('.btn-update').style.display = 'inline-block';
}
</script>

</body>
</html>