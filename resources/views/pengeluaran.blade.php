<!DOCTYPE html>
<html>
<head>
    <title>Pengeluaran</title>
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
        }

        .form-box, .table-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        input {
            width: 100%;
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

        .btn-add { background: #0ea5e9; color: white; }
        .btn-delete { background: #ef4444; color: white; }
        .btn-edit { background: #f59e0b; color: white; }
        .btn-update { background: #22c55e; color: white; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 7px;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #0ea5e9;
            color: white;
        }

        tr:hover {
            background: #f1f5f9;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Buku Kas</h2>
    <a href="/dashboard">Dashboard</a>
    <a href="/pemasukan">Pemasukan</a>
    <a href="/pengeluaran" class="active"><strong>Pengeluaran</strong></a>
    <a href="/catatan">Catatan</a>
</div>

<div class="main">

    <div class="navbar">
        <div><strong>Pengeluaran</strong></div>

        <form method="POST" action="/logout">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </div>

    <div class="container">

        <div class="header">
            <h3>Data Pengeluaran</h3>
        </div>

        <div class="form-box">
            <form method="POST" action="/pengeluaran">
                @csrf
                <input type="date" name="tanggal" required>
                <input type="text" name="keterangan" placeholder="Keterangan" required>
                <input type="number" name="jumlah" placeholder="Jumlah" required>
                <button class="btn-add">Tambah Pengeluaran</button>
            </form>
        </div>

        <div class="table-box">
            <h4>Daftar Pengeluaran</h4>

            <table>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>

                @foreach($data as $item)
                <tr>
                    <td>
                        <form method="POST" action="/pengeluaran/update/{{ $item->id }}">
                            @csrf
                            <span class="text">{{ $item->tanggal }}</span>
                            <input type="date" name="tanggal" value="{{ $item->tanggal }}" style="display:none;">
                    </td>

                    <td>
                            <span class="text">{{ $item->keterangan }}</span>
                            <input type="text" name="keterangan" value="{{ $item->keterangan }}" style="display:none;">
                    </td>

                    <td style="text-align:right;">
                            <span class="text">Rp {{ number_format($item->jumlah,0,',','.') }}</span>
                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" style="display:none;">
                    </td>

                    <td style="text-align:center;">
                            <button type="button" class="btn-edit" onclick="editRow(this)">Edit</button>
                            <button type="submit" class="btn-update" style="display:none;">Update</button>
                        </form>

                        <form action="/pengeluaran/delete/{{ $item->id }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn-delete" onclick="return confirm('Hapus data ini?')">Hapus</button>
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
    row.querySelectorAll('input').forEach(e => e.style.display = 'block');

    btn.style.display = 'none';
    row.querySelector('.btn-update').style.display = 'inline-block';
}
</script>

</body>
</html>