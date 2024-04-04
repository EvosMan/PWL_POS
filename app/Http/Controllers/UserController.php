<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar User',
            'list' => ['Home', 'user']
        ];

        $page = (object)[
            'title' => 'Daftar user yang terdaftar dalam siste,'
        ];

        $activeMenu = 'user'; //set menu yang sedang aktif

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');
        return DataTables::of($users)
                ->addIndexColumn() // menambahkan kolom index / no urut (default nama
                ->addColumn('aksi', function ($user) { // menambahkan kolom aksi

                $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' .
                    url('/user/' . $user->user_id) . '">'. csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm"onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }
    public function create(){
        $breadcrumb = (object)[
            'title' => 'Tambah User',
            'list' => ['Home' , 'User', 'Tambah']
        ];
        $page = (object)[
            'title' => 'Tambah user baru'
        ];
        $level = LevelModel::all();
        $activeMenu = 'user';

        return view ('user.create', ['breadcrumb'=>$breadcrumb, 'page'=>$page, 'level'=>$level, 'activeMenu'=>$activeMenu]);
    }

    public function store (Request $request)
    {
        $request->validate([
            'username'=> 'required|string|min:3|unique:m_user,username',
            'nama'    => 'required|string|max:100',
            'passwod' => 'required|min:5',
            'level_id'=> 'required|integer'
        ]);

        UserModel::create{[
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]};
        
        return redirect('/user')-> with ('success', 'Data user berhasil disimpan');
    }

    public function show()
    {
        return 'awodkawodk';
    }
}

//public function index(){
    //     $user = UserModel::with('level')->get();
    //     return view('user', ['data' => $user]);

    // }

    // public function tambah()
    //     {
    //         return view ('user_tambah');
    //     }

    // public function create(Request $request)
    // {
    //     UserModel::create([
    //         'username' => $request->username,
    //         'nama' => $request->nama,
    //         'password' => Hash::make('$request->password'),
    //         'level_id' => $request->level_id
    //     ]);

    //     return redirect('/user');
    // }

    // public function edit($id)
    // {
    //     $user = UserModel::find($id);
    //     return view('user_ubah', ['data'=> $user]);
    // }

    // public function update($id, Request $request)
    // {
    //     $user = UserModel::find($id);

    //     $user->username = $request->username;
    //     $user->nama = $request->nama;
    //     $user->password = Hash::make('$request ->password');
    //     $user->level_id = $request->level_id;

    //     $user->save();

    //     return redirect('/user');

    // }

    // public function destroy($id)
    // {
    //     $user = UserModel::find($id);
    //     $user->delete();

    //     return redirect('/user');
    // }

        // $data = [
        //     'username'=> 'customer-1',
        //     'nama'=>'Pelanggan',
        //     'password'=> Hash::make('12345'),
        //     'level_id'=> 4
        // ];
        // UserModel::insert($data);

        //tambahkan data ke tabel m_user
        //coba akses model UserModel
        // $user = UserModel::all(); //ambil semua data dari tabel m_user
        // return view('user', ['data' => $user]);

        //$data=[
        //     'level_id'=>2,
        //     'username'=> 'manager_tiga',
        //     'nama'=> 'Manager 3',
        //     'password'=> Hash::make('12345')
        // ];
        // UserModel::create($data);

        // $user = UserModel::all();
        // return view ('user', ['data' => $user]);


        // $user->username = 'Manager56';
        // $user->isDirty();//true
        // $user->isDirty('username');//true
        // $user->isDirty('nama'); //false
        // $user->isDirty(['nama', 'username']);//false

        // $user->isClean(); //false
        // $user->isClean('username');//false
        // $user->isClean('nama');//true
        // $user->isClean(['nama', 'username']);//false

        // $user->save();

        // $user->isDirty();
        // $user->isClean();
        // return dd($user->isDirty());

        // $user = UserModel::create(
        //     [
        //         'username' => 'manager11',
        //         'nama' => 'Manager11',
        //         'password'=> Hash::make('12345'),
        //         'level_id'=>2

        //     ]);
        // $user->username = 'manager12';
        // $user->nama = 'Manager12';

        // $user->save();

        // $user->wasChanged();
        // $user->wasChanged('username');
        // $user->wasChanged(['username', 'level_id']);
        // $user->wasChanged('nama');
        // dd($user->wasChanged(['nama', 'username']));
