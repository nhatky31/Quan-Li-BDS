<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết BĐS</title>

    <style>
        body {
            font-family: Arial;
            background: #f5f6f8;
        }

        .container {
            width: 70%;
            margin: 30px auto;
            background: white;
            border-radius: 16px;
            padding: 20px;
        }

        img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin: 15px 0;
        }

        .price {
            font-size: 26px;
            color: #d4a800;
            font-weight: bold;
        }

        .info {
            margin: 10px 0;
            color: #555;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 10px;
            margin-right: 10px;
            font-size: 13px;
        }

        .type {
            background: #eee;
        }

        .status {
            background: #dbeafe;
            color: #2563eb;
        }

        .status.free {
            background: #dcfce7;
            color: #16a34a;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- ẢNH -->
    @if($bds->hinhanh)
        <img src="data:image/jpeg;base64,{{ base64_encode($bds->hinhanh) }}">
    @else
        <img src="https://via.placeholder.com/600x300">
    @endif

    <!-- TIÊU ĐỀ -->
    <div class="title">
        {{ $bds->masoqsdd }}
    </div>

    <!-- BADGE -->
    <div>
        <span class="badge type">BĐS</span>

        @if($bds->tinhtrang == 1)
            <span class="badge status">Đã ký gửi</span>
        @else
            <span class="badge status free">Còn trống</span>
        @endif
    </div>

    <!-- GIÁ -->
    <div class="price">
        {{ number_format($bds->dongia) }} đ
    </div>

    <!-- THÔNG TIN -->
    <div class="info">
        📐 {{ $bds->dientich }} m²
    </div>

    <div class="info">
        📍 {{ $bds->sonha }}, {{ $bds->tenduong }}, {{ $bds->quan }}
    </div>

    <!-- MÔ TẢ -->
    <div class="info">
        <b>Mô tả:</b><br>
        {{ $bds->mota }}
    </div>

</div>

</body>
</html>