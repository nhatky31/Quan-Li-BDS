<!DOCTYPE html>
<html>
<head>
    <title>Khách hàng</title>
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

        .card {
            background: white;
            border-radius: 12px;
            padding: 15px;
        }

        .header, .row {
            display: grid;
            grid-template-columns: 2fr 2fr 2fr 1fr 1fr;
            align-items: center;
            padding: 15px 10px;
        }

        .header {
            font-weight: bold;
            color: #555;
            border-bottom: 1px solid #ddd;
        }

        .row {
            border-bottom: 1px solid #eee;
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: #d4a800;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }

        .flex {
            display: flex;
            align-items: center;
        }

        .badge {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
            display: inline-block;
        }

        .buy {
            background: #dbeafe;
            color: #2563eb;
        }

        .sell {
            background: #dcfce7;
            color: #16a34a;
        }

        .both {
            background: #ede9fe;
            color: #7c3aed;
        }

        .actions i {
            margin: 0 8px;
            cursor: pointer;
        }

        .edit { color: orange; }
        .delete { color: red; }
        .view { color: blue; }

    </style>
</head>
<body>

<div class="container">

    <a href="/admin/khachhang/create" class="btn-add">+ Thêm khách hàng</a>

    <div class="card">

        <div class="header">
            <div>KHÁCH HÀNG</div>
            <div>LIÊN HỆ</div>
            <div>ĐỊA CHỈ</div>
            <div>LOẠI</div>
            <div>THAO TÁC</div>
        </div>

        @foreach($data as $kh)
        <div class="row">

            <!-- KHÁCH HÀNG -->
            <div class="flex">
                <div class="avatar">
                    {{ strtoupper(substr($kh->hoten, 0, 1)) }}
                </div>
                <div>
                    <div><b>{{ $kh->hoten }}</b></div>
                    <small>ID: {{ $kh->khid }}</small>
                </div>
            </div>

            <!-- LIÊN HỆ -->
            <div>
                <div>📧 {{ $kh->email }}</div>
                <div>📞 {{ $kh->sodienthoai }}</div>
            </div>

            <!-- ĐỊA CHỈ -->
            <div>
                📍 {{ $kh->diachi }}
            </div>

            <!-- LOẠI -->
            <div>
                @if($kh->loaikh == 1)
                    <span class="badge buy">Người mua</span>
                @else
                    <span class="badge sell">Người bán</span>
                @endif
            </div>

            <!-- THAO TÁC -->
            <div class="actions">

                <a href="/admin/khachhang/edit/{{ $kh->khid }}">
                    <i class="edit">✏️</i>
                </a>

                <form action="/admin/khachhang/delete/{{ $kh->khid }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="border:none;background:none;">
                        <i class="delete">🗑️</i>
                    </button>
                </form>

            </div>

        </div>
        @endforeach

    </div>

</div>

</body>
</html>