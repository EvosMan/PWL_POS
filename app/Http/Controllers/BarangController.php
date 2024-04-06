<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Barang',
            'list' => ['Home', 'barang']
        ];

        $page = (object)[
            'title' => 'Daftar barang yang terdaftar dalam sistem'
        ];

        $activeMenu = 'barang'; //set menu yang sedang aktif

        $kategori = KategoriModel::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    // Ambil data barang dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // $barangs = BarangModel::select('barang_id', 'barang_kode', 'barang_nama')->with('barang');
        $barangs = BarangModel::select(
            'barang_id',
            'kategori_id',
            'barang_kode',
            'barang_nama',
            'harga_beli',
            'harga_jual',
        )->with('kategori');

        if ($request->barang_id) {
            $barangs->where('kategori_id', $request->barang_id);
        }

        return DataTables::of($barangs)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama
            ->addColumn('aksi', function ($barang) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/barang/' . $barang->barang_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah barang baru'
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'barang';

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama'    => 'required|string|max:100',
            'kategori_id' => 'required|integer',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'

        ]);

        BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama'     => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli, // password dienkripsi sebelum disimpan
            'harga_jual' => $request->harga_jual

        ]);
        return redirect('/barang')->with('success', 'Data barang berhasil disimpan');
    }
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama,' . $id . ',barang_id',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'kategori_id' => 'required|integer',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'

        ]);

        BarangModel::create([
            'barang_kode' => $request->barang_kode,
            'barang_nama'     => $request->barang_nama,
            'kategori_id' => $request->kategori_id,
            'harga_beli' => $request->harga_beli, // password dienkripsi sebelum disimpan
            'harga_jual' => $request->harga_jual

        ]);

        return redirect('/barang')->with('success', 'Data barang berhasil diubah');
    }
    public function show(string $id)
    {
        $barang = BarangModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Barang',
            'list' => ['Home', 'Barang', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang';

        return view('barang.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    public function destroy(string $id)
    {
        $check = BarangModel::find($id);
        if (!$check) {      // untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Data barang tidak ditemukan');
        }

        try {
            BarangModel::destroy($id);   // Hapus data barang

            return redirect('/barang')->with('success', 'Data barang berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data barang gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}































































//public function index(){
    //     $barang = BarangModel::with('barang')->get();
    //     return view('barang', ['data' => $barang]);

    // }

    // public function tambah()
    //     {
    //         return view ('barang_tambah');
    //     }

    // public function create(Request $request)
    // {
    //     BarangModel::create([
    //         'barangname' => $request->barangname,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'barang_id' => $request->barang_id
    //     ]);

    //     return redirect('/barang');
    // }

    // public function edit($id)
    // {
    //     $barang = BarangModel::find($id);
    //     return view('barang_ubah', ['data'=> $barang]);
    // }

    // public function update($id, Request $request)
    // {
    //     $barang = BarangModel::find($id);

    //     $barang->barangname = $request->barangname;
    //     $barang->nama = $request->nama;
    //     $barang->password = Hash::make('$request ->password');
    //     $barang->barang_id = $request->barang_id;

    //     $barang->save();

    //     return redirect('/barang');

    // }

    // public function destroy($id)
    // {
    //     $barang = BarangModel::find($id);
    //     $barang->delete();

    //     return redirect('/barang');
    // }

        // $data = [
        //     'barangname'=> 'customer-1',
        //     'nama'=>'Pelanggan',
        //     'password'=> Hash::make('12345'),
        //     'barang_id'=> 4
        // ];
        // BarangModel::insert($data);

        //tambahkan data ke tabel m_barang
        //coba akses model BarangModel
        // $barang = BarangModel::all(); //ambil semua data dari tabel m_barang
        // return view('barang', ['data' => $barang]);

        //$data=[
        //     'barang_id'=>2,
        //     'barangname'=> 'manager_tiga',
        //     'nama'=> 'Manager 3',
        //     'password'=> Hash::make('12345')
        // ];
        // BarangModel::create($data);

        // $barang = BarangModel::all();
        // return view ('barang', ['data' => $barang]);


        // $barang->barangname = 'Manager56';
        // $barang->isDirty();//true
        // $barang->isDirty('barangname');//true
        // $barang->isDirty('nama'); //false
        // $barang->isDirty(['nama', 'barangname']);//false

        // $barang->isClean(); //false
        // $barang->isClean('barangname');//false
        // $barang->isClean('nama');//true
        // $barang->isClean(['nama', 'barangname']);//false

        // $barang->save();

        // $barang->isDirty();
        // $barang->isClean();
        // return dd($barang->isDirty());

        // $barang = BarangModel::create(
        //     [
        //         'barangname' => 'manager11',
        //         'nama' => 'Manager11',
        //         'password'=> Hash::make('12345'),
        //         'barang_id'=>2

        //     ]);
        // $barang->barangname = 'manager12';
        // $barang->nama = 'Manager12';

        // $barang->save();

        // $barang->wasChanged();
        // $barang->wasChanged('barangname');
        // $barang->wasChanged(['barangname', 'barang_id']);
        // $barang->wasChanged('nama');
        // dd($barang->wasChanged(['nama', 'barangname']));
