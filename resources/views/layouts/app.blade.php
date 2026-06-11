<!DOCTYPE html>
<html lang="id" class="{{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Warasa - AI E-Commerce Assistant</title>
    
    <!-- Favicon -->
    <link rel="icon" href="/images/icon.ico" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light-bg text-light-text dark:bg-dark-bg dark:text-dark-text font-inter overflow-x-hidden">
    <div class="min-h-screen">
        @include('layouts.navigation')
        
        <!-- MAIN TANPA CLASS CONTAINER -->
        <main>
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
    
    @stack('scripts')
</body>
</html>