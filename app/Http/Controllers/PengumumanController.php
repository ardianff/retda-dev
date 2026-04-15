<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Carbon\Carbon;

class PengumumanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pengumuman=Pengumuman::orderBy('id','DESC')->get();
        return view('pengumuman.index',compact('pengumuman'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dashboard()
    {
        $pengumuman=Pengumuman::orderBy('id','DESC')->get();
        return view('dashboard',compact('pengumuman'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tanggal_awal = Carbon::createFromFormat('d-F-Y', trim($request->tgl_awal))->format('Y-m-d');

        $tanggal_akhir = Carbon::createFromFormat('d-F-Y', trim($request->tgl_akhir))->format('Y-m-d');
        
        $pengumuman=new Pengumuman();
        $pengumuman->judul=$request->judul;
        $pengumuman->deskripsi=$request->deskripsi;
        $pengumuman->link=$request->link;
        $pengumuman->user_id=auth()->user()->id;
        $pengumuman->tgl_awal=$tanggal_awal;
        $pengumuman->tgl_akhir=$tanggal_akhir;
        $pengumuman->save();

        return back()->with('message', [
            'type' => 'success', // success, error, warning, info
            'text' => 'Data berhasil Disimpan!'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pengumuman = Pengumuman::find($id);
        return response()->json($pengumuman);
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
    public function update(Request $request,$id)
    {
        $tanggal_awal = Carbon::createFromFormat('d-F-Y', trim($request->tgl_awal))->format('Y-m-d');

        $tanggal_akhir = Carbon::createFromFormat('d-F-Y', trim($request->tgl_akhir))->format('Y-m-d');
        
        $pengumuman=Pengumuman::find($id);
        $pengumuman->judul=$request->judul;
        $pengumuman->deskripsi=$request->deskripsi;
        $pengumuman->link=$request->link;
        $pengumuman->user_id=auth()->user()->id;
        $pengumuman->tgl_awal=$tanggal_awal;
        $pengumuman->tgl_akhir=$tanggal_akhir;
        $pengumuman->update();

        return back()->with('message', [
            'type' => 'success', // success, error, warning, info
            'text' => 'Data berhasil Diperbarui!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $pengumuman=Pengumuman::find($id)->delete();
        return response()->json([
            'type' => 'success',
            'message' => 'Data berhasil dihapus
            ']);
    }
}
