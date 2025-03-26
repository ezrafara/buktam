<?php
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <title>Login</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url(bg.jpg);
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        #bg-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        .container {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        h2 {
            color: white;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 10px 0;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            font-size: 16px;
            background: rgba(207, 207, 207, 0.2);
            color: black;
            outline: none;
        }

        input[type="text"]::placeholder,
        input[type="password"]::placeholder {
            color: rgba(0, 0, 0, 0.38);
        }

        input[type="submit"] {
            background: rgba(22, 92, 19, 0.7);
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            margin-top: 10px;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: rgb(22, 92, 19);
            box-shadow: 0 0 10px rgba(22, 92, 19, 0.8);
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="bg-video">
        <source src="bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container">
        <h2>Silahkan masuk,</h2>
        <?php if (isset($_GET['error'])): ?>
            <p style="color: red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <form method="POST" action="action_login.php">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" value="Masuk">
        </form>
    </div>
</body>
</html>