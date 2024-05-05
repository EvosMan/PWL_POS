<?php

namespace App\Http\Controllers;

use App\Models\KategoriModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Kategori',
            'list' => ['Home', 'kategori']
        ];

        $page = (object)[
            'title' => 'Daftar kategori yang terdaftar dalam siste,'
        ];

        $activeMenu = 'kategori'; //set menu yang sedang aktif

        $barang = BarangModel::all();

        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    // Ambil data kategori dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama')->with('barang');
        $kategoris = KategoriModel::select('kategori_id', 'kategori_kode', 'kategori_nama');

        if($request->barang_id){
            $kategoris->where('barang_id', $request->barang_id);
        }


        return DataTables::of($kategoris)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama
            ->addColumn('aksi', function ($kategori) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/kategori/' . $kategori->kategori_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Kategori',
            'list' => ['Home', 'Kategori', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah kategori baru'
        ];
        $barang = BarangModel::all();
        $activeMenu = 'kategori';

        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama'     => 'required|string|max:100',
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama'     => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function edit(string $id)
    {
        $kategori = KategoriModel::find($id);
        $barang = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Kategori',
            'list'  => ['Home', 'Kategori', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit kategori'
        ];

        $activeMenu = 'kategori'; // set menu yang sedang aktif

        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama'     => 'required|string|max:100',
        ]);

        KategoriModel::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama'     => $request->kategori_nama,
        ]);

        return redirect('/kategori')->with('success', 'Data kategori berhasil disimpan');
    }

    public function show($id)
    {
        $kategori = KategoriModel::find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Kategori',
            'list'  => ['Home', 'Kategori', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail kategori'
        ];

        $activeMenu = 'kategori';

        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function destroy(string $id)
    {
        $check = KategoriModel::find($id);
        if (!$check) {      // untuk mengecek apakah data kategori dengan id yang dimaksud ada atau tidak
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan');
        }

        try {
            KategoriModel::destroy($id);   // Hapus data barang

            return redirect('/kategori')->with('success', 'Data kategori berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Data kategori gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}































































//public function index(){
    //     $kategori = KategoriModel::with('barang')->get();
    //     return view('kategori', ['data' => $kategori]);

    // }

    // public function tambah()
    //     {
    //         return view ('kategori_tambah');
    //     }

    // public function create(Request $request)
    // {
    //     KategoriModel::create([
    //         'kategoriname' => $request->kategoriname,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'barang_id' => $request->barang_id
    //     ]);

    //     return redirect('/kategori');
    // }

    // public function edit($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     return view('kategori_ubah', ['data'=> $kategori]);
    // }

    // public function update($id, Request $request)
    // {
    //     $kategori = KategoriModel::find($id);

    //     $kategori->kategoriname = $request->kategoriname;
    //     $kategori->nama = $request->nama;
    //     $kategori->password = Hash::make('$request ->password');
    //     $kategori->barang_id = $request->barang_id;

    //     $kategori->save();

    //     return redirect('/kategori');

    // }

    // public function destroy($id)
    // {
    //     $kategori = KategoriModel::find($id);
    //     $kategori->delete();

    //     return redirect('/kategori');
    // }

        // $data = [
        //     'kategoriname'=> 'customer-1',
        //     'nama'=>'Pelanggan',
        //     'password'=> Hash::make('12345'),
        //     'barang_id'=> 4
        // ];
        // KategoriModel::insert($data);

        //tambahkan data ke tabel m_kategori
        //coba akses model KategoriModel
        // $kategori = KategoriModel::all(); //ambil semua data dari tabel m_kategori
        // return view('kategori', ['data' => $kategori]);

        //$data=[
        //     'barang_id'=>2,
        //     'kategoriname'=> 'manager_tiga',
        //     'nama'=> 'Manager 3',
        //     'password'=> Hash::make('12345')
        // ];
        // KategoriModel::create($data);

        // $kategori = KategoriModel::all();
        // return view ('kategori', ['data' => $kategori]);


        // $kategori->kategoriname = 'Manager56';
        // $kategori->isDirty();//true
        // $kategori->isDirty('kategoriname');//true
        // $kategori->isDirty('nama'); //false
        // $kategori->isDirty(['nama', 'kategoriname']);//false

        // $kategori->isClean(); //false
        // $kategori->isClean('kategoriname');//false
        // $kategori->isClean('nama');//true
        // $kategori->isClean(['nama', 'kategoriname']);//false

        // $kategori->save();

        // $kategori->isDirty();
        // $kategori->isClean();
        // return dd($kategori->isDirty());

        // $kategori = KategoriModel::create(
        //     [
        //         'kategoriname' => 'manager11',
        //         'nama' => 'Manager11',
        //         'password'=> Hash::make('12345'),
        //         'barang_id'=>2

        //     ]);
        // $kategori->kategoriname = 'manager12';
        // $kategori->nama = 'Manager12';

        // $kategori->save();

        // $kategori->wasChanged();
        // $kategori->wasChanged('kategoriname');
        // $kategori->wasChanged(['kategoriname', 'barang_id']);
        // $kategori->wasChanged('nama');
        // dd($kategori->wasChanged(['nama', 'kategoriname']));
