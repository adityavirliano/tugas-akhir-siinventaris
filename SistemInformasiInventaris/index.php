<?php

require 'function.php';
require 'cek.php';

// Data untuk Pie Chart (Nama Barang dan Stock)
$queryBarang = "SELECT namabarang, stock FROM stock";
$resultBarang = mysqli_query($conn, $queryBarang);
$labelsPie = [];
$dataPie = [];
$colors = []; // Warna untuk setiap bagian
while ($row = mysqli_fetch_assoc($resultBarang)) {
    $labelsPie[] = $row['namabarang'];
    $dataPie[] = $row['stock'];
    $colors[] = '#' . substr(md5(rand()), 0, 6); // Generate warna acak
}

// Ubah bagian query data line chart menjadi:
$query = "SELECT 
            (SELECT COALESCE(SUM(stock), 0) FROM stock) as total_stock,
            (SELECT COALESCE(SUM(qty), 0) FROM masuk) as total_masuk,
            (SELECT COALESCE(SUM(qty), 0) FROM keluar) as total_keluar,
            (SELECT COALESCE(SUM(qty), 0) FROM peminjaman WHERE status='Dipinjam') as total_pinjam";

$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

// Siapkan data untuk chart
$labels = ['Stock Barang', 'Barang Masuk', 'Barang Keluar', 'Barang Dipinjam'];
$values = [
    (int)$data['total_stock'],
    (int)$data['total_masuk'],
    (int)$data['total_keluar'],
    (int)$data['total_pinjam']
];
$colorss = ['#36a2eb', '#4bc0c0', '#ff6384', '#ffcd56'];
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Sistem Informasi Inventaris MAN 1</title>
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
    .card {
        background: white;
        /* Tambahkan ini */
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
    }

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
                        <a class="nav-link active" href="index.php">
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
                        <a class="nav-link" href="admin.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                            Kelola Admin
                        </a>
                    </div>
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
                    <h1 class="mt-4 pb-2">Dashboard</h1>
                    <div class="row">
                        <!-- card -->
                        <div class="col-md-3">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <div style="font-weight: bold; font-size: 1.5rem;">Stock Barang</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="font-size: 2rem;">
                                            <?php
                                            $totalStock = mysqli_query($conn, "SELECT SUM(stock) as total FROM stock");
                                            $dataStock = mysqli_fetch_array($totalStock);
                                            echo $dataStock['total'] ? $dataStock['total'] : 0;
                                            ?>
                                        </span>
                                        <i class="fas fa-boxes fa-2x mt-2"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="stock.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <div style="font-weight: bold; font-size: 1.5rem;">Barang Masuk</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="font-size: 2rem;">
                                            <?php
                                            $totalMasuk = mysqli_query($conn, "SELECT SUM(qty) as total FROM masuk");
                                            $dataMasuk = mysqli_fetch_array($totalMasuk);
                                            echo $dataMasuk['total'] ? $dataMasuk['total'] : 0;
                                            ?>
                                        </span>
                                        <i class="fas fa-arrow-down fa-2x mt-2"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="masuk.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-danger text-white mb-4">
                                <div class="card-body">
                                    <div style="font-weight: bold; font-size: 1.5rem;">Barang Keluar</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="font-size: 2rem;">
                                            <?php
                                            $totalKeluar = mysqli_query($conn, "SELECT SUM(qty) as total FROM keluar");
                                            $dataKeluar = mysqli_fetch_array($totalKeluar);
                                            echo $dataKeluar['total'] ? $dataKeluar['total'] : 0;
                                            ?>
                                        </span>
                                        <i class="fas fa-arrow-up fa-2x mt-2"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="keluar.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <div style="font-weight: bold; font-size: 1.5rem;">Barang Dipinjam</div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span style="font-size: 2rem;">
                                            <?php
                                            $totalDipinjam = mysqli_query($conn, "SELECT SUM(qty) as total FROM peminjaman WHERE status='Dipinjam'");
                                            $dataDipinjam = mysqli_fetch_array($totalDipinjam);
                                            echo $dataDipinjam['total'] ? $dataDipinjam['total'] : 0;
                                            ?>
                                        </span>
                                        <i class="fas fa-hand-holding fa-2x mt-2"></i>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="peminjaman.php">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Bagian Chart -->
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Perbandingan Stok, Masuk, Keluar & Peminjaman
                                </div>
                                <div class="card-body">
                                    <canvas id="comparisonBarChart" width="100%" height="52"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="card mb-4">
                                <div class="card-header">
                                    <i class="fas fa-chart-pie me-1"></i>
                                    Distribusi Stok Barang
                                </div>
                                <div class="card-body">
                                    <canvas id="stockPieChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian taebl stok -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Stock Barang
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Stock</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center align-middle">
                                    <?php
                                    $ambilsemuadatastock = mysqli_query($conn, 'SELECT * FROM stock');
                                    $i = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadatastock)) {
                                        $namabarang = $data['namabarang'];
                                        $kategori = $data['kategori'];
                                        $stock = $data['stock'];
                                        $idbarang = $data['idbarang'];
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $namabarang; ?></td>
                                            <td><?= $kategori; ?></td>
                                            <td><?= $stock; ?></td>
                                        </tr>
                                    <?php
                                    };
                                    ?>
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
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart Customization
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14,
                            family: 'Poppins'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(42,47,79,0.9)',
                    titleFont: {
                        family: 'Poppins',
                        size: 14
                    },
                    bodyFont: {
                        family: 'Poppins',
                        size: 14
                    },
                    cornerRadius: 8,
                    displayColors: false
                }
            },
            scales: {
                y: {
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        font: {
                            family: 'Poppins'
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: 'Poppins'
                        }
                    }
                }
            }
        };
        // Pie Chart
        new Chart(document.getElementById('stockPieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: <?= json_encode($labelsPie) ?>,
                datasets: [{
                    data: <?= json_encode($dataPie) ?>,
                    backgroundColor: <?= json_encode($colors) ?>,
                    borderColor: 'rgba(255,255,255,0.3)',
                    borderWidth: 3,
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    }
                }
            }
        });

        //barchart
        new Chart(document.getElementById('comparisonBarChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    data: <?= json_encode($values) ?>,
                    backgroundColor: <?= json_encode($colorss) ?>,
                    borderColor: ['#2980b9', '#16a085', '#c0392b', '#f39c12'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda
                    },
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.label}: ${context.raw.toLocaleString('id-ID')} unit`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: (value) => value.toLocaleString('id-ID', {
                                maximumFractionDigits: 0
                            })
                        },
                        title: {
                            display: true,
                            text: 'Jumlah (unit)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jenis Transaksi'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
