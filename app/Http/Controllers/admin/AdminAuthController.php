<?php

namespace App\Http\Controllers\Admin;

use App\Models\BarangSekaliPakai;
use App\Models\RequestPerbaikanBarang;
use App\Models\User;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return redirect('/admin/dashboard');
        }

        return view('pages.admin.login.index');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors(['email' => 'Email or password is incorrect.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    public function dashboard()
    {
        $user_name = Auth::user();

        $jml_users = User::count();
        $jml_perbaikan = RequestPerbaikanBarang::count();
        $jml_permintaan = Permintaan::count();
        $jml_sekali_pakai = BarangSekaliPakai::count();

        // Ambil tanggal 5 hari terakhir
        $lastFiveDays = \Carbon\Carbon::now()->subDays(5)->toDateString();
        $dates = [];
        for ($i = 0; $i < 5; $i++) {
            $dates[] = \Carbon\Carbon::now()->subDays(4 - $i)->toDateString();
        }


        $perbaikan_per_tanggal = RequestPerbaikanBarang::selectRaw('DATE(created_at) as tanggal, 
                                                        COUNT(*) as perbaikan, 
                                                        SUM(CASE WHEN status = "dalam_perbaikan" THEN 1 ELSE 0 END) as perbaikan')
            ->where('created_at', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();

        $permintaan_per_tanggal = Permintaan::selectRaw('DATE(created_at) as tanggal, COUNT(*) as permintaan')
            ->where('created_at', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();

        $sekali_pakai_per_tanggal = BarangSekaliPakai::selectRaw('DATE(created_at) as tanggal, COUNT(*) as barang_sekali_pakai')
            ->where('created_at', '>=', $lastFiveDays)
            ->groupBy('tanggal')
            ->get();


        $data_per_tanggal = [];
        foreach ($dates as $tanggal) {
            $data_per_tanggal[$tanggal] = [
                'perbaikan' => 0,
                'permintaan' => 0,
                'sekali_pakai' => 0,
            ];
        }

        // Masukkan data peminjaman, barang dan rusak ke dalam data_per_tanggal
        foreach ($perbaikan_per_tanggal as $perbaikan) {
            $data_per_tanggal[$perbaikan->tanggal]['perbaikan'] = $perbaikan->perbaikan;
        }
        foreach ($permintaan_per_tanggal as $permintaan) {
            $data_per_tanggal[$permintaan->tanggal]['permintaan'] = $permintaan->permintaan;
        }
        foreach ($sekali_pakai_per_tanggal as $barang_sekali_pakai) {
            $data_per_tanggal[$barang_sekali_pakai->tanggal]['sekali_pakai'] = $barang_sekali_pakai->barang_sekali_pakai;
        }

        //sorting tanggal
        ksort($data_per_tanggal);

        $dates = array_keys($data_per_tanggal);
        $perbaikan = array_column($data_per_tanggal, 'perbaikan');
        $permintaan = array_column($data_per_tanggal, 'permintaan');
        $barang_sekali_pakai = array_column($data_per_tanggal, 'sekali_pakai');

        $chart_data = [
            'perbaikan' => $jml_perbaikan,
            'permintaan' => $jml_permintaan,
            'barang_sekali_pakai' => $jml_sekali_pakai,
        ];

        return view('pages.admin.dashboard.dashboard', compact(
            'user_name',
            'jml_users',
            'jml_perbaikan',
            'jml_permintaan',
            'jml_sekali_pakai',
            'chart_data',
            'dates',
            'perbaikan',
            'permintaan',
            'barang_sekali_pakai'
        ));
    }
}

?>