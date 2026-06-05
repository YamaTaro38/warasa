<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - Warasa</title>
    <style>
        /* Reset total */
        body, table, td, p, a, div, span {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font-weight: normal;
            vertical-align: baseline;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f0f2f5;
            line-height: 1.5;
            padding: 40px 0;
        }
        
        /* Container */
        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Card */
        .card {
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }
        
        /* Header */
        .header {
            padding: 32px 32px 0;
            text-align: center;
        }
        
        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #ee4d2d;
            letter-spacing: -0.3px;
        }
        
        /* Body */
        .body {
            padding: 28px 32px 32px;
        }
        
        /* Greeting */
        .greeting {
            font-size: 16px;
            font-weight: 500;
            color: #1a1a1a;
            margin-bottom: 16px;
        }
        
        /* Text */
        .text {
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 24px;
            line-height: 1.5;
        }
        
        .text-sm {
            font-size: 13px;
            color: #718096;
            line-height: 1.5;
        }
        
        /* List */
        .list {
            background: #f7fafc;
            border-radius: 6px;
            padding: 20px 24px;
            margin: 24px 0;
            border: 1px solid #e2e8f0;
        }
        
        .list-title {
            font-size: 13px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 14px;
        }
        
        .list-item {
            font-size: 13px;
            color: #4a5568;
            padding: 6px 0;
            display: flex;
            align-items: center;
        }
        
        .list-marker {
            width: 18px;
            color: #48bb78;
            font-weight: 500;
            flex-shrink: 0;
        }
        
        /* Button */
        .btn-wrapper {
            text-align: center;
            margin: 32px 0 28px;
        }
        
        .btn {
            display: inline-block;
            background: #ee4d2d;
            color: #ffffff;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            padding: 10px 24px;
            border-radius: 6px;
            text-align: center;
        }
        
        /* Warning */
        .warning {
            background: #fffaf0;
            border-left: 3px solid #ed8936;
            padding: 12px 16px;
            margin: 24px 0;
            font-size: 12px;
            color: #744210;
            line-height: 1.4;
        }
        
        /* Divider */
        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 28px 0 20px;
        }
        
        /* Link fallback */
        .link-fallback {
            font-size: 11px;
            color: #718096;
            word-break: break-all;
            margin-top: 16px;
            line-height: 1.4;
        }
        
        .link-fallback a {
            color: #ee4d2d;
            text-decoration: none;
        }
        
        /* Footer */
        .footer {
            background: #fafbfc;
            padding: 24px 32px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .footer-link {
            font-size: 12px;
            color: #718096;
            text-decoration: none;
            margin: 0 10px;
        }
        
        .copyright {
            font-size: 11px;
            color: #a0aec0;
            margin-top: 16px;
        }
        
        /* Responsive */
        @media (max-width: 560px) {
            body {
                padding: 20px 0;
            }
            .header {
                padding: 24px 24px 0;
            }
            .body {
                padding: 24px;
            }
            .list {
                padding: 16px 20px;
            }
            .footer {
                padding: 20px 24px;
            }
        }
        
        /* Dark mode */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a202c;
            }
            .card {
                background: #2d3748;
            }
            .greeting {
                color: #f7fafc;
            }
            .text {
                color: #cbd5e0;
            }
            .list {
                background: #1a202c;
                border-color: #4a5568;
            }
            .list-title {
                color: #e2e8f0;
            }
            .list-item {
                color: #cbd5e0;
            }
            .warning {
                background: #2d3748;
                color: #fef3c7;
            }
            .divider {
                background: #4a5568;
            }
            .footer {
                background: #1a202c;
                border-top-color: #4a5568;
            }
            .footer-link {
                color: #cbd5e0;
            }
            .copyright {
                color: #718096;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            
            <!-- Header -->
            <div class="header">
                <div class="logo">warasa</div>
            </div>
            
            <!-- Body -->
            <div class="body">
                
                <!-- Greeting -->
                <div class="greeting">
                    Hi {{ $user->name }},
                </div>
                
                <!-- Message -->
                <div class="text">
                    Thanks for joining <strong>Warasa</strong>. Please verify your email address to activate your account.
                </div>
                
                <!-- Benefits List -->
                <div class="list">
                    <div class="list-title">After verification, you can:</div>
                    <div class="list-item">
                        <span class="list-marker">✓</span>
                        <span>Create and manage products</span>
                    </div>
                    <div class="list-item">
                        <span class="list-marker">✓</span>
                        <span>Use AI product generator</span>
                    </div>
                    <div class="list-item">
                        <span class="list-marker">✓</span>
                        <span>Access analytics dashboard</span>
                    </div>
                    <div class="list-item">
                        <span class="list-marker">✓</span>
                        <span>Get priority support</span>
                    </div>
                </div>
                
                <!-- Button -->
                <div class="btn-wrapper">
                    <a href="{{ $verificationUrl }}" class="btn">Verify email address</a>
                </div>
                
                <!-- Warning -->
                <div class="warning">
                    This link will expire in {{ $expiresIn }} minutes. If you did not create an account with Warasa, please ignore this email.
                </div>
                
                <!-- Divider -->
                <div class="divider"></div>
                
                <!-- Fallback link -->
                <div class="link-fallback">
                    Button not working? Copy this link into your browser:<br>
                    <a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a>
                </div>
                
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <div>
                    <a href="{{ route('home') }}" class="footer-link">Home</a>
                    <a href="{{ route('features') }}" class="footer-link">Features</a>
                    <a href="{{ route('pricing') }}" class="footer-link">Pricing</a>
                    <a href="{{ route('contact') }}" class="footer-link">Contact</a>
                </div>
                <div class="copyright">
                    © {{ date('Y') }} Warasa. All rights reserved.
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>