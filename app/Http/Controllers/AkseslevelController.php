<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Akseslevel;
use App\Models\Menu;
use App\Models\User;

class AkseslevelController extends Controller
{
    public function index(Request $request) 
    {
        $menus = Menu::whereNull('parent_id')->with('children')->orderBy('urutan')->get();
        $parentMenus = getMenuHierarchy($menus);
        return view('akses.index',compact('menus','parentMenus'));
    }

  public function detail($id) 
  {
       // Ambil semua menu yang dimiliki oleh level user tertentu
       $menuIds = Akseslevel::where('level_id', $id)->pluck('menu_id')->toArray();

       // Ambil menu beserta struktur hierarkinya
       $menus = Menu::whereIn('id', $menuIds)->with('children')->get();
       return response()->json($menus);
  }

  public function show($id) 
  {
   
       // Ambil daftar menu yang sudah dipilih user
       $menuIds = Akseslevel::where('level_id', $id)->pluck('menu_id')->toArray();

       // Ambil menu beserta struktur hierarkinya
       $menus = Menu::whereIn('id', $menuIds)->with('children')->pluck('id')->toArray();
       
           return response()->json([
              
               'level_id' => $id,
               
               'menu_id' => $menus // Kirim menu yang sudah dipilih
           ]);
  }

  public function store(Request $request)
    { 
        if ($request->has('menu_id')) {
            $menuAccessData = [];
            foreach ($request->menu_id as $menuId) {
                $menuAccessData[] = [
                    'level_id' => $request->level_id,
                    'menu_id' => $menuId,
                ];
            }
            Akseslevel::insert($menuAccessData);
        }
        return redirect()->back()->with(['success','user berhasil di simpan']);

    }

    public function update(Request $request, $id)
    {
        $akses=Akseslevel::where('level_id',$request->level_id)->delete();
        if ($request->has('menu_id')) {
            $menuAccessData = [];
            foreach ($request->menu_id as $menuId) {
                $menuAccessData[] = [
                    'level_id' =>$request->level_id,
                    'menu_id' => $menuId,
                ];
            }
            Akseslevel::insert($menuAccessData);
        }
        return redirect()->back()->with(['success','profil berhasil di update']);
    }


}
