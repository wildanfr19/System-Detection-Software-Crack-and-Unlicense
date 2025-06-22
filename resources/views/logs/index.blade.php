<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Detection Crack Application</title>
    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @include('customcss.style')
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
                            <i class="fas fa-info-circle"></i>
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

    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
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
