@extends('layouts.template')

@section('own_style')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{ $pageTitle }}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dashboard_assets/assets/svg/icon-sprite.svg#stroke-home') }}">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
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
            <ul class="nav nav-tabs" id="myTab">
                <li class="nav-item">
                    <button class="nav-link active" id="user-tab" data-bs-toggle="tab" data-bs-target="#user">
                        Data Kategori
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail">
                        Arsip Terhapus
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3">
                <!-- TAB 1 -->
                <div class="tab-pane fade show active" id="user">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-primary" id="tambah-data" style="margin-right: 5px">
                                        <i class="fa fa-plus-circle me-2"></i> Tambah Data
                                    </button>
                                    <button class="btn btn-info refresh-data" data-table="data" style="margin-right: 5px">
                                        <i class="fa fa-refresh me-2" aria-hidden="true"></i> Refresh Data
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="dataTable" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Icon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2 -->
                <div class="tab-pane fade" id="detail">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-info refresh-data" data-table="trash" style="margin-right: 5px">
                                        <i class="fa fa-refresh me-2" aria-hidden="true"></i> Refresh Data
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table id="dataTableTrash" class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Icon</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="modal fade" id="modalCreate" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formCreate">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_kategori">Nama Kategori (Wajib diisi)</label>
                            <input type="text" name="nama_kategori" class="form-control"
                                placeholder="Masukkan nama kategori">
                            <small class="text-danger error-nama_kategori"></small>
                        </div>

                        <div class="mb-3">
                            <label>Icon</label>
                            <input type="file" name="icon" class="form-control" id="icon">
                            <div class="mt-2">
                                <img id="preview-icon" src="" alt="Preview"
                                    style="max-width: 150px; display: none; border-radius: 8px;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEdit">
                    <input type="hidden" name="id" id="edit_id">

                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="edit_nama_kategori">Nama Kategori (Wajib diisi)</label>
                            <input type="text" id="edit_nama_kategori" name="edit_nama_kategori" class="form-control"
                                placeholder="Masukkan nama kategori">
                            <small class="text-danger error-edit_nama_kategori"></small>
                        </div>

                        <div class="mb-3">
                            <label>Icon</label>
                            <input type="file" name="edit_icon" class="form-control" id="edit_icon">
                            <div class="mt-2">
                                <img id="preview-edit_icon" src="" alt="Preview"
                                    style="max-width: 150px; display: none; border-radius: 8px;">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('own_script')
    <script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
    <script src="{{ asset('own_assets/scripts/kategori_menu.js') }}"></script>
@endsection
