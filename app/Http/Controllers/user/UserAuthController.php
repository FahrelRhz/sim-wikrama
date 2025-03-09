<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Barang;
use App\Models\Jurusan;
use App\Models\Peminjaman;
use App\Models\RequestPerbaikanBarang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect('/user/dashboard'); 
        }

        $jurusans = Jurusan::all();

        return view('pages.user.login.index', compact('jurusans'));
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'jurusan' => 'required|string|exists:jurusan,nama_jurusan', 
            'password' => 'required|string',
        ]);

        $user = User::where('name', $request->name)
            ->where('email', $request->email)
            ->whereHas('jurusan', function ($query) use ($request) {
                $query->where('nama_jurusan', $request->jurusan);
            })
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors(['login' => 'Email, nama, jurusan, atau password tidak sesuai.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/user/login');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $jurusan_id = $user->jurusan_id; // Ambil jurusan pengguna yang sedang login
    
        // Hitung jumlah barang berdasarkan jurusan pengguna
        $jml_barang = Barang::where('jurusan_id', $jurusan_id)->count();
    
        // Hitung jumlah peminjaman berdasarkan jurusan pengguna
        $jml_dipinjam = Peminjaman::whereHas('barang', function ($query) use ($jurusan_id) {
            $query->where('jurusan_id', $jurusan_id);
        })->where('status_pinjam', 'dipinjam')->count();
    
        $jml_kembali = Peminjaman::whereHas('barang', function ($query) use ($jurusan_id) {
            $query->where('jurusan_id', $jurusan_id);
        })->where('status_pinjam', 'kembali')->count();
    
        // Hitung jumlah permintaan berdasarkan user yang login
        $jml_rusak = RequestPerbaikanBarang::where('user_id', $user->id)->count();
    
        // Ambil 3 status peminjaman terbaru berdasarkan jurusan
        $status_terbaru = Peminjaman::whereHas('barang', function ($query) use ($jurusan_id) {
            $query->where('jurusan_id', $jurusan_id);
        })->latest()->take(3)->get();
    
        // Ambil tanggal 5 hari terakhir
        $lastFiveDays = \Carbon\Carbon::now()->subDays(5)->toDateString();
        $dates = [];
        for ($i = 0; $i < 5; $i++) {
            $dates[] = \Carbon\Carbon::now()->subDays(4 - $i)->toDateString();
        }
    
        // Ambil jumlah peminjaman per tanggal berdasarkan jurusan pengguna
        $peminjaman_per_tanggal = Peminjaman::selectRaw('DATE(tanggal_pinjam) as tanggal, 
                                                        COUNT(*) as dipinjam, 
                                                        SUM(CASE WHEN status_pinjam = "dipinjam" THEN 1 ELSE 0 END) as dipinjam')
            ->whereHas('barang', function ($query) use ($jurusan_id) {
                $query->where('jurusan_id', $jurusan_id);
            })
            ->where('tanggal_pinjam', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();

        $kembali_per_tanggal = Peminjaman::selectRaw('DATE(tanggal_kembali) as tanggal, 
                                                        COUNT(*) as kembali, 
                                                        SUM(CASE WHEN status_pinjam = "kembali" THEN 1 ELSE 0 END) as kembali')
            ->whereHas('barang', function ($query) use ($jurusan_id) {
                $query->where('jurusan_id', $jurusan_id);
            })
            ->where('tanggal_kembali', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();
    
        // Ambil jumlah permintaan rusak per tanggal berdasarkan user login
        $rusak_per_tanggal = RequestPerbaikanBarang::selectRaw('DATE(tanggal_request) as tanggal, COUNT(*) as rusak')
            ->where('user_id', $user->id)
            ->where('tanggal_request', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();
    
        // Ambil jumlah barang per tanggal berdasarkan jurusan pengguna
        $barang_per_tanggal = Barang::selectRaw('DATE(created_at) as tanggal, COUNT(*) as barang')
            ->where('jurusan_id', $jurusan_id)
            ->where('created_at', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();
    
        // Persiapkan data per tanggal
        $data_per_tanggal = [];
        foreach ($dates as $tanggal) {
            $data_per_tanggal[$tanggal] = [
                'dipinjam' => 0,
                'kembali' => 0,
                'rusak' => 0,
                'barang' => 0
            ];
        }
    
        // Masukkan data ke dalam data_per_tanggal
        foreach ($peminjaman_per_tanggal as $peminjaman) {
            $data_per_tanggal[$peminjaman->tanggal]['dipinjam'] = $peminjaman->dipinjam;
        }
        foreach ($kembali_per_tanggal as $pengembalian) {
            $data_per_tanggal[$pengembalian->tanggal]['kembali'] = $pengembalian->kembali;
        }
        foreach ($barang_per_tanggal as $barang) {
            $data_per_tanggal[$barang->tanggal]['barang'] = $barang->barang;
        }
        foreach ($rusak_per_tanggal as $rusak) {
            $data_per_tanggal[$rusak->tanggal]['rusak'] = $rusak->rusak;
        }
    
        // Urutkan tanggal
        ksort($data_per_tanggal);
    
        // Siapkan data untuk chart
        $dates = array_keys($data_per_tanggal);
        $barang = array_column($data_per_tanggal, 'barang');
        $dipinjam = array_column($data_per_tanggal, 'dipinjam');
        $kembali = array_column($data_per_tanggal, 'kembali');
        $rusak = array_column($data_per_tanggal, 'rusak');
    
        $chart_data = [
            'barang' => $jml_barang,
            'dipinjam' => $jml_dipinjam,
            'kembali' => $jml_kembali,
            'rusak' => $jml_rusak,
        ];
    
        return view('pages.user.dashboard.dashboard', compact(
            'user',
            'jml_barang',
            'jml_dipinjam',
            'jml_kembali',
            'jml_rusak',
            'status_terbaru',
            'chart_data',
            'dates',
            'barang',
            'dipinjam',
            'kembali',
            'rusak'
        ));
    }    
}
