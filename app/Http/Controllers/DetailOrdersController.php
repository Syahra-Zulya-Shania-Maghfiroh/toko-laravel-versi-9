<?php

namespace App\Http\Controllers;
use App\Models\Detail_Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DetailOrdersController extends Controller
{
        public function show()
        {
            $data_detail_orders = Detail_Orders::join('orders', 'orders.id_orders', 'detail_orders.id_product')->get();
            return Response()->json($data_detail_orders);        
        }
        public function detail($id_product)
        {
            if(Detail_Orders::where('id_product', $id_product)->exists()) {
            $data_detail_orders = Detail_Orders::join('orders', 'orders.id_orders', 'detail_orders.id_orders')
            ->where('detail_orders.id_orders', '=', $id_orders)
            ->get();
     
                return Response()->json($data_detail_orders);
        }
            else {
                return Response()->json(['message' => 'Tidak ditemukan' ]);
            }
        }
        
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(),
                [
                    'id_orders' => 'required',
                    'id_product' => 'required',
                    'qty' => 'required'
                ]
            );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            
            $id_product = $request->id_product;
            $qty = $request->qty;
            $harga = DB::table('product')->where('id_product', $id_product)->value('harga');
            $subtotal = $harga * $qty;
    
            $simpan = Detail_Orders::create([
                'id_orders' => $request->id_orders,
                'id_product' => $request->id_product,
                'qty' => $qty,
                'subtotal'=>$subtotal
            ]);
            if($simpan)
            {
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
        }
        public function update($id_detail_orders, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id_orders' => 'required',
            'id_product' => 'required',
            'qty' => 'required'
        ]
        );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $id_product = $request->id_product;
            $qty = $request->qty;
            $harga = DB::table('product')->where('id_product', $id_product)->value('harga');
            $subtotal = $harga * $qty;
            
            $ubah = Detail_Orders::where('id_detail_orders', $id_detail_orders)->update([
                'id_orders' => $request->id_orders,
                'id_product' => $request->id_product,
                'qty' => $qty,
                'subtotal'=>$subtotal
            ]);
            if($ubah) {
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
    }
        public function destroy($id_detail_orders){
            $hapus = Detail_Orders::where('id_detail_orders', $id_detail_orders)->delete();
            if($hapus){
                return Response()->json(['status' => 1]);
            }
            else{
                return Response()->json(['status' => 0]);
            }
        }
    
}
