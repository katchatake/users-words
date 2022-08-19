<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Frases;
use App\Models\User;
use Validator;

class FrasesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataFrases = Frases::with("comments")->get();
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
            'texto' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }

        $dataUSer = User::where('id', intval($request->id_user))->get();
        // return response()->json(['Validation User Error',($dataUSer)]);
        if (count($dataUSer) == 0) {
            return response()->json(['Validation User Error']);
        }

        $newFrase = [
            "id_user_invite" => intval($request->id_user),
            "texto" => $request->texto,
            "status"=> 0
        ];

        Frases::create($newFrase);

        return response()->json(['Validation Success.', $request->all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_frase' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }

        $dataUSer = User::where('id', intval($request->id_user))->get();

        if ($dataUSer[0]->id_role != 1) {
            return response()->json(['Validation Error User Unauthorised.']);
        }

        $dataFrase = Frases::find(intval($request->id_frase));

        if ($dataFrase->status == 1) {
            return response()->json(['Validation Frase "'.$dataFrase->texto.'" ya se encuentra activado']);
        }

        $dataFrase->status = 1;
        $dataFrase->save();
        return response()->json(['data'=>$dataFrase,'status'=>true]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_frase' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }

        $dataUSer = User::where('id', intval($request->id_user))->get();

        if ($dataUSer[0]->id_role != 1) {
            return response()->json(['Validation Error User Unauthorised.']);
        }

        $dataFrase = Frases::find(intval($request->id_frase));

        $dataFrase->status = 2;
        $dataFrase->save();
        return response()->json(['data'=>$dataFrase,'status'=>true]);

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
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_frase' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['Validation Error.', $validator->errors()]);
        }
        $dataUSer = User::where('id', intval($request->id_user))->get();

        if (count($dataUSer) == 0) {
            return response()->json(['Validation Error User.']);
        }

        $dataFrase = Frases::find(intval($request->id_frase));

        if (count($dataFrase) == 0) {
            return response()->json(['Validation Error Frase']);
        }
        $fraseDelete = Frases::withTrashed()->where('id', intval($request->id_frase))->get();
    }
}
