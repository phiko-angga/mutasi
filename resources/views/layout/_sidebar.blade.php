
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
            @foreach($menu_grup as $key => $grup)
              <li class="menu-header small text-uppercase"><span class="menu-header-text">{{$grup->grup}}</span></li>
              @php
                  $menu2 = clone $menu;
                  $menuPerGrup = $menu2->where('grup',$grup->grup);
              @endphp

              @if($menuPerGrup)
                  @foreach($menuPerGrup as $m)
                  <li class="menu-item {{ Request::segment(1) == $m->link ? 'active' : '' }}">
                    <a href="{{url($m->link)}}" class="menu-link">
                      <i class="menu-icon tf-icons bx bx-home-circle"></i>
                      <div data-i18n="Analytics">{{$m->nama}}</div>
                    </a>
                  </li>
                  @endforeach
              @endif
            @endforeach
          </ul>
        </aside>
        <!-- / Menu -->