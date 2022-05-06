<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
        public function show()
        {
            return Product::all();
        }
        public function details($id_product){
            if(Product::where('id_product', $id_product)){
                $data_product = DB::table('product')
                ->select('product.id_product', 'product.nama_product', 'product.deskripsi', 'product.harga', 'product.foto_product')
                ->where('id_product', $id_product)
                ->get();
                return Response()->json($data_product);
            }
            else{
                return Response()->json(['message : not found']);
            }
        }
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(),
                [
                    'nama_product' => 'required',
                    'deskripsi' => 'required',
                    'harga' => 'required',
                ]
            );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $simpan = Product::create([
                'nama_product' => $request->nama_product,
                'deskripsi' => $request->deskripsi,
                'harga' => $request->harga
                
            ]);
            if($simpan) {
                return Response()->json([
                    'status'=>1,
                    'message' => 'Success add data!'
                ]);
            }
            else {
                return Response()->json([
                    'status'=>0,
                    'message' => 'Failed add data!'
                ]);
            }
        }
        public function uploadProduct(Request $request, $id_product){
            $validator=Validator::make($request->all(),
            [
                'foto_product' => 'required|image|mimes:jpeg,png,jpg |max:2048',
            ]);
            if($validator->fails()) {
                return Response()->json($validator->error());
            }
    
            //define nama file yang akan di upload
            $imageName = time().'.'.$request->foto_product->extension();
    
            // proses upload
            $request->foto_product->move(public_path('photo'), $imageName);
    
            $update=DB::table('product')
            ->where('id_product', '=', $id_product)
            ->update([
                'foto_product' => $imageName
            ]);
    
            $data_product = Product::where('id_product', '=', $id_product)-> get();
            if($update){
                return Response() -> json([
                    'status' => 1,
                    'message' => 'Succes upload photo product!',
                    'data' => $data_product
                ]);
            } 
            else 
            {
                return Response() -> json([
                    'status' => 0,
                    'message' => 'Failed upload photo product!'
                ]);
            }
        }
        public function update($id_product, Request $request)
        {
            $validator=Validator::make($request->all(),
            [
                'nama_product' => 'required',
                'deskripsi' => 'required',
                'harga' => 'required'
            ]
            );
                if($validator->fails()) {
                    return Response()->json($validator->errors());
                }
                $ubah = Product::where('id_product', $id_product)->update([
                    'nama_product' => $request->nama_product,
                    'deskripsi' => $request->deskripsi,
                    'harga' => $request->harga
                ]);
                if($ubah) {
                    return Response()->json([
                        'status' => 1,
                        'message' => 'Success update data!'
                    ]);
                }
                else {
                    return Response()->json([
                        'status' => 0,
                        'message' => 'Failed update data!'
                    ]);
                }
        }
        public function destroy($id_product){
            $hapus = Product::where('id_product', $id_product)->delete();
            if($hapus){
                return Response()->json([
                    'status' => 1,
                    'message' => 'Success delete data!'
                ]);
            }
            else{
                return Response()->json([
                    'status' => 0,
                    'message' => 'Failed delete data!'
                ]);
            }
        }
    
}
