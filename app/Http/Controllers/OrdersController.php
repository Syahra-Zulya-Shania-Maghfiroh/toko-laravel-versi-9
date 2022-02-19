<?php

namespace App\Http\Controllers;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
        public function show()
        {
            $data_orders = Orders::join('petugas', 'petugas.id_petugas', 'orders.id_petugas')->get();
            return Response()->json($data_orders);
    
            
        }
        public function detail($id_petugas)
        {
            if(Orders::where('id_petugas', $id_petugas)->exists()) {
            $data_orders = Orders::join('petugas', 'petugas.id_petugas', 'orders.id_petugas')
            ->where('orders.id_petugas', '=', $id_petugas)
            ->get();
     
                return Response()->json($data_orders);
        }
            else {
                return Response()->json(['message' => 'Tidak ditemukan' ]);
            }
        }
        public function show2()
        {
            $data_orders = Orders::join('customers', 'customers.id_customers', 'orders.id_customers')->get();
            return Response()->json($data_orders);
        }
        public function detail2($id_customers)
        {
            if(Orders::where('id_customers', $id_customers)->exists()) {
            $data_orders = Orders::join('customers', 'customers.id_customers', 'orders.id_customers')
            ->where('orders.id_customers', '=', $id_customers)
            ->get();
     
                return Response()->json($data_orders);
        }
            else {
                return Response()->json(['message' => 'Tidak ditemukan' ]);
            }
        }
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(),
                [
                    'id_customers' => 'required',
                    'id_petugas' => 'required'
                ]
            );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
    
            $simpan = Orders::create([
                'id_customers' => $request->id_customers,
                'id_petugas' => $request->id_petugas,
                'tgl_transaksi' => date("Y-m-d")
            ]);
            if($simpan)
            {
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
        }
        public function update($id_orders, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'id_customers' => 'required',
            'id_petugas' => 'required'
        ]
        );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $ubah = Orders::where('id_orders', $id_orders)->update([
                'id_customers' => $request->id_customers,
                'id_petugas' => $request->id_petugas,
                'tgl_transaksi' => date("Y-m-d")
            ]);
            if($ubah) {
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
    }
        public function destroy($id_orders){
            $hapus = Orders::where('id_orders', $id_orders)->delete();
            if($hapus){
                return Response()->json(['status' => 1]);
            }
            else{
                return Response()->json(['status' => 0]);
            }
        }
    
}
