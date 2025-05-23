<?php
session_start();


//membuat koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventaris");

if (isset($_POST['addnewbarang'])) {
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];
    $qty = $_POST['qty'];

    $addtotable = mysqli_query($conn, "insert into stock (namabarang, deskripsi, stock) values('$namabarang','$deskripsi','$stock')");
    if ($addtotable) {
        header('location:stock.php');
    } else {
        echo 'gagal';
        header('location:stock.php');
    }
}

//barang masuk
if (isset($_POST['barangmasuk'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang + $qty;

    $addtomasuk = mysqli_query($conn, "insert into masuk (idbarang, keterangan, qty) values('$barangnya','$penerima','$qty')");
    $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

    if ($addtomasuk && $updatestockmasuk) {
        header('location:masuk.php');
    } else {
        echo 'gagal';
        header('location:masuk.php');
    }
}

//barang keluar
if (isset($_POST['addbarangkeluar'])) {
    $barangnya = $_POST['barangnya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idbarang='$barangnya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['stock'];

    if ($stocksekarang >= $qty) {
        //kalo cukup barangya

        $tambahkanstocksekarangdenganquantity = $stocksekarang - $qty;

        $addtokeluar = mysqli_query($conn, "insert into keluar (idbarang, penerima, qty) values('$barangnya','$penerima','$qty')");
        $updatestockmasuk = mysqli_query($conn, "update stock set stock='$tambahkanstocksekarangdenganquantity' where idbarang='$barangnya'");

        if ($addtokeluar && $updatestockmasuk) {
            header('location:keluar.php');
        } else {
            echo 'gagal';
            header('location:keluar.php');
        }
    } else {
        //kalo barangnya ga cukup
        echo '
        <script>
            alert("Stock saat ini tidak mencukupi");
            window.location.href="keluar.php";
        </script>
        ';
    }
}

// Update barang
if (isset($_POST['updatebarang'])) {
    $idbarang = $_POST['idbarang'];
    $namabarang = $_POST['namabarang'];
    $deskripsi = $_POST['deskripsi'];
    $stock = $_POST['stock'];

    $update = mysqli_query($conn, "UPDATE stock SET namabarang='$namabarang', deskripsi='$deskripsi', stock='$stock' WHERE idbarang='$idbarang'");
}

// Hapus barang
if (isset($_POST['hapusbarang'])) {
    $idbarang = $_POST['idbarang'];

    // Hapus dari tabel stock
    $hapus_stock = mysqli_query($conn, "DELETE FROM stock WHERE idbarang='$idbarang'");
    $hapus_masuk = mysqli_query($conn, "DELETE FROM masuk WHERE idbarang='$idbarang'");
    $hapus_keluar = mysqli_query($conn, "DELETE FROM keluar WHERE idbarang='$idbarang'");
}

// Edit Barang Masuk
if (isset($_POST['updatemasuk'])) {
    $idmasuk = $_POST['idmasuk'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    // Ambil data lama untuk kalkulasi stok
    $queryOld = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $oldData = mysqli_fetch_assoc($queryOld);
    $oldQty = $oldData['qty'];
    $idbarang = $oldData['idbarang'];

    // Update data masuk
    mysqli_query($conn, "UPDATE masuk SET qty='$qty', keterangan='$keterangan' WHERE idmasuk='$idmasuk'");

    // Update stok (selisih)
    $selisih = $qty - $oldQty;
    mysqli_query($conn, "UPDATE stock SET stock = stock + $selisih WHERE idbarang='$idbarang'");

    header('location:masuk.php');
}

// Hapus Barang Masuk
if (isset($_POST['hapusmasuk'])) {
    $idmasuk = $_POST['idmasuk'];

    // Ambil data untuk kalkulasi stok
    $queryData = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $data = mysqli_fetch_assoc($queryData);
    $qty = $data['qty'];
    $idbarang = $data['idbarang'];

    // Hapus data
    mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idmasuk'");

    // Kurangi stok
    mysqli_query($conn, "UPDATE stock SET stock = stock - $qty WHERE idbarang='$idbarang'");

    header('location:masuk.php');
}

// Edit Barang Keluar
if (isset($_POST['updatekeluar'])) {
    $idkeluar = $_POST['idkeluar'];
    $qty = $_POST['qty'];
    $penerima = $_POST['penerima'];

    // Ambil data lama
    $queryOld = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idkeluar'");
    $oldData = mysqli_fetch_assoc($queryOld);
    $oldQty = $oldData['qty'];
    $idbarang = $oldData['idbarang'];

    // Update data keluar
    mysqli_query($conn, "UPDATE keluar SET qty='$qty', penerima='$penerima' WHERE idkeluar='$idkeluar'");

    // Update stok (selisih)
    $selisih = $oldQty - $qty;
    mysqli_query($conn, "UPDATE stock SET stock = stock + $selisih WHERE idbarang='$idbarang'");

    header('location:keluar.php');
}

// Hapus Barang Keluar
if (isset($_POST['hapuskeluar'])) {
    $idkeluar = $_POST['idkeluar'];

    // Ambil data untuk kalkulasi stok
    $queryData = mysqli_query($conn, "SELECT * FROM keluar WHERE idkeluar='$idkeluar'");
    $data = mysqli_fetch_assoc($queryData);
    $qty = $data['qty'];
    $idbarang = $data['idbarang'];

    // Hapus data
    mysqli_query($conn, "DELETE FROM keluar WHERE idkeluar='$idkeluar'");

    // Tambah stok
    mysqli_query($conn, "UPDATE stock SET stock = stock + $qty WHERE idbarang='$idbarang'");

    header('location:keluar.php');
}

//menambah admin baru
if (isset($_POST['addadmin'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $queryinsert = mysqli_query($conn, "insert into login (email, password) values('$email','$password')");

    if ($queryinsert) {
        header("location:admin.php");
    } else {
        header("location:admin.php");
    }
}

//editadmin
if (isset($_POST["updateadmin"])) {
    $emailbaru = $_POST["emailadmin"];
    $passwordbaru = $_POST["passwordbaru"];
    $idnya = $_POST["id"];

    $queryupdate = mysqli_query($conn, "update login set email='$emailbaru', password='$passwordbaru' where iduser='$idnya'");

    if($queryupdate){
        header("location.admin.php");
    } else {
        header("location:admin.php");
    }
}

//deleteadmin
if (isset($_POST["hapusadmin"])) {
    $id = $_POST["id"];

    $querydelete = mysqli_query($conn, "delete from login where iduser='$id'");

    if($querydelete){
        header("location.admin.php");
    } else {
        header("location:admin.php");
    }
}

// Tambah Peminjaman
if(isset($_POST['addpeminjaman'])) {
    $idbarang = $_POST['idbarang'];
    $qty = $_POST['qty'];
    $peminjam = $_POST['peminjam'];
    
    // Cek stok tersedia
    $cekstock = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$idbarang'");
    $stock = mysqli_fetch_array($cekstock);
    
    if($stock['stock'] >= $qty) {
        $insert = mysqli_query($conn, "INSERT INTO peminjaman (idbarang, qty, peminjam) VALUES ('$idbarang','$qty','$peminjam')");
        
        if($insert) {
            // Kurangi stok
            mysqli_query($conn, "UPDATE stock SET stock = stock - $qty WHERE idbarang='$idbarang'");
            header('location:peminjaman.php');
        }
    } else {
        echo '<script>alert("Stok tidak mencukupi");window.location="peminjaman.php"</script>';
    }
}

// Update Peminjaman
if(isset($_POST['updatepeminjaman'])) {
    $idpeminjaman = $_POST['idpeminjaman'];
    $qty = $_POST['qty'];
    $peminjam = $_POST['peminjam'];
    $status = $_POST['status'];

    // Ambil data lama
    $queryOld = mysqli_query($conn, "SELECT * FROM peminjaman WHERE idpeminjaman='$idpeminjaman'");
    $oldData = mysqli_fetch_assoc($queryOld);
    $oldQty = $oldData['qty'];
    $oldStatus = $oldData['status'];
    $idbarang = $oldData['idbarang'];

    // Cek apakah status berubah menjadi 'Dikembalikan'
    if ($oldStatus != 'Dikembalikan' && $status == 'Dikembalikan') {
        $tanggal_kembali = $data['tanggalpengembalian'];  // Tanggal pengembalian otomatis

        // Update data dan set tanggal pengembalian
        if (isset($_POST['kembalikan'])) {
    $idpeminjaman = $_POST['idpeminjaman'];
    $tanggal_kembali = date('Y-m-d');

    // Update status dan tanggalpengembalian
    $update = mysqli_query($conn, "UPDATE peminjaman 
        SET status = 'Dikembalikan', tanggalpengembalian = '$tanggal_kembali' 
        WHERE idpeminjaman = '$idpeminjaman'");
}


        // Kembalikan stok
        mysqli_query($conn, "UPDATE stock SET stock = stock + $oldQty WHERE idbarang='$idbarang'");
    } else {
        // Jika status tidak berubah ke 'Dikembalikan', hanya update data biasa
        mysqli_query($conn, "UPDATE peminjaman SET 
            qty = '$qty',
            peminjam = '$peminjam',
            status = '$status'
            WHERE idpeminjaman = '$idpeminjaman'");

        // Logika penyesuaian stok
        if($oldStatus == 'Dikembalikan' && $status == 'Dipinjam') {
            mysqli_query($conn, "UPDATE stock SET stock = stock - $qty WHERE idbarang='$idbarang'");
        } elseif($status == 'Dipinjam' && $oldQty != $qty) {
            $selisih = $oldQty - $qty;
            mysqli_query($conn, "UPDATE stock SET stock = stock + $selisih WHERE idbarang='$idbarang'");
        }
    }

    header('location:peminjaman.php');
}

// Hapus Peminjaman
if(isset($_POST['hapuspeminjaman'])) {
    $idpeminjaman = $_POST['idpeminjaman'];
    
    // Ambil data untuk mengembalikan stok
    $data = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM peminjaman WHERE idpeminjaman='$idpeminjaman'"));
    $idbarang = $data['idbarang'];
    $qty = $data['qty'];
    
    // Hapus data
    mysqli_query($conn, "DELETE FROM peminjaman WHERE idpeminjaman='$idpeminjaman'");
    
    // Kembalikan stok jika status belum dikembalikan
    if($data['status'] == 'Dipinjam') {
        mysqli_query($conn, "UPDATE stock SET stock = stock + $qty WHERE idbarang='$idbarang'");
    }
    
    header('location:peminjaman.php');
}
