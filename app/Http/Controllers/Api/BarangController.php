<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BarangModel;
use Illuminate\Http\Request;

class BarangController extends Controller {
    public function index() {
        return BarangModel::all();
    }

    public function show(BarangModel $Barang) {
        return $Barang;
    }

    public function store(Request $request) {
        $Barang = BarangModel::create($request->all());
        return response()->json($Barang, 201);
    }

    public function update(Request $request, BarangModel $Barang) {
        $Barang->update($request->all());
        return BarangModel::find($Barang);
    }

    public function destroy(BarangModel $Barang) {
        $Barang->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus'
        ]);
    }
}