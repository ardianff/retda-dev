<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{asset('admin_assets/img/Logo-Icon-Retda.png')}}" alt="AdminLTE Logo" class="brand-image  img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">E-Tarif Retda</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-1 pb-1 mb-1 d-flex">
        <div class="image">
          <img src="{{asset('admin/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{route('profile')}}" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>



      <!-- Sidebar Menu -->
      <nav class="mt-2">
        @php
    $userMenus = Auth::user()->menus->pluck('id')->toArray(); // Ambil menu_id yang dimiliki user
@endphp
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    @if(in_array(1, $userMenus))
        <li class="nav-item">
        <a href="{{route('dashboard')}}" class="nav-link {{request()->routeIs('dashboard') ? 'active' : ''}}">
            <i class=" fas fa-tachometer-alt"></i>
            <p>
            Beranda
            </p>
        </a>
        </li>
@endif

@if (in_array(2, $userMenus))
    
          <li class="nav-item {{request()->routeIs('menu.index','opd.index','uppd.index','satuan.index','golongan.index','jenis.index','tahun-usulan.index','rekening.index') ? ' menu-open' : ''}}">
            <a href="#" class="nav-link {{request()->routeIs('menu.index','opd.index','uppd.index','golongan.index','jenis.index','tahun-usulan.index','rekening.index') ? ' active' : ''}}">
              <i class=" fas fa-cogs"></i>
              <p>
                Pengaturan
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
@if (in_array(5, $userMenus))

              <li class="nav-item">
                <a href="{{route('menu.index')}}" class="nav-link {{request()->routeIs('menu.index') ? 'active' : ''}}">
                    <i class="fas fa-server  pl-3"></i>
                  <p class="">Menu</p>
                </a>
              </li>
              @endif
@if (in_array(30, $userMenus))

              <li class="nav-item">
                <a href="{{route('akseslevel.index')}}" class="nav-link {{request()->routeIs('akseslevel.index') ? 'active' : ''}}">
                  <i class="fas fa-users-cog  pl-3"></i>
                  <p class="">Admin Menu Akses</p>
                </a>
              </li>
              @endif
@if (in_array(27, $userMenus))
              <li class="nav-item">
                <a href="{{route('tahun-usulan.index')}}" class="nav-link {{request()->routeIs('tahun-usulan.index') ? 'active' : ''}}">
                  <i class="fas fa-database fa-sm pl-3"></i>
                  <p class="">Copy DB Tarif</p>
                </a>
              </li>
      @endif

@if (in_array(4, $userMenus))          
              <li class="nav-item {{request()->routeIs('opd.index','uppd.index') ? ' menu-open' : ''}}">
                <a href="#" class="nav-link {{request()->routeIs('opd.index','uppd.index') ? ' active' : ''}}">
                  <i class=" fas fa-door-closed pl-3"></i>
                  <p >
                    Tabel OPD
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

@if (in_array(8, $userMenus))          

                  <li class="nav-item">
                    <a href="{{route('opd.index')}}" class="nav-link {{request()->routeIs('opd.index') ? 'active' : ''}}">
                      <p style="padding-left: 50px">OPD</p>
                    </a>
                  </li>
      @endif
      @if (in_array(9, $userMenus))          

                  <li class="nav-item">
                    <a href="{{route('uppd.index')}}" class="nav-link {{request()->routeIs('uppd.index') ? 'active' : ''}}">
                      <p style="padding-left: 50px">UPT/Balai/UPPD</p>
                    </a>
                  </li>
          @endif

                </ul>
              </li>
@endif

