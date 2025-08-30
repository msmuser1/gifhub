<?php 
$options_header = ['title' => 'Fake QR-Code Căn Cước Công Dân Quét Được Qua Zalo Miễn Phí','description'=>'Tool fake qr code cccd quét được qua zalo miễn phí'];
require_once($_SERVER['DOCUMENT_ROOT'].'/include/head.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/include/nav.php'); 

// Khởi tạo biến để chứa thông tin QR code sau khi người dùng gửi form
$qr_code_generated = false;
$qr_code_url = '';
$error_message = ''; // Biến lưu thông báo lỗi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Thu thập thông tin từ form
    $so_cccd = $_POST['so-cccd'];
    $so_cmnd = $_POST['so-cmnd'];
    $hovaten = $_POST['hovaten'];
    $ngaysinh = $_POST['ngaysinh'];
    $gioitinh = $_POST['gioitinh']; // Cần bổ sung trường giới tính trong form
    $noithuongtru = $_POST['noithuongtru'];
    $ngaycap = $_POST['ngaycap'];

    // Kiểm tra dữ liệu có hợp lệ không
    if (empty($so_cccd) || empty($so_cmnd) || empty($hovaten) || empty($ngaysinh) || empty($noithuongtru) || empty($ngaycap) || empty($gioitinh)) {
        $error_message = 'Vui lòng nhập đầy đủ thông tin.';
    } else {
        // Tạo chuỗi dữ liệu theo định dạng yêu cầu của API
        $data = urlencode("$so_cccd|$so_cmnd|$hovaten|$ngaysinh|$gioitinh|$noithuongtru|$ngaycap");

        // Tạo URL API với dữ liệu đã mã hóa
        $api_url = "https://wusteam.com/api/qr-code?data=$data&size=300x300";

        // Gửi yêu cầu GET tới API để lấy mã QR
        $qr_code_url = $api_url;

        // Đánh dấu là đã tạo mã QR thành công
        $qr_code_generated = true;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Mã QR CCCD</title>
    <style>
        .btn-outline-light {
            color: white !important;
            border-color: #1a915a !important;
        }

        .btn-outline-light:hover {
            background-color: #073b30 !important;
            border-color: #00815d !important;
        }

        .error-message {
            color: red;
            font-weight: bold;
        }
        
        /* Ẩn QR code và loading khi chưa tạo */
        .qr-container {
            display: none;
        }

        .qr-container.show {
            display: block;
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <div class="flex-grow-1 container-p-y container-fluid">
        <h4 class="py-3 breadcrumb-wrapper mb-4">
            <span class="text-red-800 fw-light">Hệ Thống Fake CCCD /</span> QR Code
        </h4>

        <div class="row justify-content-center">
            <div class="col-sm-12 col-md-10">
                <form method="POST">
                    <div class="card mb-4 thanhdieu-card-bg thanhdieu-border-card">
                        <h5 class="card-header text-red-800">
                            <i class="ri-qr-code-line me-2"></i>Tạo Mã QR-CCCD
                        </h5>
                        <div class="card-body d-flex flex-column flex-md-row">
                            <div class="col-md-8">
                                <?php if ($error_message): ?>
                                    <div class="alert alert-danger error-message">
                                        <?= $error_message ?>
                                    </div>
                                <?php endif; ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="so-cccd" class="form-label">Số CCCD</label>
                                            <input type="number" class="form-control" name="so-cccd" placeholder="eg: 0402 0302 5635" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hovaten" class="form-label">Họ Và Tên</label>
                                            <input type="text" class="form-control" name="hovaten" placeholder="eg: Nguyen Van A" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="so-cmnd" class="form-label">Số CMND</label>
                                            <input type="number" class="form-control" name="so-cmnd" placeholder="eg: 504 898 806" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="noithuongtru" class="form-label">Nơi Thường Trú</label>
                                            <input type="text" class="form-control" name="noithuongtru" placeholder="eg: Xóm Hòa Sơn, Nghệ An" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ngaysinh" class="form-label">Ngày Sinh</label>
                                            <input type="date" class="form-control" name="ngaysinh" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="ngaycap" class="form-label">Ngày Cấp CCCD</label>
                                            <input type="date" class="form-control" name="ngaycap" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="gioitinh" class="form-label">Giới Tính</label>
                                            <select class="form-control" name="gioitinh" required>
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                                <option value="Khác">Khác</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center text-nowrap">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-check-line me-2"></i>Xác Nhận
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-center">
                                <div class="shadow-cccd card-body text-center qr-container <?php echo $qr_code_generated ? 'show' : ''; ?>">
                                    <?php if ($qr_code_generated): ?>
                                        <!-- Hiển thị mã QR -->
                                        <img src="<?= $qr_code_url ?>" alt="QR CCCD" class="img-fluid">
                                        <a href="<?= $qr_code_url ?>" download class="qrcode-img btn btn-outline-light mt-3">
                                            <i class="ri-download-line"></i>&ensp;Tải Xuống
                                        </a>
                                    <?php else: ?>
                                        <img src="loading.gif" alt="Đang tạo mã QR" class="img-fluid">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>

<?php require_once ($_SERVER['DOCUMENT_ROOT'] . '/include/foot.php'); ?>
