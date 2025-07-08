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
            <div class="stat-item" style="background: linear-gradient(45deg, #d71313, #bf0f0f); color: white;">
                <div class="stat-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" style="color: white" id="total-detected">{{ $logs->total() ?? 0 }}</div>
                    <div class="stat-label" style="color:white">Total Detected</div>
                </div>
            </div>
            
            <div class="stat-item" style="background: linear-gradient(45deg, #c88b12, #ffcc00); color: white;">
                <div class="stat-icon warning">
                    <i class="fas fa-desktop"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" style="color: white" id="pc-affected">{{ $logs->unique('pc_name')->count() ?? 0 }}</div>
                    <div class="stat-label" style="color: white">PC Affected</div>
                </div>
            </div>
            
            <div class="stat-item" style="background:linear-gradient(45deg, #0f64bf, #0f64bf) ">
                <div class="stat-icon info">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" style="color: white" id="total-users">{{ $logs->unique('user_name')->count() ?? 0 }}</div>
                    <div class="stat-label" style="color: white">Users</div>
                </div>
            </div>
            
            <div class="stat-item" style="background:linear-gradient(45deg, #0fbf1e, #0ca118)">
                <div class="stat-icon success">
                   <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-number" style="color: white" id="total-apps">{{ $logs->unique('app_name')->count() ?? 0 }}</div>
                    <div class="stat-label" style="color: white">App Types</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h3 class="table-title">Detection Log |
                {{-- <br> --}}
               
            </h3>
            <div class="table-actions" style="display: flex; gap: 15px; margin-left: 57%;">
                <div class="action-buttons">
                    <!-- Export Excel Button -->
                    <a href="{{ route('detectionlogs.export') }}" class="btn btn-export btn-success" id="exportExcel">
                        <i class="fas fa-file-excel"></i>
                        Export Excel
                    </a>
                    
                    <!-- Refresh Button -->
                    <button class="btn btn-refresh btn-secondary" onclick="location.reload()">
                        <i class="fas fa-sync-alt"></i>
                        Refresh
                    </button>
                </div>
                
            </div>
            <div class="table-actions">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Search..." id="searchInput">
                    <i class="fas fa-search search-icon"></i>
                </div>
            </div>
        </div>

        {{-- @if($logs->count() > 0) --}}
            <div class="table-wrapper">
               
                <table class="data-table table-bordered">
                    <thead>
                        <tr style="background-color: black">
                            <th class="text-center">No</th>
                            <th class="text-center">PC Name</th>
                            <th class="text-center">User</th>
                            <th class="text-center">IP Address</th>
                            <th class="text-center">MAC Address</th>
                            {{-- <th class="text-center">Detection Time</th> --}}
                            <th class="text-center">ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="log-body">
                        @forelse($logs as $index => $log)
                            <tr>
                                <td class="text-center">
                                    <span class="row-number">{{ $index + $logs->firstItem() }}</span>
                                </td>
                                <td class="text-center">
                                    <i class="fas fa-desktop pc-icon"></i>
                                        <span>{{ $log->pc_name }}</span>
                                </td>
                                <td class="text-center">
                                        <i class="fas fa-user user-icon"></i>
                                        <span class="text-center">{{ $log->user_name }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="ip-address">{{ $log->ip_address }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="mac-address">{{ $log->mac_address }}</span>
                                </td>
                                 <td class="text-center">
                                    <button class="btn btn-primary" id="detail-detected" data-id="{{ $log->pc_name }}">
                                        <i class="fa fa-info-circle"></i>
                                        Detail Detected
                                    </button>
                                </td>
                            </tr>
                       @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                      <span>No Data Available</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        {{-- @else
           
        @endif --}}
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
@include('logs.show-detail-modal')
@push('js')
<script>
    let tableInitialized = false;
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

    $(document).on('click','#detail-detected', function(){
        let params = $(this).data('id');
        $('#logDetailModal').modal('show');
        let url= "{{ route('detectionlogs.showdetail',':param') }}";
        let route = url.replace(':param', params);
         if (!tableInitialized) {
            $('#log-detail-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: route,
                columns: [
                    { data: 'pc_name', name: 'pc_name', className:'text-center' },
                    { data: 'app_name', name: 'app_name',className:'text-center' },
                    { data: 'ip_address', name: 'ip_address',className:'text-center' },
                    { data: 'mac_address', name: 'mac_address', className:'text-center'},
                    { data: 'path', name: 'path' },
                    { data: 'detected_at', name: 'detected_at', className:'text-center' }
                ]
            });
            tableInitialized = true;
        }
    })
    function fetchLiveLogs() {
        $.ajax({
            url: "{{ route('detectionlogs.livedata') }}",
            method: "GET",
            success: function (data) {
                let html = '';
                if (data.length === 0) {
                    html = `
                        <tr>
                            <td class="text-center" colspan="6">
                                🔍 Searching for data, please wait...
                            </td>
                        </tr>
                    `;
                    $('#total-detected').text(0);
                    $('#pc-affected').text(0);
                    $('#total-users').text(0);
                    $('#total-apps').text(0);
                } else {
                    const affectedPCs = [...new Set(data.map(log => log.pc_name))];
                    const uniqueUsers = [...new Set(data.map(log => log.user_name))];
                    const uniqueApps = [...new Set(data.map(log => log.app_name))];
                    data.forEach((log, index) => {
                        html += `
                            <tr>
                                <td class="text-center"><span class="row-number">${index + 1}</span></td>
                                <td class="text-center"><i class="fas fa-desktop pc-icon"></i> <span>${log.pc_name}</span></td>
                                <td class="text-center"><i class="fas fa-user user-icon"></i> <span>${log.user_name}</span></td>
                                <td class="text-center"><span class="ip-address">${log.ip_address}</span></td>
                                <td class="text-center"><span class="mac-address">${log.mac_address}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-primary" id="detail-detected" data-id="${log.pc_name}">
                                        <i class="fa fa-info-circle"></i> Detail Detected
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#total-detected').text(data.length);
                    $('#pc-affected').text(affectedPCs.length);
                    $('#total-users').text(uniqueUsers.length);
                    $('#total-apps').text(uniqueApps.length);
                    // location.reload();
                }
                $('#log-body').html(html);
                //  location.reload();
            }
        });
    }
    setInterval(fetchLiveLogs, 5000);
    // $('#logDetailModal').on('shown.bs.modal', function () {
       
    // });
</script>
@endpush
@endsection
{{-- @push('js')
    <script></script>
@endpush --}}