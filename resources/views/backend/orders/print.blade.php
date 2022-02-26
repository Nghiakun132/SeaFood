<!DOCTYPE html>
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hóa đơn bán hàng</title>
    <link rel="stylesheet" href="{{ asset('backend/css/sb-admin-2.css') }}">
</head>
<style>
    body{
        font-family: DejaVu Sans, sans-serif;
    }
</style>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>Nghĩa Kun</h4>
                <h5>Địa chỉ: Hưng Lợi, Tân Hưng, Bình Tân, Vĩnh Long</h5>
                <h2>HOA DON BAN HANG</h2>
            </div>
            {{-- <div class="col-md-6"> --}}
            {{-- </div> --}}
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Tên khách hàng:{{$orders->name}}</h5>
            </div>
            <div class="col-md-12">
                <h5>Địa chỉ:{{$orders->address}}</h5>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @foreach ($order_details as $order_details)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $order_details->pro_name }}</td>
                                    <td>{{ $order_details->product_quantity }}</td>
                                    <td>{{ number_format($order_details->product_price, 0, ',', ',') . ' VND' }}</td>
                                    <td>{{ number_format($order_details->product_price * $order_details->product_quantity, 0, ',', ',') . ' VND' }}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">Tổng tiền</td>
                                <td>{{ number_format($sum, 0, ',', ',') . ' VND' }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mt-2">
                <h5>Thành tiền (chữ): <b>{{$money}}</b> đồng</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h5>Ngày {{$day}} Tháng {{$month}} Năm  {{$year}}</h5>
                <h6>NGƯỜI BÁN HÀNG</h6>
            </div>
        </div>
</body>

</html>
