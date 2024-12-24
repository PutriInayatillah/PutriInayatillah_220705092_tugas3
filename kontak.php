<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fbc2eb, #a18cd1);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .contact-container {
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            width: 90%;
            max-width: 900px;
            box-sizing: border-box;
        }

        h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }

        p {
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 30px;
        }

        .contact-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }

        /* Tombol dengan warna serasi dengan tema */
        .contact-button {
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .contact-button.shopee {
            background-color: #fb5411; /* Warna Shopee */
        }

        .contact-button.whatsapp {
            background-color: #25d366; /* Warna WhatsApp */
        }

        .contact-button.instagram {
            background-color: #e1306c; /* Warna Instagram */
        }

        .contact-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .contact-button img {
            width: 30px;
            height: 30px;
        }

        button {
            background-color: #ff79c6;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 16px;
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background-color: #ff4081;
        }

        /* Modal Style */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            overflow: auto;
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .modal-close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 25px;
        }

        .modal-close:hover,
        .modal-close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button[type="submit"] {
            background-color: #ff79c6;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #ff4081;
        }

        /* Responsive design for mobile */
        @media (max-width: 600px) {
            .contact-links {
                flex-direction: column;
            }

            .contact-button {
                width: 100%;
                margin-bottom: 20px;
            }
        }

        /* Styling for the order confirmation message */
        .thank-you-message {
            display: none;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 1.2rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>

<body>
    <div class="contact-container">
        <h1>Hubungi Kami</h1>
        <p>Untuk memesan produk, Anda bisa menghubungi kami melalui platform berikut:</p>
        <div class="contact-links">
            <a href="https://shopee.co.id/yourshop" target="_blank" class="contact-button shopee">
                <img src="uploads/shoope.png" alt="Shopee">
                Belanja di Shopee
            </a>
            <a href="https://wa.me/yourphone" target="_blank" class="contact-button whatsapp">
                <img src="uploads/wa.png" alt="WhatsApp">
                Chat via WhatsApp
            </a>
            <a href="https://instagram.com/yourprofile" target="_blank" class="contact-button instagram">
                <img src="uploads/ig.png" alt="Instagram">
                DM via Instagram
            </a>
            <button onclick="openModal()">Pesan Langsung</button>
        </div>
    </div>

    <!-- Modal Form Pemesanan -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <span class="modal-close" onclick="closeModal()">&times;</span>
            <h2>Form Pemesanan</h2>
            <form id="orderForm" onsubmit="submitOrder(event)">
                <div class="form-group">
                    <label for="nama">Nama Penerima</label>
                    <input type="text" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="alamat">Alamat Pengiriman</label>
                    <textarea id="alamat" name="alamat" required></textarea>
                </div>
                <div class="form-group">
                    <label for="produk">Produk yang Dipesan</label>
                    <input type="text" id="produk" name="produk" required>
                </div>
                <div class="form-group">
                    <label for="ukuran">Ukuran/Warna</label>
                    <input type="text" id="ukuran" name="ukuran" required>
                </div>
                <div class="form-group">
                    <label for="bukti-pembayaran">Upload Bukti Pembayaran</label>
                    <input type="file" id="bukti-pembayaran" name="bukti-pembayaran" accept="image/*, .pdf" required>
                </div>
                <button type="submit">Kirim Pemesanan</button>
            </form>
        </div>
    </div>

    <!-- Pesan Terima Kasih -->
    <div id="thankYouMessage" class="thank-you-message">
        <h2>Terima Kasih!</h2>
        <p>Terima kasih telah berbelanja di butik kami! Kami akan segera memproses pesanan Anda.</p>
    </div>

    <script>
        // Fungsi untuk membuka modal
        function openModal() {
            document.getElementById('orderModal').style.display = "block";
        }

        // Fungsi untuk menutup modal
        function closeModal() {
            document.getElementById('orderModal').style.display = "none";
        }

        // Fungsi untuk mengirim pesanan dan menampilkan pesan terima kasih
        function submitOrder(event) {
            event.preventDefault(); // Mencegah form dari reload halaman

            // Menyembunyikan form pemesanan dan menampilkan pesan terima kasih
            document.getElementById('orderModal').style.display = "none";
            document.getElementById('thankYouMessage').style.display = "block";
        }
    </script>
</body>

</html>

