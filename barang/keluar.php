<?php
require 'function.php';
require 'ceklogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Barang Keluar</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="css/font-googleapis.css"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-thumbs-up"></i>
                </div>
                <div class="sidebar-brand-text mx-3">InvMan's</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Beranda -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-home"></i>
                    <span>Beranda</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Barang
            </div>

            <!-- Nav Item - Stock -->
            <li class="nav-item">
                <a class="nav-link" href="stock.php">
                    <i class="fas fa-box"></i>
                    <span>Stock</span>
                </a>
            </li>

            <!-- Nav Item - Laporan -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Perihal:</h6>
                        <a class="collapse-item" href="masuk.php">Barang Masuk</a>
                        <a class="collapse-item" href="keluar.php">Barang Keluar</a>
                    </div>
                </div>
            </li>

            
            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Kelola -->
            <li class="nav-item">
                <a class="nav-link" href="admin.php">
                <i class="fas fa-user-cog"></i>
                    <span>Kelola Admin</span></a>
            </li>

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    
                </nav>
                <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Barang Keluar</h1>
<p class="mb-4">Berikut adalah barang yang sudah kelua dari gudang:</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- Button to Open the Modal -->
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Tambah Barang Keluar
  </button>
  <a href="expkeluar.php" class="btn btn-info">Ekspor Data</a>
  <!-- The Modal -->
  <div class="modal fade" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Tambahkan Barang Keluar</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <form method="post">
        <div class="modal-body">
        <select name="barangnya" class="form-control">
              <?php
              $ambilsemua = mysqli_query($koneksi, "SELECT * FROM stok_barang");
              while($fetcharray = mysqli_fetch_array($ambilsemua)){
                  $namabarangnya = $fetcharray['nama_barang'];
                  $idbarangnya = $fetcharray['kode_barang'];
              ?>
              <option value="<?=$idbarangnya;?>"><?=$namabarangnya?></option>
              <?php
              }
              ?>
          </select><br>
          <input type="number" name="qty" class="form-control" placeholder="Kuantitas" required><br>
          <button type="submit" class="btn btn-primary" name="keluarbrg">Tambah</button>
        </div>
        </form>      
      </div>
    </div>
  </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Qty</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $ambilsemua = mysqli_query($koneksi, "SELECT * FROM barang_keluar k, stok_barang s WHERE s.kode_barang = k.kode_barang");
                        while($data = mysqli_fetch_array($ambilsemua)){
                            $kodeklr = $data['kode_keluar'];
                            $kodebrg = $data['kode_barang'];
                            $namabrg = $data['nama_barang'];
                            $tglkel = $data['tgl_keluar'];
                            $qty = $data ['qty'];
                    ?>
                    <tr>
                        <td><?=$namabrg?></td>
                        <td><?=$tglkel?></td>
                        <td><?=$qty?></td>
                        <td>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?=$kodebrg?>">
                                Edit
                        </button>
                             <!-- Edit Modal -->
                            <div class="modal fade" id="edit<?=$kodebrg?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Edit Barang</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <!-- Modal body -->
                                        <form method="post">
                                            <div class="modal-body">
                                                <input type="number" name="qty" value="<?=$qty?>" class="form-control" required><br>
                                                <input type="hidden" name="kodebrg" value="<?=$kodebrg?>">
                                                <input type="hidden" name="kodekel" value="<?=$kodeklr?>">
                                                <button type="submit" class="btn btn-primary" name="upbarangkel">Edit</button>
                                            </div>
                                        </form>   
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="mauhapus" value="<?=$kodebrg?>">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?=$kodebrg?>">
                                Hapus
                        </button>
                            <!-- Delete Modal -->
                            <div class="modal fade" id="delete<?=$kodebrg?>">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                            <h4 class="modal-title">Hapus barang</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        
                                        <!-- Modal body -->
                                        <form method="post">
                                            <div class="modal-body">
                                                <p>Apakah yakin untuk menghapus <?=$namabrg?>?</p><br>
                                                <input type="hidden" name="kodebrg" value="<?=$kodebrg?>">
                                                <input type="hidden" name="qty" value="<?=$qty?>">
                                                <input type="hidden" name="kodekel" value="<?=$kodeklr?>">
                                                <button type="submit" class="btn btn-danger" name="hpsbarangkel">Hapus</button>
                                            </div>
                                        </form>   
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->


            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Fajar Prayoga 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Siap Keluar?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Pilih "Logout" di bawah ini jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>