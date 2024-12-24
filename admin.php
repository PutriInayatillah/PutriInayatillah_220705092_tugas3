<?php
session_start(); // Memulai sesi

// Cek jika sesi admin belum ada, arahkan ke halaman login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Tambah atau Edit Produk
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $dekripsi = $_POST['dekripsi']; // Mendapatkan deskripsi dari form
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $query = "";

    if ($id == "") { // Jika ID kosong, tambahkan produk baru
        $target = "uploads/" . basename($image);
        $query = "INSERT INTO produk (name, dekripsi, price, image) VALUES ('$name', '$dekripsi', '$price', '$image')";
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else { // Jika ID ada, lakukan edit
        if (!empty($image)) {
            $target = "uploads/" . basename($image);
            $query = "UPDATE produk SET name='$name', dekripsi='$dekripsi', price='$price', image='$image' WHERE id=$id";
            move_uploaded_file($_FILES['image']['tmp_name'], $target);
        } else {
            $query = "UPDATE produk SET name='$name', dekripsi='$dekripsi', price='$price' WHERE id=$id";
        }
    }

    if ($conn->query($query) === TRUE) {
        header("Location: admin.php");
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}

// Hapus Produk
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM produk WHERE id=$id");
    header("Location: admin.php");
}

// Ambil Data Produk untuk Edit
$editProduct = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM produk WHERE id=$id");
    $editProduct = $result->fetch_assoc();
}

// Ambil Semua Produk
$query = "SELECT * FROM produk";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ina's Boutique</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffe4e6;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header {
            background-color: #ffb6c1;
            color: #fff;
            padding: 20px;
            position: relative;
            text-align: center;
            border-bottom: 4px solid #ff91a4;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .header .logout {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #ff91a4;
            color: #fff;
            text-decoration: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 14px;
        }

        .header .logout:hover {
            background-color: #ff6f88;
        }

        /* Main Section */
        main {
            padding: 20px;
            text-align: center;
        }

        h2 {
            color: #d14369;
            font-size: 26px;
            margin-bottom: 20px;
        }

        /* Form Produk */
        form {
            background-color: #fff0f3;
            border: 1px solid #ff91a4;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            margin: 20px auto;
            text-align: left;
        }

        form input[type="text"],
        form input[type="number"],
        form input[type="file"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ff91a4;
            border-radius: 5px;
            box-sizing: border-box;
        }

        form button {
            background-color: #ff91a4;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }

        form button:hover {
            background-color: #ff6f88;
        }

        /* Tabel Produk */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }

        table th, table td {
            padding: 12px;
            border: 1px solid #ff91a4;
            text-align: center;
        }

        table th {
            background-color: #ffb6c1;
            color: #fff;
        }

        table tbody tr:nth-child(even) {
            background-color: #ffe4e6;
        }

        table tbody tr:hover {
            background-color: #ffccd5;
        }

        table img {
            width: 80px;
            height: auto;
            border-radius: 5px;
        }

        table td a {
            text-decoration: none;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
        }

        table td a.edit {
            background-color: #ff91a4;
        }

        table td a.edit:hover {
            background-color: #ff6f88;
        }

        table td a.delete {
            background-color: #d14369;
        }

        table td a.delete:hover {
            background-color: #b03656;
        }

        /* Responsif */
        @media (max-width: 600px) {
            form {
                width: 90%;
            }

            table th, table td {
                font-size: 14px;
                padding: 8px;
            }

            table img {
                width: 60px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <a href="logout.php" class="logout">Logout</a>
        <h1>Admin Ina's Boutique</h1>
    </header>

    <!-- Main Section -->
    <main>
        <h2>Manajemen Produk</h2>

        <!-- Form Tambah/Edit Produk -->
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $editProduct['id'] ?? ''; ?>">
            <input type="text" name="name" placeholder="Nama Pakaian" value="<?php echo $editProduct['name'] ?? ''; ?>" required>
            <textarea name="dekripsi" placeholder="Deskripsi" required><?php echo $editProduct['dekripsi'] ?? ''; ?></textarea>
            <input type="number" name="price" placeholder="Harga Pakaian" value="<?php echo $editProduct['price'] ?? ''; ?>" required>
            <input type="file" name="image" accept="image/*">
            <?php if ($editProduct): ?>
                <button type="submit" name="save">Simpan Perubahan</button>
            <?php else: ?>
                <button type="submit" name="save">Tambah Produk</button>
            <?php endif; ?>
        </form>

        <!-- Tabel Produk -->
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['dekripsi']; ?></td>
                        <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                        <td>
                            <a class="edit" href="admin.php?edit=<?php echo $row['id']; ?>">Edit</a>
                            <a class="delete" href="admin.php?delete=<?php echo $row['id']; ?>">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
