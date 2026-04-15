<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Menu;
use App\Models\Akses;
use App\Models\Akseslevel;
use App\Models\Uppd;
use App\Models\Opd;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    { if (auth()->user()->level == 5) {
        $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        $opd=Opd::where('id',auth()->user()->opd_id)->get();
        $opd_id=auth()->user()->opd_id;
        $uppd_id=auth()->user()->uppd_id;

     }
     elseif (auth()->user()->level == 4) {
         $uppd=Uppd::where('id',auth()->user()->uppd_id)->get();
        $opd=Opd::where('id',auth()->user()->opd_id)->get();
        $opd_id=auth()->user()->opd_id;
        $uppd_id=auth()->user()->uppd_id;

     }
     elseif (auth()->user()->level == 3) {
         $uppd=Uppd::where('opd_id',auth()->user()->opd_id)->get();
        $opd=Opd::where('id',auth()->user()->opd_id)->get();
        $opd_id=auth()->user()->opd_id;
        $uppd_id=0;
     }
     elseif (auth()->user()->level == 2) {
        if ($request->opd_id) {
            $uppd=Uppd::where('opd_id',$request->opd_id)->get();
        }else{

            $uppd=Uppd::all();
        }
        $opd=Opd::all();
        $opd_id=$request->opd_id??auth()->user()->opd_id;
        $uppd_id=$request->uppd_id??0;
     }
     elseif (auth()->user()->level == 1) {
        if ($request->opd_id) {
            $uppd=Uppd::where('opd_id',$request->opd_id)->get();
        }else{

            $uppd=Uppd::all();
        }
        $opd=Opd::all();
        $opd_id=$request->opd_id??0;
        $uppd_id=$request->uppd_id??0;
     }
     elseif (auth()->user()->level == 6) {
        if ($request->opd_id) {
            $uppd=Uppd::where('opd_id',$request->opd_id)->get();
        }else{

            $uppd=Uppd::all();
        }
        $opd=Opd::all();
        $opd_id=$request->opd_id??auth()->user()->opd_id;
        $uppd_id=$request->uppd_id??0;
     }
        // $menus=Menu::whereNull('parent_id')->with('children.children')->get();
        // return $menus;
        $userLevel = auth()->user()->level;

    // Semua level yang ada
    $levels = [
        1 => 'SuperAdmin',
        2 => 'Admin Bapenda',
        6 => 'Pengolah Data',
        3 => 'Admin OPD',
        4 => 'Admin Balai/UPT',
        5 => 'User'
    ];

    // Tentukan level yang dapat dipilih berdasarkan level pengguna
    switch ($userLevel) {
    case 1:
        $allowedLevels = [1, 2, 6, 3, 4, 5];
        break;
    case 2:
        $allowedLevels = [6, 3, 4, 5];
        break;
    case 6:
        $allowedLevels = [3, 4, 5];
        break;
    case 3:
        $allowedLevels = [4, 5];
        break;
    case 4:
        $allowedLevels = [5];
        break;
    default:
        $allowedLevels = [];
}


    // Ambil hanya level yang diperbolehkan
   $showlevel = array_filter($levels, fn($key) => in_array($key, $allowedLevels), ARRAY_FILTER_USE_KEY);

    // $user = User::with('access')->findOrFail(11);
    // return $showlevel;
        return view('user.index',compact('opd_id','uppd_id','opd','uppd','showlevel'));
    }

    public function data($opd_id,$uppd_id)
    {
       // level 1= SUperadmin
        // level 2= Admin Bapenda
        // level 3= Admin OPD
        // level 4=Admin Balai
        // level 5=user balai/user opd
        // level 6= pengolah data bapenda
        if (auth()->user()->level == 5) {
            $user = User::with('opd','uppd')->find(auth()->user()->id);
 
         }elseif (auth()->user()->level == 4) {
            $user = User::with('opd','uppd')->where('uppd_id',$uppd_id)->orderBy('id', 'desc')->get();
 
         }elseif (auth()->user()->level == 3) {
            $usr = User::with('opd','uppd')->where('opd_id',$opd_id);
            if ($uppd_id!=0) {
                $usr->where('uppd_id',$uppd_id);  
            }
            $user=$usr->orderBy('id', 'desc')->get();
 
         }elseif (auth()->user()->level == 2) {
            
             $usr = User::with('opd','uppd')->where('level','!=',1);
             if ($opd_id != 0) {
                 $usr->where('opd_id',$opd_id);
             }
             if ($uppd_id != 0) {
                 $usr->where('uppd_id',$uppd_id);
             }
             
             $user=$usr->orderBy('id', 'desc')->get();
 
         } elseif (auth()->user()->level == 1) {
             
             $usr=User::with('opd','uppd')->orderby('id','DESC');
             if ($opd_id != 0) {
                 $usr->where('opd_id',$opd_id);
             }
             if ($uppd_id != 0) {
                 $usr->where('uppd_id',$uppd_id);
             }
             $user=$usr->get();
 
         }
 
         elseif (auth()->user()->level == 6) {
         $level = [1, 2]; // Array level yang harus dihindari
     
         $usr = User::with('opd','uppd')->whereNotIn('level', $level); // Menggunakan whereNotIn untuk menghindari level 1 dan 2
         
         if ($opd_id != 0) {
             $usr->where('opd_id', $opd_id);
         }
         if ($uppd_id != 0) {
             $usr->where('uppd_id', $uppd_id);
         }
     
         $user = $usr->orderBy('id', 'desc')->get();
     }

        return datatables()
            ->of($user)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('user.update', $user->id) .'`)" class="btn btn-sm btn-info " title="Ubah User"><i class="fas fa-edit"></i></button>
                    <button type="button" onclick="hakAkses(`'. route('user.akses', $user->id) .'`,`'.route('user.ubahakses', $user->id). '`)" class="btn btn-sm btn-warning " title="Hak Akses User"><i class="fas fa-user-tag"></i></button>
                    <button type="button" onclick="deleteData(`'. route('user.destroy', $user->id) .'`)" class="btn btn-sm btn-danger " title="Hapus User"><i class="fas fa-trash"></i></button>
                </div>
                ';
            })
            ->addColumn('level', function($user) {
                $levels = [
                    1 => 'Superadmin',
                    2 => 'Admin Bapenda',
                    3 => 'Admin OPD',
                    4 => 'Admin Balai/UPT',
                    5 => 'User'
                ];
            
                return $levels[$user->level] ?? 'Pengolah Data';
            })
            ->addColumn('upt', function($user) {
                $opd = optional($user->opd)->opd ?? ' ';
    $uppd = optional($user->uppd)->nama ?? ' ';

    return $opd.'->'.$uppd;
            })
            ->rawColumns(['aksi','level','upt'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //     $uppd=Uppd::where('level',1)->get();
    //     foreach ($uppd as $value) {
    //         $name=str_replace(' ', '', $value->singkatan);
    //         $user = new User();
    //         $user->name = 'admin '.$value->nama;
    //         $user->username = 'admin'.strtolower($name);
    //         $user->kelompok = 'non-bapenda';
    //         $user->akses = 'Full-Akses';
    //         $user->opd_id = $value->opd_id;
    //         $user->uppd_id = $value->id;
    //         $user->level = 3;
    //         $user->password = bcrypt('qwerty');
    //         $user->foto = '/img/user.jpg';
    //         $user->save();

    // $menu_id=Akseslevel::where('level_id',3)->get();
            
    //             $menuAccessData = [];
    //             foreach ($menu_id as $menuId) {
    //                 $menuAccessData[] = [
    //                     'user_id' => $user->id,
    //                     'menu_id' => $menuId->menu_id,
    //                     'aksi' => 1,
    //                 ];
    //             }
    //             Akses::insert($menuAccessData);
            

    //     }
    $menu_id=Akseslevel::where('level_id',3)->get();
       
        $user=User::where('level',3)->get();

        foreach($user as $users){
            $menuAccessData = [];
                        foreach ($menu_id as $menuId) {
                            $menuAccessData[] = [
                                'user_id' => $users->id,
                                'menu_id' => $menuId->menu_id,
                                'aksi' => 1,
                            ];
                        }
                        Akses::insert($menuAccessData);
        }

        return 'ok';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
DB::beginTransaction();

try {
if ($request->level == 3) {
   $uppd_id=Uppd::where('opd_id', $request->opd_id)->where('level',1)->first();
}else{
    $uppd_id=$request->uppd_id;
}
    if (in_array($request->level, [3, 4])) {
        $existingAdmin = User::where('opd_id', $request->opd_id)
                             ->where('uppd_id', $uppd_id)
                             ->where('level', $request->level)
                             ->exists();

        if ($existingAdmin) {
            return back()->withErrors(['level' => 'Setiap OPD/UPPD hanya boleh memiliki 1 admin.']);
        }
    }

    if (in_array($request->level, [1,2,6])) {
        $request->opd_id = 0;
        $request->uppd_id = 0;
    }

    $user = new User();
    $user->name = $request->name;
    $user->username = $request->username;
    $user->kelompok = $request->kelompok ?? 'non-bapenda';
    $user->akses = $request->akses ?? 'Full-Akses';
    $user->opd_id = $request->opd_id ?? 0;
    $user->uppd_id = $request->uppd_id ?? 0;
    $user->level = $request->level;
    $user->password = bcrypt($request->password);
    $user->foto = 'admin/dist/img/user.jpg';
    $user->save();

    $menus = Akseslevel::where('level_id', $request->level)->get();

    $menuAccessData = [];

    foreach ($menus as $menu) {
        $menuAccessData[] = [
            'user_id' => $user->id,
            'menu_id' => $menu->menu_id,
            'aksi' => 1,
        ];
    }

    if (!empty($menuAccessData)) {
        Akses::insert($menuAccessData);
    }

    // return $user;
    DB::commit();

    return redirect()->back()->with('success', 'User berhasil disimpan');

} catch (\Exception $e) {

    DB::rollback();

    return back()->withErrors(['error' => $e->getMessage()]);
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
        

        // Ambil daftar menu yang sudah dipilih user
        $user = User::with('access')->findOrFail($id);

    // Pastikan `access` adalah collection sebelum `pluck()`
    // $userMenuIds = $user->access->pluck('menu_id')->toArray();
    
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'level' => $user->level,
            'akses' => $user->akses,
            'kelompok' => $user->kelompok,
            'opd_id' => $user->opd_id,
            'uppd_id' => $user->uppd_id,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function akses($id)
    {
        $levels = [
        1 => 'Superadmin',
        2 => 'Admin Bapenda',
        3 => 'Admin OPD',
        4 => 'Admin Balai/UPT',
        5 => 'User'
    ];

        $user = User::with('access')->findOrFail($id);

        //mengambil menu id di table akses
        $menuIds = Akseslevel::where('level_id', $user->level)->pluck('menu_id')->toArray();

        // mengambil data menu untuk level user
        $menus = Menu::whereIn('id', $menuIds)->whereNull('parent_id')
        ->with(['children' => function ($query) use ($menuIds) {
            $query->whereIn('id', $menuIds)->with(['children' => function ($subQuery) use ($menuIds) {
                $subQuery->whereIn('id', $menuIds);
            }]);
        }])
        ->get();
// Ambil akses user dari tabel akses
$userAccess = Akses::where('user_id', $id)->get()->keyBy('menu_id');
       
        return response()->json([

            'menus'       => $menus,
            'userAccess' => $userAccess,
            'user_level' => $levels[$user->level],

        ]);

    }

    public function ubahakses(Request $request, $id)
    {
        $menuIds = $request->input('menu_ids', []);
    $aksi = $request->input('aksi', []);

    // Hapus akses lama user
    Akses::where('user_id', $id)->delete();

    // Simpan akses baru
    foreach ($menuIds as $menuId) {
        Akses::create([
            'user_id' => $id,
            'menu_id' => $menuId,
            'aksi' => isset($aksi[$menuId]) ? $aksi[$menuId] : 0, // Default read-only jika tidak dipilih
        ]);
    }

        return redirect()->back()->with(['success','profil berhasil di update']);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
           $user->kelompok = $request->kelompok??'non-bapenda';
        $user->akses = $request->akses??'Full-Akses';
        $user->opd_id = $request->opd_id;
        $user->uppd_id = $request->uppd_id;
        $user->level = $request->level;
        if ($request->has('password') && $request->password != "")
            $user->password = bcrypt($request->password);
        $user->update();
        // $akses=Akses::where('user_id',$id)->delete();
        // if ($request->has('menu_id')) {
        //     $menuAccessData = [];
        //     foreach ($request->menu_id as $menuId) {
        //         $menuAccessData[] = [
        //             'user_id' => $user->id,
        //             'menu_id' => $menuId,
        //         ];
        //     }
        //     Akses::insert($menuAccessData);
        // }
        return redirect()->back()->with(['success','profil berhasil di update']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return response(null, 204);
    }

    
    public function profile()
    {
        $profil = auth()->user();
        return view('user.profil', compact('profil'));
    }

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        if ($request->has('password') && $request->password != "") {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->password == $request->password_confirmation) {
                    $user->password = bcrypt($request->password);
                } else {
                    return response()->json('Konfirmasi password tidak sesuai', 422);
                }
            } else {
                return response()->json('Password lama tidak sesuai', 422);
            }
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $user->foto = "admin/dist/img/$nama";
        }

        $user->update();

        return redirect()->back()->with(['success','profil berhasil di update']);

    }


    
}
