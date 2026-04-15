<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\User;

class JenisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $golongan=Golongan::all();
        return view('jenis.index',compact('golongan'));
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

       $jenis=Jenis::all();

        return datatables()
            ->of($jenis)
            ->addIndexColumn()


            ->addColumn('golongan', function ($jenis) {
                return$jenis->golongan->singkatan;
            })
            ->addColumn('aksi', function ($jenis) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('jenis.update',$jenis->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                    <button type="button" onclick="deleteData(`'. route('jenis.destroy',$jenis->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi','opd'])
            ->make(true);
     }



    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
       $jenis= new Jenis();
       $jenis->golongan_id = $request->golongan_id;
       $jenis->name = $request->name;
       $jenis->singkatan = $request->singkatan;
       $jenis->grms_id = $request->grms_id;
       $jenis->id_sipenari = $request->id_sipenari;
       $jenis->kode = $request->kode;
       $jenis->status = $request->status;
       $jenis->save();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
       $jenis = Jenis::find($id);
        return response()->json($jenis);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        // return $request;
       $jenis = Jenis::find($id);
       $jenis->golongan_id = $request->golongan_id;
       $jenis->name = $request->name;
       $jenis->singkatan = $request->singkatan;
       $jenis->grms_id = $request->grms_id;
       $jenis->id_sipenari = $request->id_sipenari;
       $jenis->kode = $request->kode;
       $jenis->status = $request->status;
       $jenis->update();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
