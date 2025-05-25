<?php

require 'function.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cekdatabase = mysqli_query($conn, "SELECT * FROM login where email='$email' and password='$password'");

    $hitung = mysqli_num_rows($cekdatabase);

    if ($hitung > 0) {
        $data_user = mysqli_fetch_array($cekdatabase);
        $_SESSION['log'] = 'true';
        $_SESSION['role'] = $data_user['role']; // Simpan peran pengguna di sesi
        header('location:index.php');
    } else {
        header('location:login.php');
    };
};

if (!isset($_SESSION['log'])) {
} else {
    header('location:index.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - Sistem Informasi Inventaris MAN 1</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
        background: url('assets/img/man.jpeg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }

    body::before {
        content: "";
        background: rgba(0, 0, 0, 0.5);
        /* overlay gelap */
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: -1;
    }

    .login-container {
        position: relative;
        z-index: 1;
    }

    .login-heading {
        font-size: 2.4rem;
        font-weight: bold;
        color: #fff;
        text-align: center;
        margin-top: 20px;
        text-shadow: 2px 2px 5px #000;
    }

    .logo-container {
        text-align: center;
        margin-top: 30px;
    }

    .logo-container img {
        width: 130px;
        height: auto;
        margin-bottom: 10px;
    }


    .card {
        background-color: rgba(255, 255, 255, 0.95);
    }

    .card-header h3 {
        font-size: 1.8rem;
    }
</style>

<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="assets/img/logoman.png" alt="Logo MAN 1">
        </div>
        <div class="login-heading">Sistem Informasi Inventaris MAN 1</div>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-4">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-bold">Login</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="email" type="email" placeholder="name@example.com" />
                                                <label>Email address</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="password" type="password" placeholder="Password" />
                                                <label>Password</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary w-100" name="login">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
