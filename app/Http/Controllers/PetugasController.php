<?php

namespace App\Http\Controllers;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetugasController extends Controller
{
        public function show()
        {
            return Petugas::all();
        }
        public function store(Request $request)
        {
            $validator=Validator::make($request->all(),
                [
                    'nama_petugas' => 'required',
                    'username' => 'required',
                    'password' => 'required',
                    'level' => 'required'
                ]
            );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $simpan = Petugas::create([
                'nama_petugas' => $request->nama_petugas,
                'username' => $request->username,
                'password' => $request->password,
                'level' => $request->level
            ]);
            if($simpan) {
                return Response()->json(['status'=>1]);
            }
            else {
                return Response()->json(['status'=>0]);
            }
        }
        public function update($id_petugas, Request $request)
        {
        $validator=Validator::make($request->all(),
        [
            'nama_petugas' => 'required',
            'username' => 'required',
            'password' => 'required',
            'level' => 'required'
        ]
        );
            if($validator->fails()) {
                return Response()->json($validator->errors());
            }
            $ubah = Petugas::where('id_petugas', $id_petugas)->update([
                'nama_petugas' => $request->nama_petugas,
                'username' => $request->username,
                'password' => $request->password,
                'level' => $request->level
            ]);
            if($ubah) {
                return Response()->json(['status' => 1]);
            }
            else {
                return Response()->json(['status' => 0]);
            }
    }
        public function destroy($id_petugas){
            $hapus = Petugas::where('id_petugas', $id_petugas)->delete();
            if($hapus){
                return Response()->json(['status' => 1]);
            }
            else{
                return Response()->json(['status' => 0]);
            }
        }
    
}
