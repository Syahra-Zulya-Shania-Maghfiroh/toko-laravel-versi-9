<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
        public function show()
        {
            return Product::all();
        }
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(),
                [
                    'nama_product' => 'required',
                    'deskripsi' => 'required',
                    'harga' => 'required',
                    'foto_product' => 'required',
                    
                ]
            );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $simpan = Product::create([
                'nama_product' => $request->nama_product,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'foto_product' => $request->foto_product
                
            ]);
            if($simpan) {
                return Response()->json(['status'=>1]);
            }
            else {
                return Response()->json(['status'=>0]);
            }
        }
        public function update($id_product, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nama_product' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'foto_product' => 'required'
        ]
        );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $ubah = Product::where('id_product', $id_product)->update([
                'nama_product' => $request->nama_product,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga,
                'foto_product' => $request->foto_product
            ]);
            if($ubah) {
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
    }
        public function destroy($id_product){
            $hapus = Product::where('id_product', $id_product)->delete();
            if($hapus){
                return Response()->json(['status' => 1]);
            }
            else{
                return Response()->json(['status' => 0]);
            }
        }
    
}