@if (in_array(7, $userMenus))          

    <li class="nav-item {{request()->routeIs('golongan.index','jenis.index','satuan.index','rekening.index') ? ' menu-open' : ''}}">
      <a href="#" class="nav-link {{request()->routeIs('golongan.index','jenis.index','satuan.index','rekening.index') ? ' active' : ''}}">
          <i class="fas fa-file-invoice-dollar  pl-4"></i>
        <p >
          Tabel Tarif
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
  @if (in_array(10, $userMenus))          
        <li class="nav-item">
          <a href="{{route('satuan.index')}}" class="nav-link {{request()->routeIs('satuan.index') ? 'active' : ''}}">
            <p style="padding-left: 50px">Satuan Tarif</p>
          </a>
        </li>
  @endif
  @if (in_array(11, $userMenus))          

        <li class="nav-item">
          <a href="{{route('golongan.index')}}" class="nav-link {{request()->routeIs('golongan.index') ? 'active' : ''}}">
            <p style="padding-left: 50px">Golongan Retribusi</p>
          </a>
        </li>
@endif
@if (in_array(12, $userMenus))          

        <li class="nav-item">
          <a href="{{route('jenis.index')}}" class="nav-link {{request()->routeIs('jenis.index') ? 'active' : ''}}">
            <p style="padding-left: 50px">Jenis Retribusi</p>
          </a>
        </li>
  @endif
  @if (in_array(13, $userMenus))  
        <li class="nav-item">
          <a href="{{route('rekening.index')}}" class="nav-link {{request()->routeIs('rekening.index') ? 'active' : ''}}">
            <p style="padding-left: 50px">Rekening Tarif</p>
          </a>
        </li>
@endif
      </ul>
    </li>
@endif
@if (in_array(31, $userMenus))          

    <li class="nav-item">
      <a href="{{route('pengumuman.index')}}" class="nav-link ">
          <i class="fas fa-volume-up"></i>
        <p>Pengumuman</p>
      </a>
    </li>
    @endif
  </ul>
</li>
@endif
@if (in_array(3, $userMenus))          

<li class="nav-item {{request()->routeIs('user.index','pejabat.view','pejabat.index') ? ' menu-open' : ''}}">
  <a href="#" class="nav-link {{request()->routeIs('user.index','pejabat.view','pejabat.index') ? ' active' : ''}}">
      <i class="fas fa-tasks"></i>
    <p>
      Manajemen
      <i class="right fas fa-angle-left"></i>
    </p>
  </a>
  <ul class="nav nav-treeview">


@if (in_array(15, $userMenus))          

    <li class="nav-item">
      <a href="{{route('user.index')}}" class="nav-link {{request()->routeIs('user.index') ? 'active' : ''}}">
        <i class="far fa-user fa-sm pl-3"></i>
        <p>Pengguna</p>
      </a>
    </li>
@endif
@if (in_array(16, $userMenus))          

              <li class="nav-item">
                <a href="{{route('pejabat.view')}}" class="nav-link {{ request()->routeIs('pejabat.view') || request()    ->routeIs('pejabat.index') ? 'active' : '' }}">
                    <i class="fas fa-user-tie fa-sm pl-3"></i>
                  <p>Pejabat</p>
                </a>
              </li>
              @endif

            </ul>
          </li>
@endif
@if (in_array(14, $userMenus))          

          <li class="nav-item {{request()->routeIs('tarif.view','tarif.index','TA.index','pengajuan.index') ? ' menu-open' : ''}}">
            <a href="#" class="nav-link {{request()->routeIs('tarif.view','tarif.index','TA.index','pengajuan.index') ? ' active' : ''}}">
              <i class="fas fa-store-alt"></i>
              <p>
               Retribusi Daerah
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
  @if (in_array(32, $userMenus))          
      <li class="nav-item">
        <a href="{{route('pengajuan.index')}}" class="nav-link {{request()->routeIs('pengajuan.index') ? 'active' : ''}}">
            <i class="far fa-calendar-check fa-sm pl-3"></i>
          <p>Set Tanggal Usulan</p>
        </a>
      </li>
      @endif
    
  @if (in_array(6, $userMenus))
      <li class="nav-item">
        <a href="{{route('TA.index')}}" class="nav-link {{request()->routeIs('TA.index') ? 'active' : ''}}">
            <i class="far fa-calendar-check fa-sm  pl-3"></i>
          <p class="">Pergub & Penetapan</p>
        </a>
      </li>
