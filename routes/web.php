<?php
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AkseslevelController;
use App\Http\Controllers\TAController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\OpdController;
use App\Http\Controllers\UppdController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\RekeningController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PejabatController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\UsulanController;
use App\Http\Controllers\CopyTarifController;
use App\Http\Controllers\TahunUsulanController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\ImportTarifController;
use App\Http\Controllers\PdfImportController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\GenerateController;
Route::get('/', function () {
    return view('auth.login');
});


Route::controller(AuthController::class)->group(function () {
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [UserController::class, 'update_profile'])->name('update_profile');

    // Route::get('dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('dashboard', [PengumumanController::class, 'dashboard'])->name('dashboard');

    Route::get('/user/data/{opd_id}/{uppd_id}', [UserController::class, 'data'])->name('user.data');
    Route::get('/user/akses/{id}', [UserController::class, 'akses'])->name('user.akses');
    Route::POST('/user/ubahakses/{id}', [UserController::class, 'ubahakses'])->name('user.ubahakses');
    Route::resource('/user', UserController::class);



    Route::get('/TA/data', [TAController::class, 'data'])->name('TA.data');
    Route::resource('/TA', TAController::class);

    Route::resource('/pengumuman', PengumumanController::class);

    Route::get('/menu/data', [MenuController::class, 'data'])->name('menu.data');
    Route::resource('/menu', MenuController::class);
    Route::get('/akseslevel/data', [AkseslevelController::class, 'data'])->name('akseslevel.data');
    Route::get('/akseslevel/detail/{id}', [AkseslevelController::class, 'detail'])->name('akseslevel.detail');
    Route::resource('/akseslevel', AkseslevelController::class);

    Route::get('/opd/data', [OpdController::class, 'data'])->name('opd.data');
    Route::get('/opd/aktif/{id}', [OpdController::class, 'aktif'])->name('opd.aktif');
    Route::get('/opd/tahunAktif/{id}', [OpdController::class, 'tahunAktif'])->name('opd.tahunAktif');
    Route::get('/opd/masuk', [OpdController::class, 'masuk'])->name('opd.masuk');
    Route::get('/opd/uppd/{opd_id}', [OpdController::class, 'uppd'])->name('opd.uppd');
    Route::get('/opd/getuppd/{opd_id}', [OpdController::class, 'getuppd'])->name('opd.getuppd');
    Route::get('/opd/mutasi', [OpdController::class, 'mutasi'])->name('opd.mutasi');
    Route::resource('/opd', OpdController::class);


    Route::get('/uppd/aktif/{id}', [UppdController::class, 'aktif'])->name('uppd.aktif');
    Route::get('/uppd/data/{id}', [UppdController::class, 'data'])->name('uppd.data');
    Route::resource('/uppd', UppdController::class);
    
    Route::get('/satuan/data', [SatuanController::class, 'data'])->name('satuan.data');
    Route::get('/satuan/aktif/{id}', [SatuanController::class, 'aktif'])->name('satuan.aktif');
    Route::resource('/satuan', SatuanController::class);
    
    Route::get('/rekening/data', [RekeningController::class, 'data'])->name('rekening.data');
    Route::get('/rekening/aktif/{id}', [RekeningController::class, 'aktif'])->name('rekening.aktif');
    Route::resource('/rekening', RekeningController::class);
    
    Route::get('/golongan/data', [GolonganController::class, 'data'])->name('golongan.data');
    Route::get('/golongan/jenis/{gol}', [GolonganController::class, 'jenis'])->name('golongan.jenis');
    Route::resource('/golongan', GolonganController::class);

    Route::get('/jenis/data', [JenisController::class, 'data'])->name('jenis.data');
    Route::resource('/jenis', JenisController::class);
    Route::get('/rekening/data', [RekeningController::class, 'data'])->name('rekening.data');
    Route::resource('/rekening', RekeningController::class);

    Route::get('/pengajuan/data', [PengajuanController::class, 'data'])->name('pengajuan.data');
    Route::post('/pengajuan/updateStatus', [PengajuanController::class, 'updateStatus'])->name('pengajuan.updateStatus');
    Route::resource('/pengajuan', PengajuanController::class);

    Route::get('/pejabat/data', [PejabatController::class, 'data'])->name('pejabat.data');
    Route::get('/pejabat/view', [PejabatController::class, 'view'])->name('pejabat.view');
    Route::resource('/pejabat', PejabatController::class);
    
    // Info tarif
    Route::get('/info/view', [InfoController::class, 'view'])->name('info.view');
    Route::get('/info/data/{opd_id}/{uppd_id}/{gol_id}/{jenis_id}/{thn_id}', [InfoController::class, 'data'])->name('info.data');
    Route::post('/info/update-open-status', [InfoController::class, 'updateOpenStatus'])->name('info.updateOpenStatus');

    Route::get('/info/index', [InfoController::class, 'index'])->name('info.index');
   
    
    // Tarif
    
    Route::get('/tarif/view', [TarifController::class, 'view'])->name('tarif.view');
    Route::get('/tarif/get-headers', [TarifController::class, 'getHeaders'])->name('tarif.getHeaders');
    Route::get('/tarif/data/{opd_id}/{uppd_id}/{gol_id}/{jenis_id}/{thn_id}', [TarifController::class, 'data'])->name('tarif.data');
    // Route::get('tarif/children/{id}', [TarifController::class, 'children'])->name('tarif.children');
    Route::post('/tarif/update-open-status', [TarifController::class, 'updateOpenStatus'])->name('tarif.updateOpenStatus');
    
    Route::post('/tarif/update-status', [TarifController::class, 'updateStatus'])->name('tarif.updateStatus');
    Route::post('/tarif/pindah-tarif/{id}', [TarifController::class, 'pindahTarif'])->name('tarif.pindahTarif');
    Route::post('/tarif/pindah-Headertarif/{id}', [TarifController::class, 'pindahHeaderTarif'])->name('tarif.pindahHeaderTarif');
    Route::post('/tarif/update-tarif', [TarifController::class, 'updateTarif'])->name('tarif.updateTarif');
    Route::get('/tarif/mutasi', [TarifController::class, 'mutasi'])->name('tarif.mutasi');
    
    Route::resource('/tarif', TarifController::class);
    
    Route::resource('/tahun-usulan', TahunUsulanController::class);

    Route::post('/copytarif/headerUsulan/{id}', [CopyTarifController::class, 'headerUsulan'])->name('copytarif.headerUsulan');
    Route::post('/copytarif/childUsulan/{id}', [CopyTarifController::class, 'childUsulan'])->name('copytarif.childUsulan');
    Route::get('/copytarif/get-headers', [CopyTarifController::class, 'getHeaders'])->name('copytarif.getHeaders');

    // Usulan
    Route::get('/usulan/view', [UsulanController::class, 'view'])->name('usulan.view');
    Route::get('/usulan/get-headers', [UsulanController::class, 'getHeaders'])->name('usulan.getHeaders');
    Route::post('/usulan/pindah-tarif/{id}', [UsulanController::class, 'pindahTarif'])->name('usulan.pindahTarif');
    Route::post('/usulan/pindah-Headertarif/{id}', [UsulanController::class, 'pindahHeaderTarif'])->name('usulan.pindahHeaderTarif');
    Route::post('/usulan/update-tarif/{id}', [UsulanController::class, 'updateTarif'])->name('usulan.updateTarif');
    Route::post('/usulan/update-open-status', [UsulanController::class, 'updateOpenStatus'])->name('usulan.updateOpenStatus');
    Route::post('/usulan/update-status', [UsulanController::class, 'updateStatus'])->name('usulan.updateStatus');
    Route::post('/usulan/update-kode', [UsulanController::class, 'update_kode'])->name('usulan.update_kode');
    Route::post('/usulan/forcedelete/{id}', [UsulanController::class, 'forcedelete'])->name('usulan.forcedelete');
    Route::get('/usulan/data/{opd_id}/{uppd_id}/{gol_id}/{jenis_id}/{tu_id}', [UsulanController::class, 'data'])->name('usulan.data');
    Route::resource('/usulan', UsulanController::class);

    Route::get('/print/draft',[PrintController::class,'draft'])->name('print.draft');
    Route::get('/print/draftexport',[PrintController::class,'draftexport'])->name('print.draftexport');
    Route::get('/print/lampiranExport',[PrintController::class,'lampiranExport'])->name('print.lampiranExport');
    Route::get('/print/lampiran',[PrintController::class,'lampiran'])->name('print.lampiran');
    Route::get('/print/usulanExport',[PrintController::class,'usulanExport'])->name('print.usulanExport');
    Route::get('/print/usulan',[PrintController::class,'usulan'])->name('print.usulan');
    Route::get('/print/perbandinganExport',[PrintController::class,'perbandinganExport'])->name('print.perbandinganExport');
    Route::get('/print/perbandingan',[PrintController::class,'perbandingan'])->name('print.perbandingan');
    Route::get('/print/export',[PrintController::class,'export'])->name('print.export');
    Route::get('/generate/index',[GenerateController::class,'index'])->name('generate.index');
    Route::get('/generate/tarif/{id}',[GenerateController::class,'tarif'])->name('generate.tarif');
    Route::get('/generate/print',[GenerateController::class,'print'])->name('generate.print');
    Route::get('/generate/usulan',[GenerateController::class,'usulan'])->name('generate.usulan');
   


    Route::get('/upload', [FileUploadController::class, 'index'])->name('file.index');
Route::post('/upload', [FileUploadController::class, 'upload'])->name('file.upload');
Route::post('/importUsulan', [InfoController::class, 'importUsulan'])->name('importUsulan');

Route::get('/import-tarif', [ImportTarifController::class, 'index'])->name('import_tarif.index');
Route::get('/insertMaster', [ImportTarifController::class, 'insertMaster'])->name('insertMaster');
Route::post('/import-tarif/mutasiTarif', [ImportTarifController::class, 'mutasiTarif'])->name('mutasiTarif');
Route::get('/insertUsulan', [ImportTarifController::class, 'insertUsulan'])->name('insertUsulan');
Route::post('/import-tarif/mutasiUsulan', [ImportTarifController::class, 'mutasiUsulan'])->name('mutasiUsulan');
Route::post('/import-tarif/store', [ImportTarifController::class, 'store'])->name('import_tarif.store');


Route::post('/import-pdf', [PdfImportController::class, 'import'])->name('pdf.import');

});
