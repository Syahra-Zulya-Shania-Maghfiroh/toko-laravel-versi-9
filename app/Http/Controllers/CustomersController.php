<?php

namespace App\Http\Controllers;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
// header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

class CustomersController extends Controller
{
        public function show()
        {
            return Customers::all();
        }
        public function details($id_customers)
        {
            if(Customers::where('id_customers', $id_customers)){
                $data_customers = DB::table('customers')
                ->select('customers.id_customers', 'customers.nama', 'customers.alamat', 'customers.telp', 'customers.username', 'customers.password')
                ->where('id_customers', $id_customers)
                ->get();
                return Response()->json($data_customers);
            }
            else{
                return Response()->json(['message : not found']);
            }
        }
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(),
                [
                    'nama' => 'required',
                    'alamat' => 'required',
                    'telp' => 'required',
                    'username' => 'required',
                    'password' => 'required'
                ]
            );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $simpan = Customers::create([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
            if($simpan) {
                return Response()->json([
                    'message' => 'success add data!',
                    'status'=>1
                ]);
            }
            else {
                return Response()->json([
                    'message' => 'failed add data!',
                    'status'=>0
                ]);
            }
        }
        public function update($id_customers, Request $request)
    {
        $validator=Validator::make($request->all(),
        [
            'nama' => 'required',
            'alamat' => 'required',
            'telp' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]
        );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $ubah = Customers::where('id_customers', $id_customers)->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'telp' => $request->telp,
                'username' => $request->username,
                'password' => $request->password
            ]);
            if($ubah) {
                return Response()->json([
                    'message' => 'success update data!',
                    'status' => 1
                ]);
            }
            else {
                return Response()->json([
                    'message' => 'failed update data!',
                    'status' => 0
                ]);
            }
    }
        public function destroy($id_customers){
        $hapus = Customers::where('id_customers', $id_customers)->delete();
        if($hapus){
            return Response()->json([
                'message' => 'success delete data!',
                'status' => 1
            ]);
        }
        else{
            return Response()->json([
                'message' => 'failed delete data!',
                'status' => 0
            ]);
        }
    }
         
}
