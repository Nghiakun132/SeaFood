@extends('layouts.backend')
@section('content')
@section('title', 'Sản phẩm')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Thống kê</h1>
    <div class="row">
        <div class="col-xl-12 col-lg-12">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <span class="m-0 font-weight-bold text-primary">Thống kê doanh thu</span>
                    <div class="dropdown" style="float: right">
                        <button class="btn btn-primary dropdown-toggle btn-sm" type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            Thống kê theo
                        </button>
                        <div class="dropdown-menu animated--fade-in"
                            aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="{{Request::URL()}}">Mặc định</a>
                            <a class="dropdown-item" href="{{Request::URL()}}?thong_ke=7_ngay">7 ngày gần nhất</a>
                            <a class="dropdown-item" href="{{Request::URL()}}?thong_ke=thang">Tháng gần nhất</a>
                            <a class="dropdown-item" href="{{Request::URL()}}?thong_ke=nam">Năm</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="myBarChart"></canvas>
                    </div>
                    <hr>
                    Styling for the bar chart can be found in the
                    <code>/js/demo/chart-bar-demo.js</code> file.
                </div>
            </div>
        </div>
    </div>

</div>
<script src="{{ asset('backend/vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('backend/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('backend/js/demo/chart-pie-demo.js') }}"></script>
<script src="{{ asset('backend/js/demo/chart-bar-demo.js') }}"></script>
<?php
$success = Session::get('success');
if ($success) {
    echo "<script>alert('$success')</script>";
    Session::forget('success');
}
?>
@stop
