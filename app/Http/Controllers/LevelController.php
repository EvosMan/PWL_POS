<?php

namespace App\Http\Controllers;

use App\Models\LevelModel;
use App\Models\BarangModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Level',
            'list' => ['Home', 'level']
        ];

        $page = (object)[
            'title' => 'Daftar level yang terdaftar dalam siste,'
        ];

        $activeMenu = 'level'; //set menu yang sedang aktif

        $barang = BarangModel::all();

        return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }
    // Ambil data level dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        // $levels = LevelModel::select('level_id', 'level_kode', 'level_nama')->with('barang');
        $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');

        if($request->barang_id){
            $levels->where('barang_id', $request->barang_id);
        }


        return DataTables::of($levels)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama
            ->addColumn('aksi', function ($level) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/level/' . $level->level_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Level',
            'list' => ['Home', 'Level', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah level baru'
        ];
        $barang = BarangModel::all();
        $activeMenu = 'level';

        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'levelname' => 'required|string|min:3|unique:m_level,levelname',
            'nama'    => 'required|string|max:100',
            'password' => 'required|min:5',
            'barang_id' => 'required|integer'
        ]);

        LevelModel::create([
            'levelname' => $request->levelname,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password), // password dienkripsi sebelum disimpan
            'barang_id' => $request->barang_id
        ]);
        return redirect('/level')->with('success', 'Data level berhasil disimpan');
    }
    public function edit(string $id)
    {
        $level = LevelModel::find($id);
        $barang = BarangModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Level',
            'list'  => ['Home', 'Level', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit level'
        ];

        $activeMenu = 'level'; // set menu yang sedang aktif

        return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            // levelname harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_level kolom levelname kecuali untuk level dengan id yang sedang diedit
            'levelname' => 'required|string|min:3|unique:m_level,levelname,' . $id . ',level_id',
            'nama'     => 'required|string|max:100', // nama harus diisi, berupa string, dan maksimal 100 karakter
            'password' => 'nullable|min:5',          // password bisa diisi (minimal 5 karakter) dan bisa tidak diisi
            'barang_id' => 'required|integer'         // barang_id harus diisi dan berupa angka
        ]);

        LevelModel::find($id)->update([
            'levelname' => $request->levelname,
            'nama'     => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : LevelModel::find($id)->password,
            'barang_id' => $request->barang_id
        ]);

        return redirect('/level')->with('success', 'Data level berhasil diubah');
    }
    public function show(string $id)
    {
        $level = LevelModel::find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Level',
            'list' => ['Home', 'Level', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Level'
        ];

        $activeMenu = 'level';

        return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function destroy(string $id)
    {
        $check = LevelModel::find($id);
        if (!$check) {      // untuk mengecek apakah data level dengan id yang dimaksud ada atau tidak
            return redirect('/level')->with('error', 'Data level tidak ditemukan');
        }

        try {
            LevelModel::destroy($id);   // Hapus data barang

            return redirect('/level')->with('success', 'Data level berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/level')->with('error', 'Data level gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}































































//public function index(){
    //     $level = LevelModel::with('barang')->get();
    //     return view('level', ['data' => $level]);

    // }

    // public function tambah()
    //     {
    //         return view ('level_tambah');
    //     }

    // public function create(Request $request)
    // {
    //     LevelModel::create([
    //         'levelname' => $request->levelname,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'barang_id' => $request->barang_id
    //     ]);

    //     return redirect('/level');
    // }

    // public function edit($id)
    // {
    //     $level = LevelModel::find($id);
    //     return view('level_ubah', ['data'=> $level]);
    // }

    // public function update($id, Request $request)
    // {
    //     $level = LevelModel::find($id);

    //     $level->levelname = $request->levelname;
    //     $level->nama = $request->nama;
    //     $level->password = Hash::make('$request ->password');
    //     $level->barang_id = $request->barang_id;

    //     $level->save();

    //     return redirect('/level');

    // }

    // public function destroy($id)
    // {
    //     $level = LevelModel::find($id);
    //     $level->delete();

    //     return redirect('/level');
    // }

        // $data = [
        //     'levelname'=> 'customer-1',
        //     'nama'=>'Pelanggan',
        //     'password'=> Hash::make('12345'),
        //     'barang_id'=> 4
        // ];
        // LevelModel::insert($data);

        //tambahkan data ke tabel m_level
        //coba akses model LevelModel
        // $level = LevelModel::all(); //ambil semua data dari tabel m_level
        // return view('level', ['data' => $level]);

        //$data=[
        //     'barang_id'=>2,
        //     'levelname'=> 'manager_tiga',
        //     'nama'=> 'Manager 3',
        //     'password'=> Hash::make('12345')
        // ];
        // LevelModel::create($data);

        // $level = LevelModel::all();
        // return view ('level', ['data' => $level]);


        // $level->levelname = 'Manager56';
        // $level->isDirty();//true
        // $level->isDirty('levelname');//true
        // $level->isDirty('nama'); //false
        // $level->isDirty(['nama', 'levelname']);//false

        // $level->isClean(); //false
        // $level->isClean('levelname');//false
        // $level->isClean('nama');//true
        // $level->isClean(['nama', 'levelname']);//false

        // $level->save();

        // $level->isDirty();
        // $level->isClean();
        // return dd($level->isDirty());

        // $level = LevelModel::create(
        //     [
        //         'levelname' => 'manager11',
        //         'nama' => 'Manager11',
        //         'password'=> Hash::make('12345'),
        //         'barang_id'=>2

        //     ]);
        // $level->levelname = 'manager12';
        // $level->nama = 'Manager12';

        // $level->save();

        // $level->wasChanged();
        // $level->wasChanged('levelname');
        // $level->wasChanged(['levelname', 'barang_id']);
        // $level->wasChanged('nama');
        // dd($level->wasChanged(['nama', 'levelname']));