@endif
@if (in_array(26, $userMenus))          
              <li class="nav-item">
                <a href="{{route('tarif.view')}}" class="nav-link {{ request()->routeIs('tarif.view') || request()->routeIs('tarif.index') ? 'active' : '' }}">
                  <i class="fas fa-file-invoice-dollar fa-sm pl-3"></i>
                  <p>Master Tarif</p>
                </a>
              </li>
      @endif
            </ul>
          </li>
@endif

@if (in_array(17, $userMenus))          

              <li class="nav-item">
                <a href="{{route('usulan.view')}}" class="nav-link {{ request()->routeIs('usulan.view') || request()->routeIs('usulan.index') ? 'active' : '' }}">
                    <i class="fas fa-book-open fa-sm "></i>
                  <p>Usulan /Perubahan</p>
                </a>
              </li>
@endif
@if (in_array(29, $userMenus))          

              <li class="nav-item">
                <a href="{{route('info.view')}}" class="nav-link {{ request()->routeIs('info.view') || request()->routeIs('info.index') ? 'active' : '' }}">
                    <i class="fas fa-book-open fa-sm "></i>
                  <p>Info Tarif</p>
                </a>
              </li>
@endif


      
@if (in_array(19, $userMenus))          

          <li class="nav-item {{request()->routeIs('print.draft','print.lampiran','print.usulan','print.perbandingan','print.generate') ? ' menu-open' : ''}}">
            <a href="#" class="nav-link {{request()->routeIs('print.draft','print.lampiran','print.usulan','print.perbandingan','print.generate') ? ' active' : ''}}">
              <i class="fas fa-print"></i>
              <p>
                Print Out
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
    @if (in_array(22, $userMenus))          

          <li class="nav-item">
            <a href="{{route('print.usulan')}}" class="nav-link {{request()->routeIs('print.usulan') ? 'active' : ''}}">
              <i class="fas fa-file-signature"></i>
              <p>Lampiran Usulan Tarif</p>
            </a>
          </li>
    @endif
@if (in_array(20, $userMenus))          

              <li class="nav-item">
                <a href="{{route('print.draft')}}" class="nav-link {{request()->routeIs('print.draft') ? 'active' : ''}}">
                  <i class="fas fa-file-alt"></i>
                  <p>Draft Pergub Tarif</p>
                </a>
              </li>
@endif
@if (in_array(21, $userMenus))          

              <li class="nav-item">
                <a href="{{route('print.lampiran')}}" class="nav-link {{request()->routeIs('print.lampiran') ? 'active' : ''}}">
                  <i class="fas fa-book"></i>
                  <p>Lampiran Pergub Tarif</p>
                </a>
              </li>
@endif



@if (in_array(23, $userMenus)) 
              <li class="nav-item">
                <a href="{{route('print.perbandingan')}}" class="nav-link {{request()->routeIs('print.perbandingan') ? 'active' : ''}}">
                  <i class="fas fa-copy"></i>
                  <p>Perbandingan Tarif</p>
                </a>
              </li>
        @endif

@if (in_array(24, $userMenus)) 
              <li class="nav-item">
                <a href="{{route('generate.index')}}" class="nav-link {{request()->routeIs('print.generate') ? 'active' : ''}}">
                  <i class="fas fa-file-code"></i>
                  <p>generate Tarif</p>
                </a>
              </li>
      @endif

            </ul>
          </li>
          @endif
          @if (in_array(28, $userMenus)) 

          <li class="nav-item">
            <a href="{{route('file.index')}}" class="nav-link {{request()->routeIs('file.index') ? 'active' : ''}}">
                <i class="fas fa-book-open fa-sm pl-3"></i>
              <p>konversi excel</p>
            </a>
          </li>
          @endif
          @if (in_array(28, $userMenus)) 
          <li class="nav-item">
            <a href="{{route('import_tarif.index')}}" class="nav-link {{request()->routeIs('import_tarif.index') ? 'active' : ''}}">
                <i class="fas fa-book-open fa-sm pl-3"></i>
              <p>Import Tarif</p>
            </a>
          </li>
          @endif

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
