@extends('layouts.app')
@section('content')
@include('customcss.style')
<style>
/* Logs table page tweaks */
.table-header { display:flex; flex-wrap:wrap; align-items:center; justify-content:space-between; gap:8px; margin-bottom:10px; }
.table-header .action-buttons .btn { padding:6px 10px; font-size:13px; }
.table-header .search-container { margin-left:auto; }
.search-input { width:220px; padding:6px 10px; border-radius:6px; border:1px solid #ddd; }
.data-table td, .data-table th { vertical-align: middle; }
.pc-icon { margin-right:6px; }
.modal .modal-body { padding: 0.8rem; }
.table-sm td, .table-sm th { padding: 0.45rem; }
.btn-outline-info { border-color:#17a2b8; color:#17a2b8; }
.btn-outline-info:hover { background:#17a2b8; color:white; }
@media (max-width:576px){ .search-input{ width:120px;} .action-buttons .d-none.d-sm-inline{ display:none !important; } }
</style>
<div class="main-container">
    <!-- Logs Table Only -->

    <div class="table-section">
        <div class="table-header" style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
            <div class="header-left" style="display:flex; align-items:center; gap:14px;">
                <h3 class="table-title" style="margin:0;">Detection Log</h3>
                <div class="action-buttons" style="display:flex; gap:8px; align-items:center;">
                    <!-- Export Excel Button -->
                    <a href="{{ route('detectionlogs.export') }}" class="btn btn-export btn-success" id="exportExcel">
                        <i class="fas fa-file-excel"></i>
                        <span class="d-none d-sm-inline">Export Excel</span>
                    </a>

                    <!-- Refresh Button -->
                    <button class="btn btn-refresh btn-secondary" id="btn-refresh-page">
                        <i class="fas fa-sync-alt"></i>
                        <span class="d-none d-sm-inline">Refresh</span>
                    </button>

                    <!-- Clean PC Modal Button -->
                    <button class="btn btn-outline-info" id="open-clean-modal" title="Show Clean PC list">
                        <i class="fas fa-check-circle"></i>
                        <span class="d-none d-sm-inline">Clean PC</span>
                    </button>
                </div>
            </div>

            <div class="header-right" style="margin-left:auto;">
                <div class="search-container" style="position:relative;">
                    <input type="text" class="search-input" placeholder="Search..." id="searchInput" style="padding-right:36px;">
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
                                   <button class="btn btn-primary detail-detected" data-id="{{ $log->pc_name }}">
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
@include('logs.show-clean-modal')
@push('js')
<script>
    // Charts removed on logs table page; charts moved to Dashboard page.

    let tableInitialized = false;
    let cleanTableInitialized = false;
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

    // Use event delegation for buttons with class .detail-detected
    $(document).on('click', '.detail-detected', function(){
        let params = $(this).data('id');
        if (!params) return;
        params = encodeURIComponent(params);
        $('#logDetailModal').modal('show');
        let url= "{{ route('detectionlogs.showdetail',':param') }}";
        let route = url.replace(':param', params);
        if (!tableInitialized) {
            // initialize with placeholder ajax; we'll set URL below
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
                    // { data: 'source', name: 'source' },
                    { data: 'detected_at', name: 'detected_at', className:'text-center' }
                ]
            });
            tableInitialized = true;
        }
        // Update ajax URL and reload table to reflect clicked PC
        var dt = $('#log-detail-table').DataTable();
        dt.ajax.url(route).load();
    });

    // Open Clean PC modal and initialize table once
    $(document).on('click', '#open-clean-modal', function(){
        $('#logCleanModal').modal('show');
        if (!cleanTableInitialized) {
            $('#log-clean-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('detectionlogs.clean') }}",
                responsive: true,
                scrollX: true,
                pageLength: 10,
                lengthChange: false,
                language: { emptyTable: 'No clean PC records yet' },
                columns: [
                    { data: 'pc_name', name: 'pc_name', className:'text-center' },
                    { data: 'user_name', name: 'user_name', className:'text-center' },
                    { data: 'ip_address', name: 'ip_address', className:'text-center' },
                    { data: 'mac_address', name: 'mac_address', className:'text-center' },
                    { data: 'latest_detected_at', name: 'latest_detected_at', className:'text-center' }
                ]
            });
            cleanTableInitialized = true;
        }
    });

    // Refresh page button (now inside header)
    $(document).on('click', '#btn-refresh-page', function(){ location.reload(); });
    // modal toolbar actions
    $(document).on('click', '#refresh-clean-list', function(){
        if (cleanTableInitialized) { $('#log-clean-table').DataTable().ajax.reload(); }
    });
    $(document).on('click', '#export-clean-list', function(){
        // basic CSV export using current table data (client-side)
        if (!cleanTableInitialized) return;
        var tbl = $('#log-clean-table').DataTable();
        var data = tbl.rows({search:'applied'}).data().toArray();
        if (!data || data.length === 0) { alert('No data to export'); return; }
        var csv = 'PC Name,User,IP Address,MAC Address,Last Clean At\n';
        data.forEach(function(r){ csv += `"${r.pc_name}","${r.user_name}","${r.ip_address}","${r.mac_address}","${r.latest_detected_at}"\n`; });
        var blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
        var url = URL.createObjectURL(blob);
        var a = document.createElement('a'); a.href = url; a.download = 'clean_pc_list.csv'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
    });
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
                } else {
                    data.forEach((log, index) => {
                        html += `
                            <tr>
                                <td class="text-center"><span class="row-number">${index + 1}</span></td>
                                <td class="text-center"><i class="fas fa-desktop pc-icon"></i> <span>${log.pc_name}</span></td>
                                <td class="text-center"><i class="fas fa-user user-icon"></i> <span>${log.user_name}</span></td>
                                <td class="text-center"><span class="ip-address">${log.ip_address}</span></td>
                                <td class="text-center"><span class="mac-address">${log.mac_address}</span></td>
                                <td class="text-center">
                                    <button class="btn btn-primary detail-detected" data-id="${log.pc_name}">
                                        <i class="fa fa-info-circle"></i> Detail Detected
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                }
                $('#log-body').html(html);
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
