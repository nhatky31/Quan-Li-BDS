@extends('admin.layout')

@section('content')

    <div style="background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        
        @if ($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border: 1px solid #f5c6cb; border-radius: 5px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border: 1px solid #c3e6cb; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="color: #333; margin: 0;">Danh Sách Bất Động Sản</h2>
            <a href="/admin/batdongsan/create" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold;">+ Thêm BĐS</a> 
        </div>

        <div style="display: flex; gap: 15px; margin-bottom: 20px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #e9ecef;">
            <div style="flex: 2;">
                <label style="font-weight: bold; margin-bottom: 5px; display: block; color: #333;">Tìm kiếm tự do:</label>
                <input type="text" id="searchInputBDS" placeholder="🔍 Nhập tên chủ sở hữu hoặc vị trí (quận, đường)..." style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
            </div>
            <div style="flex: 1;">
                <label style="font-weight: bold; margin-bottom: 5px; display: block; color: #333;">Lọc theo tình trạng:</label>
                <select id="statusFilterBDS" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; cursor: pointer;">
                    <option value="all">-- Tất cả tình trạng --</option>
                    <option value="đang">🟢 Đang trống / Đang giao dịch</option>
                    <option value="đã bán">🔴 Đã bán</option>
                </select>
            </div>
        </div>

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Hình ảnh</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Chủ sở hữu</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Vị trí</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Diện tích</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Đơn giá</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Tình trạng</th>
                    <th style="background-color: #0056b3; color: white; border: 1px solid #ddd; padding: 12px; text-align: left;">Tác vụ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($danhsachBDS as $bds)
                <tr style="border-bottom: 1px solid #ddd;">
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        @if($bds->hinhanh)
                          <img src="data:image/jpeg;base64,{{ $bds->hinhanh }}" width="80" height="80" style="object-fit: cover; border-radius: 4px; border: 1px solid #ccc;">
                        @else
                            <span style="color: #999; font-style: italic;">Không có ảnh</span>
                        @endif
                    </td>
                    <td style="border: 1px solid #ddd; padding: 12px;"><b>{{ $bds->hoten }}</b></td>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{ $bds->tenduong }}, {{ $bds->quan }}</td>
                    <td style="border: 1px solid #ddd; padding: 12px;">{{ $bds->dientich }} m²</td>
                    <td style="border: 1px solid #ddd; padding: 12px; color: red; font-weight: bold;">{{ number_format($bds->dongia) }} VNĐ</td>
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        @if($bds->tinhtrang == 1)
                            <span style="color: green; font-weight: bold;">Đang trống</span>
                        @else
                            <span style="color: gray; font-weight: bold;">Đã bán</span>
                        @endif
                    </td>
                    <td style="border: 1px solid #ddd; padding: 12px;">
                        <a href="/admin/batdongsan/show/{{ $bds->bdsid }}" style="color: #17a2b8; font-weight: bold; text-decoration: none; margin-right: 10px;">👁️ Xem</a>
                        @if($bds->tinhtrang == 1)
                            <a href="/admin/batdongsan/edit/{{ $bds->bdsid }}" style="color: #ffc107; font-weight: bold; text-decoration: none; margin-right: 10px;">Sửa</a>
                            <a href="/admin/batdongsan/delete/{{ $bds->bdsid }}" style="color: #dc3545; font-weight: bold; text-decoration: none;" onclick="return confirm('Bạn có chắc chắn muốn xóa BĐS này?')">Xóa</a>
                        @else
                            <span style="color: #999; font-size: 13px; font-style: italic; background: #e9ecef; padding: 4px 8px; border-radius: 4px; display: inline-block; margin-top: 5px;">🔒 Đã khóa</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInputBDS');
    const statusFilter = document.getElementById('statusFilterBDS');
    
    const tableRows = document.querySelectorAll('table tbody tr');

    function filterBDS() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusTerm = statusFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const ownerName = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
            const location = row.cells[2] ? row.cells[2].textContent.toLowerCase() : '';
            const status = row.cells[5] ? row.cells[5].textContent.toLowerCase().trim() : '';

            const matchesSearch = ownerName.includes(searchTerm) || location.includes(searchTerm);
            
            let matchesStatus = true;
            if (statusTerm !== 'all') {
                matchesStatus = status.includes(statusTerm);
            }

            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterBDS);
    statusFilter.addEventListener('change', filterBDS);
});
</script>

@endsection