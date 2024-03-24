<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\LevelModel;
use Illuminate\Support\Facades\DB;
class LevelController extends Controller
{

public function index(){
    return view('template/pages/form/advanced/html');
}
    public function store(Request $request){
        LevelModel::create([
            'level_kode'=> $request->kodeLevel,
            'level_nama'=> $request->namaLevel,
        ]);

    }
}




// DB::insert('insert into m_level(level_kode, level_nama, created_at)
        //             values(?,?,?)',['CUS','Pelanggan', now()]);
        // return 'Insert data baru berhasil yeeyyyyeyyeyyeyyeyeyeyeye';

        // $row=DB::update('update m_level set level_nama= ? where level_kode = ?',['Customer','CUS']);
        // return'Update data berhasil, Jumlah data yang diupdate: ' .$row.'baris';

        // $row = DB::delete('delete from m_level where level_kode = ?',['CUS']);
        // return 'Delete data berhasil. Jumlah data yang dihapus; ' .$row. 'baris';

        // $data = DB::select ('select * from m_level');
        // return view('level', ['data' =>$data] );
