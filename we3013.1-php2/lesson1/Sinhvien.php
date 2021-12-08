<?php
class sinhVien{
    var $ten;
    var $maSinhVien;
    var $soDuTaiKhoan = 0;
    var $lop;
    var $namNhapHoc = 2021;
    
    function nhap_hoc($ten, $maSinhVien, $lop)
    {
        $this->ten = $ten;
        $this->maSinhVien = $maSinhVien;
        $this->lop = $lop;
    }

    function chuyen_lop($lop){
        $this->lop = $lop;
    }

    function display_data()
    {
        echo"
	<table class=\"table table-bordered\">
		<tbody>
			<tr>
				<td><b>Tên</b></td>
				<td><b>Lớp</b></td>
				<td><b>Mã sinh viên</b></td>
				<td><b>Số dư tài khoản</b></td>
				<td><b>Năm nhập học</b></td>
			</tr>
			<tr>
				<td>$this->ten</td>
				<td>$this->lop</td>
				<td>$this->maSinhVien</td>
                <td>$this->soDuTaiKhoan</td>
                <td>$this->namNhapHoc</td>
			</tr>
		</tbody>
	</table>";
    }
}

$ngoc = new sinhVien();
$ngoc->nhap_hoc("Trương Khánh Ngọc", "PH11120", "web15302");
$ngoc->chuyen_lop('web15301');
$ngoc->display_data();

$a = new sinhVien();
$a->nhap_hoc(" Ngọc", "PH12345", "web15301");
$a->chuyen_lop('web15303');
$a->display_data();

