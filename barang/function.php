<?php
    session_start();
    //koneksi
    $koneksi = mysqli_connect("localhost","root","","barang");
    //menambah barang
    if(isset($_POST['newbarang'])){
        $namabarang = $_POST['namabarang'];
        $asalbarang = $_POST['asalbarang'];
        $stock = $_POST['stock'];

        $tbhdata = mysqli_query($koneksi, "INSERT INTO stok_barang(nama_barang, asal_barang, stok) VALUES('$namabarang', '$asalbarang', '$stock')");
        if($tbhdata){
            header('Location: stock.php');
        } else {
            echo'gagal';
            header('Location: stock.php');
        }
    }
    //menambah barang baru
    if(isset($_POST['masukbrg'])){
        $barangnya = $_POST['barangnya'];
        $kondisi = $_POST['kondisi'];
        $penerima = $_POST['penerima'];
        $qty = $_POST['qty'];

        $cekstk = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE kode_barang='$barangnya'");
        $ambildata = mysqli_fetch_array($cekstk);

        $stkskrg = $ambildata['stok'];
        $penjumlahan = $stkskrg + $qty;

        $tbhmasuk = mysqli_query($koneksi, "INSERT INTO barang_masuk(kode_barang, kondisi, penerima, qty) VALUES('$barangnya', '$kondisi', '$penerima', '$qty')");
        $updstkmasuk = mysqli_query($koneksi, "UPDATE stok_barang SET stok='$penjumlahan' WHERE kode_barang='$barangnya'");
        if($tbhmasuk&&$updstkmasuk){
            header('Location: masuk.php');
        } else {
            echo'gagal';
            header('Location: masuk.php');
        }
    }

    //menambah barang keluar
    if(isset($_POST['keluarbrg'])){
        $barangnya = $_POST['barangnya'];
        $qty = $_POST['qty'];

        $cekstk = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE kode_barang='$barangnya'");
        $ambildata = mysqli_fetch_array($cekstk);

        $stkskrg = $ambildata['stok'];

        if($stkskr >= $qty){
            $pengurangan = $stkskrg - $qty;

            $tbhkeluar = mysqli_query($koneksi, "INSERT INTO barang_keluar(kode_barang, qty) VALUES('$barangnya', '$qty')");
            $updstkkeluar = mysqli_query($koneksi, "UPDATE stok_barang SET stok='$pengurangan' WHERE kode_barang='$barangnya'");
            if($tbhkeluar&&$updstkkeluar){
                header('Location: keluar.php');
            } else {
                echo'gagal';
                header('Location: keluar.php');
            }

        } else {
            echo '
            <script>
                alert("Stok saat ini sudah habis");
                window.location.href="keluar.php";
            </script>
            ';
        }

        
    }

    //update barang
    if(isset($_POST['upbarang'])){
        $kodebrg = $_POST['kodebrg'];
        $namabarang = $_POST['namabarang'];
        $asal = $_POST['asalbarang'];
        
        $up = mysqli_query($koneksi, "UPDATE stok_barang SET nama_barang = '$namabarang', asal_barang = '$asal' WHERE kode_barang = '$kodebrg'");
        if($up){
            header('Location: stock.php');
        } else {
            echo'gagal';
            header('Location: stock.php');
        }
    }

    //hapus barang
    if(isset($_POST['hpsbarang'])){
        $kodebrg = $_POST['kodebrg'];

        $del = mysqli_query($koneksi, "DELETE FROM stok_barang WHERE kode_barang = '$kodebrg'");
        if($del){
            header('Location: stock.php');
        } else {
            echo'gagal';
            header('Location: stock.php');
        }
    }

    //update barang masuk
    if(isset($_POST['upbarangmsk'])){
        $kodemsk = $_POST['kodemsk'];
        $kodebrg = $_POST['kodebrg'];
        $kondisi = $_POST['kondisi'];
        $penerima = $_POST['penerima'];
        $qty = $_POST['qty'];

        $lhtstk = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE kode_barang = '$kodebrg'");
        $stkny = mysqli_fetch_array($lhtstk);
        $stkskrg = $stkny['stok'];

        $lhtqty = mysqli_query($koneksi, "SELECT * FROM barang_masuk WHERE kode_masuk = '$kodemsk'");
        $qtyny = mysqli_fetch_array($lhtqty);
        $qtyskrg = $qtyny['qty'];

        if($qty>$qtyskrg){
            $kur = $qty - $qtyskrg;
            $kurin = $stkskrg + $kur;
            $kurstk = mysqli_query($koneksi, "UPDATE stok_barang SET stok = '$kurin' WHERE kode_barang = '$kodebrg'");
            $update = mysqli_query($koneksi, "UPDATE barang_masuk SET kondisi = '$kondisi', penerima = '$penerima',qty = '$qty' WHERE kode_masuk = '$kodemsk'");
            
            if($kurstk&&$update){
                header('Location: masuk.php');
            } else {
                echo'gagal';
                header('Location: masuk.php');
            }
        } else {
            $kur = $qtyskrg - $qty;
            $kurin = $stkskrg + $kur;
            $kurstk = mysqli_query($koneksi, "UPDATE  stok_barang SET stok = '$kurin' WHERE kode_barang = '$kodebrg'");
            $update = mysqli_query($koneksi, "UPDATE  barang_masuk SET qty = '$qty' WHERE kode_masuk = '$kodemsk'");
            
            if($kurstk&&$update){
                header('Location: masuk.php');
            } else {
                echo'gagal';
                header('Location: masuk.php');
            }
        }
    }

    //hapus barang masuk
    if(isset($_POST['hpsbarangmsk'])){
        $kodemsk = $_POST['kodemsk'];
        $kodebrg = $_POST['kodebrg'];
        $qty = $_POST['qty'];

        $getdata = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE kode_barang = '$kodebrg'");
        $data = mysqli_fetch_array($getdata);
        $stok = $data['stok'];

        $selisih = $stok - $qty;

        $update = mysqli_query($koneksi, "UPDATE stok_barang SET stok = '$selisih' WHERE kode_barang = '$kodebrg'");
        $hpsdata = mysqli_query($koneksi, "DELETE FROM barang_masuk WHERE kode_masuk = '$kodemsk'");

        if($update&&$hpsdata){
            header('Location: masuk.php');
        } else {
            echo'gagal';
            header('Location: masuk.php');
        }
    }

    //update barang keluar
    if(isset($_POST['upbarangkel'])){
        $kodekel = $_POST['kodekel'];
        $kodebrg = $_POST['kodebrg'];
        $qty = $_POST['qty'];

        $lhtstk = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE kode_barang = '$kodebrg'");
        $stkny = mysqli_fetch_array($lhtstk);
        $stkskrg = $stkny['stok'];

        $lhtqty = mysqli_query($koneksi, "SELECT * FROM barang_keluar WHERE kode_keluar = '$kodekel'");
        $qtyny = mysqli_fetch_array($lhtqty);
        $qtyskrg = $qtyny['qty'];

        if($qty>$qtyskrg){
            $kur = $qty - $qtyskrg;
            $kurin = $stkskrg - $kur;
            $kurstk = mysqli_query($koneksi, "UPDATE stok_barang SET stok = '$kurin' WHERE kode_barang = '$kodebrg'");
            $update = mysqli_query($koneksi, "UPDATE barang_keluar SET qty = '$qty' WHERE kode_keluar = '$kodekel'");
            
            if($kurstk&&$update){
                header('Location: keluar.php');
            } else {
                echo'gagal';
                header('Location: keluar.php');
            }
        } else {
            $kur = $qtyskrg - $qty;
            $kurin = $stkskrg + $kur;
            $kurstk = mysqli_query($koneksi, "UPDATE  stok_barang SET stok = '$kurin' WHERE kode_barang = '$kodebrg'");
            $update = mysqli_query($koneksi, "UPDATE  barang_keluar SET qty = '$qty' WHERE kode_keluar = '$kodekel'");
            
            if($kurstk&&$update){
                header('Location: keluar.php');
            } else {
                echo'gagal';
                header('Location: keluar.php');
            }
        }
    }

    //hapus barang keluar
    if(isset($_POST['hpsbarangkel'])){
        $kodekel = $_POST['kodekel'];
        $kodebrg = $_POST['kodebrg'];
        $qty = $_POST['qty'];

        $getdata = mysqli_query($koneksi, "SELECT * FROM stok_barang WHERE kode_barang = '$kodebrg'");
        $data = mysqli_fetch_array($getdata);
        $stok = $data['stok'];

        $selisih = $stok + $qty;

        $update = mysqli_query($koneksi, "UPDATE stok_barang SET stok = '$selisih' WHERE kode_barang = '$kodebrg'");
        $hpsdata = mysqli_query($koneksi, "DELETE FROM barang_keluar WHERE kode_keluar = '$kodekel'");

        if($update&&$hpsdata){
            header('Location: keluar.php');
        } else {
            echo'gagal';
            header('Location: keluar.php');
        }
    }

    //tambah admin baru
    if(isset($_POST['newadmin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $namalengkap = $_POST['namalengkap'];

        $tbhdata = mysqli_query($koneksi, "INSERT INTO login(username, password, nama_lengkap) VALUES('$username', '$password', '$namalengkap')");
        if($tbhdata){
            header('Location: admin.php');
        } else {
            echo'gagal';
            header('Location: admin.php');
        }
    }
    //update admin
    if(isset($_POST['upadmin'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $namalengkap = $_POST['namalengkap'];

        $tbhdata = mysqli_query($koneksi, "UPDATE login SET username = '$username', password = '$password', nama_lengkap = '$namalengkap' WHERE username = '$username'");
        if($tbhdata){
            header('Location: admin.php');
        } else {
            echo'gagal';
            header('Location: admin.php');
        }
    }

    //hapus admin
    if(isset($_POST['hpsadmin'])){
        $username = $_POST['username'];

        $del = mysqli_query($koneksi, "DELETE FROM login WHERE username = '$username'");
        if($del){
            header('Location: admin.php');
        } else {
            echo'gagal';
            header('Location: admin.php');
        }
    }
?>