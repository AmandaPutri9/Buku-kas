<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', function (Request $request) {

    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    return back()->with('error', 'Email atau password salah');
});


Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
});

Route::get('/dashboard', function () {

    $totalPemasukan = DB::table('pemasukans')->sum('jumlah');
    $totalPengeluaran = DB::table('pengeluarans')->sum('jumlah');
    $saldo = $totalPemasukan - $totalPengeluaran;

    $pemasukan = DB::table('pemasukans')
        ->select('tanggal','keterangan','jumlah', DB::raw("'Pemasukan' as jenis"));

    $pengeluaran = DB::table('pengeluarans')
        ->select('tanggal','keterangan','jumlah', DB::raw("'Pengeluaran' as jenis"));

    $transaksi = $pemasukan
        ->unionAll($pengeluaran)
        ->orderBy('tanggal','desc')
        ->limit(5)
        ->get();

    return view('dashboard', compact(
        'totalPemasukan',
        'totalPengeluaran',
        'saldo',
        'transaksi'
    ));

})->middleware('auth');

Route::get('/pemasukan', function () {
    $data = DB::table('pemasukans')->orderBy('tanggal','desc')->get();
    return view('pemasukan', compact('data'));
})->middleware('auth');

Route::post('/pemasukan', function (Request $request) {

    DB::table('pemasukans')->insert([
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan,
        'jumlah' => $request->jumlah,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect('/pemasukan');

})->middleware('auth');

Route::post('/pemasukan/update/{id}', function (Request $request, $id) {
    DB::table('pemasukans')->where('id', $id)->update([
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan,
        'jumlah' => $request->jumlah,
        'updated_at' => now()
    ]);

    return redirect('/pemasukan');

})->middleware('auth');

Route::post('/pemasukan/delete/{id}', function ($id) {

    DB::table('pemasukans')->where('id', $id)->delete();
    return back();

})->middleware('auth');


Route::get('/pengeluaran', function () {
    $data = DB::table('pengeluarans')->orderBy('tanggal','desc')->get();
    return view('pengeluaran', compact('data'));
})->middleware('auth');

Route::post('/pengeluaran', function (Request $request) {
    DB::table('pengeluarans')->insert([
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan,
        'jumlah' => $request->jumlah,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect('/pengeluaran');
})->middleware('auth');

Route::post('/pengeluaran/update/{id}', function (Request $req, $id) {
    DB::table('pengeluarans')->where('id', $id)->update([
        'tanggal' => $req->tanggal,
        'keterangan' => $req->keterangan,
        'jumlah' => $req->jumlah,
        'updated_at' => now()
    ]);

    return redirect('/pengeluaran');

})->middleware('auth');

Route::post('/pengeluaran/delete/{id}', function ($id) {

    DB::table('pengeluarans')->where('id', $id)->delete();
    return back();

})->middleware('auth');


Route::get('/catatan', function () {
    $data = DB::table('catatan')->orderBy('tanggal','desc')->get();
    return view('catatan', compact('data'));

})->middleware('auth');

Route::post('/catatan', function (Request $request) {
    DB::table('catatan')->insert([
        'tanggal' => $request->tanggal,
        'isi' => $request->isi,
        'created_at' => now(),
        'updated_at' => now()
    ]);

    return redirect('/catatan');
})->middleware('auth');

Route::post('/catatan/update/{id}', function (Request $request, $id) {

    DB::table('catatan')->where('id', $id)->update([
        'tanggal' => $request->tanggal,
        'isi' => $request->isi,
        'updated_at' => now()
    ]);

    return redirect('/catatan');

})->middleware('auth');

Route::post('/catatan/delete/{id}', function ($id) {

    DB::table('catatan')->where('id', $id)->delete();
    return back();
})->middleware('auth');

Route::get('/user', function () {
    $data = DB::table('users')->get();
    return view('user', compact('data'));
})->middleware('auth');

Route::post('/user', function (Request $request) {

    DB::table('users')->insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    return redirect('/user');
})->middleware('auth');

Route::post('/user/update/{id}', function (Request $request, $id) {

    $user = DB::table('users')->where('id', $id)->first();

    DB::table('users')->where('id', $id)->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password
            ? Hash::make($request->password)
            : $user->password,
        'updated_at' => now()
    ]);
    return redirect('/user')->with('success', 'User berhasil diupdate');
})->middleware('auth');

Route::post('/user/delete/{id}', function ($id) {
    DB::table('users')->where('id', $id)->delete();
    return back();
})->middleware('auth');