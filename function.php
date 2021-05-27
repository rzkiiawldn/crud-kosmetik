<?php

$conn = mysqli_connect("localhost","root","","kosmetik");

if( !$conn ){
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}

function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows	= [];
	while ( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}

//FUNCTION PRODUK
function tambahproduk($data) {
	global $conn;
	//ambil data dari tiap form
	$kode_produk = htmlspecialchars($data["kode_produk"]);
	$nama_produk = htmlspecialchars($data["nama_produk"]);
	$stok_produk = htmlspecialchars($data["stok_produk"]);
	$harga_satuan = htmlspecialchars($data["harga_satuan"]);


	$query = "INSERT INTO produk VALUES ('', '$kode_produk','$nama_produk','$stok_produk','$harga_satuan')";
	
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}

function hapusproduk($id_produk) {
	global $conn;
	mysqli_query($conn, "DELETE FROM produk WHERE id_produk = '$id_produk'");
	return mysqli_affected_rows($conn);
}

function editproduk($data) {
	global $conn;
	//ambil data dari tiap form
	$id_produk 		= $data['id_produk'];
	$kode_produk 	= htmlspecialchars($data["kode_produk"]);
	$nama_produk 	= htmlspecialchars($data["nama_produk"]);
	$stok_produk 	= htmlspecialchars($data["stok_produk"]);
	$harga_satuan 	= htmlspecialchars($data["harga_satuan"]);

	$query = "UPDATE produk SET kode_produk ='$kode_produk', nama_produk='$nama_produk', stok_produk='$stok_produk', harga_satuan='$harga_satuan' WHERE id_produk = '$id_produk' ";
	
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);

}