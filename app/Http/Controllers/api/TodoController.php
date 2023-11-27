<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $todos = Todo::all();
        if ($todos -> count()>0) {
            return response()->json([
                'status'=> true,
                'data'=> $todos
            ],200);
        }else{
            return response()->json([
                'status'=> false,
                'message'=> 'Data todo masih kosong'
            ]);
        }
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi
        $validator = Validator::make($request->all(),[
            'title'=> ['required','max:180'],
            // 'is_completed' => ['required']
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'message'=>$validator->errors()
            ], 400);
        }
        //simpan
        $todo = new Todo();
        $todo->title=$request->title;
        $todo->description=$request->description;
        $todo->is_completed = $request->is_completed;
        $simpan = $todo->save();
        if($simpan){
            return response()->json([
                'status'=> true,
                'message'=> 'Berhasil tambah data Todo'      
            ], 201);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $todo = Todo::find($id);
        if($todo == null){
            return response()->json([
                'status'=>false,
                'message'=> 'ID tidak ditemukan'
            ],404);
        }else{
            return response()->json([
                'status'=> true,
                'data'=>$todo
            ],200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);
        if($todo == null){
            return response()->json([
                'status' => false,
                'message' => 'Id tidak ditemukan'
            ],404);
        }else{
            $validator = Validator::make($request->all(),[
                'title'=> ['required','max:180'],
                'is_completed' => ['required']
            ],[
                'title.required'=> 'Judul kegiatan harus diisi',
                'title.max'=> 'Maksimum judul 180 karakter',
                'is_completed.required'=> 'Staus kegiatan harus diisi'
            ]);

            if($validator -> fails()){
                return response()->json([
                    'status'=> false,
                    'message'=> $validator->errors()
                ],400);
            }
            $todo -> title = $request-> title;
            $todo -> is_completed = $request -> is_completed;
            if($todo -> save()){
                return response()->json([
                    'status'=> true,
                    'message'=> 'Judul berhasil diupdate'
                ],200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if ($todo == null) {
            return response()->json([
                'status'=>false,
                'message'=> 'Id tidak ditemukan'
            ],400);
        }

        $delete= $todo-> delete();
        if ($delete) {
            return response()->json([
                'status'=> true,
                'message'=> 'Todo berhasil dihapus'
            ],200);
        }
    }
}
