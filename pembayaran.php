<?php
// Inisialisasi variabel untuk menyimpan nilai input dan error
$nama = $email = $nomor = $tipe_kamar = $durasi = $metode_pembayaran = "";
$namaErr = $emailErr = $nomorErr = $durasiErr = "";
$total_pembayaran = 0;
$status_pembayaran = "Belum Dibayar";

// Daftar harga kamar per malam
$harga_kamar = [
    "Standar" => 500000,
    "Deluxe" => 750000,
    "Suite" => 1200000
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi Nama
    $nama = $_POST["nama"];
    if (empty($nama)) {
        $namaErr = "Nama wajib diisi";
    }

    // Validasi Email
    $email = $_POST["email"];
    if (empty($email)) {
        $emailErr = "Email wajib diisi";
    }

    // Validasi Nomor Telepon
    $nomor = $_POST["nomor"];
    if (empty($nomor)) {
        $nomorErr = "Nomor Telepon wajib diisi";
    } elseif (!ctype_digit($nomor)) {
        $nomorErr = "Nomor Telepon harus berupa angka";
    }

    // Validasi Durasi Menginap
    $durasi = $_POST["durasi"];
    if (empty($durasi) || !ctype_digit($durasi) || $durasi <= 0) {
        $durasiErr = "Durasi menginap harus angka positif";
    }

    // Menyimpan pilihan tipe kamar dan metode pembayaran
    $tipe_kamar = $_POST["tipe_kamar"];
    $metode_pembayaran = $_POST["metode_pembayaran"];

    // Hitung total pembayaran
    if (isset($harga_kamar[$tipe_kamar]) && is_numeric($durasi)) {
        $total_pembayaran = $harga_kamar[$tipe_kamar] * $durasi;
    }

    // Status pembayaran
    if (!empty($metode_pembayaran)) {
        $status_pembayaran = "Menunggu Pembayaran";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran Kamar Hotel</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Form Pembayaran Kamar Hotel</h2>
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>">
                <span class="error"><?php echo $namaErr ? "* $namaErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                <span class="error"><?php echo $emailErr ? "* $emailErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="nomor">Nomor Telepon:</label>
                <input type="text" id="nomor" name="nomor" value="<?php echo $nomor; ?>">
                <span class="error"><?php echo $nomorErr ? "* $nomorErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="tipe_kamar">Pilih Tipe Kamar:</label>
                <select id="tipe_kamar" name="tipe_kamar">
                    <option value="Standar" <?php echo ($tipe_kamar == "Standar") ? "selected" : ""; ?>>Standar - Rp500.000/malam</option>
                    <option value="Deluxe" <?php echo ($tipe_kamar == "Deluxe") ? "selected" : ""; ?>>Deluxe - Rp750.000/malam</option>
                    <option value="Suite" <?php echo ($tipe_kamar == "Suite") ? "selected" : ""; ?>>Suite - Rp1.200.000/malam</option>
                </select>
            </div>

            <div class="form-group">
                <label for="durasi">Durasi Menginap (malam):</label>
                <input type="text" id="durasi" name="durasi" value="<?php echo $durasi; ?>">
                <span class="error"><?php echo $durasiErr ? "* $durasiErr" : ""; ?></span>
            </div>

            <div class="form-group">
                <label for="metode_pembayaran">Metode Pembayaran:</label>
                <select id="metode_pembayaran" name="metode_pembayaran">
                    <option value="Cash" <?php echo ($metode_pembayaran == "Cash") ? "selected" : ""; ?>>Cash</option>
                    <option value="E-Wallet" <?php echo ($metode_pembayaran == "E-Wallet") ? "selected" : ""; ?>>E-Wallet</option>
                    <option value="Transfer" <?php echo ($metode_pembayaran == "Transfer") ? "selected" : ""; ?>>Transfer</option>
                </select>
            </div>

            <div class="button-container">
                <button type="submit">Bayar Sekarang</button>
            </div>
        </form>
    </div>

    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && !$namaErr && !$emailErr && !$nomorErr && !$durasiErr) { ?>
    <div class="container">
        <h3>Data Pembayaran:</h3>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th width="20%">Nama</th>
                        <th width="20%">Email</th>
                        <th width="15%">Nomor Telepon</th>
                        <th width="15%">Tipe Kamar</th>
                        <th width="10%">Durasi</th>
                        <th width="20%">Metode Pembayaran</th>
                        <th width="15%">Total Pembayaran</th>
                        <th width="15%">Status Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $nama; ?></td>
                        <td><?php echo $email; ?></td>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $tipe_kamar; ?></td>
                        <td><?php echo $durasi . " malam"; ?></td>
                        <td><?php echo $metode_pembayaran; ?></td>
                        <td>Rp<?php echo number_format($total_pembayaran, 0, ',', '.'); ?></td>
                        <td><?php echo $status_pembayaran; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php } ?>
</body>

</html>
