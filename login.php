<?php
session_start(); // Memulai sesi

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek jika username dan password sesuai
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin'] = $username;
        header('Location: admin.php'); // Redirect ke dashboard admin
        exit;
    } else {
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        /* Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            width: 360px;
            padding: 20px 30px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        h2 {
            font-size: 28px;
            color: #ff6f88;
            margin-bottom: 20px;
            font-weight: bold;
        }

        label {
            font-size: 14px;
            color: #333;
            text-align: left;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus, input[type="password"]:focus {
            border-color: #ff6f88;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #ff6f88;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #ff4c69;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        /* Responsif */
        @media (max-width: 600px) {
            .login-container {
                width: 90%;
                padding: 15px 20px;
            }

            h2 {
                font-size: 24px;
            }

            input[type="text"], input[type="password"] {
                font-size: 16px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
