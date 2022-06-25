<?php
require 'function.php';

//cek login
if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    //cocokan dengan data di mysql
    $cekdatabase = mysqli_query($koneksi, "SELECT * FROM login where username ='$username' and password ='$password'");
    //hitung jmlh data
    $hitung = mysqli_num_rows($cekdatabase);

    if($hitung > 0){
        $_SESSION['log'] = 'true';
        header('Location: index.php');
    } else {
        header('Location: login.php');
    };
};

if(!isset($_SESSION['log'])){

} else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="css/font-googleapis.css"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-8 col-lg-10 col-md-7">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome !!</h1>
                        </div>
                        <form method="post">
                            <div class="form-group">
                                <input type="username" class="form-control form-control-user" name="username"
                                    id="exampleInputUsername" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" name="password"
                                    id="exampleInputPassword" placeholder="Password" required>
                            </div>
                            <button href="index.php" class="btn btn-primary btn-user btn-block" name="login">
                                Login
                            </button>
                        </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>