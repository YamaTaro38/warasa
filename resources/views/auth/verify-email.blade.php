<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - Warasa</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .verification-container {
            max-width: 500px;
            width: 100%;
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .verification-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }
        
        .verification-header {
            background: linear-gradient(135deg, #ee4d2d 0%, #ff6b4a 100%);
            padding: 40px 30px;
            text-align: center;
            position: relative;
        }
        
        .verification-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            opacity: 0.1;
        }
        
        .logo {
            font-size: 48px;
            font-weight: 800;
            color: white;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            letter-spacing: -0.5px;
        }
        
        .logo span {
            font-weight: 300;
        }
        
        .verification-header h2 {
            color: white;
            font-size: 28px;
            font-weight: 600;
            margin-top: 20px;
            position: relative;
            z-index: 1;
        }
        
        .verification-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }
        
        .verification-body {
            padding: 40px 30px;
        }
        
        .icon-wrapper {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .icon-circle {
            width: 80px;
            height: 80px;
            background: #fef2e8;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .icon-circle i {
            font-size: 40px;
            color: #ee4d2d;
        }
        
        .info-text {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .info-text h3 {
            color: #1e293b;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        
        .info-text p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        
        .email-display {
            display: inline-block;
            background: #f1f5f9;
            padding: 8px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            color: #ee4d2d;
            margin-top: 10px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        
        .alert-success i {
            color: #10b981;
            font-size: 20px;
        }
        
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        
        .alert-error i {
            color: #ef4444;
            font-size: 20px;
        }
        
        .alert-warning {
            background: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
        }
        
        .alert-warning i {
            color: #f59e0b;
            font-size: 20px;
        }
        
        .btn-resend {
            width: 100%;
            background: #ee4d2d;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 15px;
        }
        
        .btn-resend:hover {
            background: #d63e1f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(238, 77, 45, 0.3);
        }
        
        .btn-resend:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .btn-back {
            width: 100%;
            background: white;
            color: #475569;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }
        
        .btn-back:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        
        .footer-text {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #94a3b8;
        }
        
        .footer-text a {
            color: #ee4d2d;
            text-decoration: none;
        }
        
        .footer-text a:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 640px) {
            .verification-header {
                padding: 30px 20px;
            }
            .verification-header h2 {
                font-size: 24px;
            }
            .verification-body {
                padding: 30px 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="verification-container">
        <div class="verification-card">
            <div class="verification-header">
                <div class="logo">
                    WARASA
                </div>
                <h2>Verify Your Email</h2>
                <p>Complete your registration to access all features</p>
            </div>
            
            <div class="verification-body">
                <div class="icon-wrapper">
                    <div class="icon-circle">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                
                <div class="info-text">
                    <h3>Check your inbox</h3>
                    <p>We've sent a verification link to:</p>
                    <div class="email-display">
                        <i class="fas fa-at"></i> {{ auth()->user()->email }}
                    </div>
                    <p style="margin-top: 20px; font-size: 13px;">
                        Please check your email and click the verification link to activate your account.
                    </p>
                </div>
                
                @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif
                
                @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif
                
                @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-clock"></i>
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                
                <div id="alertContainer"></div>
                
                <button type="button" id="resendBtn" class="btn-resend">
                    <i class="fas fa-paper-plane"></i>
                    Resend Verification Email
                </button>
                
                <a href="{{ route('profile.edit') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Profile
                </a>
                
                <div class="footer-text">
                    <p>Didn't receive the email? Check your spam folder or <a href="#" id="resendLink">click here to resend</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        const resendBtn = document.getElementById('resendBtn');
        const resendLink = document.getElementById('resendLink');
        const alertContainer = document.getElementById('alertContainer');
        
        function showAlert(message, type = 'success') {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.style.animation = 'slideIn 0.3s ease';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : (type === 'error' ? 'exclamation-circle' : 'clock')}"></i>
                <span>${message}</span>
            `;
            
            alertContainer.innerHTML = '';
            alertContainer.appendChild(alertDiv);
            
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => {
                    if (alertContainer.contains(alertDiv)) {
                        alertContainer.removeChild(alertDiv);
                    }
                }, 300);
            }, 5000);
        }
        
        async function resendVerification() {
            const btn = resendBtn;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Sending...';
            btn.disabled = true;
            
            try {
                const response = await fetch('{{ route("verification.send") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showAlert(data.message || 'Verification link sent to your email!', 'success');
                    btn.innerHTML = '<i class="fas fa-check"></i> Sent!';
                    setTimeout(() => {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }, 3000);
                } else {
                    showAlert(data.message || 'Failed to send verification link', 'error');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Network error. Please try again.', 'error');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
        
        resendBtn.addEventListener('click', resendVerification);
        
        if (resendLink) {
            resendLink.addEventListener('click', (e) => {
                e.preventDefault();
                resendVerification();
            });
        }
        
        // Auto hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        }, 1000);
    </script>
</body>
</html>