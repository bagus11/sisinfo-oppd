<div class="mini-nav">
    <div class="brand-logo d-flex align-items-center justify-content-center">
        <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
            <iconify-icon icon="solar:hamburger-menu-line-duotone" class="fs-7"></iconify-icon>
        </a>
    </div>
    <ul class="mini-nav-ul" data-simplebar>
        @php
            $modules = DB::table('modules')->where('status', 1)->get();
        @endphp
        @foreach ($modules as $module)
            <li class="mini-nav-item" id="mini-{{$module->id}}">
                <a href="javascript:void(0)" data-bs-toggle="tooltip"
                    data-bs-custom-class="custom-tooltip" data-bs-placement="right"
                    data-bs-title="{{ $module->name }}">
                    <iconify-icon icon="{{ $module->icon }}" class="fs-7"></iconify-icon>
                </a>
            </li>
        @endforeach
    </ul>
</div>

<div class="sidebarmenu">
    <div class="brand-logo d-flex align-items-center nav-logo">
        <a href="{{ route('home') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo.png') }}" style="width:50px" alt="Logo" /> <b>SISINFO OPPD</b>
        </a>
    </div>

    @php
        $modules = DB::table('modules')->where('status', 1)->get();
    @endphp
    @foreach ($modules as $module)
        <nav class="sidebar-nav d-block" id="menu-right-mini-{{ $module->id }}" data-simplebar>
            <ul class="sidebar-menu" id="sidebarnav" >
                @php
                    $submodules = DB::table('submodules')->where([
                        'status'    => 1,
                        'module_id' => $module->id
                    ])->get();
                @endphp

                @foreach ($submodules as $submodule)
                    <li class="nav-small-cap">
                        <strong class="hide-menu">{{ $submodule->name }}</strong>
                        <hr>
                    </li>
                    @php
                      $menuItems = DB::table('menus')
                                        ->select('menus.id', 'menus.name', 'menus.type', 'menus.permission', 'menus.status', 'menus.submodule_code','menus.link','menus.icon') // List all required columns
                                        ->join('permissions', 'permissions.name', '=', 'menus.permission')
                                        ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                                        ->join('roles', 'roles.id', '=', 'role_has_permissions.role_id')
                                        ->join('model_has_roles', 'model_has_roles.role_id', '=', 'roles.id')
                                        ->where([
                                            'menus.status' => 1,
                                            'menus.submodule_code' => $submodule->submodule_code,
                                        ])
                                        ->where('model_has_roles.model_id', auth()->user()->id)
                                        ->groupBy('menus.id', 'menus.name', 'menus.type', 'menus.permission', 'menus.status', 'menus.submodule_code','menus.link','menus.icon') // Group by all selected columns
                                        ->get();
                    @endphp
                    @foreach ($menuItems as $menu)
                        @if ($menu->type == 1 )
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{$menu->link}}" aria-expanded="false">
                                <iconify-icon icon="{{ $menu->icon }}"></iconify-icon>
                                <span class="hide-menu">{{ $menu->name }}</span>
                            </a>
                        </li>
                        @else
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <iconify-icon icon="{{$menu->icon}}"></iconify-icon>
                                <span class="hide-menu">{{$menu->name}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @php
                                    $submenu = DB::table('submenus')->select('submenus.link','submenus.name','submenus.id','submenus.logo')
                                                ->join('permissions','permissions.name','=','submenus.permission')
                                                ->join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                                                ->join('roles', 'roles.id','role_has_permissions.role_id')
                                                ->join('model_has_roles', 'model_has_roles.role_id', 'roles.id')
                                                ->where([
                                                    'submenus.status'    => 1,
                                                    'submenus.menus_id'  =>$menu->id
                                                ])
                                                ->groupBy('submenus.link','submenus.name','submenus.id','submenus.logo')
                                                ->get();
                                @endphp
                                {{-- {{$submenu}} --}}
                                @foreach ($submenu as $sub)
                                <li class="sidebar-item">
                                    <a class="sidebar-link" href="{{$sub->link}}">
                                        {{-- <iconify-icon icon="{{$sub->logo}}"></iconify-icon> --}}
                                        <span class="icon-small"></span>
                                         {{$sub->name}}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </nav>
    @endforeach
</div>
<script src="{{ asset('assets/js/theme/sidebarmenu.js') }}"></script>