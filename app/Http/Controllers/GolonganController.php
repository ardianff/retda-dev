<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Golongan;
use App\Models\Jenis;
use App\Models\User;

class GolonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('golongan.index');
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $gol=Golongan::all();

        return datatables()
            ->of($gol)
            ->addIndexColumn()


            ->addColumn('aksi', function ($gol) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('golongan.update', $gol->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                    <button type="button" onclick="deleteData(`'. route('golongan.destroy', $gol->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
     }

     public function jenis($gol)
     {
         $jenis = Jenis::where('golongan_id', $gol)->get();
         return response()->json($jenis);
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
        $gol= new Golongan();
        $gol->name = $request->name;
        $gol->singkatan = $request->singkatan;
        $gol->id_sipenari = $request->id_sipenari;
        $gol->grms_id = $request->grms_id;
        $gol->kode = $request->kode;
        $gol->status =$request->status;
        $gol->save();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $gol = Golongan::find($id);
        return response()->json($gol);
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
        $gol = Golongan::find($id);
        $gol->name = $request->name;
        $gol->singkatan = $request->singkatan;
        $gol->id_sipenari = $request->id_sipenari;
        $gol->grms_id = $request->grms_id;
        $gol->kode = $request->kode;
        $gol->status =$request->status;
        $gol->update();

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
