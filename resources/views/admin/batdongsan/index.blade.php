<!DOCTYPE html>
<html>
<head>
    <title>Bất động sản</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f6f8;
        }

        .container {
            width: 90%;
            margin: 30px auto;
        }

        .btn-add {
            background: linear-gradient(to right, #e0b400, #f5d142);
            padding: 12px 20px;
            border-radius: 10px;
            color: black;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        /* GRID CARD */
        .grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }

        .card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        .card-body {
            padding: 15px;
        }

        .title {
            font-weight: bold;
            margin-bottom: 8px;
        }

        .price {
            color: #d4a800;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .info {
            font-size: 14px;
            color: #555;
            margin-bottom: 6px;
        }

        .badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dcfce7;
            color: #16a34a;
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
        }

        .badge.sold {
            background: #dbeafe;
            color: #2563eb;
        }

        .card-top {
            position: relative;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .btn {
            flex: 1;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-view {
            border: 1px solid #ccc;
            color: black;
        }

        .btn-edit {
            background: #f5e6c8;
            color: #d4a800;
        }
    </style>
</head>

<body>

<div class="container">

    <a href="/admin/batdongsan/create" class="btn-add">+ Thêm bất động sản</a>

    <div class="grid">

        @foreach($data as $bds)
        <div class="card">

            <!-- ẢNH -->
            <div class="card-top">
                @if($bds->hinhanh)
                    <img src="data:image/jpeg;base64,{{ base64_encode($bds->hinhanh) }}">
                @else
                    <img src="https://via.placeholder.com/300x180">
                @endif

                <!-- TRẠNG THÁI -->
                @if($bds->tinhtrang == 1)
                    <div class="badge sold">Đã bán</div>
                @else
                    <div class="badge">Còn trống</div>
                @endif
            </div>

            <!-- BODY -->
            <div class="card-body">

                <!-- TIÊU ĐỀ -->
                <div class="title">
                    {{ $bds->masoqsdd }}
                </div>

                <!-- GIÁ -->
                <div class="price">
                    {{ number_format($bds->dongia) }} đ
                </div>

                <!-- ĐỊA CHỈ -->
                <div class="info">
                    📍 {{ $bds->sonha }}, {{ $bds->tenduong }}, {{ $bds->quan }}
                </div>

                <!-- DIỆN TÍCH -->
                <div class="info">
                    📐 {{ $bds->dientich }} m²
                </div>

                <!-- BUTTON -->
                <div class="actions">

                    <a href="/admin/batdongsan/show/{{ $bds->bdsid }}" class="btn btn-view">
                        👁 Xem
                    </a>

                    <a href="/admin/batdongsan/edit/{{ $bds->bdsid }}" class="btn btn-edit">
                        ✏️ Sửa
                    </a>

                    <form action="/admin/batdongsan/delete/{{ $bds->bdsid }}" method="POST">
                        @csrf
                        <button class="btn" style="background:#fee2e2;color:red;border:none;">
                            🗑️
                        </button>
                    </form>

                </div>

            </div>

        </div>
        @endforeach

    </div>

</div>

</body>
</html>