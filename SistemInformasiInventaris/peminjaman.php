<?php
date_default_timezone_set('Asia/Jakarta');
require 'function.php';
require 'cek.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Peminjaman Barang - Sistem Informasi Inventaris MAN 1</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<style>
    /* Custom Styles */
    :root {
        --primary: #2A2F4F;
        --secondary: #917FB3;
        --accent: #E5BEEC;
        --light: #FDE2F3;
    }

    body {
        background: #f8f9fa;
        font-family: 'Poppins', sans-serif;
    }

    /* Navigation */
    .sb-topnav {
        background: var(--primary) !important;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
    }

    /* Sidebar */
    .sb-sidenav-dark {
        background: var(--primary);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sb-sidenav-dark .sb-sidenav-menu .nav-link {
        color: rgba(255, 255, 255, 0.8);
        transition: all 0.3s ease;
    }

    .sb-sidenav-dark .sb-sidenav-menu .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.05);
        transform: translateX(5px);
    }

    .container-fluid,
    .container {
        background: transparent !important;
    }

    /* Cards */

    .card-header {
        background: linear-gradient(45deg, var(--primary), var(--secondary));
        color: white;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }



    /* Chart Containers */
    .chart-container {
        position: relative;
        padding: 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    /* Value Cards */
    .card.bg-primary,
    .card.bg-success,
    .card.bg-danger,
    .card.bg-warning {
        border: none;
        background: linear-gradient(135deg, var(--primary), var(--secondary)) !important;
        color: white;
    }

    .card.bg-success {
        background: linear-gradient(135deg, #4CAF50, #45a049) !important;
    }

    .card.bg-danger {
        background: linear-gradient(135deg, #FF6B6B, #FF5252) !important;
    }

    .card.bg-warning {
        background: linear-gradient(135deg, #FFD93D, #FFC107) !important;
    }

    .card i {
        font-size: 2.5rem;
        opacity: 0.8;
        transition: transform 0.3s ease;
    }

    .card:hover i {
        transform: scale(1.1);
    }

    /* Table Styling */
    #datatablesSimple {
        border-radius: 12px;
        overflow: hidden;
    }

    #datatablesSimple th {
        background: var(--primary);
        color: white !important;
        font-weight: 500;
    }

    #datatablesSimple td {
        vertical-align: middle;
    }
</style>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <a class="navbar-brand ps-3" href="index.php">Sistem Informasi Inventaris MAN 1</a>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark d-flex flex-column" id="sidenavAccordion">
                <div class="sb-sidenav-menu flex-grow-1">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">FITUR</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <a class="nav-link" href="stock.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Stock Barang
                        </a>
                        <a class="nav-link" href="masuk.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-down"></i></div>
                            Barang Masuk
                        </a>
                        <a class="nav-link" href="keluar.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-arrow-circle-up"></i></div>
                            Barang Keluar
                        </a>
                        <a class="nav-link active" href="peminjaman.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-hand-holding"></i></div>
                            Peminjaman Barang
                        </a>
                        <?php if ($role == 'admin') { ?>
                            <div class="sb-sidenav-menu-heading">ADMIN</div> <a class="nav-link" href="admin.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                                Kelola Admin
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="small" style="color: rgba(255, 255, 255, 0.5); padding: 0.5rem 1.5rem;">
                    Logged as: <strong><?php echo ucfirst($role); ?></strong>
                </div>
                <div class="sb-sidenav-footer">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Log Out
                    </a>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 pb-2">Peminjaman Barang</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Peminjaman
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pinjam</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah</th>
                                        <th>Peminjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambildata = mysqli_query(
                                        $conn,
                                        "SELECT p.*, s.namabarang 
                                        FROM peminjaman p 
                                        JOIN stock s ON p.idbarang = s.idbarang"
                                    );
                                    while ($data = mysqli_fetch_array($ambildata)) {
                                        $idpeminjaman = $data['idpeminjaman'];
                                        $tanggal = $data['tanggalpinjam'];
                                        $namabarang = $data['namabarang'];
                                        $qty = $data['qty'];
                                        $peminjam = $data['peminjam'];
                                        $tanggal_kembali = $data['tanggalpengembalian'];
                                        $status = $data['status'];
                                    ?>
                                        <tr>
                                            <td><?= date('d M Y', strtotime($tanggal)) ?></td>
                                            <td><?= $namabarang ?></td>
                                            <td><?= $qty ?></td>
                                            <td><?= $peminjam ?></td>
                                            <td>
                                                <?= ($status == 'Dikembalikan' && !empty($tanggal_kembali)) ? date('d M Y', strtotime($tanggal_kembali)) : '' ?>
                                            </td>
                                            <td>
                                                <?= ($status == 'Dikembalikan') ? 'Dikembalikan' : 'Belum dikembalikan' ?>
                                            </td>

                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#edit<?= $idpeminjaman ?>">Edit</button>
                                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#delete<?= $idpeminjaman ?>">Hapus</button>
                                                    <?php if ($status == 'Dipinjam') { ?>
                                                        <form method="post" style="display:inline;">
                                                            <input type="hidden" name="idpeminjaman" value="<?= $idpeminjaman ?>">
                                                            <button type="submit" name="kembalikan" class="btn btn-success btn-sm">Kembalikan</button>
                                                        </form>
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?= $idpeminjaman ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="idpeminjaman" value="<?= $idpeminjaman ?>">
                                                            <input type="number" name="qty" value="<?= $qty ?>" class="form-control mb-2" required>
                                                            <input type="text" name="peminjam" value="<?= $peminjam ?>" class="form-control mb-2" required>
                                                            <select name="status" class="form-select">
                                                                <option value="Dipinjam" <?= ($status == 'Dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
                                                                <option value="Dikembalikan" <?= ($status == 'Dikembalikan') ? 'selected' : '' ?>>Dikembalikan</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="updatepeminjaman">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Modal Hapus -->
                                        <div class="modal fade" id="delete<?= $idpeminjaman ?>">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Hapus Peminjaman</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin hapus data ini?
                                                            <input type="hidden" name="idpeminjaman" value="<?= $idpeminjaman ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" name="hapuspeminjaman">Hapus</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Peminjaman -->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Peminjaman</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <select name="idbarang" class="form-select mb-2">
                            <?php
                            $ambilstock = mysqli_query($conn, "SELECT * FROM stock");
                            while ($stock = mysqli_fetch_array($ambilstock)) {
                                echo '<option value="' . $stock['idbarang'] . '">' . $stock['namabarang'] . '</option>';
                            }
                            ?>
                        </select>
                        <input type="number" name="qty" placeholder="Jumlah" class="form-control mb-2" required>
                        <input type="text" name="peminjam" placeholder="Nama Peminjam" class="form-control mb-2" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="addpeminjaman">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>
<?php
if (isset($_POST['kembalikan'])) {
    $idpeminjaman = $_POST['idpeminjaman'];
    $tanggal_kembali = date('Y-m-d');

    // Ambil data peminjaman
    $ambil = mysqli_query($conn, "SELECT * FROM peminjaman WHERE idpeminjaman = '$idpeminjaman'");
    $data = mysqli_fetch_assoc($ambil);
    $idbarang = $data['idbarang'];
    $qty = $data['qty'];

    // Update status peminjaman
    $update = mysqli_query($conn, "UPDATE peminjaman 
        SET status = 'Dikembalikan', tanggalpengembalian = '$tanggal_kembali' 
        WHERE idpeminjaman = '$idpeminjaman'");

    // Tambahkan kembali ke stock
    $updatestock = mysqli_query($conn, "UPDATE stock 
        SET stock = stock + $qty 
        WHERE idbarang = '$idbarang'");

    if ($update && $updatestock) {
        echo "<script>alert('Barang berhasil dikembalikan!'); window.location.href='peminjaman.php';</script>";
    } else {
        echo "<script>alert('Gagal mengembalikan barang.');</script>";
    }
}
?>

</html>
