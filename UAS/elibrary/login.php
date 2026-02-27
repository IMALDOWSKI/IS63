<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

require_once 'koneksi.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = 'Username dan password wajib diisi!';
    } else {
        $username_safe = mysqli_real_escape_string($conn, $username);
        $sql  = "SELECT * FROM users WHERE username = '$username_safe' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            // Mendukung MD5 (lama) maupun password_hash (baru)
            $valid = (md5($password) === $user['password'])
                  || password_verify($password, $user['password']);

            if ($valid) {
                $_SESSION['user']     = $user['username'];
                $_SESSION['id_user']  = $user['id_user'];
                header('Location: index.php');
                exit;
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username tidak ditemukan!';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — E-Library</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --navy:   #0f172a;
    --gold:   #c9a84c;
    --cream:  #fdf6e3;
    --dark:   #1e293b;
    --muted:  #64748b;
    --error:  #ef4444;
  }

  body {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--navy);
    font-family: 'DM Sans', sans-serif;
    position: relative;
    overflow: hidden;
  }

  /* decorative background circles */
  body::before {
    content: '';
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,.15) 0%, transparent 70%);
    top: -150px; right: -150px;
  }
  body::after {
    content: '';
    position: absolute;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(201,168,76,.08) 0%, transparent 70%);
    bottom: -100px; left: -100px;
  }

  .card {
    background: var(--dark);
    border: 1px solid rgba(201,168,76,.25);
    border-radius: 16px;
    padding: 48px 40px;
    width: 100%;
    max-width: 420px;
    position: relative;
    z-index: 1;
    box-shadow: 0 25px 60px rgba(0,0,0,.5);
    animation: fadeUp .5s ease;
  }

  @keyframes fadeUp {
    from { opacity:0; transform:translateY(24px); }
    to   { opacity:1; transform:translateY(0); }
  }

  .logo {
    text-align: center;
    margin-bottom: 32px;
  }
  .logo-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 64px; height: 64px;
    background: linear-gradient(135deg, var(--gold), #a07830);
    border-radius: 16px;
    margin-bottom: 16px;
    font-size: 28px;
  }
  .logo h1 {
    font-family: 'Playfair Display', serif;
    color: var(--cream);
    font-size: 26px;
    line-height: 1.2;
  }
  .logo p {
    color: var(--muted);
    font-size: 13px;
    margin-top: 6px;
  }

  .alert-error {
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.4);
    color: #fca5a5;
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 14px;
    margin-bottom: 20px;
  }

  label {
    display: block;
    color: var(--cream);
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 8px;
  }

  input[type="text"],
  input[type="password"] {
    width: 100%;
    background: var(--navy);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 10px;
    color: var(--cream);
    padding: 12px 16px;
    font-size: 15px;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    margin-bottom: 18px;
  }
  input:focus {
    border-color: var(--gold);
    box-shadow: 0 0 0 3px rgba(201,168,76,.2);
  }

  .btn-login {
    width: 100%;
    padding: 13px;
    background: linear-gradient(135deg, var(--gold), #a07830);
    color: var(--navy);
    font-weight: 700;
    font-size: 15px;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    letter-spacing: .5px;
    transition: opacity .2s, transform .1s;
    margin-top: 4px;
  }
  .btn-login:hover  { opacity: .9; }
  .btn-login:active { transform: scale(.98); }

  .footer-note {
    text-align: center;
    color: var(--muted);
    font-size: 12px;
    margin-top: 24px;
  }
</style>
</head>
<body>
<div class="card">
  <div class="logo">
    <div class="logo-icon">📚</div>
    <h1>E-Library System</h1>
    <p>Sistem Manajemen Perpustakaan Digital</p>
  </div>

  <?php if ($error): ?>
    <div class="alert-error">⚠️ <?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="">
    <label for="username">Username</label>
    <input type="text" id="username" name="username"
           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
           placeholder="Masukkan username" autocomplete="username">

    <label for="password">Password</label>
    <input type="password" id="password" name="password"
           placeholder="Masukkan password" autocomplete="current-password">

    <button type="submit" class="btn-login">🔐 Masuk</button>
  </form>

  <p class="footer-note">E-Library Management System &copy; <?= date('Y') ?></p>
</div>
</body>
</html>
