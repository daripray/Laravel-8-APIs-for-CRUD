<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Petani;
use Validator;
use Storage;

class PetaniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Petani::all();
        foreach ($data as $key => $value) {
            $data[$key]->url_file = $this->fileUrl($value->foto);
        }
        return response()->json($data);
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
        $rules = [
            'kelompok_tani_id' => 'required',
            'nik' => 'required|numeric|unique:petanis,nik',
            'name' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'foto'  => 'required|file|mimes:jpg,jpeg,png',
            'status' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status'    => 201,
                'success'   => true,
                'message'   => $validator->errors()
            ]);
        } else {
            $validasi = $request->validate($rules);
        }

        try {
            $fileName = time().$request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs('upload/petanis', $fileName);
            $validasi['foto'] = $path;
            $response = Petani::create($validasi);
            return response()->json([
                'status'    => 201,
                'success'   => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 201,
                'success'   => false,
                'errors'    => $e->errorInfo[1],
                'message'   => $e->errorInfo[2],
            ]);
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
        $data = Petani::find($id);
        $data->foto_url = $this->fileUrl($data->foto);
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
            'kelompok_tani_id' => 'required',
            'nik' => 'required|numeric|unique:petanis,nik,'.$id,
            'name' => 'required',
            'alamat' => 'required',
            'telp' => 'required|numeric',
            'foto'  => '',
            'status' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status'    => 201,
                'success'   => true,
                'message'   => $validator->errors()
            ]);
        } else {
            $validasi = $request->validate($rules);
        }

        try {
            if($request->file('foto')){
                $fileName = time().$request->file('foto')->getClientOriginalName();
                $path = $request->file('foto')->storeAs('upload/petanis', $fileName);
                $validasi['foto'] = $path;
            }
            $petani = Petani::find($id);
            $petani->update($validasi);
            return response()->json([
                'status'    => 201,
                'success'   => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => 201,
                'success'   => false,
                'errors'    => $e->errorInfo[1],
                'message'   => $e->errorInfo[2],
            ]);
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
            $response = Petani::find($id);
            return response()->json([
                'success'   => true,
                'message' => empty($response) ? $response : $response->delete()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success'   => false,
                'errors'    => $e->getMessage(),
            ]);
        }
    }

    public function fileUrl($var = null)
    {
        return Storage::url($var);
    }
}
