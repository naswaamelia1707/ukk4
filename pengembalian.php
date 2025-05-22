<?php
// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "buku";

$conn = mysqli_connect($host, $user, $password, $database); // Corrected $db to $database


// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$pesan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi dan sanitasi input
    $id_peminjaman = filter_input(INPUT_POST, 'id_peminjaman', FILTER_VALIDATE_INT);
    $nama_buku = htmlspecialchars(trim($_POST["nama_buku"] ?? ''));
    $tanggal_pengembalian = date("Y-m-d");
    $status = "Dikembalikan"; // Status tetap

    // Validasi data
    if ($id_peminjaman && !empty($nama_buku)) {
        // Mulai transaksi
        $conn->begin_transaction();
        
        try {
            // 1. Cek ketersediaan peminjaman
            $check_stmt = $conn->prepare("SELECT id FROM peminjaman WHERE id = ? AND status != 'Dikembalikan'");
            $check_stmt->bind_param("i", $id_peminjaman);
            $check_stmt->execute();
            
            if ($check_stmt->get_result()->num_rows > 0) {
                // 2. Simpan data pengembalian
                $insert_stmt = $conn->prepare("INSERT INTO pengembalian (id_peminjaman, nama_buku, tanggal_pengembalian, status) VALUES (?, ?, ?, ?)");
                $insert_stmt->bind_param("isss", $id_peminjaman, $nama_buku, $tanggal_pengembalian, $status);
                $insert_stmt->execute();
                
                // 3. Update status peminjaman
                $update_stmt = $conn->prepare("UPDATE peminjaman SET status = ? WHERE id = ?");
                $update_stmt->bind_param("si", $status, $id_peminjaman);
                $update_stmt->execute();
                
                $conn->commit();
                $pesan = "✅ Buku berhasil dikembalikan.";
            } else {
                $pesan = "⚠ ID Peminjaman tidak valid atau sudah dikembalikan.";
            }
        } catch (Exception $e) {
            $conn->rollback();
            $pesan = "⚠ Error: " . $e->getMessage();
        }
    } else {
        $pesan = "⚠ Harap isi semua data dengan benar!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengembalian Buku</title>
    <style>
        :root {
            --success: #4CAF50;
            --error: #F44336;
            --primary: #2196F3;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .alert {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #E8F5E9;
            color: var(--success);
            border-left: 4px solid var(--success);
        }
        .alert-error {
            background-color: #FFEBEE;
            color: var(--error);
            border-left: 4px solid var(--error);
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            background-color: var(--primary);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #0b7dda;
        }
        h2 {
            color: #333;
            margin-top: 0;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Form Pengembalian Buku</h2>

        <?php if (!empty($pesan)): ?>
            <div class="alert <?= strpos($pesan, '✅') !== false ? 'alert-success' : 'alert-error' ?>">
                <?= htmlspecialchars($pesan) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="id_peminjaman">ID Peminjaman</label>
                <input type="number" id="id_peminjaman" name="id_peminjaman" required min="1">
            </div>

            <div class="form-group">
                <label for="nama_buku">Nama Buku</label>
                <input type="text" id="nama_buku" name="nama_buku" required>
            </div>

            <div class="form-group">
                <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" value="<?= date('Y-m-d') ?>" required readonly>
            </div>

            <input type="submit" value="Proses Pengembalian">
        </form>
    </div>
</body>
</html>