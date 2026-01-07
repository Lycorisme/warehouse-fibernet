@extends('Master.Layouts.app_login', ['title' => $title])

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-color: #6366f1;
        --primary-hover: #4f46e5;
        --glass-bg: rgba(255, 255, 255, 0.85);
        --glass-border: rgba(255, 255, 255, 0.3);
    }

    body {
        font-family: 'Outfit', sans-serif;
    }

    .login-img {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Animated background elements */
    .bg-shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        animation: float 20s infinite alternate;
    }

    .shape-1 {
        width: 400px;
        height: 400px;
        background: rgba(99, 102, 241, 0.3);
        top: -100px;
        left: -100px;
    }

    .shape-2 {
        width: 300px;
        height: 300px;
        background: rgba(168, 85, 247, 0.3);
        bottom: -50px;
        right: -50px;
        animation-delay: -5s;
    }

    @keyframes float {
        0% { transform: translate(0, 0) scale(1); }
        100% { transform: translate(50px, 50px) scale(1.1); }
    }

    .login-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--glass-border);
        border-radius: 24px;
        width: 100%;
        max-width: 450px;
        padding: 3rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
        z-index: 10;
        position: relative;
    }

    .logo-wrapper {
        background: white;
        padding: 1.25rem;
        border-radius: 28px;
        box-shadow: 0 15px 40px -10px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 110px;
        height: 110px;
        margin: 0 auto 2rem auto;
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .logo-wrapper:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px -12px rgba(0, 0, 0, 0.15);
    }

    .logo-img {
        max-height: 100%;
        max-width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.05));
    }

    .login-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .login-header h2 {
        color: #1f2937;
        font-weight: 800;
        font-size: 2.25rem;
        margin-bottom: 0.75rem;
        letter-spacing: -0.025em;
    }

    .login-header p {
        color: #6b7280;
        font-size: 1.1rem;
        line-height: 1.6;
        margin: 0;
    }

    .login-header p strong {
        color: var(--primary-color);
        font-weight: 700;
    }

    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 1.25rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.25rem;
        transition: all 0.3s;
    }

    .form-control-modern {
        width: 100%;
        padding: 1.1rem 1.1rem 1.1rem 3.5rem;
        background: #f8fafc;
        border: 2px solid transparent;
        border-radius: 16px;
        color: #1f2937;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control-modern:focus {
        background: #fff;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .form-control-modern:focus + .input-icon {
        color: var(--primary-color);
        transform: translateY(-50%) scale(1.1);
    }

    .login-btn {
        width: 100%;
        height: 56px;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        border: none;
        border-radius: 16px;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(99, 102, 241, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-top: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .login-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .login-btn:hover::before {
        left: 100%;
    }

    .login-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(99, 102, 241, 0.45);
        background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
    }

    .login-btn:active {
        transform: translateY(0);
    }

    .login-btn:disabled {
        background: #94a3b8;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .footer {
        position: absolute !important;
        bottom: 0;
        width: 100%;
        background: transparent !important;
        border-top: none !important;
        padding: 2.5rem 0 !important;
        z-index: 10;
    }

    .footer, .footer a {
        color: rgba(255, 255, 255, 0.7) !important;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .spinner {
        width: 22px;
        height: 22px;
        border: 2.5px solid rgba(255,255,255,0.25);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin 0.6s cubic-bezier(0.5, 0.1, 0.4, 0.9) infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Override master layout background if necessary */
    .wrap-login100 { display: none; }
</style>

<div class="bg-shape shape-1"></div>
<div class="bg-shape shape-2"></div>

<div class="login-card">

    <div class="login-header">
        <h2>Selamat Datang</h2>
        <p>Silahkan login untuk mengakses sistem<br><strong>{{$web->web_nama}}</strong></p>
    </div>

    <form method="POST" name="myForm" action="{{ url('admin/proseslogin') }}" onsubmit="return validateForm()">
        @csrf
        <div class="form-group">
            <input name="user" value="{{Session::get('userInput')}}" class="form-control-modern" type="text" placeholder="Username" autocomplete="off">
            <i class="fe fe-user input-icon"></i>
        </div>

        <div class="form-group">
            <input name="pwd" class="form-control-modern" type="password" placeholder="Password" autocomplete="off">
            <i class="fe fe-lock input-icon"></i>
        </div>

        <button type="submit" class="login-btn" id="btnLogin">
            Login ke Akun <i class="fe fe-arrow-right"></i>
        </button>

        <button type="button" class="login-btn d-none" id="btnLoader" disabled>
            <div class="spinner"></div>
            Memproses...
        </button>
    </form>
</div>

@include('Master.Layouts.footer')

@endsection

@section('scripts')
<script>
    function validateForm() {
        var usr = document.forms["myForm"]["user"].value;
        var pwd = document.forms["myForm"]["pwd"].value;

        if (usr == "") {
            validasi('Username masih kosong!', 'warning');
            return false;
        } else if (pwd == '') {
            validasi('Password masih kosong!', 'warning');
            return false;
        }

        setLoading(true);
        return true;
    }

    function setLoading(bool){
        if(bool == true){
            $('#btnLoader').removeClass('d-none');
            $('#btnLogin').addClass('d-none');
        }else{
            $('#btnLogin').removeClass('d-none');
            $('#btnLoader').addClass('d-none');
        }
    }

    function validasi(judul, status) {
        swal({
            title: judul,
            type: status,
            confirmButtonText: "OK",
            confirmButtonColor: "#6366f1"
        });
    }
</script>
@endsection
