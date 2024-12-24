<?php
include 'db.php'; // Koneksi ke database

// Menangani pencarian produk
$search = isset($_GET['cari']) ? $_GET['cari'] : ''; // Ambil kata kunci pencarian

// Menggunakan prepared statement untuk menghindari SQL injection
$sql = $conn->prepare("SELECT * FROM produk WHERE name LIKE ?");
$searchTerm = "%" . $search . "%"; // Menambahkan wildcard untuk pencarian
$sql->bind_param("s", $searchTerm); // "s" berarti parameter string
$sql->execute();
$result = $sql->get_result(); // Menjalankan query dan mendapatkan hasilnya
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ina's Boutique</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
        }

        /* Header */
        header {
            background: url('uploads/background.jpeg') no-repeat center center/cover;
            height: 80vh;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            position: relative;
            padding: 20px;
        }

        /* Logo Styling */
        header .logo {
            max-width: 250px; /* Sesuaikan ukuran logo */
            height: auto;
            margin-bottom: 20px; /* Memberi jarak antara logo dan elemen lainnya */
        }

        header .search {
            margin-top: 20px;
        }

        .search input[type="text"] {
            padding: 10px;
            width: 250px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
        }

        .search button {
            padding: 10px 15px;
            background-color: #ff6f88;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-left: 10px;
        }

        /* Navbar */
        nav {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 20px;
        }

        nav a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            text-transform: uppercase;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #ffd1dc;
        }

        /* Produk Section */
        .produk {
            padding: 40px 0;
            text-align: center;
        }

        .produk h2 {
            font-size: 28px;
            margin-bottom: 30px;
            color: #333;
        }

        .produk-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            justify-items: center;
            padding: 0 20px;
        }

        .produk-item {
            background-color: #fff;
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 250px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: center;
        }

        .produk-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .produk-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .produk-item h3 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .produk-item p {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .produk-item p:last-child {
            font-size: 16px;
            color: #ff6f88;
            font-weight: bold;
        }

       

        /* Responsif */
        @media (max-width: 768px) {
            .produk-list {
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .produk-item {
                width: 90%;
                margin-bottom: 20px;
            }

            .search input[type="text"], .search button {
                width: 80%;
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <header>
        <img src="uploads/logo2-removebg-preview.png" alt="Logo Butik" class="logo"> <!-- Logo butik Anda -->
        <div class="search">
            <form method="GET">
                <input type="text" name="cari" placeholder="Cari produk..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Cari</button>
            </form>
        </div>
        <nav>
            <a href="index.php">Beranda</a>
            <a href="kontak.php">Kontak</a>
            <a href="login.php">Login Admin</a>
        </nav>
    </header>

    <!-- Produk -->
    <section class="produk">
        <h2>Produk Kami</h2>
        <div class="produk-list">
            <?php
            // Menampilkan produk yang ditemukan berdasarkan pencarian
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="produk-item">';
                    echo '<img src="uploads/' . $row['image'] . '" alt="' . $row['name'] . '">'; // Menampilkan gambar produk
                    echo '<h3>' . $row['name'] . '</h3>'; // Menampilkan nama produk
                    echo '<p>' . $row['dekripsi'] . '</p>'; // Menampilkan deskripsi produk
                    echo '<p>Rp ' . number_format($row['price'], 0, ',', '.') . '</p>'; // Menampilkan harga produk
                    echo '</div>';
                }
            } else {
                echo '<p>Produk tidak ditemukan.</p>';
            }
            ?>
        </div>
    </section>

</body>
</html>
