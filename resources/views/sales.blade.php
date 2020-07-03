<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Books store - Sale List</title>

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            /*text-align: center;*/
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">

    <div class="content">
        @if (session('success'))
            <div class="row">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
            <hr>
        @endif
        <div class="row">
            <form method="post" action="{{ route('sales') }}">
                @csrf
                <div class="">
                    <div class="form-group">
                        <select name="customer_id" class="form-control">
                            <option value>All customers</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="product_id" class="form-control">
                            <option value>All Products</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="customRange3">Price filter</label>
                        <input type="text" name="price_from" class="form-control" placeholder="From">
                        <input type="text" name="price_to" class="form-control" placeholder="To">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Price</th>
                    <th>Date Origin</th>
                    <th>Date Updated</th>
                </tr>
                @if($sales)
                    @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->id }}</td>
                            <td>{{ $sale->product->product_name }}</td>
                            <td>{{ $sale->customer->customer_name }}</td>
                            <td>{{ $sale->price }}</td>
                            <td>{{ $sale->sale_date }}</td>
                            <td>{{ $sale->new_date }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th colspan="5">Total</th>
                        <td><strong>{{ $salesSum }}</strong></td>
                    </tr>
                    <tr>
                        <th colspan="5">Results Count</th>
                        <td><strong>{{ $saleTotal }}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="6">There is no sales</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
</div>
</body>
</html>
