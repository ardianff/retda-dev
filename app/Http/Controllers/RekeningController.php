<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rekening;
use App\Models\User;

use DB;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('rekening.index');
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $rekening=Rekening::all();

        return datatables()
            ->of($rekening)
            ->addIndexColumn()
            ->addColumn('status', function ($rekening){
                $status = ($rekening->status == 'Aktif' ? '<span onclick="status(`'. route('rekening.aktif', $rekening->id) .'`)" class="btn btn-success btn-xs" > Aktif</span>' : '<span onclick="status(`'. route('rekening.aktif', $rekening->id) .'`)" class="btn btn-danger btn-xs" >Non Aktif</span>');
                return $status;
            })


            ->addColumn('aksi', function ($rekening) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('rekening.update', $rekening->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                   
                </div>
                ';
            })
            ->rawColumns(['aksi','status'])
            ->make(true);
     }



    public function create()
    {
        $rek=Rekening::all();

        foreach ($rek as $key => $value) {
            if ($value) {
                # code...
            }
            $cari_rek_lama=DB('rekening_grms')::where('grms_id_baru',$value->rek_grms)->first();
            $cari_rek=Rekening::find($value->id);


        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rekening= new Rekening();
        $rekening->no_rek = $request->no_rek;
        $rekening->grms_id_2025 = $request->grms_id_2025;
        $rekening->rek_grms = $request->rek_grms;
        $rekening->ket = $request->ket;
        $rekening->status = $request->status;
        $rekening->save();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $rekening = Rekening::find($id);
        return response()->json($rekening);
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
        $rekening = Rekening::find($id)->update($request->all());

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    function aktif($id) 
    {
        $rekening=Rekening::find($id);
        if ($rekening->status == 'Aktif') {
        $sat=Rekening::find($id);
            $sat->status='Non Aktif';
            $sat->update();
        }else{
        $sat=Rekening::find($id);

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
