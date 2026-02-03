

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>InayaFleet360 – All-in-One Fleet & Transport Automation System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap + FontAwesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: "Open Sans", sans-serif;
            overflow: hidden;
            background: #f4f6f9;
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
        }

        /* LEFT PANEL */
        .login-left {
            width: 38%;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            box-shadow: 5px 0 20px rgba(0,0,0,0.1);
            z-index: 10;
        }

        .login-box {
            width: 100%;
            max-width: 380px;
            text-align: center;
        }

        .login-box .logo-container {
            margin-bottom: 25px;
        }

        .login-box .logo {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
        }

        .login-box .logo i {
            font-size: 32px;
            color: #fff;
        }

        .login-box .brand-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
            line-height: 1.3;
        }

        .login-box .brand-tagline {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 30px;
            font-weight: 400;
        }

        .login-box h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #2b3e51;
        }

        .form-control {
            height: 45px;
            border-radius: 5px;
            font-size: 0.95rem;
            padding-left: 40px;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #999;
        }

        .btn-login {
            background: linear-gradient(135deg, #4f46e5 0%, #0ea5e9 100%);
            color: #fff;
            font-weight: 600;
            width: 100%;
            padding: 12px 0;
            border-radius: 8px;
            border: none;
            transition: .3s;
            font-size: 1rem;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #4338ca 0%, #0284c7 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.4);
        }

        /* RIGHT PANEL - ENHANCED ROAD VIEW */
        .login-right {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: linear-gradient(to bottom, #0a1a2d, #1a3a5f);
        }

        .road-container {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60%;
            perspective: 800px;
            overflow: hidden;
        }

        .road-surface {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 200%;
            height: 100%;
            background: 
                /* Road surface */
                linear-gradient(to right, 
                    #333 0%, 
                    #444 2%, 
                    #333 4%, 
                    #444 6%,
                    #333 8%,
                    #2a2a2a 100%
                ),
                /* Road texture */
                repeating-linear-gradient(
                    90deg,
                    transparent,
                    transparent 49.5%,
                    #555 49.5%,
                    #555 50.5%,
                    transparent 50.5%,
                    transparent 100%
                ),
                /* Lane markings */
                linear-gradient(90deg,
                    transparent 45%,
                    #ffd700 45%,
                    #ffd700 46%,
                    transparent 46%,
                    transparent 54%,
                    #ffd700 54%,
                    #ffd700 55%,
                    transparent 55%
                ),
                /* Road center dashed line */
                repeating-linear-gradient(
                    90deg,
                    transparent,
                    transparent 40px,
                    #ffd700 40px,
                    #ffd700 60px,
                    transparent 60px
                );
            background-size: 100% 100%, 100px 100%, 100% 5px, 100px 10px;
            background-position: 0 0, 0 0, 0 50%, 0 50%;
            background-repeat: repeat-x, repeat-x, repeat-x, repeat-x;
            animation: roadMove 4s linear infinite;
            transform-origin: bottom;
            transform: rotateX(60deg) scaleY(2);
            filter: brightness(0.8) contrast(1.2);
        }

        .road-shoulder {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 20px;
            background: linear-gradient(to right, #555, #666, #555);
            z-index: 2;
        }

        .road-shoulder::before,
        .road-shoulder::after {
            content: '';
            position: absolute;
            top: 0;
            height: 100%;
            width: 20%;
            background: repeating-linear-gradient(
                90deg,
                #666,
                #666 10px,
                #777 10px,
                #777 20px
            );
        }

        .road-shoulder::before {
            left: 0;
        }

        .road-shoulder::after {
            right: 0;
        }

        /* MOVING CAR - PERSPECTIVE ADJUSTED */
        .car-container {
            position: absolute;
            bottom: 30%;
            left: 0;
            width: 280px;
            height: 120px;
            animation: carDrive 8s linear infinite;
            z-index: 15;
            transform-style: preserve-3d;
        }

        .car-body {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            border-radius: 15px 15px 5px 5px;
            box-shadow: 
                0 5px 15px rgba(0,0,0,0.3),
                inset 0 2px 0 rgba(255,255,255,0.1);
            transform: rotateX(10deg) scaleY(0.8);
            overflow: hidden;
        }

        .car-window {
            position: absolute;
            top: 15px;
            left: 20px;
            width: 40%;
            height: 30px;
            background: linear-gradient(135deg, #87CEEB, #E0F6FF);
            border-radius: 5px;
            box-shadow: inset 0 0 10px rgba(0,0,0,0.2);
        }

        .car-window:nth-child(2) {
            left: auto;
            right: 20px;
        }

        .car-headlight {
            position: absolute;
            top: 40px;
            width: 20px;
            height: 10px;
            background: #FFD700;
            border-radius: 10px;
            box-shadow: 0 0 15px 5px #FFD700;
        }

        .car-headlight:nth-child(3) {
            left: 10px;
        }

        .car-headlight:nth-child(4) {
            right: 10px;
        }

        .car-wheel {
            position: absolute;
            bottom: -15px;
            width: 35px;
            height: 35px;
            background: #222;
            border-radius: 50%;
            border: 3px solid #444;
            animation: wheelSpin 1s linear infinite;
        }

        .car-wheel::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 15px;
            height: 15px;
            background: #666;
            border-radius: 50%;
        }

        .car-wheel:nth-child(5) {
            left: 30px;
        }

        .car-wheel:nth-child(6) {
            right: 30px;
        }

        .car-shadow {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%) scaleX(1.5) scaleY(0.3);
            width: 80%;
            height: 20px;
            background: rgba(0,0,0,0.3);
            border-radius: 50%;
            filter: blur(5px);
            z-index: 14;
        }

        /* ROADSIDE ELEMENTS */
        .roadside {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .tree {
            position: absolute;
            bottom: 20px;
            width: 20px;
            height: 60px;
            background: linear-gradient(to right, #8B4513, #A0522D);
            animation: treeMove 15s linear infinite;
        }

        .tree::before {
            content: '';
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 60px;
            background: radial-gradient(circle at 30% 30%, #228B22, #006400);
            border-radius: 50%;
        }

        .tree:nth-child(1) { left: 10%; animation-delay: 0s; }
        .tree:nth-child(2) { left: 30%; animation-delay: 2s; }
        .tree:nth-child(3) { left: 50%; animation-delay: 4s; }
        .tree:nth-child(4) { left: 70%; animation-delay: 6s; }
        .tree:nth-child(5) { left: 90%; animation-delay: 8s; }

        .lamp-post {
            position: absolute;
            bottom: 20px;
            width: 5px;
            height: 100px;
            background: linear-gradient(to right, #666, #888, #666);
            animation: treeMove 20s linear infinite;
        }

        .lamp-post::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 25px;
            height: 25px;
            background: radial-gradient(circle at 30% 30%, #FFD700, #FFA500);
            border-radius: 50%;
            box-shadow: 0 0 20px 5px #FFD700;
        }

        .lamp-post:nth-child(6) { left: 20%; animation-delay: 1s; }
        .lamp-post:nth-child(7) { left: 60%; animation-delay: 5s; }

        /* SKY AND BACKGROUND */
        .sky {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 40%;
            background: linear-gradient(to bottom, #1a3a5f, #2a5298, #3498db);
            overflow: hidden;
        }

        .cloud {
            position: absolute;
            width: 120px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            border-radius: 40px;
            animation: cloudMove 30s linear infinite;
            filter: blur(2px);
        }

        .cloud::before,
        .cloud::after {
            content: '';
            position: absolute;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        .cloud::before {
            width: 50px;
            height: 50px;
            top: -25px;
            left: 15px;
        }

        .cloud::after {
            width: 40px;
            height: 40px;
            top: -20px;
            right: 15px;
        }

        .cloud:nth-child(1) { top: 20%; animation-delay: 0s; }
        .cloud:nth-child(2) { top: 30%; animation-delay: 10s; }
        .cloud:nth-child(3) { top: 15%; animation-delay: 20s; }

        /* ANIMATIONS */
        @keyframes roadMove {
            0% { transform: rotateX(60deg) scaleY(2) translateX(0); }
            100% { transform: rotateX(60deg) scaleY(2) translateX(-50%); }
        }

        @keyframes carDrive {
            0% { 
                transform: translateX(-300px) translateY(0) rotateY(0deg);
                filter: brightness(1);
            }
            10% { 
                transform: translateX(10%) translateY(-2px) rotateY(5deg);
                filter: brightness(1.2);
            }
            50% { 
                transform: translateX(50%) translateY(0) rotateY(0deg);
                filter: brightness(1);
            }
            90% { 
                transform: translateX(90%) translateY(-2px) rotateY(-5deg);
                filter: brightness(1.2);
            }
            100% { 
                transform: translateX(110%) translateY(0) rotateY(0deg);
                filter: brightness(1);
            }
        }

        @keyframes wheelSpin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes treeMove {
            0% { transform: translateX(100vw); }
            100% { transform: translateX(-100px); }
        }

        @keyframes cloudMove {
            0% { transform: translateX(100vw); }
            100% { transform: translateX(-200px); }
        }

        /* HEADLIGHT BEAM */
        .headlight-beam {
            position: absolute;
            top: 50%;
            left: 0;
            width: 500px;
            height: 150px;
            background: linear-gradient(90deg, 
                rgba(255,215,0,0.4) 0%,
                rgba(255,215,0,0.2) 30%,
                rgba(255,215,0,0.1) 60%,
                transparent 100%);
            clip-path: polygon(0% 50%, 100% 0%, 100% 100%);
            animation: carDrive 8s linear infinite;
            filter: blur(10px);
            z-index: 12;
            opacity: 0.6;
        }

        /* COMPANY TITLE + TAGLINE */
        .system-text {
            position: absolute;
            top: 15%;
            left: 50px;
            z-index: 20;
            color: #fff;
            text-shadow: 0 0 10px rgba(0,0,0,0.8);
        }

        .system-text h1 {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .system-text p {
            font-size: 18px;
            opacity: .9;
            color: #FFD700;
        }

        @media(max-width: 850px) {
            .login-left {
                width: 100%;
                box-shadow: none;
            }
            .login-right {
                display: none;
            }
            
            .system-text h1 {
                font-size: 32px;
            }
            
            .system-text p {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

<?php
$settings = DB::table('settings')->where('id', 1)->first();
$logoUrl = null;
if ($settings && $settings->site_logo) {
    $logoUrl = asset('public/admin_resource/assets/images/' . $settings->site_logo);
} elseif ($settings && $settings->admin_logo) {
    $logoUrl = asset('public/admin_resource/assets/images/' . $settings->admin_logo);
}
?>

<div class="login-wrapper">
    <!-- LEFT SIDE LOGIN -->
    <div class="login-left">
        <div class="login-box">
            <div class="logo-container">
                @if($logoUrl)
                    <img src="{{ $logoUrl }}" alt="Logo" class="site-logo" style="width: 250px;; object-fit: contain; margin: 0 auto; border-radius: 8px;">
                @else
                    <div class="logo">
                        <i class="fas fa-truck"></i>
                    </div>
                @endif
                <!-- <h1 class="brand-title">InayaFleet360</h1>
                <p class="brand-tagline">All-in-One Fleet & Transport Automation System</p> -->
            </div>
            <h5>Login to your account</h5>
<hr>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group position-relative">
                    <i class="fas fa-user input-icon"></i>
                    <input type="text"
                           name="email"
                           value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="Enter Employee ID"
                           required autofocus>
                    @error('email') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>

                <div class="form-group position-relative">
                    <i class="fas fa-lock input-icon"></i>
                    <input type="password"
                           name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="Enter Password"
                           required>
                    @error('password') <span class="invalid-feedback"><strong>{{ $message }}</strong></span> @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="fas fa-sign-in-alt mr-2"></i> Login
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT SIDE WITH ENHANCED ROAD VIEW -->
    <div class="login-right">
        <!-- SKY -->
        <div class="sky">
            <div class="cloud"></div>
            <div class="cloud"></div>
            <div class="cloud"></div>
        </div>

        <!-- ROAD CONTAINER -->
        <div class="road-container">
            <!-- ROADSIDE ELEMENTS -->
            <div class="roadside">
                <div class="tree"></div>
                <div class="tree"></div>
                <div class="tree"></div>
                <div class="tree"></div>
                <div class="tree"></div>
                <div class="lamp-post"></div>
                <div class="lamp-post"></div>
            </div>
            
            <!-- ROAD -->
            <div class="road-surface"></div>
            <div class="road-shoulder"></div>
            
            <!-- CAR WITH HEADLIGHT -->
            <div class="headlight-beam"></div>
            <div class="car-container">
                <div class="car-shadow"></div>
                <div class="car-body">
                    <div class="car-window"></div>
                    <div class="car-window"></div>
                    <div class="car-headlight"></div>
                    <div class="car-headlight"></div>
                    <div class="car-wheel"></div>
                    <div class="car-wheel"></div>
                </div>
            </div>
        </div>

        <!-- COMPANY TEXT -->
        <div class="system-text">
            <h1>InayaFleet - 360</h1>
            <p>All-in-One Fleet & Transport Automation System</p>
            
        </div>
    </div>
</div>

</body>
</html>