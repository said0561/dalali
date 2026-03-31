<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dalali Mkuu</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body { background-color: #f4f7f6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e3e6f0;
            transition: all 0.3s;
        }

        .nav-link {
            color: #4e73df;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 4px 15px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .nav-link:hover { background-color: #f8f9fc; color: #224abe; }
        .nav-link.active { background-color: #4e73df; color: white !important; shadow: 0 4px 12px rgba(78, 115, 223, 0.2); }
        
        .sidebar-heading {
            padding: 1.5rem 1.5rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #b7b9cc;
        }

        /* Responsive Mobile Styles */
        @media (max-width: 767.98px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -100%; /* Ifiche kushoto kwanza */
                z-index: 1050;
                width: 280px;
                height: 100%;
                box-shadow: 5px 0 15px rgba(0,0,0,0.1);
            }
            .sidebar.show { left: 0; } /* Ionekane ikibonyezwa */
            
            .main-content { margin-left: 0; }
        }

        .topbar { background: white; border-bottom: 1px solid #e3e6f0; }
        .user-profile-img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse bg-white p-0">
            <div class="position-sticky pt-3">
                <div class="text-center py-4 d-none d-md-block">
                    <h4 class="fw-bold text-primary">DALALI MKUU</h4>
                </div>
                
                <ul class="nav flex-column">
                    @include('layouts.partials.sidebar')
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
            
            <nav class="navbar navbar-expand-md navbar-light topbar px-4 py-3 sticky-top shadow-sm">
                <div class="container-fluid p-0">
                    <button class="navbar-toggler border-0 d-md-none" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <h5 class="m-0 fw-bold text-primary d-md-none">DALALI MKUU</h5>

                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center text-dark" id="userMenu" data-bs-toggle="dropdown">
                                <span class="me-2 d-none d-sm-inline small fw-bold">{{ Auth::user()->name }}</span>
                                <i class="bi bi-person-circle fs-4 text-primary"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Toka Nje
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="p-4">
                @yield('content')
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>