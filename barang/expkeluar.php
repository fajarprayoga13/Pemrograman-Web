<?php
require 'function.php';
require 'ceklogin.php';
?>
<html>
<head>
  <title>Ekspor Data</title>
  <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="vendor/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="vendor/datatables/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
			<h2>Barang Keluar</h2>
			<h4>(Inventory)</h4>
				<div class="data-tables datatable-dark">	
                <table class="table table-bordered" id="mauexport" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Qty</th>
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
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
		</div>
</div>
	
<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy','csv','excel', 'pdf', 'print'
        ]
    } );
} );

</script>

<script src="vendor/jquery/jquery-3.5.1.js"></script>
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.buttons.min.js"></script>
<script src="vendor/datatables/buttons.flash.min.js"></script>
<script src="js/jszip.min.js"></script>
<script src="js/pdfmake.min.js"></script>
<script src="js/vfs_fonts.js"></script>
<script src="vendor/datatables/buttons.html5.min.js"></script>
<script src="vendor/datatables/buttons.print.min.js"></script>

	

</body>

</html>