<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dalali Mkuu - Huduma Zote za Udalali Tanzania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { 
            --primary-blue: #0d6efd; 
            --dark-blue: #084298; 
        }
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        
        .navbar { background: white; border-bottom: 3px solid var(--primary-blue); }
        .navbar-brand { color: var(--primary-blue) !important; font-weight: 800; letter-spacing: -1px; }
        
        /* MUHIMU: Marekebisho ya Hero Section */
        .hero-section { 
            background-color: var(--primary-blue); /* Rangi ya akiba (fallback) */
            background: linear-gradient(135deg, rgba(13, 110, 253, 0.96), rgba(8, 66, 152, 0.92)), 
                        url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&w=1920&q=80');
            background-size: cover; 
            background-position: center;
            min-height: 80vh; 
            display: flex; 
            align-items: center; 
            color: white;
            padding: 60px 0;
        }

        .btn-primary-custom { background-color: var(--primary-blue); color: white; border-radius: 50px; font-weight: 600; border: none; }
        .btn-primary-custom:hover { background-color: var(--dark-blue); color: white; }

        .search-card {
            background: white; border-radius: 20px; padding: 30px; border: none;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3); color: #333;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top py-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand fs-2" href="{{ url('/') }}">DALALI MKUU</a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link fw-bold px-3 text-dark" href="{{ url('/') }}">
                        <i class="bi bi-house-door me-1"></i> Nyumbani
                    </a>
                </li>

                @guest
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        @if(Request::is('login'))
                            <a href="{{ route('register') }}" class="btn btn-primary-custom px-4 shadow">Jisajili Sasa</a>
                        @elseif(Request::is('register'))
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4">Ingia</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-outline-primary rounded-pill px-4 me-2">Ingia</a>
                            <a href="{{ route('register') }}" class="btn btn-primary-custom px-4 shadow">Anza Udalali</a>
                        @endif
                    </li>
                @else
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a href="{{ route('home') }}" class="btn btn-primary-custom px-4 shadow">Dashboard</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<footer class="bg-dark text-white py-5 mt-5">
    <div class="container text-center">
        <h4 class="fw-bold mb-3 text-primary">DALALI MKUU</h4>
        <p class="text-secondary small">Unganisha Madalali waaminifu na Wateja nchi nzima kwa haraka zaidi.</p>
        <hr class="bg-secondary opacity-25">
        <p class="mb-0 small text-secondary">&copy; 2025 Dalali Mkuu. Haki zote zimehifadhiwa.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>