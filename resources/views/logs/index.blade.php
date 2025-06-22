<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Detection Crack Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            /* background: linear-gradient(135deg, #10121c 0%, #1c1623 100%); */ */
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .main-container {
            background: rgba(192, 187, 187, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin: 20px auto;
            max-width: 1900px;
        }

        .header-section {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
            padding: 30px;
            border-radius: 20px 20px 0 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="70" cy="80" r="2.5" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% { transform: translateX(-100px); }
            100% { transform: translateX(100px); }
        }

        .header-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            position: relative;
            z-index: 1;
        }

        .header-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-top: 10px;
            position: relative;
            z-index: 1;
        }

        .stats-section {
            padding: 30px;
            background: #f8f9fa;
        }

        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table-container {
            padding: 30px;
            background: white;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e9ecef;
        }

        .table-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #495057;
            margin: 0;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            border-radius: 25px;
            padding-left: 45px;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .search-box input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .custom-table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
        }

        .custom-table thead th {
            background: linear-gradient(45deg, #495057, #6c757d);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.85rem;
            padding: 20px 15px;
            border: none;
            position: relative;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f8f9fa;
        }

        .custom-table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .custom-table td {
            padding: 18px 15px;
            vertical-align: middle;
            border: none;
        }

        .app-name {
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
            padding: 8px 15px;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            display: inline-block;
            min-width: 120px;
            text-align: center;
        }

        .pc-name {
            font-weight: 600;
            color: #495057;
        }

        .user-name {
            color: #6f42c1;
            font-weight: 500;
        }

        .ip-address, .mac-address {
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
            padding: 5px 10px;
            border-radius: 8px;
            font-size: 0.85rem;
        }

        .detection-time {
            color: #28a745;
            font-weight: 500;
        }

        /* Custom Pagination Styling */
        .pagination-container {
            padding: 30px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 0 0 20px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 20px;
        }

        .pagination-info {
            color: #495057;
            font-size: 0.95rem;
            font-weight: 500;
            background: white;
            padding: 12px 24px;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border: 2px solid rgba(102, 126, 234, 0.1);
            text-align: center;
        }

        .pagination-info i {
            color: #667eea;
            margin-right: 8px;
        }

        /* Custom Pagination */
        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .custom-pagination .page-item {
            display: inline-block;
        }

        .custom-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 45px;
            height: 45px;
            padding: 0 15px;
            text-decoration: none;
            border: 2px solid transparent;
            border-radius: 12px;
            background: white;
            color: #495057;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        .custom-pagination .page-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea, #764ba2);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .custom-pagination .page-link:hover {
            color: white;
            border-color: transparent;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .custom-pagination .page-link:hover::before {
            left: 0;
        }

        .custom-pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-color: transparent;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
            transform: scale(1.1);
        }

        .custom-pagination .page-item.active .page-link::before {
            left: 0;
        }

        .custom-pagination .page-item.disabled .page-link {
            background: #f8f9fa;
            color: #adb5bd;
            cursor: not-allowed;
            opacity: 0.6;
            border-color: #e9ecef;
        }

        .custom-pagination .page-item.disabled .page-link:hover {
            transform: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            color: #adb5bd;
        }

        .custom-pagination .page-item.disabled .page-link::before {
            display: none;
        }

        /* Previous/Next buttons styling */
        .custom-pagination .page-item:first-child .page-link,
        .custom-pagination .page-item:last-child .page-link {
            background: linear-gradient(135deg, #495057, #6c757d);
            color: white;
            min-width: 55px;
            font-weight: 700;
        }

        .custom-pagination .page-item:first-child .page-link:hover,
        .custom-pagination .page-item:last-child .page-link:hover {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }

        .custom-pagination .page-item:first-child.disabled .page-link,
        .custom-pagination .page-item:last-child.disabled .page-link {
            background: #e9ecef;
            color: #adb5bd;
        }

        .alert-danger {
            border-radius: 15px;
            border: none;
            background: linear-gradient(45deg, #dc3545, #fd7e14);
            color: white;
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        @media (max-width: 768px) {
            .header-title {
                font-size: 1.8rem;
            }

            .search-box {
                width: 100%;
                margin-top: 15px;
            }

            .table-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .custom-table {
                font-size: 0.85rem;
            }

            .stat-card {
                margin-bottom: 20px;
            }

            .pagination-container {
                padding: 20px;
                gap: 15px;
            }

            .pagination-info {
                order: 2;
                font-size: 0.85rem;
                padding: 10px 20px;
            }

            .custom-pagination {
                order: 1;
                flex-wrap: wrap;
                gap: 6px;
            }

            .custom-pagination .page-link {
                min-width: 40px;
                height: 40px;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .custom-pagination .page-link {
                min-width: 36px;
                height: 36px;
                padding: 0 10px;
                font-size: 0.8rem;
            }

            .custom-pagination .page-item:first-child .page-link,
            .custom-pagination .page-item:last-child .page-link {
                min-width: 45px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Header Section -->
        <div class="header-section">
            <h1 class="header-title">
                <i class="fas fa-shield-alt me-3"></i>
                Dashboard Detection Crack Application Monitoring PT Indonesia Thai Summit Auto
            </h1>
            <p class="header-subtitle">
                Crack & Unlicensed Software Application Detection System
            </p>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-number text-danger">{{ $logs->total() ?? 0 }}</div>
                        <div class="stat-label">Detected Total</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon text-warning">
                            <i class="fas fa-desktop"></i>
                        </div>
                        <div class="stat-number text-warning">{{ $logs->unique('pc_name')->count() ?? 0 }}</div>
                        <div class="stat-label">PC Detected</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon text-info">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number text-info">{{ $logs->unique('user_name')->count() ?? 0 }}</div>
                        <div class="stat-label">Users Engage</div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stat-card">
                        <div class="stat-icon text-success">
                            <i class="fas fa-shield-check"></i>
                        </div>
                        <div class="stat-number text-success">{{ $logs->unique('app_name')->count() ?? 0 }}</div>
                        <div class="stat-label">Application Type</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list-alt me-2"></i>
                    Recent Detection Log
                </h3>
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" class="form-control" placeholder="Cari data..." id="searchInput">
                </div>
            </div>

            @if($logs->count() > 0)
                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-hashtag me-2"></i>No</th>
                                <th><i class="fas fa-desktop me-2"></i>PC Name</th>
                                <th><i class="fas fa-user me-2"></i>User</th>
                                <th><i class="fas fa-bug me-2"></i>Unlicense Application</th>
                                <th><i class="fas fa-file me-2"></i> Location Drive</th>
                                <th><i class="fas fa-network-wired me-2"></i>IP Address</th>
                                <th><i class="fas fa-ethernet me-2"></i>MAC Address</th>
                                <th><i class="fas fa-clock me-2"></i>Detection Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $index => $log)
                                <tr>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">{{ $index + $logs->firstItem() }}</span>
                                    </td>
                                    <td class="pc-name">
                                        <i class="fas fa-computer me-2 text-primary"></i>
                                        {{ $log->pc_name }}
                                    </td>
                                    <td class="user-name">
                                        <i class="fas fa-user-circle me-2"></i>
                                        {{ $log->user_name }}
                                    </td>
                                    <td>
                                        <span class="app-name">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $log->app_name }}
                                        </span>
                                    </td>
                                     <td>
                                        <span class="lcation">
                                            <i class="fas fa-exclamation-circle me-2"></i>
                                            {{ $log->path }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="ip-address">
                                            <i class="fas fa-globe me-2 text-info"></i>
                                            {{ $log->ip_address }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="mac-address">
                                            <i class="fas fa-ethernet me-2 text-success"></i>
                                            {{ $log->mac_address }}
                                        </span>
                                    </td>
                                    <td class="detection-time">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        {{ \Carbon\Carbon::parse($log->detected_at)->format('d/m/Y H:i:s') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info text-center py-5">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <h4>No Data Available</h4>
                    <p class="mb-0">There are no detected cracked applications recorded in the system.</p>
                </div>
            @endif
        </div>

        <!-- Custom Pagination -->
        @if($logs->hasPages())
            <div class="pagination-container">
                <div class="pagination-info">
                    <i class="fas fa-info-circle"></i>
                    Displaying {{ $logs->firstItem() }} until {{ $logs->lastItem() }}
                    from {{ $logs->total() }} total data
                </div>

                <nav aria-label="Page navigation">
                    <ul class="custom-pagination">
                        {{-- Previous Page Link --}}
                        @if ($logs->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $logs->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                            @if ($page == $logs->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Next Page Link --}}
                        @if ($logs->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $logs->nextPageUrl() }}" rel="next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('.custom-table tbody tr');

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Auto-refresh functionality (optional)
        setInterval(function() {
            // Uncomment the line below if you want auto-refresh every 30 seconds
            // location.reload();
        }, 30000);
    </script>
</body>
</html>
