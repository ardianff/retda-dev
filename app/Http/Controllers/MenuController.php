<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Bahan;
use App\Models\User;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::whereNull('parent_id')->with('children')->orderBy('urutan')->get();
        $parentMenus = getMenuHierarchy($menus);
        return view('menu.index',compact('menus','parentMenus'));
    }

    /**
     * Show the form for creating a new resource.
     */

     function data()
     {

        $menu=Menu::whereNull('parent_id')->with('children')->orderBy('order_number')->get();

        return datatables()
            ->of($menu)
            ->addIndexColumn()


            ->addColumn('aksi', function ($menu) {
                return '
              <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('menu.update', $menu->id) .'`)" class="btn btn-xs btn-info btn-flat"><i class="fas fa-pen-alt    "></i></button>
                    <button type="button" onclick="deleteData(`'. route('menu.destroy', $menu->id) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
     }



    public function create()
    {
        $bahan= Bahan::all();
        return view('menu.create',compact('bahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $menu= new Menu();
        $menu->parent_id = $request->parent_id;
        $menu->menu = $request->menu;
        $menu->route = $request->route;
        $menu->urutan = $request->urutan;
        $menu->save();

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $menu = Menu::find($id);
        return response()->json($menu);
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
        $menu = Menu::find($id)->update($request->all());

        return back()->with(['status' => 'success', 'message' => 'Operation successful']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $menu=Menu::find($id)->delete();
        return response()->json(['message' => 'Data berhasil dihapus'], 200);
        
    }
}
