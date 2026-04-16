@extends('layouts.template')

@section('own_style')
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/assets/css/vendors/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('dashboard_assets/assets/css/vendors/range-slider.css') }}">
    <style>
        /* Game Theme CSS */
        .game-card {
            background: linear-gradient(145deg, #1a1e2b 0%, #2a2f3f 100%);
            border: 2px solid #3d4b6b;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5), 0 0 0 2px #4e3b2e inset, 0 0 0 4px #2a1e1a inset;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .game-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.6), 0 0 20px #ffd700, 0 0 0 2px #ffaa00 inset;
            border-color: #ffaa00;
        }

        .game-character-frame {
            position: relative;
            padding: 10px;
            background: linear-gradient(45deg, #2c3e50, #3498db);
            border-radius: 15px 15px 0 0;
            border-bottom: 4px solid #f1c40f;
        }

        .game-character-img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid #ecf0f1;
            image-rendering: pixelated;
            filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.5));
        }

        .game-glow-effect {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(255, 215, 0, 0.2), transparent 70%);
            pointer-events: none;
            animation: glowPulse 2s infinite;
        }

        @keyframes glowPulse {

            0%,
            100% {
                opacity: 0.5;
            }

            50% {
                opacity: 1;
            }
        }

        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: 2px solid #fff;
            box-shadow: 0 0 10px rgba(102, 126, 234, 0.5);
            animation: slideInRight 0.5s ease;
        }

        .status-badge.available {
            background: linear-gradient(135deg, #00b09b, #96c93d);
        }

        .status-badge.rented {
            background: linear-gradient(135deg, #ee0979, #ff6a00);
        }

        .game-type-badge {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            padding: 8px 15px;
            border-radius: 30px;
            display: inline-block;
            margin-bottom: 12px;
            border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            transform: skewX(-10deg);
        }

        .game-type-text {
            display: inline-block;
            transform: skewX(10deg);
            color: white;
            font-weight: bold;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 2px 2px 0 rgba(0, 0, 0, 0.3);
        }

        .game-unit-name {
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-shadow: 3px 3px 0 #3498db, 5px 5px 0 rgba(0, 0, 0, 0.3);
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes glow {

            0%,
            100% {
                text-shadow: 3px 3px 0 #3498db, 5px 5px 0 rgba(0, 0, 0, 0.3);
            }

            50% {
                text-shadow: 3px 3px 0 #f1c40f, 5px 5px 0 rgba(0, 0, 0, 0.3);
            }
        }

        .game-price-container {
            background: linear-gradient(90deg, #2c3e50, #3498db);
            padding: 8px 15px;
            border-radius: 50px;
            display: inline-flex;
            align-items: center;
            border: 2px solid #f1c40f;
            box-shadow: 0 5px 0 #1a2634;
            margin-bottom: 12px;
        }

        .game-coin-icon {
            font-size: 20px;
            margin-right: 8px;
            animation: spinCoin 2s linear infinite;
        }

        @keyframes spinCoin {
            0% {
                transform: rotateY(0deg);
            }

            100% {
                transform: rotateY(360deg);
            }
        }

        .game-price {
            color: #ffd700;
            font-weight: bold;
            font-size: 16px;
            margin-right: 5px;
            text-shadow: 2px 2px 0 #000;
        }

        .game-price-per {
            color: #ecf0f1;
            font-size: 12px;
            font-style: italic;
        }

        .game-stats {
            display: flex;
            gap: 15px;
            margin-top: 12px;
            padding-top: 12px;
            border-top: 2px dashed #4a5568;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #a0aec0;
            font-size: 12px;
            background: rgba(0, 0, 0, 0.3);
            padding: 4px 10px;
            border-radius: 15px;
        }

        .stat-item i {
            color: #ffd700;
        }

        .game-details {
            padding: 15px;
            background: linear-gradient(135deg, #2d3748 0%, #1a202c 100%);
        }

        /* Animasi untuk muncul */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Efek pixelated untuk feel game */
        .detail-unit {
            image-rendering: pixelated;
            image-rendering: -moz-crisp-edges;
            image-rendering: crisp-edges;
        }

        /* Loading animation untuk gambar */
        .game-character-img {
            position: relative;
            background: linear-gradient(90deg, #2d3748 25%, #4a5568 50%, #2d3748 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>

    {{-- modal style --}}
    <style>
        /* Game Modal Styles */
        .game-modal .modal-content {
            background: transparent;
            border: none;
        }

        .game-modal-content {
            background: linear-gradient(145deg, #1a1e2b 0%, #0f1219 100%);
            border: 3px solid #4e3b2e;
            border-radius: 20px;
            box-shadow: 0 0 50px rgba(0, 0, 0, 0.8), 0 0 0 2px #8b6b4d inset, 0 0 20px #ffaa00;
            position: relative;
            overflow: hidden;
        }

        /* Modal Header */
        .game-modal-header {
            background: linear-gradient(90deg, #2c1810 0%, #4a2a1a 50%, #2c1810 100%);
            border-bottom: 4px solid #8b6b4d;
            padding: 20px 25px;
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .game-title {
            display: flex;
            flex-direction: column;
        }

        .title-text {
            font-size: 28px;
            font-weight: bold;
            color: #fff;
            text-shadow: 3px 3px 0 #8b4513, 5px 5px 0 #000;
            letter-spacing: 2px;
            animation: titlePulse 2s infinite;
        }

        .game-close-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #ffaa00;
            background: linear-gradient(145deg, #4a2a1a, #2c1810);
            color: #fff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .game-close-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px #ffaa00;
            border-color: #fff;
        }

        /* Modal Body */
        .game-modal-body {
            padding: 30px;
            background: radial-gradient(circle at 50% 0%, #2a2f3f, #1a1e2b);
        }

        

        /* Form Styles */
        .game-form-group {
            margin-bottom: 25px;
        }

        .game-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffd700;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .label-icon {
            color: #ffaa00;
            font-size: 18px;
        }

        .label-required {
            color: #ff4757;
            font-size: 16px;
        }

        .game-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .game-input {
            width: 100%;
            padding: 15px 45px;
            background: #2c3e50;
            border: 3px solid #4a3a2a;
            border-radius: 15px;
            color: #fff;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .game-input:focus {
            outline: none;
            border-color: #ffaa00;
            box-shadow: 0 0 20px rgba(255, 170, 0, 0.3);
            transform: scale(1.02);
        }

        .input-decoration {
            position: absolute;
            left: 15px;
            color: #ffaa00;
            font-size: 20px;
        }

        .input-glow {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 15px;
            pointer-events: none;
            box-shadow: 0 0 20px transparent;
            transition: box-shadow 0.3s ease;
        }

        .game-input:focus+.input-glow {
            box-shadow: 0 0 30px #ffaa00;
        }

        /* Select Styles */
        .game-select-wrapper {
            position: relative;
        }

        .game-select {
            width: 100%;
            padding: 15px 45px;
            background: #2c3e50;
            border: 3px solid #4a3a2a;
            border-radius: 15px;
            color: #fff;
            font-size: 16px;
            appearance: none;
            cursor: pointer;
        }

        .select-decoration {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #ffaa00;
            font-size: 16px;
            pointer-events: none;
        }

        /* Price Input Special */
        .price-wrapper {
            position: relative;
        }

        .price-prefix {
            position: absolute;
            left: 15px;
            color: #ffaa00;
            font-weight: bold;
            font-size: 18px;
            z-index: 1;
        }

        .price-input {
            padding-left: 60px;
            padding-right: 60px;
        }

        .price-suffix {
            position: absolute;
            right: 15px;
            color: #ffaa00;
            font-weight: bold;
            z-index: 1;
        }

        /* Input Stats */
        .input-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            color: #a0aec0;
            font-size: 12px;
        }

        .char-count,
        .price-hint,
        .select-info {
            background: rgba(0, 0, 0, 0.3);
            padding: 3px 10px;
            border-radius: 10px;
        }

        /* Preview Section */
        .unit-preview-section {
            margin-top: 30px;
            padding: 20px;
            background: linear-gradient(145deg, #2c3e50, #1e2b3a);
            border-radius: 15px;
            border: 3px solid #4a3a2a;
        }

        .preview-title {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffd700;
            margin-bottom: 15px;
        }

        .preview-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px;
            background: #1a1e2b;
            border-radius: 10px;
            border: 2px solid #8b6b4d;
        }

        .preview-character {
            width: 60px;
            height: 60px;
            background: linear-gradient(145deg, #4a3a2a, #2c1810);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #ffd700;
            border: 3px solid #ffaa00;
        }

        .preview-details {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .preview-name {
            color: #fff;
            font-weight: bold;
            font-size: 18px;
        }

        .preview-type {
            color: #ffaa00;
            font-size: 14px;
        }

        .preview-price {
            color: #ffd700;
            font-size: 16px;
        }

        /* Modal Footer */
        .game-modal-footer {
            background: linear-gradient(90deg, #2c1810 0%, #4a2a1a 50%, #2c1810 100%);
            border-top: 4px solid #8b6b4d;
            padding: 20px;
            display: flex;
            gap: 15px;
        }

        /* Game Buttons */
        .game-btn {
            flex: 1;
            padding: 15px 20px;
            border: 3px solid #8b6b4d;
            border-radius: 15px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            color: #fff;
            font-size: 16px;
        }

        .game-btn i {
            font-size: 20px;
        }

        /* Cancel Button */
        .game-btn-cancel {
            background: linear-gradient(145deg, #4a4a4a, #2c2c2c);
            border-color: #6b6b6b;
        }

        .game-btn-cancel:hover {
            background: linear-gradient(145deg, #5a5a5a, #3c3c3c);
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(255, 255, 255, 0.2);
        }

        /* Primary Button (Update) */
        .game-btn-primary {
            background: linear-gradient(145deg, #4facfe, #00f2fe);
            border-color: #ffaa00;
            position: relative;
        }

        .game-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 30px #4facfe;
            animation: buttonGlow 1s infinite;
        }

        /* Danger Button (Delete) */
        .game-btn-danger {
            background: linear-gradient(145deg, #f5515f, #9f041b);
            border-color: #ffaa00;
        }

        .game-btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 30px #f5515f;
            animation: bloodShake 0.5s infinite;
        }

        /* Button Effects */
        .btn-overlay {
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .game-btn:hover .btn-overlay {
            left: 100%;
        }

        .btn-glow {
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.3) 0%, transparent 70%);
            animation: rotate 4s linear infinite;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .game-btn-primary:hover .btn-glow {
            opacity: 1;
        }

        /* Level Up Effect */
        .level-up-effect {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            background: radial-gradient(circle at var(--x, 50%) var(--y, 50%), rgba(255, 215, 0, 0.2) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .game-modal-content:hover .level-up-effect {
            opacity: 1;
        }

        /* Animations */
        @keyframes floatIcon {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes crownGlow {

            0%,
            100% {
                filter: drop-shadow(0 0 5px gold);
            }

            50% {
                filter: drop-shadow(0 0 15px gold);
            }
        }

        @keyframes titlePulse {

            0%,
            100% {
                text-shadow: 3px 3px 0 #8b4513, 5px 5px 0 #000;
            }

            50% {
                text-shadow: 3px 3px 0 #ffaa00, 5px 5px 0 #8b4513;
            }
        }

        @keyframes heartbeat {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        @keyframes fillPulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.8;
            }
        }

        @keyframes spinCoin {
            0% {
                transform: rotateY(0deg);
            }

            100% {
                transform: rotateY(360deg);
            }
        }

        @keyframes buttonGlow {

            0%,
            100% {
                box-shadow: 0 5px 30px #4facfe;
            }

            50% {
                box-shadow: 0 5px 50px #4facfe;
            }
        }

        @keyframes bloodShake {

            0%,
            100% {
                transform: translateX(0) translateY(-3px);
            }

            25% {
                transform: translateX(-2px) translateY(-3px);
            }

            75% {
                transform: translateX(2px) translateY(-3px);
            }
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .game-modal-footer {
                flex-direction: column;
            }

            .preview-card {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-4">
                    <h4>{{ $pageTitle }}</h4>
                </div>
                <div class="col-8 d-flex justify-content-end">
                    <button class="btn btn-primary" id="tambah-data" style="margin-right: 5px">
                        <i class="fa fa-plus-circle me-2"></i> Tambah Data
                    </button>

                    <button class="btn btn-primary" id="filter">
                        <i class="fa fa-filter me-2"></i> Filter
                    </button>

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid product-wrapper sidebaron">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @else
            <div class="card d-none" id="filter-section">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control" id="filter-status">
                                    <option value="">-- All --</option>
                                    <option value="1">Active</option>
                                    <option value="0">Nonactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="apply-filter">
                                <i class="fa fa-check me-2"></i> Apply Filter
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-grid">
                <div class="feature-products">
                    <div class="row">
                        <div class="col-12">
                            <form>
                                <div class="form-group m-0">
                                    <input class="form-control" type="search" id="search" placeholder="Search.."
                                        data-original-title="" title=""><i class="fa fa-search"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="product-wrapper-grid" style="opacity: 1;">
                    <div class="row data-ctr">
                        @foreach ($data as $d)
                            <div class="col-6 col-xl-3 col-md-3 detail-unit" style="cursor: pointer"
                                data-id="{{ $d->id }}" data-status="{{ $d->status }}">
                                <div class="card game-card">
                                    <div class="product-box game-product-box">
                                        <div class="product-img game-img-container">
                                            <div class="game-character-frame">
                                                <img class="img-fluid game-character-img"
                                                    src="{{ asset('own_assets/images/default.png') }}" alt="Unit Image">

                                                <div class="game-glow-effect"></div>

                                                @if ($d->status == 'available')
                                                    <div class="status-badge available">
                                                        <i class="fas fa-check-circle"></i> Ready
                                                    </div>
                                                @elseif($d->status == 'rented')
                                                    <div class="status-badge rented">
                                                        <i class="fas fa-clock"></i> In Battle
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="product-details game-details">
                                            <div class="game-type-badge">
                                                <span class="game-type-text">
                                                    <i class="fas fa-gamepad me-1"></i>{{ $d->type }}
                                                </span>
                                            </div>

                                            <h5 class="game-unit-name">{{ $d->name }}</h5>

                                            <div class="game-price-container">
                                                <span class="game-coin-icon">🪙</span>
                                                <span class="game-price">Rp
                                                    {{ number_format($d->price_per_hour, 0, ',', '.') }}</span>
                                                <span class="game-price-per">/Jam</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        @endif
    </div>

    <div class="modal fade bd-example-modal-lg" id="tambah-data-modal" tabindex="-1" role="dialog"
        aria-labelledby="myExtraLargeModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myExtraLargeModal">Add Student</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body dark-modal">
                    <div class="card">
                        <form class="form theme-form dark-inputs">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="foto">Upload Student Photo</label>
                                            <input type="file" class="form-control input-air-primary" id="foto"
                                                accept="image/*">
                                            <div class="mt-3">
                                                <img id="preview-foto" src="#" alt="Photo Preview"
                                                    class="img-thumbnail d-none" style="max-width: 150px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="nama">Enter Student Name</label>
                                            <input type="text" class="form-control input-air-primary" id="nama"
                                                placeholder="Enter Student Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Enter Student Email</label>
                                            <input type="text" class="form-control input-air-primary" id="email"
                                                placeholder="Enter Student Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-light" type="button" id="cancel-add" value="Cancel">
                                <button class="btn btn-primary me-3" type="button" id="store">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gaming Theme Modal Edit -->
    <div class="modal fade game-modal" id="edit-data-modal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content game-modal-content">
                <div class="modal-header game-modal-header">
                    <div class="header-content">
                        <h4 class="modal-title game-title">
                            <span class="title-text">EDIT UNIT</span>
                        </h4>
                    </div>
                    <button class="game-close-btn" type="button" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        <span class="close-effect"></span>
                    </button>
                </div>

                <div class="modal-body game-modal-body">

                    <form id="editUnitForm" class="game-form">
                        <input type="hidden" id="id" class="game-input-hidden">

                        <div class="game-form-group">
                            <label class="game-label">
                                <i class="fas fa-tag label-icon"></i>
                                <span>NAMA UNIT</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="game-input-wrapper">
                                <input type="text" class="game-input" id="edit_name"
                                    placeholder="Masukkan nama unit..." maxlength="50">
                                <div class="input-decoration">
                                    <i class="fas fa-cube"></i>
                                </div>
                                <div class="input-glow"></div>
                            </div>
                            <div class="input-stats">
                                <span class="char-count"><span id="name-count">0</span>/50</span>
                                <span class="input-hint">Required</span>
                            </div>
                        </div>

                        <div class="game-form-group">
                            <label class="game-label">
                                <i class="fas fa-gamepad label-icon"></i>
                                <span>TYPE UNIT</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="game-select-wrapper">
                                <select class="game-select" id="edit_type">
                                    <option value="PS3" data-icon="🎮">Play Station 3</option>
                                    <option value="PS4" data-icon="🎯">Play Station 4</option>
                                </select>
                                <div class="select-decoration">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="select-options-bg"></div>
                            </div>
                            <div class="select-stats mt-2">
                                <span class="select-info" style="color: #a0aec0">
                                    <i class="fas fa-info-circle"></i>
                                    Pilih tipe konsol
                                </span>
                            </div>
                        </div>

                        <div class="game-form-group">
                            <label class="game-label">
                                <i class="fas fa-coins label-icon"></i>
                                <span>HARGA PER JAM</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="game-input-wrapper price-wrapper">
                                <span class="price-prefix">RP</span>
                                <input type="number" class="game-input price-input" id="edit_price" placeholder="0"
                                    min="0" step="1000">
                                <div class="price-suffix">/Jam</div>
                            </div>
                            <div class="input-stats">
                                <span class="price-hint">
                                    <i class="fas fa-bolt"></i>
                                    Minimal Rp 1.000
                                </span>
                                <span class="price-value" id="price-display">Rp 0</span>
                            </div>
                        </div>

                        <div class="unit-preview-section">
                            <div class="preview-title">
                                <i class="fas fa-eye"></i>
                                <span>PREVIEW UNIT</span>
                            </div>
                            <div class="preview-card" id="unitPreview">
                                <div class="preview-character">
                                    <i class="fas fa-user-astronaut"></i>
                                </div>
                                <div class="preview-details">
                                    <span class="preview-name" id="previewName">-</span>
                                    <span class="preview-type" id="previewType">-</span>
                                    <span class="preview-price" id="previewPrice">-</span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer game-modal-footer">
                    <button class="game-btn game-btn-cancel" data-bs-dismiss="modal" id="cancelBtn">
                        <i class="fas fa-shield-halved"></i>
                        <span>BATAL</span>
                        <div class="btn-overlay"></div>
                    </button>

                    <button class="game-btn game-btn-primary" type="button" id="update">
                        <i class="fas fa-hammer"></i>
                        <span>UPDATE UNIT</span>
                        <div class="btn-glow"></div>
                        <div class="btn-sparks"></div>
                    </button>

                    <button class="game-btn game-btn-danger" type="button" id="delete">
                        <i class="fas fa-skull-crossbones"></i>
                        <span>HAPUS</span>
                        <div class="btn-overlay"></div>
                        <div class="btn-blood-effect"></div>
                    </button>
                </div>

                <div class="level-up-effect"></div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-alert" id="alert" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenter1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img id="alert-image"></li>
                        </ul>
                        <h4 class="text-center pb-2" id="alert-title"></h4>
                        <p class="text-center" id="alert-message"></p>
                        <button class="btn btn-secondary d-flex m-auto" id="is-error" type="button"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="modal-toggle-wrapper">
                        <ul class="modal-img">
                            <li> <img id="alert-image" src="{{ asset('own_assets/icon/confirm.gif') }}" width="300px">
                            </li>
                        </ul>
                        <h4 class="text-center pb-2" id="alert-title">Hapus Data</h4>
                        <p class="text-center" id="alert-message">Apakah anda yakin ingin menghapus data?</p>
                        <div class="row">
                            <div class="col-md-6 d-flex justify-content-end">
                                <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                            </div>
                            <div class="col-md-6 d-flex justify-content-start">
                                <button class="btn btn-danger" id="delete-confirmed" type="button"
                                    data-bs-dismiss="modal">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('own_script')
    <script src="{{ asset('own_assets/scripts/unit.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/range-slider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/range-slider/rangeslider-script.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/touchspin/vendors.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/touchspin/touchspin.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/touchspin/input-groups.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/product-tab.js') }}"></script>
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('preview-foto');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('d-none');
            }
        });
    </script>

    <script>
        // Live Preview Update
        document.getElementById('edit_name').addEventListener('input', function(e) {
            document.getElementById('previewName').textContent = e.target.value || '-';
            document.getElementById('name-count').textContent = e.target.value.length;
        });

        document.getElementById('edit_type').addEventListener('change', function(e) {
            const type = e.target.value;
            const typeText = type === 'PS4' ? 'PS4 - Standard Edition' : 'PS5 - Pro Edition';
            document.getElementById('previewType').textContent = typeText;

            // Update icon based on type
            const previewChar = document.querySelector('.preview-character i');
            if (type === 'PS5') {
                previewChar.className = 'fas fa-crown';
            } else {
                previewChar.className = 'fas fa-user-astronaut';
            }
        });

        document.getElementById('edit_price').addEventListener('input', function(e) {
            const price = e.target.value || 0;
            const formattedPrice = 'Rp ' + new Intl.NumberFormat('id-ID').format(price);
            document.getElementById('previewPrice').textContent = formattedPrice;
            document.getElementById('price-display').textContent = formattedPrice;
        });

        // Mouse move effect untuk level up
        document.querySelector('.game-modal-content').addEventListener('mousemove', function(e) {
            const rect = this.getBoundingClientRect();
            const x = ((e.clientX - rect.left) / rect.width) * 100;
            const y = ((e.clientY - rect.top) / rect.height) * 100;
            this.style.setProperty('--x', x + '%');
            this.style.setProperty('--y', y + '%');
        });
    </script>
@endsection
