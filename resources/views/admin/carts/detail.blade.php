@extends('admin.main')

@section('content')
    <div class="customer">
        <ul>
            <li>Tên khách hàng:<strong>{{ $order->order_name }}</strong></li>
            <li>Số điện thoại:<strong>{{ $order->order_phone }}</strong></li>
            <li>Địa chỉ:<strong>{{ $order->order_address }}</strong></li>
            <li>Email:<strong>{{ $order->order_email }}</strong></li>
            {{-- <li>Ghi chú:<strong>{{ $order->content }}</strong></li> --}}
        </ul>
    </div>
    <div class="carts">
        @php
            $total = 0;
        @endphp
        <table class="table">
            <tbody>
                <tr class="table_head">
                    <th class="column-1">Product</th>
                    <th class="column-2">Tên</th>
                    <th class="column-3">Price</th>
                    <th class="column-4">Quantity</th>
                    <th class="column-5">Coupon Code</th>
                    <th class="column-6">Total</th>
                </tr>


                @foreach ($carts as $key => $item)
                    @php
                            $price= $item->price * $item->pty;
                            $total += $price;
                    @endphp
                    <tr class="table_row">
                        <td class="column-1">
                            <div class="how-itemcart1">
                                <img src="{{$item->product->thumb}}" alt="IMG" width="100">
                            </div>
                        </td>
                        <td class="column-2">{{ $item->product->name }}</td>
                        <td class="column-3">{{ number_format($item->product->price, 0, '.') }}đ</td>
                        <td class="column-4">
                            {{$item->pty}}
                        </td>
                        <td class="column-5">{{ $item->coupon_code!=null?$item->coupon_code:"none" }}</td>
                        <td class="column-6">{{ number_format($price, 0, '.') }}đ</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Tổng tiền</td>
                    <td colspan="3">{{ number_format($total, 0, '.') }}đ</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
