<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Barang;
use App\Models\Jurusan;
use App\Models\Peminjaman;
use App\Models\Permintaan;
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
        $user_name = Auth::user();
    
        $jml_barang = Barang::count();
        $jml_dipinjam = Peminjaman::count();
        $jml_kembali = Peminjaman::where('status_pinjam', 'kembali')->count();
        $jml_rusak = Permintaan::count();
        $status_terbaru = Peminjaman::latest()->take(3)->get();
    
        // Ambil tanggal 5 hari terakhir
        $lastFiveDays = \Carbon\Carbon::now()->subDays(5)->toDateString();
        $dates = [];
        for ($i = 0; $i < 5; $i++) {
            $dates[] = \Carbon\Carbon::now()->subDays(4 - $i)->toDateString();
        }
    

        $peminjaman_per_tanggal = Peminjaman::selectRaw('DATE(tanggal_pinjam) as tanggal, 
                                                        COUNT(*) as dipinjam, 
                                                        SUM(CASE WHEN status_pinjam = "kembali" THEN 1 ELSE 0 END) as kembali')
            ->where('tanggal_pinjam', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();
    
        $rusak_per_tanggal = Permintaan::selectRaw('DATE(created_at) as tanggal, COUNT(*) as rusak')
            ->where('created_at', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();
    
        $barang_per_tanggal = Barang::selectRaw('DATE(created_at) as tanggal, COUNT(*) as barang')
            ->where('created_at', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();
    
        $data_per_tanggal = [];
        foreach ($dates as $tanggal) {
            $data_per_tanggal[$tanggal] = [
                'dipinjam' => 0,
                'kembali' => 0,
                'rusak' => 0,
                'barang' => 0
            ];
        }
    
        // Masukkan data peminjaman, barang dan rusak ke dalam data_per_tanggal
        foreach ($peminjaman_per_tanggal as $peminjaman) {
            $data_per_tanggal[$peminjaman->tanggal]['dipinjam'] = $peminjaman->dipinjam;
            $data_per_tanggal[$peminjaman->tanggal]['kembali'] = $peminjaman->kembali;
        }
        foreach ($barang_per_tanggal as $barang) {
            $data_per_tanggal[$barang->tanggal]['barang'] = $barang->barang;
        }
        foreach ($rusak_per_tanggal as $rusak) {
            $data_per_tanggal[$rusak->tanggal]['rusak'] = $rusak->rusak;
        }
    
        //sorting tanggal
        ksort($data_per_tanggal);
    
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
            'user_name',
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
