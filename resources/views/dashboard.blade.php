<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Buku Kas</title>
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
            font-size: 30px;
        }

        .header h5{
            color: #666;
            font-size: 20px;
        }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            position: relative;
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h4 {
            color: #666;
        }

        .card p {
            font-size: 26px;
            font-weight: bold;
        }

        .pemasukan p { color: #22c55e; }
        .pengeluaran p { color: #ef4444; }
        .saldo p { color: #0ea5e9; }

        .icon {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 35px;
            opacity: 0.15;
        }

        .pemasukan { border-left: 5px solid #22c55e; }
        .pengeluaran { border-left: 5px solid #ef4444; }
        .saldo { border-left: 5px solid #0ea5e9; }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        table {
            width: 99%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        table th {
            background: #0ea5e9;
            color: white;
        }

        table tr:hover {
            background: #f1f5f9;
        }

        .text-green { color: #16a34a; font-weight: bold; }
        .text-red { color: #dc2626; font-weight: bold; }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Buku Kas</h2>
    <a href="/dashboard" class="active"><strong>Dashboard</strong></a>
    <a href="/pemasukan">Pemasukan</a>
    <a href="/pengeluaran">Pengeluaran</a>
    <a href="/catatan">Catatan</a>
    <a href="/setting">Setting</a>
</div>

<div class="main">

    <div class="navbar">
        <div><strong>Dashboard</strong></div>

        <form method="POST" action="/logout">
            @csrf
            <button class="logout">Logout</button>
        </form>
    </div>

    <div class="container">

        <div class="header">
            <h3>Halo, {{ auth()->user()->name }} 👋</h3>
            <h5>Ringkasan data keuangan Anda</h5>
        </div>

        <div class="cards">

            <div class="card pemasukan">
                <div class="icon">💰</div>
                <h4>Total Pemasukan</h4>
                <p>Rp {{ number_format($totalPemasukan,0,',','.') }}</p>
            </div>

            <div class="card pengeluaran">
                <div class="icon">📉</div>
                <h4>Total Pengeluaran</h4>
                <p>Rp {{ number_format($totalPengeluaran,0,',','.') }}</p>
            </div>

            <div class="card saldo">
                <div class="icon">📊</div>
                <h4>Saldo</h4>
                <p>Rp {{ number_format($saldo,0,',','.') }}</p>
            </div>

        </div>

        <div class="table-box">
            <h4>Transaksi Terakhir</h4>

            <table>
                <tr>
                    <th style="text-align:left;">Tanggal</th>
                    <th style="text-align:left;">Keterangan</th>
                    <th style="text-align:center;">Jenis</th>
                    <th style="text-align:right;">Jumlah</th>
                </tr>

                @forelse($transaksi as $item)
                <tr>
                    <td style="color:#555;">
                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                    </td>

                    <td>
                        <strong>{{ $item->keterangan }}</strong>
                    </td>

                    <td style="text-align:center;">
                        @if($item->jenis == 'Pemasukan')
                            <span style="background:#dcfce7; color:#166534; padding:5px 12px; border-radius:20px; font-size:12px;">
                                Pemasukan
                            </span>
                        @else
                            <span style="background:#fee2e2; color:#991b1b; padding:5px 12px; border-radius:20px; font-size:12px;">
                                Pengeluaran
                            </span>
                        @endif
                    </td>

                    <td style="text-align:right;">
                        @if($item->jenis == 'Pemasukan')
                            <span class="text-green">
                                + Rp {{ number_format($item->jumlah,0,',','.') }}
                            </span>
                        @else
                            <span class="text-red">
                                - Rp {{ number_format($item->jumlah,0,',','.') }}
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center; padding:20px; color:#888;">
                        Belum ada data
                    </td>
                </tr>
                @endforelse

            </table>
        </div>

    </div>
</div>

</body>
</html>