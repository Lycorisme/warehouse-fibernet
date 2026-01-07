<!-- app-Header -->
<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex align-items-center">
            <a aria-label="Hide Sidebar" class="app-sidebar__toggle" data-bs-toggle="sidebar" href="javascript:void(0)"></a>
            
            <a class="logo-horizontal" href="{{url('/')}}">
                <div class="header-brand-img desktop-logo">
                    <div class="d-flex align-items-center">
                        @if($web->web_logo == '' || $web->web_logo == 'default.png')
                        <img src="{{url('/assets/default/web/default.png')}}" height="32" class="me-2" alt="logo">
                        @else
                        <img src="{{asset('storage/web/' . $web->web_logo)}}" height="32" class="me-2" alt="logo">
                        @endif
                        <h4 class="fw-bold mb-0 text-white text-uppercase" style="font-size: 16px; letter-spacing: 0.5px;">{{$web->web_nama}}</h4>
                    </div>
                </div>
                <div class="header-brand-img light-logo1">
                    <div class="d-flex align-items-center">
                        @if($web->web_logo == '' || $web->web_logo == 'default.png')
                        <img src="{{url('/assets/default/web/default.png')}}" height="32" class="me-2" alt="logo">
                        @else
                        <img src="{{asset('storage/web/' . $web->web_logo)}}" height="32" class="me-2" alt="logo">
                        @endif
                        <h4 class="fw-bold mb-0 text-dark text-uppercase" style="font-size: 16px; letter-spacing: 0.5px;">{{$web->web_nama}}</h4>
                    </div>
                </div>
            </a>

            <div class="d-flex order-lg-2 ms-auto header-right-icons">
                <button class="navbar-toggler navresponsive-toggler d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon fe fe-more-vertical"></span>
                </button>
                <div class="navbar navbar-collapse responsive-navbar p-0">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex order-lg-2 align-items-center">
                            
                            <!-- Fullscreen -->
                            <div class="dropdown d-flex">
                                <a class="nav-link icon full-screen-link nav-link-bg">
                                    <i class="fe fe-minimize fullscreen-button"></i>
                                </a>
                            </div>

                            <!-- Profil Pengguna -->
                            <div class="dropdown d-flex profile-1 ms-3">
                                <a href="javascript:void(0)" data-bs-toggle="dropdown" class="nav-link leading-none d-flex align-items-center">
                                    <div class="text-end me-3 d-none d-lg-block">
                                        <h6 class="text-dark mb-0 fw-bold fs-13">{{ session('user')->user_nmlengkap }}</h6>
                                        <small class="text-muted fs-11 text-uppercase fw-bold" style="letter-spacing: 0.5px;">{{ session('user')->role_title }}</small>
                                    </div>
                                    <div class="header-avatar-wrapper position-relative" style="width: 50px; height: 50px;">
                                        @php
                                            $userFoto = session('user')->user_foto;
                                            $fotoPath = ($userFoto && $userFoto != 'undraw_profile.svg') 
                                                ? asset('storage/users/' . $userFoto) 
                                                : url('/assets/default/users/undraw_profile.svg');
                                        @endphp
                                        <img src="{{ $fotoPath }}" alt="profile" class="rounded-circle shadow-sm border" style="width: 100%; height: 100%; object-fit: cover; display: block; border-width: 2px !important;">
                                        <span class="avatar-status bg-success" style="width: 14px; height: 14px; bottom: 1px; right: 1px; border: 2px solid #fff; position: absolute; border-radius: 50%;"></span>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow shadow-lg border-0">
                                    <div class="drop-heading border-bottom p-3">
                                        <div class="text-center">
                                            <h5 class="text-dark mb-0 fs-14 fw-bold">{{Session::get('user')->user_nmlengkap}}</h5>
                                            <small class="text-muted fs-11 text-uppercase">{{Session::get('user')->role_title}}</small>
                                        </div>
                                    </div>
                                    <a class="dropdown-item d-flex align-items-center" href="{{url('/admin/profile')}}/{{Session::get('user')->user_id}}">
                                        <i class="fe fe-user me-3 fs-16 text-primary"></i> 
                                        <span>Profil Saya</span>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center" href="{{url('/admin/appreance')}}">
                                        <i class="fe fe-grid me-3 fs-16 text-success"></i> 
                                        <span>Tampilan</span>
                                    </a>
                                    <div class="dropdown-divider m-0 opacity-50"></div>
                                    <a class="dropdown-item d-flex align-items-center text-danger" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modalLogout">
                                        <i class="fe fe-power me-3 fs-16"></i> 
                                        <span>Keluar</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /app-Header -->