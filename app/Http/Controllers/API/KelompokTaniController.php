<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KelompokTani;
use Validator;

class KelompokTaniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KelompokTani::all();
        $data = $data->sortBy('name');
        $sorted =  $data->values()->all();
        return response()->json($sorted, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return response()->json('Kelompok Tani - store', 200);
        $validasi = $request->validate([
            'name' => 'required|max:100|unique:kelompok_tanis,name,'
        ]);
        try {
            //code...
            $response = KelompokTani::create($validasi);
            return response()->json([
                'status'    => 201,
                'success'   => true,
                'message'   => 'success',
                'response'  => $response
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 400,
                'success'   => false,
                'errors'    => $e->errorInfo[1],
                'message'   => $e->errorInfo[2],
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = KelompokTani::find($id);
        return response()->json($data, 200);
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
        $rules = [
            'name' => 'required|max:100|unique:kelompok_tanis,name,'.$id
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'success'   => false,
                'message'   => $validator->errors()
            ], 200);
        } else {
            $validasi = $request->validate($rules);
        }

        try {
            $response = KelompokTani::find($id);
            $response->update($validasi);
            return response()->json([
                'status'    => 201,
                'success'   => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 400,
                'success'   => false,
                'errors'    => $e->errorInfo[1],
                'message'   => $e->errorInfo[2],
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $response = KelompokTani::find($id);
            return response()->json([
                'success'   => true,
                'message' => empty($response) ? $response : $response->delete()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'errors'    => $e->getMessage(),
            ], 200);
        }
    }
}
