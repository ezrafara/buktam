<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'] ?? 'Pengguna';
$file = 'guestbook.txt';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama'], $_POST['email'], $_POST['komentar'])) {
    $nama = htmlspecialchars(trim($_POST['nama']));
    $email = htmlspecialchars(trim($_POST['email']));
    $komentar = htmlspecialchars(trim($_POST['komentar']));
    $waktu = date('Y-m-d H:i:s');
    
    $entry = "$waktu|$nama|$email|$komentar\n";
    file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);
    header("Location: dashboard.php");
    exit();
}

$entries = [];
if (file_exists($file)) {
    $lines = array_reverse(file($file, FILE_IGNORE_NEW_LINES));
    foreach ($lines as $line) {
        $data = explode('|', $line, 4);
        if (count($data) == 4) {
            $entries[] = [
                'waktu' => $data[0],
                'nama' => $data[1],
                'email' => $data[2],
                'komentar' => $data[3]
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-image: url(bg.jpg);
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            margin-top: 100px;
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

        .main-container {
            width: 90%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }

        h1, h2 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        h1 {
            font-size: 2.2rem;
        }

        h2 {
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        input, textarea {
            width: 96%;
            padding: 12px 15px;
            margin: 8px 0;
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 8px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            outline: none;
        }

        input::placeholder,
        textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        button {
            background: rgba(22, 92, 19, 0.7);
            color: white;
            border: none;
            padding: 12px;
            font-size: 1rem;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:hover {
            background: rgb(22, 92, 19);
            box-shadow: 0 0 15px rgba(22, 92, 19, 0.8);
        }

        .entries {
            margin-top: 30px;
        }

        .entry {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .entry h3 {
            color:rgb(255, 255, 255);
            margin: 0 0 0px 0;
        }

        .entry p {
            color: white;
            margin: 0 0 0px 0;
        }

        .entry small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.8rem;
            display: block;
        }

        .logout-btn {
            background: rgba(255, 69, 58, 0.7);
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            display: inline-block;
            margin-top: 25px;
            text-decoration: none;
            text-align: center;
            width: 94%;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgb(255, 69, 58);
            box-shadow: 0 0 15px rgba(255, 69, 58, 0.8);
        }

        .no-entries {
            color: white;
            text-align: center;
            font-style: italic;
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="bg-video">
        <source src="bg.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="main-container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        
        <div class="form-group">
            <h2>Tulis Pesan</h2>
            <form method="POST">
                <input type="text" name="nama" placeholder="Nama Anda" required>
                <input type="email" name="email" placeholder="Email Anda" required>
                <textarea name="komentar" placeholder="Tulis pesan Anda..." required></textarea>
                <button type="submit">Kirim Pesan</button>
            </form>
        </div>
        
        <div class="entries">
            <h2>Daftar Pesan</h2>
            <?php if (!empty($entries)): ?>
                <?php foreach ($entries as $entry): ?>
                    <div class="entry">
                        <h3><?php echo htmlspecialchars($entry['nama']); ?></h3>
                        <p><?php echo htmlspecialchars($entry['komentar']); ?></p>
                        <small>Email: <?php echo htmlspecialchars($entry['email']); ?></small>
                        <small><?php echo $entry['waktu']; ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-entries">Belum ada pesan.</p>
            <?php endif; ?>
        </div>
        
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>