<?php
    /*Kết nối máy chủ MySQL. Máy chủ có cài đặt mặc định (user là 'root' và không có mật khẩu)*/
    $link = mysqli_connect("localhost", "root", "", "shoes");
 
    // Kểm tra kết nối
    if ($link === false) {
        die("ERROR: Không thể kết nối. " . mysqli_connect_error());
    }
?>