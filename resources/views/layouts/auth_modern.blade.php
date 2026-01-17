<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-container {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 600px;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        /* Left Side - Branding */
        .auth-left {
            flex: 1;
            background: linear-gradient(135deg, #1e0a3c 0%, #2d1b4e 50%, #4a2c7c 100%);
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: moveBackground 20s linear infinite;
        }

        @keyframes moveBackground {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        .auth-branding {
            position: relative;
            z-index: 1;
            text-align: center;
            color: white;
        }

        .brand-logo {
            margin-bottom: 30px;
        }

        .logo-img {
            max-width: 180px;
            height: auto;
            filter: brightness(0) invert(1);
        }

        .brand-title {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #ffffff 0%, #e0e0e0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-subtitle {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 50px;
            line-height: 1.6;
        }

        .features-list {
            text-align: left;
            max-width: 400px;
            margin: 0 auto;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
        }

        .feature-item i {
            color: #7c3aed;
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Right Side - Form */
        .auth-right {
            flex: 1;
            padding: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffffff;
        }

        .auth-form-container {
            width: 100%;
            max-width: 420px;
        }

        .auth-header {
            margin-bottom: 40px;
        }

        .auth-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .auth-subtitle {
            font-size: 16px;
            color: #666;
        }

        .auth-form {
            width: 100%;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .forgot-link {
            font-size: 13px;
            color: #7c3aed;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #6d28d9;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            color: #999;
            font-size: 16px;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid #e5e5e5;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 500;
            color: #333;
            transition: all 0.3s;
            background: #fafafa;
        }

        .form-input:focus {
            outline: none;
            border-color: #7c3aed;
            background: white;
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .form-input::placeholder {
            color: #999;
            font-weight: 400;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            background: none;
            border: none;
            color: #999;
            cursor: pointer;
            padding: 8px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #7c3aed;
        }

        .error-message {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: #ef4444;
            font-weight: 500;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-label input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #7c3aed;
        }

        .checkbox-text {
            font-size: 14px;
            color: #666;
            font-weight: 500;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            margin-top: 30px;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #6d28d9 0%, #5b21b6 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(124, 58, 237, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .auth-footer {
            margin-top: 30px;
            text-align: center;
        }

        .footer-text {
            font-size: 14px;
            color: #666;
        }

        .footer-link {
            color: #7c3aed;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #6d28d9;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 968px) {
            .auth-left {
                display: none;
            }

            .auth-container {
                max-width: 500px;
            }

            .auth-right {
                padding: 40px 30px;
            }
        }

        @media (max-width: 480px) {
            .auth-container {
                margin: 10px;
                border-radius: 15px;
            }

            .auth-right {
                padding: 30px 20px;
            }

            .auth-title {
                font-size: 26px;
            }

            .form-input {
                padding: 12px 14px 12px 44px;
            }

            .btn-submit {
                padding: 14px;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    @yield('content')
    
    @yield('javascript')
</body>
</html>
