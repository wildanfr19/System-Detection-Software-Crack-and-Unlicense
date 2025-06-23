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
    </style>
