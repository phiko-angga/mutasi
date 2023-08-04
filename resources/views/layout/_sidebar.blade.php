
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="index.html" class="app-brand-link">
              <span class="app-brand-logo demo"><img style="margin-top: 5px;width: 60px;height: auto;" src="{{url('img/logo.png')}}" alt=""></span>
              <div class="d-flex justify-content-center ">
                <p style="text-align:center;font-size:12px;margin-bottom:0">MAHKAMAH AGUNG<br>REPUBLIK INDONESIA<br>DITJEN BADAN PERADILAN UMUM</p>
              </div>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{ Request::segment(1) == '' ? 'active' : '' }}">
              <a href="{{url('')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'biaya' ? 'active' : '' }}">
              <a href="{{url('analisa-data')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Biaya</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'mutasi' ? 'active' : '' }}">
              <a href="{{url('mutasi')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Mutasi</div>
              </a>
            </li>
            
            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Transportasi</span></li>
            <!-- Cards -->
            <li class="menu-item {{ Request::segment(1) == 'transport' ? 'active' : '' }}">
              <a href="{{url('transport')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Transport</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'provinsi' ? 'active' : '' }}">
              <a href="{{url('provinsi')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-collection"></i>
                <div data-i18n="Basic">Provinsi</div>
              </a>
            </li>
            
            <!-- Tables -->
            <li class="menu-item  {{ Request::segment(1) == 'kota' ? 'active' : '' }}" >
              <a href="{{url('kota')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Kota</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'sbum' ? 'active' : '' }}">
              <a href="{{url('sbum')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">SBU/M</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'dephub' ? 'active' : '' }}">
              <a href="{{url('dephub')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Dep Hub</div>
              </a>
            </li>
            
            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">RUTE</span></li>
            <li class="menu-item {{ Request::segment(1) == 'rute' ? 'active' : '' }}">
              <a href="{{url('rute')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Rute</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'darat' ? 'active' : '' }}">
              <a href="{{url('darat')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Darat</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'laut' ? 'active' : '' }}">
              <a href="{{url('laut')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Laut</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'uang' ? 'active' : '' }}">
              <a href="{{url('uangh')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Uang Harian</div>
              </a>
            </li>
            
            <li class="menu-header small text-uppercase"><span class="menu-header-text"></span></li>
            <li class="menu-item {{ Request::segment(1) == 'paraf' ? 'active' : '' }}">
              <a href="{{url('paraf')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-table"></i>
                <div data-i18n="Tables">Paraf</div>
              </a>
            </li>
            <li class="menu-item {{ Request::segment(1) == 'bantuan' ? 'active' : '' }}">
              <a href="{{url('bantuan')}}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-support"></i>
                <div data-i18n="Tables">Bantuan</div>
              </a>
            </li>

          </ul>
        </aside>
        <!-- / Menu -->