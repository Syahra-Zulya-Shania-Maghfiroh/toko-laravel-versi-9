<?php

namespace App\Http\Controllers;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
        public function show()
        {
            return Customers::all();
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
                return Response()->json(['status'=>1]);
            }
            else {
                return Response()->json(['status'=>0]);
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
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
    }
        public function destroy($id_customers){
        $hapus = Customers::where('id_customers', $id_customers)->delete();
        if($hapus){
            return Response()->json(['status' => 1]);
        }
        else{
            return Response()->json(['status' => 0]);
        }
    }
         
}
