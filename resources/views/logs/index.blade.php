@extends('layouts.app')
@section('content')
@include('customcss.style')
<div class="main-container">
    <!-- Simple Stats Section -->
    <div class="stats-section">
        <div class="stats-title-bar">
            <h2 class="page-title">Crack Detection Monitoring</h2>
            <p class="company-name">PT Indonesia Thai Summit Auto</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $logs->total() ?? 0 }}</div>
                    <div class="stat-label">Total Detected</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon warning">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $logs->unique('pc_name')->count() ?? 0 }}</div>
                    <div class="stat-label">PC Affected</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $logs->unique('user_name')->count() ?? 0 }}</div>
                    <div class="stat-label">Users</div>
                </div>
            </div>
            
            <div class="stat-item">
                <div class="stat-icon success">
                    <i class="fas fa-apps"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $logs->unique('app_name')->count() ?? 0 }}</div>
                    <div class="stat-label">App Types</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h3 class="table-title">Detection Log</h3>
            <div class="table-actions">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search..." id="searchInput">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
        </div>

        @if($logs->count() > 0)
            <div class="table-wrapper">
                <table class="data-table table-bordered">
                    <thead>
                        <tr style="background-color: black">
                            <th class="text-center">No</th>
                            <th class="text-center">PC Name</th>
                            <th class="text-center">User</th>
                            <th class="text-center">IP Address</th>
                            <th class="text-center">MAC Address</th>
                            <th class="text-center">Detection Time</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $index => $log)
                            <tr>
                                <td class="text-center">
                                    <span class="row-number">{{ $index + $logs->firstItem() }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="pc-info">
                                        <i class="fas fa-desktop pc-icon"></i>
                                        <span class="text-center">{{ $log->pc_name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="user-info">
                                        <i class="fas fa-user user-icon"></i>
                                        <span class="text-center">{{ $log->user_name }}</span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="ip-address">{{ $log->ip_address }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="mac-address">{{ $log->mac_address }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="time-info">
                                        <i class="fas fa-clock time-icon"></i>
                                        <span>{{ \Carbon\Carbon::parse($log->detected_at)->format('d/m/Y H:i') }}</span>
                                    </div>
                                </td>
                                 <td class="text-center">
                                    <button class="btn btn-primary">Detail Detected</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h4>No Data Available</h4>
                <p>There are no detected applications in the system.</p>
            </div>
        @endif
    </div>

    <!-- Simple Pagination -->
    @if($logs->hasPages())
        <div class="pagination-section">
            <div class="pagination-info">
                Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} entries
            </div>
            
            <div class="pagination-controls">
                @if ($logs->onFirstPage())
                    <button class="page-btn disabled">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="page-btn">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                    @if ($page == $logs->currentPage())
                        <button class="page-btn active">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="page-btn">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button class="page-btn disabled">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>

<script>
    // Enhanced search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const tableRows = document.querySelectorAll('.data-table tbody tr');

        tableRows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
                row.classList.remove('hidden');
            } else {
                row.style.display = 'none';
                row.classList.add('hidden');
            }
        });
    });

    // Smooth scrolling for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
</script>

@endsection