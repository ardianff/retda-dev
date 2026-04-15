<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Satuan;
use App\Models\User;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('satuan.index');
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $satuan=Satuan::all();

        return datatables()
            ->of($satuan)
            ->addIndexColumn()
            ->addColumn('status', function ($satuan){
                $status = ($satuan->status == 'Aktif' ? '<span onclick="status(`'. route('satuan.aktif', $satuan->id) .'`)" class="btn btn-success btn-xs" > Aktif</span>' : '<span onclick="status(`'. route('satuan.aktif', $satuan->id) .'`)" class="btn btn-danger btn-xs" >Non Aktif</span>');
                return $status;
            })


            ->addColumn('aksi', function ($satuan) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('satuan.update', $satuan->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                   
                </div>
                ';
            })
            ->rawColumns(['aksi','status'])
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
        $satuan= new Satuan();
        $satuan->kode = '';
        $satuan->uraian = $request->uraian;
        $satuan->ket = $request->ket;
        $satuan->status = 'Aktif';
        $satuan->save();
        $sat=Satuan::find($satuan->id);
        $sat->kode=$satuan->id;
        $sat->update();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $satuan = Satuan::find($id);
        return response()->json($satuan);
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
        $satuan = Satuan::find($id)->update($request->all());

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    function aktif($id) 
    {
        $satuan=Satuan::find($id);
        if ($satuan->status == 'Aktif') {
        $sat=Satuan::find($id);
            $sat->status='Non Aktif';
            $sat->update();
        }else{
        $sat=Satuan::find($id);

            $sat->status='Aktif';
            $sat->update();

        }

       return response()->json();

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
