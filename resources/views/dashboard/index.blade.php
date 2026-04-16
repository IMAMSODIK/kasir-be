@extends('layouts.template')

@section('own_style')
@endsection

@section('content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6">
                    <h4>{{$pageTitle}}</h4>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">
                                <svg class="stroke-icon">
                                    <use href="{{ asset('dashboard_assets/assets/svg/icon-sprite.svg#stroke-home') }}">
                                    </use>
                                </svg></a></li>
                        <li class="breadcrumb-item">{{$pageTitle}}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- user information --}}
    @if (auth()->user()->role == 'admin')
        <div class="card">
            <div class="card-header">
                <h5>Users Information</h5>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <div class="row size-column">
                        <div class="row">
                            <div class="col-xl-3 col-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-project border-b-primary border-2"><span
                                            class="f-light f-w-500 f-14">Total Unit</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h2 class="f-w-600">0</h2> <small
                                                    class="f-light f-w-500 f-14">(Unit)</small>
                                            </div>
                                            <div class="product-sub bg-primary-light">
                                                <i class="fa fa-users text-dark"></i>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-6">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-Progress border-b-warning border-2"> <span
                                            class="f-light f-w-500 f-14">Total Unit</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h2 class="f-w-600">0</h2>
                                                <small class="f-light f-w-500 f-14">(Unit)</small>
                                            </div>
                                            <div class="product-sub bg-warning-light">
                                                <i class="fa fa-user-secret text-dark" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-6" style="cursor: pointer" onclick="location.href = '/teacher'">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-Complete border-b-secondary border-2"><span
                                            class="f-light f-w-500 f-14">Total Unit</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h2 class="f-w-600">0</h2>
                                                <small class="f-light f-w-500 f-14">(Unit)</small>
                                            </div>
                                            <div class="product-sub bg-secondary-light">
                                                <i class="fa fa-chalkboard-teacher text-dark" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"> </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-6" style="cursor: pointer" onclick="location.href = '/students'">
                                <div class="card o-hidden small-widget">
                                    <div class="card-body total-upcoming"><span class="f-light f-w-500 f-14">Total
                                            Unit</span>
                                        <div class="project-details">
                                            <div class="project-counter">
                                                <h2 class="f-w-600">0</h2>
                                                <small class="f-light f-w-500 f-14">(Unit)</small>
                                            </div>
                                            <div class="product-sub bg-light-light">
                                                <i class="fa fa-user-graduate text-dark"></i>
                                            </div>
                                        </div>
                                        <ul class="bubbles">
                                            <li class="bubble"> </li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                            <li class="bubble"></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        <div class="row size-column">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
                    <i class="fa fa-exclamation-circle me-2"></i>
                    {{ session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Session Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detailModalContent">
                    <div class="p-5 text-center">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('own_script')
    <script src="{{ asset('dashboard_assets/assets/js/chart/echart/esl.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/chart/echart/pie-chart/facePrint.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/chart/echart/pie-chart/testHelper.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/chart/echart/pie-chart/custom-transition-texture.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/chart/echart/data/symbols.js') }}"></script>

    <script src="{{ asset('dashboard_assets/assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('dashboard_assets/assets/js/dashboard/dashboard_3.js') }}"></script>
@endsection
