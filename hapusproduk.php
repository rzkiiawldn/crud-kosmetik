<?php 
include "function.php";
 
$id_produk = $_GET["id_produk"];

if ( hapusproduk($id_produk) > 0 ) {
    echo "<script> 
        alert('produk berhasil dihapus');
        document.location.href = 'index.php' ;
        </script>";
} else
    echo "<script> 
        alert('produk gagal dihapus');
        document.location.href = 'index.php' ;
        </script>";
 ?>