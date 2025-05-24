<?php
require 'function.php';
require 'cek.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan-Stok-Barang.xls");

$tglHariIni = date('d-m-Y');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Export Excel</title>
</head>
<body>
    <h2>Laporan Stok Barang per <?= $tglHariIni ?></h2>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $ambildata = mysqli_query($conn, "SELECT * FROM stock");
            while ($row = mysqli_fetch_array($ambildata)) {
                echo '
                <tr>
                    <td>'.$no++.'</td>
                    <td>'.$row['namabarang'].'</td>
                    <td>'.$row['deskripsi'].'</td>
                    <td>'.$row['stock'].'</td>
                </tr>';
            }
            ?>
        </tbody>
    </table>
</body>
</html>