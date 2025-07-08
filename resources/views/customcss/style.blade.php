 <style>
    body {
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background-color: #f5f6fa;
        /* margin: 0; */
        /* padding: 20px; */
    }

    .main-container {
        max-width: 95%;
        margin: 0 auto;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    /* Stats Section */
    .stats-section {
        padding: 30px;
        background: white;
        border-bottom: 1px solid #e5e7eb;
        max-width: 100%;
    }

    .stats-title-bar {
        margin-bottom: 30px;
        text-align: center;
    }

    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 8px 0;
    }

    .company-name {
        font-size: 16px;
        color: #6b7280;
        margin: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 20px;
        background: #f9fafb;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    .stat-icon.danger {
        background: #fef2f2;
        color: #dc2626;
    }

    .stat-icon.warning {
        background: #fffbeb;
        color: #d97706;
    }

    .stat-icon.info {
        background: #eff6ff;
        color: #2563eb;
    }

    .stat-icon.success {
        background: #f0fdf4;
        color: #16a34a;
    }

    .stat-content {
        flex: 1;
    }

    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .stat-label {
        font-size: 14px;
        color: #6b7280;
        font-weight: 500;
    }

    /* Table Section */
    .table-section {
        padding: 30px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .table-title {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
    }

    .table-actions {
        display: flex;
        gap: 12px;
        align-items: center;
    }
    .table-wrapper .data-table th {
        color: white;
        background-color: #1f2937;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        width: 280px;
        padding: 10px 16px 10px 44px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    /* Table Styles */
    .table-wrapper {
        overflow-x: auto;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
    }

    .data-table th {
        background: #f9fafb;
        padding: 16px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }

    .data-table td {
        padding: 16px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        color: #1f2937;
    }

    .data-table tbody tr:hover {
        background: #f9fafb;
    }

    .data-table tbody tr:last-child td {
        border-bottom: none;
    }

    .row-number {
        display: inline-block;
        width: 28px;
        height: 28px;
        background: #f3f4f6;
        border-radius: 4px;
        text-align: center;
        line-height: 28px;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
    }

    .pc-info, .user-info, .time-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pc-icon {
        color: #3b82f6;
    }

    .user-icon {
        color: #8b5cf6;
    }

    .time-icon {
        color: #16a34a;
    }

    .app-badge {
        display: inline-block;
        background: #dc2626;
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .location-info {
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .location-icon {
        color: #6b7280;
        margin-top: 2px;
        flex-shrink: 0;
    }

    .location-text {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #374151;
        word-break: break-all;
        line-height: 1.4;
    }

    .ip-address, .mac-address {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: #374151;
        background: #f3f4f6;
        padding: 4px 8px;
        border-radius: 4px;
        display: inline-block;
    }

    /* No Data State */
    .no-data {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }

    .no-data i {
        font-size: 48px;
        margin-bottom: 16px;
        color: #d1d5db;
    }

    .no-data h4 {
        font-size: 18px;
        margin-bottom: 8px;
        color: #374151;
    }

    .no-data p {
        font-size: 14px;
        margin: 0;
    }

    /* Pagination */
    .pagination-section {
        padding: 20px 30px;
        background: #f9fafb;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .pagination-info {
        font-size: 14px;
        color: #6b7280;
    }

    .pagination-controls {
        display: flex;
        gap: 4px;
    }

    .page-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        border: 1px solid #d1d5db;
        background: white;
        color: #374151;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .page-btn:hover:not(.disabled) {
        background: #f3f4f6;
        border-color: #9ca3af;
    }

    .page-btn.active {
        background: #3b82f6;
        border-color: #3b82f6;
        color: white;
    }

    .page-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        body {
            padding: 10px;
        }

        .stats-section {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
        }

        .stat-item {
            padding: 16px;
        }

        .table-section {
            padding: 20px;
        }

        .table-header {
            flex-direction: column;
            gap: 16px;
            align-items: stretch;
        }

        .search-input {
            width: 100%;
        }

        .pagination-section {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }

        .pagination-controls {
            justify-content: center;
        }
    }

    @media (max-width: 640px) {
        .page-title {
            font-size: 24px;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .data-table th,
        .data-table td {
            padding: 12px 8px;
            font-size: 13px;
        }

        .location-text {
            font-size: 11px;
        }

        .ip-address, .mac-address {
            font-size: 11px;
        }
    }

    #log-detail-table td,
    #log-detail-table th {
        word-break: break-word;
        vertical-align: top;
    }
    #log-detail-table thead th {
        background-color: #2d3c51;
        color: white;
    }

    #log-detail-table td:nth-child(4),
    #log-detail-table th:nth-child(4){
        max-width: 300px;
    }

    .dataTables_wrapper .dataTables_scrollBody{
        overflow-x: auto !important; 
    }
    #log-detail-table_wrapper .dataTables_filter {
      margin-bottom: 10px;
    }

    #log-detail-table_wrapper .dataTables_filter input {
        margin-left: 0.5rem; /* Biar search input tidak nempel dengan "Search:" */
    }

    #log-detail-table_wrapper table.dataTable {
       margin-top: 1rem;
    }
    #logDetailModal .modal-xl {
        max-width: 95%; /* Membuat modal hampir selebar layar */
        width: 2300px; /* Anda bisa menyesuaikan lebar ini */
    }
    @media (max-width: 1500px) {
        #logDetailModal .modal-xl {
            width: 95%;
        }
}
</style>
 {{-- <style>
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
            max-width: 1450px;
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
    </style> --}}
