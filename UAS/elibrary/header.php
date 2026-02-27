<?php
// Setiap halaman protected harus session_start() sebelum include header
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $pageTitle ?? 'E-Library System' ?></title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --navy:    #0f172a;
    --dark:    #1e293b;
    --darker:  #141f33;
    --gold:    #c9a84c;
    --gold-lt: #e6c97a;
    --cream:   #fdf6e3;
    --muted:   #64748b;
    --success: #22c55e;
    --danger:  #ef4444;
    --warning: #f59e0b;
    --info:    #3b82f6;
    --border:  rgba(255,255,255,.08);
  }

  html, body { height: 100%; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--navy);
    color: var(--cream);
    display: flex;
    flex-direction: column;
    min-height: 100vh;
  }

  /* ===== NAVBAR ===== */
  .navbar {
    background: var(--darker);
    border-bottom: 1px solid rgba(201,168,76,.2);
    padding: 0 32px;
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 4px 20px rgba(0,0,0,.4);
  }

  .nav-brand {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
  }
  .nav-brand .brand-icon {
    background: linear-gradient(135deg, var(--gold), #a07830);
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .nav-brand .brand-text {
    font-family: 'Playfair Display', serif;
    color: var(--cream);
    font-size: 18px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
  }
  .nav-links a {
    text-decoration: none;
    color: var(--muted);
    font-size: 14px;
    font-weight: 500;
    padding: 8px 14px;
    border-radius: 8px;
    transition: background .2s, color .2s;
    display: flex; align-items: center; gap: 6px;
  }
  .nav-links a:hover,
  .nav-links a.active { background: rgba(201,168,76,.15); color: var(--gold); }

  .nav-right {
    display: flex;
    align-items: center;
    gap: 12px;
  }
  .nav-user {
    display: flex; align-items: center; gap: 8px;
    color: var(--muted); font-size: 14px;
  }
  .avatar {
    width: 32px; height: 32px;
    background: linear-gradient(135deg, var(--gold), #a07830);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700;
    color: var(--navy);
    text-transform: uppercase;
  }
  .btn-logout {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 14px;
    background: rgba(239,68,68,.1);
    border: 1px solid rgba(239,68,68,.3);
    color: #fca5a5;
    font-size: 13px; font-weight: 500;
    border-radius: 8px;
    text-decoration: none;
    transition: background .2s;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
  }
  .btn-logout:hover { background: rgba(239,68,68,.2); }

  /* ===== MAIN CONTENT ===== */
  .main-content {
    flex: 1;
    padding: 32px;
    max-width: 1400px;
    width: 100%;
    margin: 0 auto;
  }

  /* ===== PAGE HEADER ===== */
  .page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
  }
  .page-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    color: var(--cream);
  }
  .page-header p { color: var(--muted); font-size: 14px; margin-top: 4px; }

  /* ===== CARD ===== */
  .card {
    background: var(--dark);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 28px;
    margin-bottom: 24px;
  }
  .card-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
  }
  .card-title {
    font-size: 16px; font-weight: 700; color: var(--cream);
    display: flex; align-items: center; gap: 8px;
  }

  /* ===== BUTTONS ===== */
  .btn {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 9px 18px;
    border-radius: 8px;
    font-size: 14px; font-weight: 500;
    cursor: pointer; text-decoration: none;
    border: none;
    font-family: 'DM Sans', sans-serif;
    transition: opacity .2s, transform .1s;
  }
  .btn:hover  { opacity: .88; }
  .btn:active { transform: scale(.97); }
  .btn-gold    { background: linear-gradient(135deg, var(--gold), #a07830); color: var(--navy); font-weight: 700; }
  .btn-success { background: rgba(34,197,94,.15); border: 1px solid rgba(34,197,94,.35); color: #86efac; }
  .btn-danger  { background: rgba(239,68,68,.15); border: 1px solid rgba(239,68,68,.35); color: #fca5a5; }
  .btn-info    { background: rgba(59,130,246,.15); border: 1px solid rgba(59,130,246,.35); color: #93c5fd; }
  .btn-sm      { padding: 6px 12px; font-size: 13px; }

  /* ===== TABLE ===== */
  .table-wrap { overflow-x: auto; }
  table { width: 100%; border-collapse: collapse; font-size: 14px; }
  thead th {
    background: rgba(201,168,76,.08);
    color: var(--gold);
    font-weight: 700;
    font-size: 12px;
    letter-spacing: .5px;
    text-transform: uppercase;
    padding: 12px 16px;
    text-align: left;
    border-bottom: 1px solid rgba(201,168,76,.2);
    white-space: nowrap;
  }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:hover { background: rgba(255,255,255,.03); }
  tbody td { padding: 12px 16px; color: var(--cream); vertical-align: middle; }
  .td-muted { color: var(--muted); font-size: 13px; }
  .badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
  }
  .badge-gold    { background: rgba(201,168,76,.15); color: var(--gold-lt); }
  .badge-info    { background: rgba(59,130,246,.15);  color: #93c5fd; }
  .badge-success { background: rgba(34,197,94,.15);   color: #86efac; }
  .badge-danger  { background: rgba(239,68,68,.15);   color: #fca5a5; }

  .book-thumb {
    width: 48px; height: 64px;
    object-fit: cover;
    border-radius: 6px;
    border: 1px solid var(--border);
  }
  .no-thumb {
    width: 48px; height: 64px;
    border-radius: 6px;
    background: rgba(255,255,255,.05);
    border: 1px dashed var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    color: var(--muted);
  }

  /* ===== FORM ===== */
  .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
  .form-group { display: flex; flex-direction: column; gap: 8px; }
  .form-group.full { grid-column: 1 / -1; }
  label { font-size: 14px; font-weight: 500; color: var(--cream); }
  label span { color: var(--danger); margin-left: 2px; }

  input[type="text"],
  input[type="number"],
  input[type="file"],
  select,
  textarea {
    background: var(--navy);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 10px;
    color: var(--cream);
    padding: 11px 14px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
    width: 100%;
  }
  input:focus, select:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(201,168,76,.18); }
  select option { background: var(--navy); }

  .form-hint { font-size: 12px; color: var(--muted); }
  .form-error { font-size: 12px; color: #fca5a5; }

  /* ===== ALERTS ===== */
  .alert {
    padding: 14px 18px;
    border-radius: 10px;
    font-size: 14px;
    margin-bottom: 20px;
    display: flex; align-items: flex-start; gap: 10px;
  }
  .alert-success { background: rgba(34,197,94,.1);  border: 1px solid rgba(34,197,94,.3);  color: #86efac; }
  .alert-danger  { background: rgba(239,68,68,.1);  border: 1px solid rgba(239,68,68,.3);  color: #fca5a5; }
  .alert-warning { background: rgba(245,158,11,.1); border: 1px solid rgba(245,158,11,.3); color: #fcd34d; }

  /* ===== STATS ===== */
  .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
  .stat-card {
    background: var(--dark);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 20px;
  }
  .stat-label { font-size: 12px; color: var(--muted); text-transform: uppercase; letter-spacing: .5px; margin-bottom: 8px; }
  .stat-value { font-size: 32px; font-weight: 700; font-family: 'Playfair Display', serif; }
  .stat-icon  { font-size: 28px; float: right; opacity: .6; }

  @media (max-width: 768px) {
    .main-content { padding: 16px; }
    .form-grid { grid-template-columns: 1fr; }
    .stats-grid { grid-template-columns: 1fr 1fr; }
  }

  /* ===== MODAL ===== */
  .modal-overlay {
    display: none; position: fixed; inset: 0;
    background: rgba(0,0,0,.7); backdrop-filter: blur(4px);
    z-index: 200; align-items: center; justify-content: center;
  }
  .modal-overlay.show { display: flex; }
  .modal {
    background: var(--dark);
    border: 1px solid rgba(201,168,76,.2);
    border-radius: 16px;
    padding: 32px;
    width: 90%; max-width: 580px;
    max-height: 90vh; overflow-y: auto;
    animation: fadeUp .3s ease;
  }
  @keyframes fadeUp {
    from { opacity:0; transform:translateY(20px); }
    to   { opacity:1; transform:translateY(0); }
  }
  .modal-header {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
  }
  .modal-title { font-size: 18px; font-weight: 700; font-family: 'Playfair Display', serif; }
  .modal-close {
    background: none; border: none; color: var(--muted);
    font-size: 22px; cursor: pointer; line-height: 1;
    transition: color .2s;
  }
  .modal-close:hover { color: var(--cream); }
</style>
</head>
<body>

<nav class="navbar">
  <a href="index.php" class="nav-brand">
    <div class="brand-icon">📚</div>
    <span class="brand-text">E-Library</span>
  </a>

  <ul class="nav-links">
    <li><a href="index.php" <?= (basename($_SERVER['PHP_SELF']) === 'index.php') ? 'class="active"' : '' ?>>🏠 Dashboard</a></li>
    <li><a href="buku.php" <?= (basename($_SERVER['PHP_SELF']) === 'buku.php') ? 'class="active"' : '' ?>>📖 Buku</a></li>
    <li><a href="penerbit.php" <?= (basename($_SERVER['PHP_SELF']) === 'penerbit.php') ? 'class="active"' : '' ?>>🏢 Penerbit</a></li>
    <li><a href="kategori.php" <?= (basename($_SERVER['PHP_SELF']) === 'kategori.php') ? 'class="active"' : '' ?>>🏷️ Kategori</a></li>
  </ul>

  <div class="nav-right">
    <div class="nav-user">
      <div class="avatar"><?= substr($_SESSION['user'], 0, 1) ?></div>
      <span><?= htmlspecialchars($_SESSION['user']) ?></span>
    </div>
    <a href="logout.php" class="btn-logout">🚪 Logout</a>
  </div>
</nav>

<div class="main-content">
