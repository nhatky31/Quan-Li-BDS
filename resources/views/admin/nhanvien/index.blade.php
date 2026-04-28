<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Nhân viên</title>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 30px; margin: 0; }
        .container { background: #fff; padding: 25px; border-radius: 8px; max-width: 1000px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h2 { color: #333; margin: 0; }
        .nav-links a { text-decoration: none; margin-right: 15px; color: #0056b3; font-weight: bold; }
        .btn-add { background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 4px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #0056b3; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .action-links a { margin-right: 10px; text-decoration: none; font-weight: bold; }
        .edit { color: #ffc107; }
        .delete { color: #dc3545; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <div class="nav-links">
                <a href="/admin/dashboard">⬅ Về Trang chủ</a>
            </div>
            <a href="/logout" style="color: #dc3545; font-weight: bold; text-decoration: none;">Đăng xuất</a>
        </div>

        <div class="header" style="margin-top: 30px;">
            <h2>Danh sách Nhân viên</h2>
            <a href="/admin/nhanvien/create" class="btn-add">+ Thêm Nhân Viên Mới</a> 
        </div>
<div style="display: flex; gap: 15px; margin-bottom: 20px; background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #e9ecef;">
    <div style="flex: 2;">
        <input type="text" id="searchInput" placeholder="🔍 Nhập tên, tài khoản hoặc mã nhân viên..." style="width: 100%; padding: 10px 15px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px;">
    </div>
    <div style="flex: 1;">
        <select id="statusFilter" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 15px; cursor: pointer;">
            <option value="all">-- Tất cả trạng thái --</option>
            <option value="Hoạt động">🟢 Hoạt động</option>
            <option value="Đã khóa">🔴 Đã khóa</option>
        </select>
    </div>
</div>
        <table>
            <thead>
                <tr>
                    <th>Mã NV</th>
                    <th>Tài khoản</th>
                    <th>Họ tên</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @foreach($danhsachNV as $nv)
                <tr>
                    <td>{{ $nv->nvid }}</td>
                    <td>{{ $nv->taikhoan }}</td>
                    <td>{{ $nv->tennv }}</td>
                    <td>
                        @if($nv->trangthai == 1)
                            <span style="color: green; font-weight: bold;">Hoạt động</span>
                        @else
                            <span style="color: red;">Đã khóa</span>
                        @endif
                    </td>
                    <td class="action-links">
                     <a href="/admin/nhanvien/edit/{{ $nv->nvid }}" class="edit">Sửa</a>
                     <a href="/admin/nhanvien/delete/{{ $nv->nvid }}" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa nhân viên này không?')">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    // Lấy tất cả các dòng dữ liệu trong bảng (bỏ qua phần thead)
    const tableRows = document.querySelectorAll('table tbody tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusTerm = statusFilter.value;

        tableRows.forEach(row => {
            // Lấy toàn bộ chữ trong dòng để tìm kiếm (tên, tài khoản, mã)
            const rowText = row.textContent.toLowerCase();
            
            // Lấy cột trạng thái (Dựa vào hình ảnh của bạn, nó nằm ở cột thứ 4, index = 3)
            // Nếu cột trạng thái của bạn nằm ở vị trí khác, hãy đổi số 3 thành số tương ứng nhé (0 là cột đầu tiên)
            const statusCell = row.cells[3] ? row.cells[3].textContent.trim() : '';

            // Kiểm tra xem dòng này có khớp với ô tìm kiếm không
            const matchesSearch = rowText.includes(searchTerm);
            
            // Kiểm tra xem dòng này có khớp với dropdown trạng thái không
            const matchesStatus = (statusTerm === 'all') || (statusCell === statusTerm);

            // Nếu khớp cả 2 điều kiện thì hiện, không thì ẩn
            if (matchesSearch && matchesStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Lắng nghe sự kiện gõ phím và thay đổi dropdown
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
});
</script>
</body>
</html>