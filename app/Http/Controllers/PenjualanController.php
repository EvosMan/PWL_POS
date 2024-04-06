<?php

namespace App\Http\Controllers;

use App\DataTables\PenjualanModelDataTable;
use App\Http\Requests\StorePenjualanRequest;
use App\Models\BarangModel;
use App\Models\PenjualanModel;
use App\Models\KategoriModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class PenjualanController extends Controller {

    public function list(Request $request) {
        $penjualans = PenjualanModel::select(
            'penjualan_id',
            'user_id',
            'pembeli',
            'penjualan_kode',
            'penjualan_tanggal',
        )->with(['user']);

        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) {
                $btn  = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Penjualan',
            'list'  => ['Home', 'Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::all();
        $user = UserModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function create() {
        // $breadcrumb = (object) [
        //     'title' => 'Tambah Penjualan',
        //     'list' => ['Home', 'Penjualan', 'Tambah']
        // ];

        // $page = (object) [
        //     'title' => 'Tambah penjualan baru'
        // ];

        // $user = BarangModel::all();
        // $user = UserModel::all();

        // $activeMenu = 'penjualan';

        // return view('penjualan.create', [
        //     'breadcrumb' => $breadcrumb,
        //     'page' => $page,
        //     'user' => $user,
        //     'user' => $user,
        //     'activeMenu' => $activeMenu
        // ]);
    }

    public function store(Request $request) {
        // $request->validate([
        //     // 'user_id' => 'required|exists:m_user,user_id|unique:t_penjualan,user_id',
        //     'user_id' => 'required|exists:m_user,user_id',
        //     'user_id' => 'required|exists:m_user,user_id',
        //     'penjualan_tanggal' => 'required|date',
        //     'penjualan_jumlah' => 'required|numeric'
        // ]);

        // PenjualanModel::create([
        //     'user_id' => $request->user_id,
        //     'user_id' => $request->user_id,
        //     'penjualan_tanggal' => $request->penjualan_tanggal,
        //     'penjualan_jumlah' => $request->penjualan_jumlah
        // ]);

        // return redirect('/penjualan')->with('success', 'Data penjualan berhasil disimpan');
    }

    public function edit(string $id) {
        // $penjualan = PenjualanModel::find($id);
        // $user = BarangModel::all();
        // $user = UserModel::all();

        // $breadcrumb = (object) [
        //     'title' => 'Edit Penjualan',
        //     'list'  => ['Home', 'Penjualan', 'Edit']
        // ];

        // $page = (object) [
        //     'title' => 'Edit penjualan'
        // ];

        // $activeMenu = 'penjualan';

        // return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'user' => $user, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id) {
        // $request->validate([
        //     // 'user_id' => 'required|exists:m_user,user_id|unique:m_penjualan,user_id,' . $request->user_id,
        //     'user_id' => 'required|exists:m_user,user_id',
        //     'user_id' => 'required|exists:m_user,user_id',
        //     'penjualan_tanggal' => 'required|date',
        //     'penjualan_jumlah' => 'required|numeric'
        // ]);

        // PenjualanModel::find($id)->update([
        //     'user_id' => $request->user_id,
        //     'user_id' => $request->user_id,
        //     'penjualan_tanggal' => $request->penjualan_tanggal,
        //     'penjualan_jumlah' => $request->penjualan_jumlah
        // ]);

        // return redirect('/penjualan')->with('success', 'Data penjualan berhasil diubah');
    }

    public function show($id) {
        $penjualan = PenjualanModel::with(['user', 'details' => ['barang']])->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Penjualan',
            'list'  => ['Home', 'Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail penjualan'
        ];

        $activeMenu = 'penjualan'; // set menu yang sedang aktif

        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

    public function destroy(string $id) {
        $check = PenjualanModel::find($id);
        if (!$check) {      // untuk mengecek apakah data penjualan dengan id yang dimaksud ada atau tidak
            return redirect('/penjualan')->with('error', 'Data penjualan tidak ditemukan');
        }

        try {
            PenjualanModel::destroy($id);   // Hapus data penjualan

            return redirect('/penjualan')->with('success', 'Data penjualan berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/penjualan')->with('error', 'Data penjualan gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}