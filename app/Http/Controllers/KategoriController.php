<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\DataTables\KategoriDataTable;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable){
        return $dataTable->render('kategori.index');
        }

    public function create(){
        return view('kategori.create');

    }

    public function store(Request $request){
        KategoriModel::create([
            'kategori_kode'=> $request->kodeKategori,
            'kategori_nama'=> $request->namaKategori,
        ]);
        return redirect('/kategori');
    }
    public function edit($id) {
        $data = KategoriModel::find($id);
        return view('kategori.edit', ['data' => $data]);
    }

    public function edit_simpan(Request $request, $id) {
        $data = [
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ];
        KategoriModel::where('kategori_id', $id)->update($data);
        return redirect('/kategori');
    }

    public function delete($id) {
        KategoriModel::destroy($id);
        return redirect('/kategori');
    }

}
