<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Frases;
use App\Models\Publicaciones;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class PublicacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataFrases = Publicaciones::with("frases")->get();
        return response()->json(['data' => $dataFrases,'status'=>true], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_frase' => 'required',
            'comment' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }

        $dataUSer = User::where('id', intval($request->id_user))->get();

        if (count($dataUSer) == 0) {
            return response()->json(['Validation Error User.']);
        }

        $dataFrase = Frases::where('id', intval($request->id_frase))->get();

        if (count($dataFrase) == 0) {
            return response()->json(['Validation Error Frase']);
        }

        $newComment = [
            "id_user_admin" => intval($request->id_user),
            "id_frase" => intval($request->id_frase),
            "comentario" => $request->comment
        ];

        Publicaciones::create($newComment);

        return response()->json(['Validation Success Frase']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
