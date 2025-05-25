<?php

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
    <title>Kelola Admin - Sistem Informasi Inventaris MAN 1</title>
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
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar Brand-->
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

                        <a class="nav-link" href="peminjaman.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-hand-holding"></i></div>
                            Peminjaman Barang
                        </a>
                        <a class="nav-link active" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                            Kelola Admin
                        </a>
                    </div>
                </div>
                <!-- Tombol logout di bawah -->
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
                    <h1 class="mt-4 pb-2">Kelola Admin</h1>
                    <div class="card mb-4">
                        <div class="card-header">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
                                Tambah Admin
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Email Admin</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center align-middle">
                                    <?php
                                    $ambilsemuadataadmin = mysqli_query($conn, 'SELECT * FROM login');
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadataadmin)) {
                                        $em = $data['email'];
                                        $iduser = $data['iduser'];
                                        $pw = $data['password'];
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $em; ?></td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $iduser; ?>">Edit</button>
                                                    <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $iduser; ?>">Delete</button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?= $iduser; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Admin</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="email" name="emailadmin" value="<?= $em; ?>" class="form-control mb-2" placeholder="Email" required>
                                                            <input type="password" name="passwordbaru" value="<?= $pw; ?>" class="form-control mb-2" placeholder="Password">
                                                            <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" name="updateadmin">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal Delete -->
                                        <div class="modal fade" id="delete<?= $iduser; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Yakin ingin menghapus <strong><?= $em; ?></strong>?
                                                            <input type="hidden" name="id" value="<?= $iduser; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger" name="hapusadmin">Hapus</button>
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
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Sistem Informasi Inventaris MAN 1</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Admin</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <input type="email" name="email" placeholder="Email" class="form-control" required>
                    <br>
                    <input type="password" name="password" placeholder="Password" class="form-control" required>
                    <br>
                    <button type="submit" class="btn btn-primary" name="addadmin">Submit</button>
                </div>
            </form>

        </div>
    </div>
</div>

</html>
