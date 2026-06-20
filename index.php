<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SnackPos - Sistem POS Makanan Ringan</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&family=Fredoka+One&display=swap" rel="stylesheet">
<style>
  :root {
    --orange: #FF6B35;
    --orange-light: #FFF0EB;
    --orange-dark: #CC4E1F;
    --yellow: #FFB800;
    --yellow-light: #FFF8E6;
    --green: #2ECC71;
    --green-light: #E8FFF3;
    --green-dark: #1A8A4A;
    --red: #E74C3C;
    --red-light: #FDECEA;
    --blue: #3498DB;
    --blue-light: #EAF4FD;
    --purple: #9B59B6;
    --purple-light: #F3E9F9;
    --bg: #FFF9F5;
    --sidebar-bg: #1A0A00;
    --card: #FFFFFF;
    --text: #1A0A00;
    --text-muted: #7A6558;
    --border: #F0E6DF;
    --shadow: 0 2px 12px rgba(255,107,53,0.10);
    --radius: 14px;
    --radius-sm: 8px;
  }
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family:'Nunito',sans-serif; background:var(--bg); color:var(--text); display:flex; min-height:100vh; }

  /* SIDEBAR */
  .sidebar {
    width:220px; min-height:100vh; background:var(--sidebar-bg);
    display:flex; flex-direction:column; position:fixed; left:0; top:0; bottom:0; z-index:100;
  }
  .sidebar-logo {
    padding:24px 20px 20px;
    border-bottom:1px solid rgba(255,255,255,0.07);
  }
  .logo-title { font-family:'Fredoka One',cursive; font-size:26px; color:#FF6B35; letter-spacing:1px; }
  .logo-sub { font-size:11px; color:#7A6558; font-weight:600; letter-spacing:2px; text-transform:uppercase; margin-top:2px; }
  .sidebar-nav { flex:1; padding:16px 12px; overflow-y:auto; }
  .nav-section { font-size:10px; font-weight:700; letter-spacing:2px; color:#4A3728; text-transform:uppercase; padding:16px 8px 8px; }
  .nav-item {
    display:flex; align-items:center; gap:10px; padding:10px 12px;
    border-radius:var(--radius-sm); cursor:pointer; margin-bottom:2px;
    color:#B0A098; font-size:13.5px; font-weight:600; transition:all 0.18s;
    text-decoration:none;
  }
  .nav-item:hover { background:rgba(255,107,53,0.12); color:#FF8C5A; }
  .nav-item.active { background:rgba(255,107,53,0.18); color:#FF6B35; }
  .nav-item .nav-icon { font-size:18px; width:22px; text-align:center; }
  .sidebar-footer { padding:16px; border-top:1px solid rgba(255,255,255,0.07); }
  .user-badge { display:flex; align-items:center; gap:10px; }
  .user-avatar { width:36px; height:36px; border-radius:50%; background:var(--orange); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:14px; color:#fff; }
  .user-info .user-name { font-size:13px; font-weight:700; color:#E8D8C8; }
  .user-info .user-role { font-size:11px; color:#7A6558; font-weight:600; }

  /* MAIN */
  .main { margin-left:220px; flex:1; display:flex; flex-direction:column; min-height:100vh; }
  .topbar {
    background:#fff; border-bottom:1px solid var(--border);
    padding:14px 28px; display:flex; align-items:center; justify-content:space-between;
    position:sticky; top:0; z-index:50;
  }
  .page-title { font-size:20px; font-weight:800; color:var(--text); }
  .page-subtitle { font-size:12px; color:var(--text-muted); font-weight:600; margin-top:1px; }
  .topbar-right { display:flex; align-items:center; gap:12px; }
  .topbar-date { font-size:12px; color:var(--text-muted); font-weight:600; }
  .badge-notif { background:var(--orange); color:#fff; border-radius:50%; width:22px; height:22px; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; cursor:pointer; }

  /* CONTENT */
  .content { padding:24px 28px; flex:1; }
  .page { display:none; }
  .page.active { display:block; }

  /* CARDS */
  .stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:24px; }
  .stat-card {
    background:var(--card); border-radius:var(--radius); padding:20px;
    border:1px solid var(--border); position:relative; overflow:hidden;
  }
  .stat-card .stat-icon { font-size:28px; margin-bottom:8px; }
  .stat-card .stat-label { font-size:11px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:1px; }
  .stat-card .stat-value { font-size:24px; font-weight:800; margin-top:4px; }
  .stat-card .stat-sub { font-size:11px; font-weight:600; margin-top:4px; }
  .stat-card::after { content:''; position:absolute; right:-12px; bottom:-12px; width:70px; height:70px; border-radius:50%; opacity:0.08; }
  .stat-orange { border-left:4px solid var(--orange); }
  .stat-orange .stat-value { color:var(--orange); }
  .stat-orange::after { background:var(--orange); }
  .stat-green { border-left:4px solid var(--green); }
  .stat-green .stat-value { color:var(--green-dark); }
  .stat-green::after { background:var(--green); }
  .stat-blue { border-left:4px solid var(--blue); }
  .stat-blue .stat-value { color:var(--blue); }
  .stat-blue::after { background:var(--blue); }
  .stat-yellow { border-left:4px solid var(--yellow); }
  .stat-yellow .stat-value { color:#8B6000; }
  .stat-yellow::after { background:var(--yellow); }

  /* TABLES */
  .card { background:var(--card); border-radius:var(--radius); border:1px solid var(--border); overflow:hidden; }
  .card-header { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
  .card-title { font-size:15px; font-weight:800; }
  .card-body { padding:20px; }
  table { width:100%; border-collapse:collapse; font-size:13.5px; }
  thead th { background:#FFF0EB; color:var(--orange-dark); font-weight:700; font-size:11px; text-transform:uppercase; letter-spacing:1px; padding:10px 14px; text-align:left; }
  tbody td { padding:11px 14px; border-bottom:1px solid var(--border); color:var(--text); font-weight:500; }
  tbody tr:last-child td { border-bottom:none; }
  tbody tr:hover td { background:#FFF9F6; }

  /* FORMS */
  .form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:16px; }
  .form-group { display:flex; flex-direction:column; gap:6px; }
  .form-group.full { grid-column:1/-1; }
  label { font-size:12px; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.8px; }
  input[type=text], input[type=number], input[type=email], input[type=password], input[type=date], select, textarea {
    border:1.5px solid var(--border); border-radius:var(--radius-sm); padding:9px 13px;
    font-size:13.5px; font-family:'Nunito',sans-serif; font-weight:600; color:var(--text);
    background:#fff; transition:border-color 0.18s; outline:none;
  }
  input:focus, select:focus, textarea:focus { border-color:var(--orange); box-shadow:0 0 0 3px rgba(255,107,53,0.12); }
  textarea { resize:vertical; min-height:80px; }

  /* BUTTONS */
  .btn { display:inline-flex; align-items:center; gap:7px; padding:9px 18px; border-radius:var(--radius-sm); font-size:13px; font-weight:700; cursor:pointer; border:none; transition:all 0.18s; font-family:'Nunito',sans-serif; }
  .btn-primary { background:var(--orange); color:#fff; }
  .btn-primary:hover { background:var(--orange-dark); transform:translateY(-1px); box-shadow:0 4px 12px rgba(255,107,53,0.3); }
  .btn-secondary { background:var(--orange-light); color:var(--orange); border:1.5px solid #FFD5C2; }
  .btn-secondary:hover { background:#FFE4D4; }
  .btn-danger { background:var(--red-light); color:var(--red); border:1.5px solid #FACCC8; }
  .btn-danger:hover { background:#FBDDDA; }
  .btn-success { background:var(--green-light); color:var(--green-dark); border:1.5px solid #B8F0D2; }
  .btn-success:hover { background:#D4F7E7; }
  .btn-sm { padding:6px 12px; font-size:12px; }
  .btn-icon { padding:7px; border-radius:var(--radius-sm); }

  /* BADGES */
  .badge { display:inline-flex; align-items:center; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
  .badge-green { background:var(--green-light); color:var(--green-dark); }
  .badge-orange { background:var(--orange-light); color:var(--orange-dark); }
  .badge-red { background:var(--red-light); color:var(--red); }
  .badge-blue { background:var(--blue-light); color:var(--blue); }
  .badge-yellow { background:var(--yellow-light); color:#8B6000; }
  .badge-purple { background:var(--purple-light); color:var(--purple); }

  /* MODAL */
  .modal-overlay { position:fixed; inset:0; background:rgba(0,0,0,0.45); z-index:500; display:none; align-items:center; justify-content:center; }
  .modal-overlay.open { display:flex; }
  .modal { background:#fff; border-radius:var(--radius); width:580px; max-width:95vw; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.2); }
  .modal-header { padding:20px 24px 16px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
  .modal-title { font-size:17px; font-weight:800; }
  .modal-close { background:none; border:none; font-size:20px; cursor:pointer; color:var(--text-muted); line-height:1; }
  .modal-body { padding:20px 24px; }
  .modal-footer { padding:14px 24px; border-top:1px solid var(--border); display:flex; justify-content:flex-end; gap:10px; }

  /* SEARCH */
  .search-bar { position:relative; }
  .search-bar input { padding-left:36px; }
  .search-bar .search-icon { position:absolute; left:11px; top:50%; transform:translateY(-50%); color:var(--text-muted); font-size:15px; }

  /* ============================================================
     POS LAYOUT - UPDATED WITH REAL IMAGES
     ============================================================ */
  .pos-layout { display:grid; grid-template-columns:1fr 360px; gap:20px; height:calc(100vh - 130px); }
  .pos-products { overflow-y:auto; padding-right:4px; }
  .pos-cart { background:var(--card); border-radius:var(--radius); border:1px solid var(--border); display:flex; flex-direction:column; }

  .product-cats { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; }
  .cat-btn { padding:7px 16px; border-radius:20px; font-size:12.5px; font-weight:700; cursor:pointer; border:1.5px solid var(--border); background:#fff; color:var(--text-muted); transition:all 0.18s; }
  .cat-btn.active { background:var(--orange); color:#fff; border-color:var(--orange); }

  /* ---- PROFESSIONAL PRODUCT CARD ---- */
  .product-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(155px,1fr)); gap:14px; }

  .product-card {
    background:#fff;
    border-radius:12px;
    border:1.5px solid var(--border);
    overflow:hidden;
    cursor:pointer;
    transition:all 0.22s cubic-bezier(0.34,1.56,0.64,1);
    position:relative;
    box-shadow:0 1px 4px rgba(0,0,0,0.06);
  }
  .product-card:hover {
    border-color:var(--orange);
    transform:translateY(-4px) scale(1.02);
    box-shadow:0 10px 28px rgba(255,107,53,0.18);
  }
  .product-card:active { transform:scale(0.97); }

  /* Image container with fixed aspect ratio */
  .product-img-wrap {
    position:relative;
    width:100%;
    aspect-ratio:1 / 1;
    overflow:hidden;
    background:#f5f0ec;
  }
  .product-img-wrap img {
    width:100%;
    height:100%;
    object-fit:cover;
    transition:transform 0.3s ease;
    display:block;
  }
  .product-card:hover .product-img-wrap img {
    transform:scale(1.08);
  }

  /* Low stock badge on image */
  .product-img-wrap .stock-badge {
    position:absolute;
    top:8px;
    right:8px;
    background:rgba(231,76,60,0.92);
    color:#fff;
    font-size:10px;
    font-weight:800;
    padding:3px 7px;
    border-radius:20px;
    backdrop-filter:blur(4px);
    letter-spacing:0.3px;
  }
  .product-img-wrap .cat-label {
    position:absolute;
    top:8px;
    left:8px;
    background:rgba(26,10,0,0.65);
    color:#fff;
    font-size:9.5px;
    font-weight:700;
    padding:2px 8px;
    border-radius:20px;
    backdrop-filter:blur(4px);
    text-transform:uppercase;
    letter-spacing:0.5px;
  }

  /* Add to cart overlay button */
  .product-img-wrap .add-overlay {
    position:absolute;
    inset:0;
    background:rgba(255,107,53,0.85);
    display:flex;
    align-items:center;
    justify-content:center;
    opacity:0;
    transition:opacity 0.2s ease;
    font-size:28px;
  }
  .product-card:hover .add-overlay { opacity:1; }

  /* Card body */
  .product-info {
    padding:10px 12px 12px;
  }
  .product-info .p-name {
    font-size:12.5px;
    font-weight:700;
    color:var(--text);
    line-height:1.35;
    margin-bottom:6px;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
  }
  .product-info .p-bottom {
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .product-info .p-price {
    font-size:13.5px;
    font-weight:800;
    color:var(--orange);
  }
  .product-info .p-stock {
    font-size:10.5px;
    color:var(--text-muted);
    font-weight:600;
    background:var(--bg);
    padding:2px 7px;
    border-radius:10px;
  }
  .product-info .p-stock.low { color:var(--red); background:var(--red-light); }

  /* ---- CART ---- */
  .cart-header { padding:16px 18px; border-bottom:1px solid var(--border); }
  .cart-title { font-size:15px; font-weight:800; }
  .cart-customer { font-size:11.5px; color:var(--text-muted); margin-top:6px; font-weight:600; }
  .cart-items { flex:1; overflow-y:auto; padding:12px; }

  .cart-item {
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px;
    border-radius:var(--radius-sm);
    border:1px solid var(--border);
    margin-bottom:8px;
    transition:background 0.15s;
  }
  .cart-item:hover { background:#FFF9F6; }
  .cart-item-img {
    width:48px;
    height:48px;
    object-fit:cover;
    border-radius:8px;
    background:#f0ebe6;
    flex-shrink:0;
  }
  .cart-item-info { flex:1; min-width:0; }
  .cart-item-name { font-size:12.5px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
  .cart-item-price { font-size:11.5px; color:var(--text-muted); font-weight:600; margin-top:2px; }
  .cart-qty { display:flex; align-items:center; gap:6px; flex-shrink:0; }
  .qty-btn { width:24px; height:24px; border-radius:50%; border:1.5px solid var(--border); background:#fff; cursor:pointer; font-size:14px; font-weight:800; display:flex; align-items:center; justify-content:center; color:var(--orange); transition:all 0.15s; }
  .qty-btn:hover { background:var(--orange); color:#fff; border-color:var(--orange); }
  .qty-val { font-size:13px; font-weight:800; min-width:22px; text-align:center; }

  .cart-footer { padding:16px 18px; border-top:1px solid var(--border); }
  .cart-totals { margin-bottom:14px; }
  .cart-row { display:flex; justify-content:space-between; font-size:13px; font-weight:600; color:var(--text-muted); margin-bottom:6px; }
  .cart-row.total { font-size:16px; font-weight:800; color:var(--text); border-top:1.5px solid var(--border); padding-top:8px; margin-top:8px; }
  .pay-methods { display:grid; grid-template-columns:repeat(3,1fr); gap:7px; margin-bottom:12px; }
  .pay-btn { padding:8px 4px; border-radius:var(--radius-sm); font-size:11.5px; font-weight:700; cursor:pointer; border:1.5px solid var(--border); background:#fff; color:var(--text-muted); text-align:center; transition:all 0.18s; }
  .pay-btn.active { border-color:var(--orange); background:var(--orange-light); color:var(--orange); }

  .empty-cart { text-align:center; padding:40px 20px; color:var(--text-muted); }
  .empty-cart .empty-icon { font-size:48px; margin-bottom:12px; }
  .empty-cart p { font-size:13px; font-weight:600; }

  /* ALERTS */
  .alert { padding:12px 16px; border-radius:var(--radius-sm); font-size:13px; font-weight:600; margin-bottom:16px; display:flex; align-items:center; gap:10px; }
  .alert-success { background:var(--green-light); color:var(--green-dark); border:1px solid #B8F0D2; }
  .alert-warning { background:var(--yellow-light); color:#8B6000; border:1px solid #FFE082; }

  /* ---- TABLE PRODUCT IMAGE ---- */
  .tbl-img {
    width:42px;
    height:42px;
    object-fit:cover;
    border-radius:8px;
    background:#f0ebe6;
  }

  /* RESPONSIVE UTILS */
  .grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
  .grid-3 { display:grid; grid-template-columns:1fr 1fr 1fr; gap:20px; }
  .mt-4 { margin-top:16px; }
  .mt-6 { margin-top:24px; }
  .flex-between { display:flex; align-items:center; justify-content:space-between; }
  .flex-gap { display:flex; align-items:center; gap:10px; }
  .text-right { text-align:right; }
  .font-bold { font-weight:800; }
  .text-orange { color:var(--orange); }
  .text-green { color:var(--green-dark); }
  .text-red { color:var(--red); }
  .text-muted { color:var(--text-muted); }
  .mb-4 { margin-bottom:16px; }
  .mb-6 { margin-bottom:24px; }
  .w-full { width:100%; }

  /* RECEIPT MODAL */
  .receipt { background:#fff; font-family:'Courier New',monospace; }
  .receipt-header { text-align:center; padding-bottom:12px; border-bottom:2px dashed #ccc; margin-bottom:12px; }
  .receipt-shop { font-size:18px; font-weight:800; font-family:'Fredoka One',cursive; color:var(--orange); }
  .receipt-items { font-size:12px; }
  .receipt-item { display:flex; justify-content:space-between; margin:4px 0; }
  .receipt-total { border-top:2px dashed #ccc; margin-top:10px; padding-top:10px; font-size:13px; font-weight:700; }
  .receipt-footer { text-align:center; font-size:11px; color:#999; margin-top:12px; }

  /* IMAGE UPLOAD GUIDE BOX */
  .img-guide-box {
    background:linear-gradient(135deg,#FFF0EB,#FFF8E6);
    border:1.5px dashed var(--orange);
    border-radius:var(--radius);
    padding:16px 20px;
    margin-bottom:20px;
    font-size:13px;
    color:var(--text);
  }
  .img-guide-box h4 { font-size:13.5px; font-weight:800; color:var(--orange-dark); margin-bottom:6px; }
  .img-guide-box code { background:rgba(255,107,53,0.12); padding:1px 6px; border-radius:4px; font-size:12px; font-family:monospace; color:var(--orange-dark); }

  /* SCROLLBAR */
  ::-webkit-scrollbar { width:5px; }
  ::-webkit-scrollbar-track { background:transparent; }
  ::-webkit-scrollbar-thumb { background:#FFD5C2; border-radius:10px; }

  @keyframes fadeIn { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
  @keyframes slideIn { from{transform:translateX(100%);opacity:0} to{transform:translateX(0);opacity:1} }
  .page.active { animation:fadeIn 0.25s ease; }

  /* ===========================
     LOGIN SCREEN
  =========================== */
  #login-screen {
    position:fixed; inset:0; z-index:99999;
    background:linear-gradient(135deg,#1A0A00 0%,#3D1C00 60%,#FF6B35 100%);
    display:flex; align-items:center; justify-content:center;
    font-family:'Nunito',sans-serif;
  }
  #login-screen.hidden { display:none; }
  .login-wrap { width:100%; max-width:420px; padding:24px; }
  .login-card {
    background:#fff; border-radius:20px; padding:36px 36px 32px;
    box-shadow:0 24px 64px rgba(0,0,0,.5);
    animation:fadeIn .35s ease;
  }
  .login-brand { text-align:center; margin-bottom:28px; }
  .login-logo { font-family:'Fredoka One',cursive; font-size:36px; color:var(--orange); letter-spacing:1px; }
  .login-logo span { color:#1A0A00; }
  .login-tagline { font-size:12px; font-weight:700; color:var(--text-muted); letter-spacing:2px; text-transform:uppercase; margin-top:4px; }
  .login-divider { font-size:13px; font-weight:800; color:var(--text-muted); margin-bottom:20px; padding-bottom:20px; border-bottom:1px solid var(--border); text-align:center; }
  .login-field { margin-bottom:16px; }
  .login-field label { display:block; font-size:11.5px; font-weight:800; color:var(--text-muted); text-transform:uppercase; letter-spacing:.8px; margin-bottom:6px; }
  .login-field input {
    width:100%; padding:11px 14px; border:2px solid var(--border);
    border-radius:10px; font-size:14px; font-family:'Nunito',sans-serif;
    color:var(--text); outline:none; transition:border .18s, box-shadow .18s;
    box-sizing:border-box;
  }
  .login-field input:focus { border-color:var(--orange); box-shadow:0 0 0 3px rgba(255,107,53,.12); }
  .login-btn {
    width:100%; padding:13px; background:var(--orange); color:#fff;
    border:none; border-radius:10px; font-size:15px; font-weight:800;
    font-family:'Nunito',sans-serif; cursor:pointer;
    transition:background .15s, transform .1s; margin-top:6px;
    letter-spacing:.4px;
  }
  .login-btn:hover { background:var(--orange-dark); }
  .login-btn:active { transform:scale(.98); }
  .login-btn:disabled { background:#ccc; cursor:not-allowed; }
  .login-error {
    background:#FDECEA; color:var(--red); border:1px solid #f5c6c6;
    padding:10px 14px; border-radius:8px; font-size:12.5px; font-weight:700;
    margin-bottom:14px; display:none; text-align:center;
  }
  .login-error.show { display:block; }
  .login-hint {
    text-align:center; font-size:11.5px; color:var(--text-muted);
    margin-top:18px; padding-top:14px; border-top:1px solid var(--border);
  }
  .login-hint strong { color:var(--orange); }
  .login-dots { display:flex; justify-content:center; gap:8px; margin-top:24px; }
  .login-dots span { width:8px; height:8px; border-radius:50%; background:rgba(255,255,255,.3); }
  .login-dots span.on { background:#FF6B35; }

  /* ===========================
     TOPBAR LOGOUT BUTTON
  =========================== */
  .btn-logout {
    display:flex; align-items:center; gap:6px;
    padding:7px 14px; border-radius:8px;
    border:1.5px solid var(--border); background:#fff;
    font-size:12.5px; font-weight:700; font-family:'Nunito',sans-serif;
    color:var(--text-muted); cursor:pointer; transition:all .15s;
  }
  .btn-logout:hover { background:var(--red-light); color:var(--red); border-color:#f5c6c6; }
  .topbar-user {
    display:flex; align-items:center; gap:8px;
    font-size:12.5px; font-weight:700; color:var(--text-muted);
  }
  .topbar-avatar {
    width:30px; height:30px; border-radius:50%; background:var(--orange);
    color:#fff; font-size:13px; font-weight:800;
    display:flex; align-items:center; justify-content:center;
  }

  /* ===========================
     CUSTOM CONFIRM / ALERT POPUP
  =========================== */
  #custom-popup-overlay {
    position:fixed; inset:0; background:rgba(26,10,0,.55);
    z-index:999999; display:flex; align-items:center; justify-content:center;
    backdrop-filter:blur(2px); display:none;
  }
  #custom-popup-overlay.show { display:flex; }
  .cpop-box {
    background:#fff; border-radius:18px; padding:32px 32px 26px;
    min-width:320px; max-width:420px; width:90%;
    box-shadow:0 24px 60px rgba(0,0,0,.25); text-align:center;
    animation:fadeIn .2s ease;
  }
  .cpop-icon { font-size:42px; margin-bottom:12px; }
  .cpop-title { font-size:17px; font-weight:800; color:var(--text); margin-bottom:8px; }
  .cpop-msg { font-size:13.5px; color:var(--text-muted); font-weight:600; line-height:1.6; margin-bottom:22px; }
  .cpop-actions { display:flex; gap:10px; justify-content:center; }
  .cpop-btn {
    padding:10px 24px; border-radius:9px; font-size:13.5px; font-weight:800;
    font-family:'Nunito',sans-serif; cursor:pointer; border:none;
    min-width:100px; transition:all .15s;
  }
  .cpop-btn-cancel { background:var(--border); color:var(--text-muted); }
  .cpop-btn-cancel:hover { background:#e0d5cc; }
  .cpop-btn-ok { background:var(--orange); color:#fff; }
  .cpop-btn-ok:hover { background:var(--orange-dark); }
  .cpop-btn-ok.danger { background:var(--red); }
  .cpop-btn-ok.danger:hover { background:#c0392b; }
  .cpop-btn-ok.success { background:var(--green-dark); }
</style>
</head>
<body>

<!-- ========================
     LOGIN SCREEN
========================= -->
<div id="login-screen">
  <div class="login-wrap">
    <div class="login-card">
      <div class="login-brand">
        <div class="login-logo">🍟 Snack<span>Pos</span></div>
        <div class="login-tagline">Sistem POS Makanan Ringan</div>
      </div>
      <div class="login-divider">Masuk ke Akun Anda</div>
      <div class="login-error" id="login-error">⚠️ Username atau password salah!</div>
      <div class="login-field">
        <label>Username</label>
        <input type="text" id="li-username" placeholder="Masukkan username"
          autocomplete="username"
          onkeydown="if(event.key==='Enter')document.getElementById('li-password').focus()">
      </div>
      <div class="login-field">
        <label>Password</label>
        <input type="password" id="li-password" placeholder="Masukkan password"
          autocomplete="current-password"
          onkeydown="if(event.key==='Enter')doLogin()">
      </div>
      <button class="login-btn" id="login-btn" onclick="doLogin()">🔐 Masuk</button>
      <div class="login-hint">
        Default: <strong>admin</strong> / <strong>admin123</strong>
        &nbsp;·&nbsp; <strong>kasir1</strong> / <strong>kasir123</strong>
      </div>
    </div>
    <div class="login-dots">
      <span class="on"></span><span></span><span></span>
    </div>
  </div>
</div>

<!-- ========================
     CUSTOM POPUP (CONFIRM / ALERT)
========================= -->
<div id="custom-popup-overlay">
  <div class="cpop-box">
    <div class="cpop-icon" id="cpop-icon">❓</div>
    <div class="cpop-title" id="cpop-title">Konfirmasi</div>
    <div class="cpop-msg" id="cpop-msg">Apakah Anda yakin?</div>
    <div class="cpop-actions" id="cpop-actions">
      <button class="cpop-btn cpop-btn-cancel" id="cpop-cancel" onclick="closePopup(false)">Batal</button>
      <button class="cpop-btn cpop-btn-ok" id="cpop-ok" onclick="closePopup(true)">Ya, Lanjutkan</button>
    </div>
  </div>
</div>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-title">🍟 SnackPos</div>
    <div class="logo-sub">Makanan Ringan</div>
  </div>
  <nav class="sidebar-nav">
    <div class="nav-section">Utama</div>
    <a class="nav-item active" onclick="showPage('dashboard',this)">
      <span class="nav-icon">📊</span> Dashboard
    </a>
    <a class="nav-item" onclick="showPage('pos',this)">
      <span class="nav-icon">🛒</span> Kasir (POS)
    </a>
    <div class="nav-section">Master Data</div>
    <a class="nav-item" onclick="showPage('barang',this)">
      <span class="nav-icon">🍿</span> Master Barang
    </a>
    <a class="nav-item" onclick="showPage('kategori',this)">
      <span class="nav-icon">🏷️</span> Kategori
    </a>
    <a class="nav-item" onclick="showPage('supplier',this)">
      <span class="nav-icon">🚚</span> Supplier
    </a>
    <a class="nav-item" onclick="showPage('pelanggan',this)">
      <span class="nav-icon">👥</span> Pelanggan
    </a>
    <a class="nav-item" onclick="showPage('kasir-user',this)">
      <span class="nav-icon">👤</span> User Kasir
    </a>
    <div class="nav-section">Transaksi</div>
    <a class="nav-item" onclick="showPage('barang-masuk',this)">
      <span class="nav-icon">📦</span> Barang Masuk
    </a>
    <a class="nav-item" onclick="showPage('barang-keluar',this)">
      <span class="nav-icon">📤</span> Barang Keluar
    </a>
    <a class="nav-item" onclick="showPage('stok-opname',this)">
      <span class="nav-icon">📋</span> Stok Opname
    </a>
    <a class="nav-item" onclick="showPage('retur',this)">
      <span class="nav-icon">↩️</span> Retur
    </a>
    <div class="nav-section">Laporan</div>
    <a class="nav-item" onclick="showPage('lap-penjualan',null)">
      <span class="nav-icon">💰</span> Lap. Penjualan
    </a>
    <a class="nav-item" onclick="showPage('lap-stok',null)">
      <span class="nav-icon">📈</span> Lap. Stok
    </a>>
  </nav>
  <div class="sidebar-footer">
    <div class="user-badge">
      <div class="user-avatar" id="sb-avatar">AD</div>
      <div class="user-info">
        <div class="user-name" id="sb-name">Admin</div>
        <div class="user-role" id="sb-role">Administrator</div>
      </div>
    </div>
  </div>
</aside>

<!-- MAIN CONTENT -->
<main class="main">
  <div class="topbar">
    <div>
      <div class="page-title" id="topbar-title">Dashboard</div>
      <div class="page-subtitle" id="topbar-sub">Selamat datang di SnackPos</div>
    </div>
    <div class="topbar-right">
      <span class="topbar-date" id="today-date"></span>
      <div class="badge-notif" title="Notifikasi stok menipis">3</div>
      <div class="topbar-user">
        <div class="topbar-avatar" id="topbar-avatar">A</div>
        <span id="topbar-username">Admin</span>
      </div>
      <button class="btn-logout" onclick="doLogout()">🚪 Logout</button>
    </div>
  </div>
  <div class="content">

    <!-- DASHBOARD -->
    <div class="page active" id="page-dashboard">
      <div class="stat-grid">
        <div class="stat-card stat-orange">
          <div class="stat-icon">💰</div>
          <div class="stat-label">Penjualan Hari Ini</div>
          <div class="stat-value">Rp 1.245.000</div>
          <div class="stat-sub text-orange">↑ 12% dari kemarin</div>
        </div>
        <div class="stat-card stat-green">
          <div class="stat-icon">🧾</div>
          <div class="stat-label">Transaksi Hari Ini</div>
          <div class="stat-value">34</div>
          <div class="stat-sub text-green">↑ 5 transaksi</div>
        </div>
        <div class="stat-card stat-blue">
          <div class="stat-icon">🍿</div>
          <div class="stat-label">Total Produk</div>
          <div class="stat-value">47</div>
          <div class="stat-sub" style="color:var(--blue)">3 produk hampir habis</div>
        </div>
        <div class="stat-card stat-yellow">
          <div class="stat-icon">👥</div>
          <div class="stat-label">Total Pelanggan</div>
          <div class="stat-value">128</div>
          <div class="stat-sub" style="color:#8B6000">6 pelanggan baru</div>
        </div>
      </div>

      <div class="alert alert-warning">
        ⚠️ <strong>Stok Hampir Habis:</strong> Chitato Sapi Panggang (3 pcs), Momogi Jagung Bakar (2 pcs), Taro Original (5 pcs)
      </div>

      <div class="grid-2">
        <div class="card">
          <div class="card-header">
            <span class="card-title">🏆 Produk Terlaris</span>
            <span class="badge badge-orange">Bulan Ini</span>
          </div>
          <table>
            <thead><tr><th>#</th><th>Produk</th><th>Terjual</th><th>Revenue</th></tr></thead>
            <tbody>
              <tr><td>1</td><td> Chitato BBQ 68g</td><td>245 pcs</td><td class="font-bold text-orange">Rp 857.500</td></tr>
              <tr><td>2</td><td> Momogi Jagung</td><td>198 pcs</td><td class="font-bold text-orange">Rp 594.000</td></tr>
              <tr><td>3</td><td> Pringles Original</td><td>176 pcs</td><td class="font-bold text-orange">Rp 616.000</td></tr>
              <tr><td>4</td><td> Yupi Gummy</td><td>154 pcs</td><td class="font-bold text-orange">Rp 308.000</td></tr>
              <tr><td>5</td><td> Taro Rumput Laut</td><td>143 pcs</td><td class="font-bold text-orange">Rp 500.500</td></tr>
            </tbody>
          </table>
        </div>
        <div class="card">
          <div class="card-header">
            <span class="card-title">🕐 Transaksi Terakhir</span>
            <button class="btn btn-secondary btn-sm" onclick="showPage('lap-penjualan',null)">Lihat Semua</button>
          </div>
          <table>
            <thead><tr><th>No. Transaksi</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead>
            <tbody id="recent-trx"></tbody>
          </table>
        </div>
      </div>

      <div class="card mt-4">
        <div class="card-header">
          <span class="card-title">📉 Grafik Penjualan Mingguan</span>
        </div>
        <div class="card-body">
          <div style="display:flex;align-items:flex-end;gap:10px;height:120px;padding:10px 0">
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange-light);width:100%;border-radius:6px 6px 0 0;height:60%;display:flex;align-items:flex-end;justify-content:center;border:2px solid var(--orange)"><span style="font-size:10px;font-weight:700;color:var(--orange);padding:2px">860K</span></div><span style="font-size:11px;color:var(--text-muted);font-weight:600">Sen</span></div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange-light);width:100%;border-radius:6px 6px 0 0;height:75%;display:flex;align-items:flex-end;justify-content:center;border:2px solid var(--orange)"><span style="font-size:10px;font-weight:700;color:var(--orange);padding:2px">1,1Jt</span></div><span style="font-size:11px;color:var(--text-muted);font-weight:600">Sel</span></div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange-light);width:100%;border-radius:6px 6px 0 0;height:55%;display:flex;align-items:flex-end;justify-content:center;border:2px solid var(--orange)"><span style="font-size:10px;font-weight:700;color:var(--orange);padding:2px">780K</span></div><span style="font-size:11px;color:var(--text-muted);font-weight:600">Rab</span></div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange-light);width:100%;border-radius:6px 6px 0 0;height:88%;display:flex;align-items:flex-end;justify-content:center;border:2px solid var(--orange)"><span style="font-size:10px;font-weight:700;color:var(--orange);padding:2px">1,3Jt</span></div><span style="font-size:11px;color:var(--text-muted);font-weight:600">Kam</span></div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange);width:100%;border-radius:6px 6px 0 0;height:100%;display:flex;align-items:flex-end;justify-content:center;"><span style="font-size:10px;font-weight:700;color:#fff;padding:2px">1,5Jt</span></div><span style="font-size:11px;color:var(--orange);font-weight:700">Jum</span></div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange-light);width:100%;border-radius:6px 6px 0 0;height:70%;display:flex;align-items:flex-end;justify-content:center;border:2px solid var(--orange)"><span style="font-size:10px;font-weight:700;color:var(--orange);padding:2px">1,0Jt</span></div><span style="font-size:11px;color:var(--text-muted);font-weight:600">Sab</span></div>
            <div style="flex:1;display:flex;flex-direction:column;align-items:center;gap:6px"><div style="background:var(--orange-light);width:100%;border-radius:6px 6px 0 0;height:82%;display:flex;align-items:flex-end;justify-content:center;border:2px solid var(--orange)"><span style="font-size:10px;font-weight:700;color:var(--orange);padding:2px">1,2Jt</span></div><span style="font-size:11px;color:var(--text-muted);font-weight:600">Min</span></div>
          </div>
        </div>
      </div>
    </div>

    <!-- POS / KASIR -->
    <div class="page" id="page-pos">
      <div class="pos-layout">
        <div class="pos-products">
          <div class="product-cats" id="cat-filter">
            <!-- category buttons rendered dynamically by JS -->
          </div>
          <div class="product-grid" id="product-grid"></div>
        </div>
        <div class="pos-cart">
          <div class="cart-header">
            <div class="cart-title">🛒 Keranjang Belanja</div>
            <div class="cart-customer">
              <select id="cart-pelanggan" style="font-size:11.5px;padding:4px 8px;border-radius:6px;border:1px solid var(--border);color:var(--text-muted);width:100%;margin-top:4px">
                <option value="">-- Pilih Pelanggan (Opsional) --</option>
                <option>Ibu Sari</option><option>Bapak Hendra</option><option>Anak Muda</option>
              </select>
            </div>
          </div>
          <div class="cart-items" id="cart-items">
            <div class="empty-cart" id="empty-cart">
              <div class="empty-icon">🛒</div>
              <p>Pilih produk untuk mulai transaksi</p>
            </div>
          </div>
          <div class="cart-footer">
            <div class="cart-totals">
              <div class="cart-row"><span>Subtotal</span><span id="cart-subtotal">Rp 0</span></div>
              <div class="cart-row"><span>Diskon</span><span>Rp 0</span></div>
              <div class="cart-row total"><span>TOTAL</span><span id="cart-total" class="text-orange">Rp 0</span></div>
            </div>
            <div class="pay-methods">
              <button class="pay-btn active" onclick="selectPay(this)">💵 Tunai</button>
              <button class="pay-btn" onclick="selectPay(this)">📱 QRIS</button>
              <button class="pay-btn" onclick="selectPay(this)">🏦 Transfer</button>
            </div>
            <div class="flex-gap mb-4" id="bayar-input-group">
              <div style="flex:1">
                <label style="font-size:11px;color:var(--text-muted);font-weight:700">JUMLAH BAYAR</label>
                <input type="number" id="bayar-input" placeholder="0" style="width:100%;margin-top:4px" oninput="calcKembalian()">
              </div>
              <div style="flex:1">
                <label style="font-size:11px;color:var(--text-muted);font-weight:700">KEMBALIAN</label>
                <input type="text" id="kembalian-out" placeholder="Rp 0" readonly style="width:100%;margin-top:4px;background:#f9f9f9">
              </div>
            </div>
            <button class="btn btn-primary w-full" onclick="prosesTransaksi()" style="justify-content:center;font-size:15px;padding:13px">
              ✅ Proses Pembayaran
            </button>
            <button class="btn btn-danger w-full mt-4" onclick="clearCart()" style="justify-content:center">🗑️ Hapus Keranjang</button>
          </div>
        </div>
      </div>
    </div>

    <!-- MASTER BARANG -->
    <div class="page" id="page-barang">
      <div class="flex-between mb-6">
        <div class="search-bar" style="width:280px"><span class="search-icon">🔍</span><input type="text" placeholder="Cari barang..." oninput="filterBarang(this.value)"></div>
        <button class="btn btn-primary" onclick="openModal('modal-barang','')">➕ Tambah Barang</button>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr><th>Kode</th><th>Foto</th><th>Nama Barang</th><th>Kategori</th><th>Harga Beli</th><th>Harga Jual</th><th>Stok</th><th>Status</th><th>Aksi</th></tr>
          </thead>
          <tbody id="tbl-barang"></tbody>
        </table>
      </div>
    </div>

    <!-- KATEGORI -->
    <div class="page" id="page-kategori">
      <div class="flex-between mb-6">
        <span class="card-title">Daftar Kategori Produk</span>
        <button class="btn btn-primary" onclick="openModal('modal-kategori','')">➕ Tambah Kategori</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>Kode</th><th>Nama Kategori</th><th>Icon</th><th>Deskripsi</th><th>Jml Produk</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-kategori"></tbody>
        </table>
      </div>
    </div>

    <!-- SUPPLIER -->
    <div class="page" id="page-supplier">
      <div class="flex-between mb-6">
        <span class="card-title">Data Supplier</span>
        <button class="btn btn-primary" onclick="openModal('modal-supplier','')">➕ Tambah Supplier</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>Kode</th><th>Nama Supplier</th><th>Kontak</th><th>No. Telp</th><th>Email</th><th>Alamat</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-supplier"></tbody>
        </table>
      </div>
    </div>

    <!-- PELANGGAN -->
    <div class="page" id="page-pelanggan">
      <div class="flex-between mb-6">
        <span class="card-title">Data Pelanggan</span>
        <button class="btn btn-primary" onclick="openModal('modal-pelanggan','')">➕ Tambah Pelanggan</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>Kode</th><th>Nama</th><th>No. Telp</th><th>Email</th><th>Alamat</th><th>Poin</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-pelanggan"></tbody>
        </table>
      </div>
    </div>

    <!-- USER KASIR -->
    <div class="page" id="page-kasir-user">
      <div class="flex-between mb-6">
        <span class="card-title">Manajemen User Kasir</span>
        <button class="btn btn-primary" onclick="openModal('modal-user','')">➕ Tambah User</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>Kode</th><th>Nama</th><th>Username</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-user"></tbody>
        </table>
      </div>
    </div>

    <!-- BARANG MASUK -->
    <div class="page" id="page-barang-masuk">
      <div class="flex-between mb-6">
        <span class="card-title">Transaksi Barang Masuk</span>
        <button class="btn btn-primary" onclick="openModal('modal-masuk','')">➕ Tambah Barang Masuk</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>No. Transaksi</th><th>Tanggal</th><th>Supplier</th><th>Barang</th><th>Qty</th><th>Harga Beli</th><th>Total</th><th>No. Faktur</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-masuk"></tbody>
        </table>
      </div>
    </div>

    <!-- BARANG KELUAR -->
    <div class="page" id="page-barang-keluar">
      <div class="flex-between mb-6">
        <span class="card-title">Transaksi Barang Keluar</span>
        <button class="btn btn-primary" onclick="openModal('modal-keluar','')">➕ Tambah Barang Keluar</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>No. Transaksi</th><th>Tanggal</th><th>Barang</th><th>Qty</th><th>Tujuan</th><th>Keterangan</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-keluar"></tbody>
        </table>
      </div>
    </div>

    <!-- STOK OPNAME -->
    <div class="page" id="page-stok-opname">
      <div class="flex-between mb-6">
        <span class="card-title">Stok Opname</span>
        <button class="btn btn-primary" onclick="openModal('modal-opname','')">➕ Input Opname</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>No. Opname</th><th>Tanggal</th><th>Barang</th><th>Stok Sistem</th><th>Stok Fisik</th><th>Selisih</th><th>Keterangan</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-opname"></tbody>
        </table>
      </div>
    </div>

    <!-- RETUR -->
    <div class="page" id="page-retur">
      <div class="flex-between mb-6">
        <span class="card-title">Retur Penjualan</span>
        <button class="btn btn-primary" onclick="openModal('modal-retur','')">➕ Tambah Retur</button>
      </div>
      <div class="card">
        <table>
          <thead><tr><th>No. Retur</th><th>Tanggal</th><th>No. Transaksi</th><th>Barang</th><th>Qty</th><th>Alasan</th><th>Status</th><th>Aksi</th></tr></thead>
          <tbody id="tbl-retur"></tbody>
        </table>
      </div>
    </div>

    <!-- LAP PENJUALAN -->
    <div class="page" id="page-lap-penjualan">
      <div class="stat-grid" style="grid-template-columns:repeat(3,1fr)">
        <div class="stat-card stat-orange"><div class="stat-label">Total Penjualan Bulan Ini</div><div class="stat-value">Rp 38.450.000</div></div>
        <div class="stat-card stat-green"><div class="stat-label">Total Transaksi</div><div class="stat-value">847</div></div>
        <div class="stat-card stat-blue"><div class="stat-label">Rata-rata per Transaksi</div><div class="stat-value">Rp 45.400</div></div>
      </div>
      <div class="card">
        <div class="card-header">
          <span class="card-title">Laporan Penjualan</span>
          <div class="flex-gap">
            <input type="date" id="filter-dari" style="font-size:12px;padding:6px 10px">
            <input type="date" id="filter-sampai" style="font-size:12px;padding:6px 10px">
            <button class="btn btn-secondary btn-sm" onclick="exportLap()">📥 Export</button>
          </div>
        </div>
        <table>
          <thead><tr><th>No. Transaksi</th><th>Tgl &amp; Waktu</th><th>Kasir</th><th>Pelanggan</th><th>Items</th><th>Total</th><th>Bayar</th><th>Status</th></tr></thead>
          <tbody id="tbl-lap-jual"></tbody>
        </table>
      </div>
    </div>

    <!-- LAP STOK -->
    <div class="page" id="page-lap-stok">
      <div class="alert alert-warning">⚠️ 3 produk memiliki stok di bawah minimum. Segera lakukan pemesanan ulang.</div>
      <div class="card">
        <div class="card-header">
          <span class="card-title">Laporan Stok Barang</span>
          <button class="btn btn-secondary btn-sm" onclick="exportLap()">📥 Export</button>
        </div>
        <table>
          <thead><tr><th>Kode</th><th>Foto</th><th>Nama Barang</th><th>Kategori</th><th>Stok Saat Ini</th><th>Min. Stok</th><th>Status Stok</th><th>Harga Beli</th><th>Nilai Stok</th></tr></thead>
          <tbody id="tbl-lap-stok"></tbody>
        </table>
      </div>
    </div>

<!-- ======== MODALS ======== -->

<!-- MODAL BARANG -->
<div class="modal-overlay" id="modal-barang">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">🍿 Form Master Barang</span>
      <button class="modal-close" onclick="closeModal('modal-barang')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>Kode Barang</label><input type="text" id="brg-kode" placeholder="Auto: BRG-001"></div>
        <div class="form-group"><label>Nama Barang</label><input type="text" id="brg-nama" placeholder="Nama produk"></div>
        <div class="form-group"><label>Kategori</label>
          <select id="brg-kategori">
            <option>Keripik</option><option>Wafer</option><option>Permen</option>
            <option>Coklat</option><option>Kacang</option><option>Lainnya</option>
          </select>
        </div>
        <div class="form-group"><label>URL Gambar / Path Gambar</label><input type="text" id="brg-img" placeholder="https://... atau images/nama.jpg"></div>
        <div class="form-group"><label>Satuan</label>
          <select id="brg-satuan"><option>Pcs</option><option>Box</option><option>Kg</option><option>Gram</option></select>
        </div>
        <div class="form-group"><label>Harga Beli (Rp)</label><input type="number" id="brg-hbeli" placeholder="0"></div>
        <div class="form-group"><label>Harga Jual (Rp)</label><input type="number" id="brg-hjual" placeholder="0"></div>
        <div class="form-group"><label>Stok Awal</label><input type="number" id="brg-stok" placeholder="0"></div>
        <div class="form-group"><label>Stok Minimum</label><input type="number" id="brg-min" placeholder="10"></div>
        <div class="form-group"><label>Status</label>
          <select id="brg-status"><option>Aktif</option><option>Tidak Aktif</option></select>
        </div>
        <div class="form-group full"><label>Deskripsi</label><textarea id="brg-desk" placeholder="Deskripsi produk..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-barang')">Batal</button>
      <button class="btn btn-primary" onclick="saveBarang()">💾 Simpan Barang</button>
    </div>
  </div>
</div>

<!-- MODAL KATEGORI -->
<div class="modal-overlay" id="modal-kategori">
  <div class="modal" style="width:440px">
    <div class="modal-header">
      <span class="modal-title">🏷️ Form Kategori</span>
      <button class="modal-close" onclick="closeModal('modal-kategori')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>Kode Kategori</label><input type="text" id="kat-kode" placeholder="KAT-001"></div>
        <div class="form-group"><label>Nama Kategori</label><input type="text" id="kat-nama" placeholder="Nama kategori"></div>
        <div class="form-group"><label>Icon</label><input type="text" id="kat-icon" placeholder="🥔" maxlength="4"></div>
        <div class="form-group"><label>Warna</label><input type="color" id="kat-warna" value="#FF6B35" style="height:40px;cursor:pointer"></div>
        <div class="form-group full"><label>Deskripsi</label><textarea id="kat-desk" placeholder="Deskripsi kategori..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-kategori')">Batal</button>
      <button class="btn btn-primary" onclick="saveKategori()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL SUPPLIER -->
<div class="modal-overlay" id="modal-supplier">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">🚚 Form Supplier</span>
      <button class="modal-close" onclick="closeModal('modal-supplier')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>Kode Supplier</label><input type="text" id="sup-kode" placeholder="SUP-001"></div>
        <div class="form-group"><label>Nama Supplier</label><input type="text" id="sup-nama" placeholder="Nama perusahaan"></div>
        <div class="form-group"><label>Kontak Person</label><input type="text" id="sup-cp" placeholder="Nama PIC"></div>
        <div class="form-group"><label>No. Telepon</label><input type="text" id="sup-telp" placeholder="08xx-xxxx-xxxx"></div>
        <div class="form-group"><label>Email</label><input type="email" id="sup-email" placeholder="email@supplier.com"></div>
        <div class="form-group"><label>Status</label>
          <select id="sup-status"><option>Aktif</option><option>Tidak Aktif</option></select>
        </div>
        <div class="form-group full"><label>Alamat</label><textarea id="sup-alamat" placeholder="Alamat lengkap supplier..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-supplier')">Batal</button>
      <button class="btn btn-primary" onclick="saveSupplier()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL PELANGGAN -->
<div class="modal-overlay" id="modal-pelanggan">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">👥 Form Pelanggan</span>
      <button class="modal-close" onclick="closeModal('modal-pelanggan')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>Kode Pelanggan</label><input type="text" id="plg-kode" placeholder="PLG-001"></div>
        <div class="form-group"><label>Nama Pelanggan</label><input type="text" id="plg-nama" placeholder="Nama lengkap"></div>
        <div class="form-group"><label>No. Telepon</label><input type="text" id="plg-telp" placeholder="08xx-xxxx-xxxx"></div>
        <div class="form-group"><label>Email</label><input type="email" id="plg-email" placeholder="email@pelanggan.com"></div>
        <div class="form-group"><label>Tanggal Lahir</label><input type="date" id="plg-lahir"></div>
        <div class="form-group"><label>Status</label>
          <select id="plg-status"><option>Aktif</option><option>Tidak Aktif</option></select>
        </div>
        <div class="form-group full"><label>Alamat</label><textarea id="plg-alamat" placeholder="Alamat lengkap pelanggan..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-pelanggan')">Batal</button>
      <button class="btn btn-primary" onclick="savePelanggan()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL USER -->
<div class="modal-overlay" id="modal-user">
  <div class="modal" style="width:440px">
    <div class="modal-header">
      <span class="modal-title">👤 Form User Kasir</span>
      <button class="modal-close" onclick="closeModal('modal-user')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>Kode User</label><input type="text" id="usr-kode" placeholder="USR-001"></div>
        <div class="form-group"><label>Nama</label><input type="text" id="usr-nama" placeholder="Nama lengkap"></div>
        <div class="form-group"><label>Username</label><input type="text" id="usr-uname" placeholder="username login"></div>
        <div class="form-group"><label>Password</label><input type="password" id="usr-pass" placeholder="••••••••"></div>
        <div class="form-group"><label>Role</label>
          <select id="usr-role"><option>Admin</option><option>Kasir</option><option>Manager</option></select>
        </div>
        <div class="form-group"><label>Status</label>
          <select id="usr-status"><option>Aktif</option><option>Tidak Aktif</option></select>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-user')">Batal</button>
      <button class="btn btn-primary" onclick="saveUser()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL BARANG MASUK -->
<div class="modal-overlay" id="modal-masuk">
  <div class="modal">
    <div class="modal-header">
      <span class="modal-title">📦 Form Barang Masuk</span>
      <button class="modal-close" onclick="closeModal('modal-masuk')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>No. Transaksi</label><input type="text" id="msk-no" placeholder="Auto: TM-001" readonly></div>
        <div class="form-group"><label>Tanggal Masuk</label><input type="date" id="msk-tgl"></div>
        <div class="form-group"><label>Supplier</label>
          <select id="msk-sup"><option>PT Snack Nusantara</option><option>CV Rasa Jaya</option><option>UD Cemilan Sejahtera</option></select>
        </div>
        <div class="form-group"><label>No. Faktur</label><input type="text" id="msk-faktur" placeholder="No. faktur supplier"></div>
        <div class="form-group"><label>Nama Barang</label>
          <select id="msk-barang"><option>Chitato BBQ 68g</option><option>Momogi Jagung</option><option>Pringles Original</option></select>
        </div>
        <div class="form-group"><label>Jumlah</label><input type="number" id="msk-qty" placeholder="0"></div>
        <div class="form-group"><label>Harga Beli (Rp)</label><input type="number" id="msk-harga" placeholder="0"></div>
        <div class="form-group"><label>Total Harga</label><input type="text" id="msk-total" placeholder="Auto-hitung" readonly style="background:#f9f9f9"></div>
        <div class="form-group full"><label>Keterangan</label><textarea id="msk-ket" placeholder="Catatan tambahan..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-masuk')">Batal</button>
      <button class="btn btn-primary" onclick="saveMasuk()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL BARANG KELUAR -->
<div class="modal-overlay" id="modal-keluar">
  <div class="modal" style="width:480px">
    <div class="modal-header">
      <span class="modal-title">📤 Form Barang Keluar</span>
      <button class="modal-close" onclick="closeModal('modal-keluar')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>No. Transaksi</label><input type="text" id="klr-no" placeholder="Auto: TK-001" readonly></div>
        <div class="form-group"><label>Tanggal Keluar</label><input type="date" id="klr-tgl"></div>
        <div class="form-group"><label>Nama Barang</label>
          <select id="klr-barang"><option>Chitato BBQ 68g</option><option>Momogi Jagung</option><option>Pringles Original</option></select>
        </div>
        <div class="form-group"><label>Jumlah</label><input type="number" id="klr-qty" placeholder="0"></div>
        <div class="form-group full"><label>Tujuan/Keperluan</label><input type="text" id="klr-tujuan" placeholder="Contoh: Rusak, Sampel, Promosi"></div>
        <div class="form-group full"><label>Keterangan</label><textarea id="klr-ket" placeholder="Catatan tambahan..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-keluar')">Batal</button>
      <button class="btn btn-primary" onclick="saveKeluar()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL STOK OPNAME -->
<div class="modal-overlay" id="modal-opname">
  <div class="modal" style="width:480px">
    <div class="modal-header">
      <span class="modal-title">📋 Form Stok Opname</span>
      <button class="modal-close" onclick="closeModal('modal-opname')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>No. Opname</label><input type="text" id="opn-no" placeholder="Auto: OP-001" readonly></div>
        <div class="form-group"><label>Tanggal</label><input type="date" id="opn-tgl"></div>
        <div class="form-group full"><label>Nama Barang</label>
          <select id="opn-barang"><option>Chitato BBQ 68g</option><option>Momogi Jagung</option><option>Pringles Original</option></select>
        </div>
        <div class="form-group"><label>Stok Sistem</label><input type="number" id="opn-sistem" placeholder="0" readonly style="background:#f9f9f9"></div>
        <div class="form-group"><label>Stok Fisik</label><input type="number" id="opn-fisik" placeholder="0" oninput="calcSelisih()"></div>
        <div class="form-group"><label>Selisih</label><input type="text" id="opn-selisih" placeholder="Auto-hitung" readonly style="background:#f9f9f9"></div>
        <div class="form-group full"><label>Keterangan</label><textarea id="opn-ket" placeholder="Alasan selisih jika ada..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-opname')">Batal</button>
      <button class="btn btn-primary" onclick="saveOpname()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL RETUR -->
<div class="modal-overlay" id="modal-retur">
  <div class="modal" style="width:480px">
    <div class="modal-header">
      <span class="modal-title">↩️ Form Retur Penjualan</span>
      <button class="modal-close" onclick="closeModal('modal-retur')">✕</button>
    </div>
    <div class="modal-body">
      <div class="form-grid">
        <div class="form-group"><label>No. Retur</label><input type="text" id="ret-no" placeholder="Auto: RET-001" readonly></div>
        <div class="form-group"><label>Tanggal Retur</label><input type="date" id="ret-tgl"></div>
        <div class="form-group full"><label>No. Transaksi Asal</label><input type="text" id="ret-trx" placeholder="TRX-XXXX"></div>
        <div class="form-group full"><label>Nama Barang</label><input type="text" id="ret-barang" placeholder="Nama barang"></div>
        <div class="form-group"><label>Qty Retur</label><input type="number" id="ret-qty" placeholder="0"></div>
        <div class="form-group"><label>Alasan Retur</label>
          <select id="ret-alasan"><option>Barang Rusak</option><option>Salah Barang</option><option>Kadaluarsa</option><option>Lainnya</option></select>
        </div>
        <div class="form-group full"><label>Keterangan</label><textarea id="ret-ket" placeholder="Catatan tambahan..."></textarea></div>
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-retur')">Batal</button>
      <button class="btn btn-primary" onclick="saveRetur()">💾 Simpan</button>
    </div>
  </div>
</div>

<!-- MODAL RECEIPT -->
<div class="modal-overlay" id="modal-receipt">
  <div class="modal" style="width:360px">
    <div class="modal-header">
      <span class="modal-title">🧾 Struk Pembayaran</span>
      <button class="modal-close" onclick="closeModal('modal-receipt')">✕</button>
    </div>
    <div class="modal-body">
      <div class="receipt" id="receipt-content"></div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" onclick="closeModal('modal-receipt')">Tutup</button>
      <button class="btn btn-primary" onclick="printReceipt()">🖨️ Print Struk</button>
    </div>
  </div>
</div>

<script>
// ============================================================
// DATA PRODUK — DENGAN GAMBAR NYATA
// ============================================================
const dataProduk = [
  {id:'BRG-001',nama:'Chitato rasa rumput laut 68g',kat:'Keripik',
    img:'uploads/Chitato Lite Keripik Kentang Rumput Laut 68 g.jpg',
    hbeli:25000,hjual:35000,stok:45,min:10,status:'Aktif'},
  {id:'BRG-002',nama:'Momogi Jagung Bakar',kat:'keripik',
    img:'uploads/Momogi Jagung Bakar (Indonesia).jpg',
    hbeli:1500,hjual:2000,stok:2,min:15,status:'Aktif'},
  {id:'BRG-003',nama:'Pringles Original 110g',kat:'Keripik',
    img:'uploads/Batata Pringles Sabor Original 114G.webp',
    hbeli:22000,hjual:28000,stok:30,min:5,status:'Aktif'},
  {id:'BRG-004',nama:'Taro Rumput Laut',kat:'Keripik',
    img:'uploads/Taro net snack seaweed 115gr.jpg',
    hbeli:2000,hjual:3500,stok:5,min:10,status:'Aktif'},
  {id:'BRG-005',nama:'Richeese Nabati',kat:'Wafer',
    img:'uploads/Richeese Nabati Bites Wafer Krim Keju 115 g.jpg',
    hbeli:1500,hjual:2500,stok:60,min:20,status:'Aktif'},
  {id:'BRG-006',nama:'Roma Kelapa',kat:'Wafer',
    img:'uploads/Roma Kelapa 300gr.jpg',
    hbeli:3000,hjual:5000,stok:40,min:10,status:'Aktif'},
  {id:'BRG-007',nama:'Yupi Gummy Bear',kat:'Permen',
    img:'uploads/Yupi Gummy Candies Breakfast 95 g.jpg',
    hbeli:1000,hjual:2000,stok:80,min:20,status:'Aktif'},
  {id:'BRG-008',nama:'Nano-Nano',kat:'Permen',
    img:'uploads/Nano Nano Permen Manisan Buah - Netto 12_5 gr.jpg',
    hbeli:500,hjual:1000,stok:100,min:30,status:'Aktif'},
  {id:'BRG-009',nama:'Silverqueen Cashew',kat:'Coklat',
    img:'uploads/download.webp',
    hbeli:8000,hjual:12000,stok:25,min:8,status:'Aktif'},
  {id:'BRG-010',nama:'Cadbury Dairy Milk',kat:'Coklat',
    img:'uploads/Cadbury dairy milk 52gr coklat susu batang 52 gram khusus instan.jpg',
    hbeli:15000,hjual:22000,stok:18,min:5,status:'Aktif'},
  {id:'BRG-011',nama:'Garuda Kacang Atom',kat:'Kacang',
    img:'uploads/GARUDA SUKRO Original 100g - Legendary Atom Nuts, Crispy, Savory, Loyal Friends, Family Snack Time - Buy Many = More!!.jpg',
    hbeli:5000,hjual:8000,stok:35,min:10,status:'Aktif'},
  {id:'BRG-012',nama:'Sukro Kacang Bawang',kat:'Kacang',
    img:'uploads/Sukro oven.jpg',
    hbeli:3500,hjual:5500,stok:28,min:10,status:'Aktif'},
  {id:'BRG-013',nama:'Qtela Singkong',kat:'Keripik',
    img:'uploads/Q - TELA BALADO SNACKS 180 GR.jpg',
    hbeli:24000,hjual:26500,stok:22,min:8,status:'Aktif'},
  {id:'BRG-014',nama:'Mie kremez Enak',kat:'Lainnya',
    img:'uploads/Snack Mie Gemez Enak Kremez Enaak - Mie Kering Ringan, Kriuk, dan Praktis.jpg',
    hbeli:2000,hjual:3500,stok:55,min:20,status:'Aktif'},
  {id:'BRG-015',nama:'Monde Butter Cookies',kat:'Wafer',
    img:'uploads/Monde Butter Cookies _ Kukis Mentega 150 Gr.jpg',
    hbeli:20000,hjual:26000,stok:15,min:5,status:'Aktif'},
];

// Fallback image jika gambar gagal dimuat
const FALLBACK_IMG = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='300' height='300' viewBox='0 0 300 300'%3E%3Crect fill='%23FFF0EB' width='300' height='300'/%3E%3Ctext x='150' y='140' font-family='sans-serif' font-size='52' text-anchor='middle'%3E🍿%3C/text%3E%3Ctext x='150' y='185' font-family='sans-serif' font-size='14' fill='%23CC4E1F' text-anchor='middle'%3EGambar Produk%3C/text%3E%3C/svg%3E";

function imgWithFallback(src, alt, cls) {
  return `<img src="${src}" alt="${alt}" class="${cls}" onerror="this.src='${FALLBACK_IMG}'" loading="lazy">`;
}

const dataKategori = [
  {kode:'KAT-001',nama:'Keripik',icon:'🥔',desk:'Produk keripik aneka rasa',jml:5},
  {kode:'KAT-002',nama:'Wafer',icon:'🍩',desk:'Wafer dan biskuit',jml:3},
  {kode:'KAT-003',nama:'Permen',icon:'🍬',desk:'Permen dan candy',jml:2},
  {kode:'KAT-004',nama:'Coklat',icon:'🍫',desk:'Produk coklat',jml:2},
  {kode:'KAT-005',nama:'Kacang',icon:'🥜',desk:'Kacang-kacangan',jml:2},
  {kode:'KAT-006',nama:'Lainnya',icon:'',desk:'Produk snack lainnya',jml:1},
];

const dataSupplier = [
  {kode:'SUP-001',nama:'PT Snack Nusantara',cp:'Bapak Agus',telp:'021-5551234',email:'snacknusantara@email.com',alamat:'Jl. Industri No.12, Bekasi',status:'Aktif'},
  {kode:'SUP-002',nama:'CV Rasa Jaya',cp:'Ibu Dewi',telp:'021-7778890',email:'rasajaya@email.com',alamat:'Jl. Raya Bogor KM 40, Depok',status:'Aktif'},
  {kode:'SUP-003',nama:'UD Cemilan Sejahtera',cp:'Pak Bambang',telp:'0812-3456-7890',email:'cemilansjt@email.com',alamat:'Jl. Pasar Lama No.5, Jakarta',status:'Aktif'},
];

const dataPelanggan = [
  {kode:'PLG-001',nama:'Ibu Sari Dewi',telp:'0812-1111-2222',email:'sari@gmail.com',alamat:'Jl. Mawar No.10, Bekasi',poin:450,status:'Aktif'},
  {kode:'PLG-002',nama:'Bapak Hendra',telp:'0813-3333-4444',email:'hendra@gmail.com',alamat:'Jl. Melati No.5, Jakarta',poin:220,status:'Aktif'},
  {kode:'PLG-003',nama:'Putri Rahayu',telp:'0814-5555-6666',email:'putri@gmail.com',alamat:'Jl. Kenanga No.7, Depok',poin:120,status:'Aktif'},
];

const dataUser = [
  {kode:'USR-001',nama:'Admin SnackPos',uname:'admin',role:'Admin',status:'Aktif'},
  {kode:'USR-002',nama:'Kasir 1 - Ani',uname:'kasir1',role:'Kasir',status:'Aktif'},
  {kode:'USR-003',nama:'Kasir 2 - Budi',uname:'kasir2',role:'Kasir',status:'Aktif'},
  {kode:'USR-004',nama:'Manager Toko',uname:'manager',role:'Manager',status:'Aktif'},
];

const dataMasuk = [
  {no:'TM-001',tgl:'2026-05-20',sup:'PT Snack Nusantara',barang:'Chitato BBQ 68g',qty:100,harga:2500,total:250000,faktur:'FK-2026-0501'},
  {no:'TM-002',tgl:'2026-05-21',sup:'CV Rasa Jaya',barang:'Pringles Original 110g',qty:50,harga:12000,total:600000,faktur:'FK-2026-0502'},
  {no:'TM-003',tgl:'2026-05-23',sup:'UD Cemilan Sejahtera',barang:'Silverqueen Cashew',qty:30,harga:8000,total:240000,faktur:'FK-2026-0503'},
];

const dataKeluar = [
  {no:'TK-001',tgl:'2026-05-18',barang:'Momogi Jagung Bakar',qty:5,tujuan:'Rusak/Expired',ket:'Produk kadaluarsa'},
  {no:'TK-002',tgl:'2026-05-22',barang:'Nano-Nano',qty:10,tujuan:'Sampel Promosi',ket:'Untuk event promo'},
];

const dataOpname = [
  {no:'OP-001',tgl:'2026-05-15',barang:'Chitato BBQ 68g',sistem:45,fisik:43,selisih:-2,ket:'Kemungkinan hilang'},
  {no:'OP-002',tgl:'2026-05-15',barang:'Yupi Gummy Bear',sistem:80,fisik:82,selisih:+2,ket:'Kelebihan stok'},
];

const dataRetur = [
  {no:'RET-001',tgl:'2026-05-19',trx:'TRX-0541',barang:'Pringles Original 110g',qty:1,alasan:'Barang Rusak',status:'Diproses'},
  {no:'RET-002',tgl:'2026-05-23',trx:'TRX-0587',barang:'Silverqueen Cashew',qty:2,alasan:'Kadaluarsa',status:'Selesai'},
];

const dataTransaksi = [
  {no:'TRX-0585',tgl:'25/05/2026 08:12',kasir:'Kasir 1 - Ani',plg:'Umum',items:3,total:15500,bayar:'Tunai',status:'Lunas'},
  {no:'TRX-0586',tgl:'25/05/2026 09:30',kasir:'Kasir 2 - Budi',plg:'Ibu Sari',items:5,total:38000,bayar:'QRIS',status:'Lunas'},
  {no:'TRX-0587',tgl:'25/05/2026 10:45',kasir:'Kasir 1 - Ani',plg:'Umum',items:2,total:9000,bayar:'Tunai',status:'Lunas'},
  {no:'TRX-0588',tgl:'25/05/2026 11:20',kasir:'Kasir 2 - Budi',plg:'Bapak Hendra',items:7,total:72000,bayar:'Transfer',status:'Lunas'},
  {no:'TRX-0589',tgl:'25/05/2026 12:05',kasir:'Kasir 1 - Ani',plg:'Umum',items:4,total:22500,bayar:'Tunai',status:'Lunas'},
];

// ============================================================
// CART STATE
// ============================================================
let cart = [];
let selectedPayMethod = 'Tunai';

// ============================================================
// NAVIGATION
// ============================================================
const pageTitles = {
  dashboard: ['Dashboard','Selamat datang di SnackPos'],
  pos: ['Kasir (POS)','Proses transaksi penjualan'],
  barang: ['Master Barang','Kelola data produk makanan ringan'],
  kategori: ['Kategori','Kelola kategori produk'],
  supplier: ['Supplier','Data supplier & distributor'],
  pelanggan: ['Pelanggan','Data pelanggan terdaftar'],
  'kasir-user': ['User Kasir','Manajemen akun pengguna'],
  'barang-masuk': ['Barang Masuk','Transaksi penerimaan barang'],
  'barang-keluar': ['Barang Keluar','Transaksi pengeluaran barang'],
  'stok-opname': ['Stok Opname','Hasil penghitungan fisik stok'],
  retur: ['Retur Penjualan','Pengembalian barang dari pelanggan'],
  'lap-penjualan': ['Laporan Penjualan','Rekap transaksi penjualan'],
  'lap-stok': ['Laporan Stok','Status stok barang saat ini'],
  'panduan-gambar': ['Panduan Gambar Produk','Cara menambahkan foto produk ke sistem'],
};

function showPage(id, el) {
  document.querySelectorAll('.page').forEach(p=>p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n=>n.classList.remove('active'));
  document.getElementById('page-'+id).classList.add('active');
  if(el) el.classList.add('active');
  const titles = pageTitles[id]||[id,''];
  document.getElementById('topbar-title').textContent = titles[0];
  document.getElementById('topbar-sub').textContent = titles[1];
  renderPage(id);
}

function renderPage(id) {
  if(id==='barang') renderBarang(dataProduk);
  else if(id==='kategori') renderKategori();
  else if(id==='supplier') renderSupplier();
  else if(id==='pelanggan') renderPelanggan();
  else if(id==='kasir-user') renderUser();
  else if(id==='barang-masuk') renderMasuk();
  else if(id==='barang-keluar') renderKeluar();
  else if(id==='stok-opname') renderOpname();
  else if(id==='retur') renderRetur();
  else if(id==='lap-penjualan') renderLapJual();
  else if(id==='lap-stok') renderLapStok();
  else if(id==='pos') renderPOS('Semua');
  else if(id==='dashboard') renderDashboard();
}

// ============================================================
// RENDER FUNCTIONS
// ============================================================
function fmt(n) { return 'Rp '+n.toLocaleString('id-ID'); }

function renderDashboard() {
  const tb = document.getElementById('recent-trx');
  tb.innerHTML = dataTransaksi.slice(0,5).map(t=>`
    <tr>
      <td class="font-bold text-orange">${t.no}</td>
      <td>${t.plg}</td>
      <td class="font-bold">${fmt(t.total)}</td>
      <td><span class="badge badge-green">${t.status}</span></td>
    </tr>`).join('');
}

function renderBarang(data) {
  document.getElementById('tbl-barang').innerHTML = data.map(b=>`
    <tr>
      <td><span class="badge badge-blue">${b.id}</span></td>
      <td>${imgWithFallback(b.img, b.nama, 'tbl-img')}</td>
      <td class="font-bold">${b.nama}</td>
      <td><span class="badge badge-orange">${b.kat}</span></td>
      <td>${fmt(b.hbeli)}</td>
      <td class="font-bold text-orange">${fmt(b.hjual)}</td>
      <td>${b.stok<=b.min?`<span class="badge badge-red">⚠️ ${b.stok}</span>`:`<span class="badge badge-green">${b.stok}</span>`}</td>
      <td><span class="badge ${b.status==='Aktif'?'badge-green':'badge-red'}">${b.status}</span></td>
      <td>
        <div class="flex-gap">
          <button class="btn btn-secondary btn-sm btn-icon" title="Edit" onclick="editBarang('${b.id}')">✏️</button>
          <button class="btn btn-danger btn-sm btn-icon" title="Hapus" onclick="hapusRow('${b.id}','barang')">🗑️</button>
        </div>
      </td>
    </tr>`).join('');
}

function filterBarang(q) {
  const filtered = dataProduk.filter(b=>b.nama.toLowerCase().includes(q.toLowerCase())||b.kat.toLowerCase().includes(q.toLowerCase()));
  renderBarang(filtered);
}

function renderKategori() {
  document.getElementById('tbl-kategori').innerHTML = dataKategori.map(k=>`
    <tr>
      <td><span class="badge badge-blue">${k.kode}</span></td>
      <td class="font-bold">${k.nama}</td>
      <td style="font-size:22px">${k.icon}</td>
      <td>${k.desk}</td>
      <td><span class="badge badge-orange">${k.jml} produk</span></td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">✏️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

// ============================================================
// CATEGORY HELPERS — sinkronisasi dan render dinamis
// ============================================================
function updateCategoryCounts() {
  dataKategori.forEach(k=>{
    k.jml = dataProduk.filter(p=>p.kat===k.nama).length;
  });
}

function renderCatButtons() {
  const container = document.getElementById('cat-filter');
  if(!container) return;
  let html = `<button class="cat-btn active" onclick="filterCat('Semua',this)">🍽️ Semua</button>`;
  dataKategori.forEach(k=>{
    html += `<button class="cat-btn" onclick="filterCat('${k.nama}',this)">${k.icon} ${k.nama} <span class="badge badge-yellow" style="margin-left:8px;font-size:12px">${k.jml}</span></button>`;
  });
  container.innerHTML = html;
}

function populateCategorySelect() {
  const sel = document.getElementById('brg-kategori');
  if(!sel) return;
  sel.innerHTML = dataKategori.map(k=>`<option>${k.nama}</option>`).join('');
}

function renderSupplier() {
  document.getElementById('tbl-supplier').innerHTML = dataSupplier.map(s=>`
    <tr>
      <td><span class="badge badge-blue">${s.kode}</span></td>
      <td class="font-bold">${s.nama}</td>
      <td>${s.cp}</td>
      <td>${s.telp}</td>
      <td style="color:var(--blue)">${s.email}</td>
      <td style="max-width:160px;font-size:12px">${s.alamat}</td>
      <td><span class="badge badge-green">${s.status}</span></td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">✏️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderPelanggan() {
  document.getElementById('tbl-pelanggan').innerHTML = dataPelanggan.map(p=>`
    <tr>
      <td><span class="badge badge-blue">${p.kode}</span></td>
      <td class="font-bold">${p.nama}</td>
      <td>${p.telp}</td>
      <td style="color:var(--blue)">${p.email}</td>
      <td style="max-width:140px;font-size:12px">${p.alamat}</td>
      <td><span class="badge badge-yellow">⭐ ${p.poin} poin</span></td>
      <td><span class="badge badge-green">${p.status}</span></td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">✏️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderUser() {
  document.getElementById('tbl-user').innerHTML = dataUser.map(u=>`
    <tr>
      <td><span class="badge badge-blue">${u.kode}</span></td>
      <td class="font-bold">${u.nama}</td>
      <td style="font-family:monospace">${u.uname}</td>
      <td><span class="badge ${u.role==='Admin'?'badge-purple':u.role==='Manager'?'badge-blue':'badge-orange'}">${u.role}</span></td>
      <td><span class="badge badge-green">${u.status}</span></td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">✏️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderMasuk() {
  document.getElementById('tbl-masuk').innerHTML = dataMasuk.map(m=>`
    <tr>
      <td class="font-bold text-orange">${m.no}</td>
      <td>${m.tgl}</td>
      <td>${m.sup}</td>
      <td>${m.barang}</td>
      <td><span class="badge badge-blue">${m.qty} pcs</span></td>
      <td>${fmt(m.harga)}</td>
      <td class="font-bold">${fmt(m.total)}</td>
      <td style="font-size:12px">${m.faktur}</td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">👁️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderKeluar() {
  document.getElementById('tbl-keluar').innerHTML = dataKeluar.map(k=>`
    <tr>
      <td class="font-bold text-orange">${k.no}</td>
      <td>${k.tgl}</td>
      <td>${k.barang}</td>
      <td><span class="badge badge-red">${k.qty} pcs</span></td>
      <td><span class="badge badge-yellow">${k.tujuan}</span></td>
      <td>${k.ket}</td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">👁️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderOpname() {
  document.getElementById('tbl-opname').innerHTML = dataOpname.map(o=>`
    <tr>
      <td class="font-bold">${o.no}</td>
      <td>${o.tgl}</td>
      <td>${o.barang}</td>
      <td>${o.sistem}</td>
      <td>${o.fisik}</td>
      <td><span class="badge ${o.selisih<0?'badge-red':o.selisih>0?'badge-green':'badge-blue'}">${o.selisih>0?'+':''}${o.selisih}</span></td>
      <td>${o.ket}</td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">✏️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderRetur() {
  document.getElementById('tbl-retur').innerHTML = dataRetur.map(r=>`
    <tr>
      <td class="font-bold">${r.no}</td>
      <td>${r.tgl}</td>
      <td style="color:var(--orange);font-weight:700">${r.trx}</td>
      <td>${r.barang}</td>
      <td>${r.qty}</td>
      <td><span class="badge badge-red">${r.alasan}</span></td>
      <td><span class="badge ${r.status==='Selesai'?'badge-green':'badge-yellow'}">${r.status}</span></td>
      <td><div class="flex-gap">
        <button class="btn btn-secondary btn-sm btn-icon">✏️</button>
        <button class="btn btn-danger btn-sm btn-icon">🗑️</button>
      </div></td>
    </tr>`).join('');
}

function renderLapJual() {
  document.getElementById('tbl-lap-jual').innerHTML = dataTransaksi.map(t=>`
    <tr>
      <td class="font-bold text-orange">${t.no}</td>
      <td style="font-size:12px">${t.tgl}</td>
      <td>${t.kasir}</td>
      <td>${t.plg}</td>
      <td><span class="badge badge-blue">${t.items} item</span></td>
      <td class="font-bold">${fmt(t.total)}</td>
      <td><span class="badge ${t.bayar==='Tunai'?'badge-green':t.bayar==='QRIS'?'badge-purple':'badge-blue'}">${t.bayar}</span></td>
      <td><span class="badge badge-green">${t.status}</span></td>
    </tr>`).join('');
}

function renderLapStok() {
  document.getElementById('tbl-lap-stok').innerHTML = dataProduk.map(b=>{
    const status = b.stok<=b.min?'Menipis':b.stok>b.min*3?'Aman':'Normal';
    const badgeCls = status==='Menipis'?'badge-red':status==='Aman'?'badge-green':'badge-yellow';
    const nilai = b.stok*b.hbeli;
    return `<tr>
      <td><span class="badge badge-blue">${b.id}</span></td>
      <td>${imgWithFallback(b.img, b.nama, 'tbl-img')}</td>
      <td class="font-bold">${b.nama}</td>
      <td><span class="badge badge-orange">${b.kat}</span></td>
      <td class="font-bold">${b.stok} pcs</td>
      <td>${b.min} pcs</td>
      <td><span class="badge ${badgeCls}">${status}</span></td>
      <td>${fmt(b.hbeli)}</td>
      <td class="font-bold">${fmt(nilai)}</td>
    </tr>`;
  }).join('');
}

// ============================================================
// POS / KASIR — PRODUCT CARD DENGAN GAMBAR NYATA
// ============================================================
function renderPOS(cat) {
  const grid = document.getElementById('product-grid');
  const filtered = cat==='Semua'?dataProduk:dataProduk.filter(p=>p.kat===cat);
  grid.innerHTML = filtered.map(p=>{
    const isLowStock = p.stok <= p.min;
    return `
    <div class="product-card" onclick="addToCart('${p.id}')">
      <div class="product-img-wrap">
        <img src="${p.img}" alt="${p.nama}"
          onerror="this.src='${FALLBACK_IMG}'"
          loading="lazy">
        <span class="cat-label">${p.kat}</span>
        ${isLowStock ? `<span class="stock-badge">⚠️ Stok ${p.stok}</span>` : ''}
        <div class="add-overlay">➕</div>
      </div>
      <div class="product-info">
        <div class="p-name" title="${p.nama}">${p.nama}</div>
        <div class="p-bottom">
          <span class="p-price">${fmt(p.hjual)}</span>
          <span class="p-stock ${isLowStock?'low':''}">${p.stok} pcs</span>
        </div>
      </div>
    </div>`;
  }).join('');
}

function filterCat(cat, btn) {
  document.querySelectorAll('.cat-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  renderPOS(cat);
}

function addToCart(id) {
  const prod = dataProduk.find(p=>p.id===id);
  if(!prod) return;
  const existing = cart.find(c=>c.id===id);
  if(existing) {
    if(existing.qty>=prod.stok){alert('Stok tidak mencukupi!');return;}
    existing.qty++;
  } else {
    cart.push({...prod,qty:1});
  }
  renderCart();
}

function changeQty(id, delta) {
  const idx = cart.findIndex(c=>c.id===id);
  if(idx===-1) return;
  cart[idx].qty += delta;
  if(cart[idx].qty<=0) cart.splice(idx,1);
  renderCart();
}

function renderCart() {
  const container = document.getElementById('cart-items');
  if(cart.length===0){
    container.innerHTML = `<div class="empty-cart"><div class="empty-icon">🛒</div><p>Pilih produk untuk mulai transaksi</p></div>`;
    document.getElementById('cart-subtotal').textContent='Rp 0';
    document.getElementById('cart-total').textContent='Rp 0';
    return;
  }
  container.innerHTML = cart.map(item=>`
    <div class="cart-item">
      ${imgWithFallback(item.img, item.nama, 'cart-item-img')}
      <div class="cart-item-info">
        <div class="cart-item-name">${item.nama}</div>
        <div class="cart-item-price">${fmt(item.hjual)} × ${item.qty} = <strong>${fmt(item.hjual*item.qty)}</strong></div>
      </div>
      <div class="cart-qty">
        <button class="qty-btn" onclick="changeQty('${item.id}',-1)">−</button>
        <span class="qty-val">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty('${item.id}',1)">+</button>
      </div>
    </div>`).join('');
  const total = cart.reduce((s,c)=>s+c.hjual*c.qty,0);
  document.getElementById('cart-subtotal').textContent=fmt(total);
  document.getElementById('cart-total').textContent=fmt(total);
  calcKembalian();
}

function calcKembalian() {
  const total = cart.reduce((s,c)=>s+c.hjual*c.qty,0);
  const bayar = parseInt(document.getElementById('bayar-input').value)||0;
  const kembalian = bayar-total;
  const el = document.getElementById('kembalian-out');
  el.value = kembalian>=0?fmt(kembalian):'Kurang: '+fmt(Math.abs(kembalian));
  el.style.color = kembalian>=0?'var(--green-dark)':'var(--red)';
}

function selectPay(btn) {
  document.querySelectorAll('.pay-btn').forEach(b=>b.classList.remove('active'));
  btn.classList.add('active');
  selectedPayMethod = btn.textContent.trim().replace(/[^a-zA-Z ]/g,'').trim();
  const inputGroup = document.getElementById('bayar-input-group');
  inputGroup.style.display = btn.textContent.includes('Tunai')?'flex':'none';
}

function clearCart() {
  if(cart.length===0) return;
  showConfirm({
    icon:'🛒', title:'Hapus Keranjang',
    msg:'Semua item di keranjang akan dihapus. Lanjutkan?',
    okLabel:'Ya, Hapus', danger:true,
    onOk:function(){
      cart=[];
      renderCart();
      document.getElementById('bayar-input').value='';
      document.getElementById('kembalian-out').value='';
    }
  });
}

function prosesTransaksi() {
  if(cart.length===0){alert('Keranjang masih kosong!');return;}
  const total = cart.reduce((s,c)=>s+c.hjual*c.qty,0);
  const payMethod = document.querySelector('.pay-btn.active').textContent.trim();
  const isTunai = payMethod.includes('Tunai');
  const bayar = isTunai?(parseInt(document.getElementById('bayar-input').value)||0):total;
  if(isTunai && bayar<total){alert('Jumlah pembayaran kurang!');return;}

  const no = 'TRX-'+String(Math.floor(Math.random()*9000)+1000);
  const now = new Date();
  const tgl = `${now.getDate().toString().padStart(2,'0')}/${(now.getMonth()+1).toString().padStart(2,'0')}/${now.getFullYear()} ${now.getHours().toString().padStart(2,'0')}:${now.getMinutes().toString().padStart(2,'0')}`;

  const rcpt = document.getElementById('receipt-content');
  rcpt.innerHTML = `
    <div class="receipt-header">
      <div class="receipt-shop">🍟 SnackPos</div>
      <div style="font-size:11px;margin-top:2px">Toko Makanan Ringan Terlengkap</div>
      <div style="font-size:10px;color:#999;margin-top:4px">Jl. Cemilan No.1, Bekasi | 0812-SNACK-POS</div>
      <div style="font-size:10px;margin-top:6px">${tgl}</div>
      <div style="font-size:11px;font-weight:bold">No: ${no}</div>
    </div>
    <div class="receipt-items">
      ${cart.map(c=>`
        <div class="receipt-item"><span>${c.nama}</span><span>${fmt(c.hjual*c.qty)}</span></div>
        <div style="font-size:10px;color:#999;padding-left:4px">${c.qty} × ${fmt(c.hjual)}</div>
      `).join('')}
    </div>
    <div class="receipt-total">
      <div class="receipt-item"><span>Subtotal</span><span>${fmt(total)}</span></div>
      <div class="receipt-item"><span>Diskon</span><span>Rp 0</span></div>
      <div class="receipt-item" style="font-size:15px;margin-top:4px"><span>TOTAL</span><span>${fmt(total)}</span></div>
      <div class="receipt-item" style="color:#666"><span>Bayar (${payMethod.replace(/[^a-zA-Z ]/g,'').trim()})</span><span>${fmt(bayar)}</span></div>
      ${isTunai?`<div class="receipt-item" style="color:green"><span>Kembalian</span><span>${fmt(bayar-total)}</span></div>`:''}
    </div>
    <div class="receipt-footer">
      <div style="font-size:14px;margin-bottom:4px">Terima Kasih! 😊</div>
      <div>Barang yang dibeli tidak dapat dikembalikan</div>
      <div>tanpa bukti pembelian</div>
    </div>`;

  openModal('modal-receipt','');
  dataTransaksi.unshift({no,tgl,kasir:'Kasir 1 - Ani',plg:'Umum',items:cart.length,total,bayar:payMethod,status:'Lunas'});
  cart=[];
  renderCart();
  document.getElementById('bayar-input').value='';
  document.getElementById('kembalian-out').value='';
}

function printReceipt() {
  const content = document.getElementById('receipt-content').innerHTML;
  const win = window.open('','_blank');
  win.document.write(`<html><head><title>Struk</title><style>body{font-family:'Courier New',monospace;width:280px;margin:0 auto;padding:10px;font-size:12px}.receipt-item{display:flex;justify-content:space-between;margin:3px 0}</style></head><body>${content}<script>window.print()<\/script></body></html>`);
  win.document.close();
}

// ============================================================
// MODAL
// ============================================================
function openModal(id, data) {
  document.getElementById(id).classList.add('open');
  const today = new Date();
  const dateStr = today.toISOString().split('T')[0];
  if(id==='modal-masuk') { document.getElementById('msk-no').value='TM-'+String(dataMasuk.length+1).padStart(3,'0'); document.getElementById('msk-tgl').value=dateStr; }
  if(id==='modal-keluar') { document.getElementById('klr-no').value='TK-'+String(dataKeluar.length+1).padStart(3,'0'); document.getElementById('klr-tgl').value=dateStr; }
  if(id==='modal-opname') { document.getElementById('opn-no').value='OP-'+String(dataOpname.length+1).padStart(3,'0'); document.getElementById('opn-tgl').value=dateStr; document.getElementById('opn-sistem').value=45; }
  if(id==='modal-retur') { document.getElementById('ret-no').value='RET-'+String(dataRetur.length+1).padStart(3,'0'); document.getElementById('ret-tgl').value=dateStr; }
}
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-overlay').forEach(m=>{
  m.addEventListener('click',e=>{ if(e.target===m) m.classList.remove('open'); });
});

// ============================================================
// SAVE FUNCTIONS
// ============================================================
function saveBarang() {
  const nama=document.getElementById('brg-nama').value;
  if(!nama){alert('Nama barang wajib diisi!');return;}
  const imgUrl = document.getElementById('brg-img').value || FALLBACK_IMG;
  const newBrg = {
    id:'BRG-'+String(dataProduk.length+1).padStart(3,'0'),
    nama, img: imgUrl,
    kat:document.getElementById('brg-kategori').value,
    hbeli:parseInt(document.getElementById('brg-hbeli').value)||0,
    hjual:parseInt(document.getElementById('brg-hjual').value)||0,
    stok:parseInt(document.getElementById('brg-stok').value)||0,
    min:parseInt(document.getElementById('brg-min').value)||10,
    status:document.getElementById('brg-status').value,
  };
  dataProduk.push(newBrg);
  closeModal('modal-barang');
  renderBarang(dataProduk);
  // update kategori setelah menambah barang
  updateCategoryCounts();
  renderKategori();
  renderCatButtons();
  populateCategorySelect();
  showToast('✅ Barang berhasil ditambahkan!');
}

function saveKategori() {
  const nama=document.getElementById('kat-nama').value;
  if(!nama){alert('Nama kategori wajib diisi!');return;}
  dataKategori.push({kode:'KAT-'+String(dataKategori.length+1).padStart(3,'0'),nama,icon:document.getElementById('kat-icon').value||'📦',desk:document.getElementById('kat-desk').value,jml:0});
  // recalculasi dan render
  updateCategoryCounts();
  closeModal('modal-kategori'); renderKategori(); renderCatButtons(); populateCategorySelect(); showToast('✅ Kategori berhasil ditambahkan!');
}

function saveSupplier() {
  const nama=document.getElementById('sup-nama').value;
  if(!nama){alert('Nama supplier wajib diisi!');return;}
  dataSupplier.push({kode:'SUP-'+String(dataSupplier.length+1).padStart(3,'0'),nama,cp:document.getElementById('sup-cp').value,telp:document.getElementById('sup-telp').value,email:document.getElementById('sup-email').value,alamat:document.getElementById('sup-alamat').value,status:document.getElementById('sup-status').value});
  closeModal('modal-supplier'); renderSupplier(); showToast('✅ Supplier berhasil ditambahkan!');
}

function savePelanggan() {
  const nama=document.getElementById('plg-nama').value;
  if(!nama){alert('Nama pelanggan wajib diisi!');return;}
  dataPelanggan.push({kode:'PLG-'+String(dataPelanggan.length+1).padStart(3,'0'),nama,telp:document.getElementById('plg-telp').value,email:document.getElementById('plg-email').value,alamat:document.getElementById('plg-alamat').value,poin:0,status:document.getElementById('plg-status').value});
  closeModal('modal-pelanggan'); renderPelanggan(); showToast('✅ Pelanggan berhasil ditambahkan!');
}

function saveUser() {
  const nama=document.getElementById('usr-nama').value;
  if(!nama){alert('Nama user wajib diisi!');return;}
  dataUser.push({kode:'USR-'+String(dataUser.length+1).padStart(3,'0'),nama,uname:document.getElementById('usr-uname').value,role:document.getElementById('usr-role').value,status:document.getElementById('usr-status').value});
  closeModal('modal-user'); renderUser(); showToast('✅ User berhasil ditambahkan!');
}

function saveMasuk() {
  const barang=document.getElementById('msk-barang').value;
  const qty=parseInt(document.getElementById('msk-qty').value)||0;
  const harga=parseInt(document.getElementById('msk-harga').value)||0;
  if(!qty){alert('Jumlah barang wajib diisi!');return;}
  dataMasuk.unshift({no:document.getElementById('msk-no').value,tgl:document.getElementById('msk-tgl').value,sup:document.getElementById('msk-sup').value,barang,qty,harga,total:qty*harga,faktur:document.getElementById('msk-faktur').value||'-'});
  closeModal('modal-masuk'); renderMasuk(); showToast('✅ Barang masuk berhasil disimpan!');
}

function saveKeluar() {
  const barang=document.getElementById('klr-barang').value;
  const qty=parseInt(document.getElementById('klr-qty').value)||0;
  if(!qty){alert('Jumlah barang wajib diisi!');return;}
  dataKeluar.unshift({no:document.getElementById('klr-no').value,tgl:document.getElementById('klr-tgl').value,barang,qty,tujuan:document.getElementById('klr-tujuan').value||'Lainnya',ket:document.getElementById('klr-ket').value||'-'});
  closeModal('modal-keluar'); renderKeluar(); showToast('✅ Barang keluar berhasil disimpan!');
}

function saveOpname() {
  const barang=document.getElementById('opn-barang').value;
  const sistem=parseInt(document.getElementById('opn-sistem').value)||0;
  const fisik=parseInt(document.getElementById('opn-fisik').value)||0;
  dataOpname.unshift({no:document.getElementById('opn-no').value,tgl:document.getElementById('opn-tgl').value,barang,sistem,fisik,selisih:fisik-sistem,ket:document.getElementById('opn-ket').value||'-'});
  closeModal('modal-opname'); renderOpname(); showToast('✅ Stok opname berhasil disimpan!');
}

function saveRetur() {
  const barang=document.getElementById('ret-barang').value;
  const qty=parseInt(document.getElementById('ret-qty').value)||0;
  if(!barang||!qty){alert('Lengkapi data retur!');return;}
  dataRetur.unshift({no:document.getElementById('ret-no').value,tgl:document.getElementById('ret-tgl').value,trx:document.getElementById('ret-trx').value||'-',barang,qty,alasan:document.getElementById('ret-alasan').value,status:'Diproses'});
  closeModal('modal-retur'); renderRetur(); showToast('✅ Retur berhasil disimpan!');
}

function calcSelisih() {
  const s=parseInt(document.getElementById('opn-sistem').value)||0;
  const f=parseInt(document.getElementById('opn-fisik').value)||0;
  const sel=f-s;
  const el=document.getElementById('opn-selisih');
  el.value=(sel>0?'+':'')+sel;
  el.style.color=sel<0?'var(--red)':sel>0?'var(--green-dark)':'var(--text)';
}

function hapusRow(id, tabel) {
  showConfirm({
    icon:'🗑️', title:'Hapus Data',
    msg:'Data ini akan dihapus permanen dan tidak bisa dikembalikan.',
    okLabel:'Ya, Hapus', danger:true,
    onOk:()=>{ showToast('🗑️ Data berhasil dihapus!'); }
  });
}
function editBarang(id) { openModal('modal-barang',''); const b=dataProduk.find(b=>b.id===id); if(b){document.getElementById('brg-nama').value=b.nama; document.getElementById('brg-img').value=b.img||'';} }
function exportLap() { showToast('📥 Export data sedang diproses...'); }

// ============================================================
// CUSTOM POPUP ENGINE (menggantikan confirm() & alert() bawaan)
// ============================================================
let _popupCallback = null;

function showConfirm({ icon='❓', title='Konfirmasi', msg='Apakah Anda yakin?', okLabel='Ya, Lanjutkan', cancelLabel='Batal', danger=false, onOk=null }) {
  document.getElementById('cpop-icon').textContent  = icon;
  document.getElementById('cpop-title').textContent = title;
  document.getElementById('cpop-msg').textContent   = msg;
  document.getElementById('cpop-cancel').textContent= cancelLabel;
  const okBtn = document.getElementById('cpop-ok');
  okBtn.textContent = okLabel;
  okBtn.className   = 'cpop-btn cpop-btn-ok' + (danger ? ' danger' : '');
  document.getElementById('cpop-cancel').style.display = '';
  _popupCallback = onOk;
  document.getElementById('custom-popup-overlay').classList.add('show');
}

function showAlert({ icon='ℹ️', title='Informasi', msg='', okLabel='OK', success=false }) {
  document.getElementById('cpop-icon').textContent  = icon;
  document.getElementById('cpop-title').textContent = title;
  document.getElementById('cpop-msg').textContent   = msg;
  document.getElementById('cpop-cancel').style.display = 'none';
  const okBtn = document.getElementById('cpop-ok');
  okBtn.textContent = okLabel;
  okBtn.className   = 'cpop-btn cpop-btn-ok' + (success ? ' success' : '');
  _popupCallback = null;
  document.getElementById('custom-popup-overlay').classList.add('show');
}

function closePopup(confirmed) {
  document.getElementById('custom-popup-overlay').classList.remove('show');
  if(confirmed && _popupCallback) _popupCallback();
  _popupCallback = null;
}

// ============================================================
// AKUN PENGGUNA (untuk autentikasi login)
// ============================================================
const AKUN = [
  { nama:'Admin SnackPos', username:'admin',   password:'admin123', role:'Administrator', initial:'AD' },
  { nama:'Kasir 1 - Ani',  username:'kasir1',  password:'kasir123', role:'Kasir',         initial:'K1' },
  { nama:'Kasir 2 - Budi', username:'kasir2',  password:'kasir456', role:'Kasir',         initial:'K2' },
  { nama:'Manager Toko',   username:'manager', password:'mgr789',   role:'Manager',       initial:'MG' },
];

let activeUser = JSON.parse(sessionStorage.getItem('snackpos_user') || 'null');

function doLogin() {
  const uname = document.getElementById('li-username').value.trim();
  const pass  = document.getElementById('li-password').value;
  const errEl = document.getElementById('login-error');
  const btn   = document.getElementById('login-btn');
  errEl.classList.remove('show');

  if(!uname || !pass) {
    errEl.textContent = '⚠️ Username dan password wajib diisi!';
    errEl.classList.add('show'); return;
  }

  const found = AKUN.find(u => u.username === uname && u.password === pass);
  if(!found) {
    errEl.textContent = '❌ Username atau password salah!';
    errEl.classList.add('show');
    document.getElementById('li-password').value = '';
    document.getElementById('li-password').focus();
    return;
  }

  // Login sukses
  btn.disabled = true; btn.textContent = '⏳ Memuat...';
  activeUser = { nama: found.nama, username: found.username, role: found.role, initial: found.initial };
  sessionStorage.setItem('snackpos_user', JSON.stringify(activeUser));

  setTimeout(() => {
    applyUserUI();
    document.getElementById('login-screen').classList.add('hidden');
    document.getElementById('li-password').value = '';
    document.getElementById('li-username').value = '';
    btn.disabled = false; btn.textContent = '🔐 Masuk';
    showToast('👋 Selamat datang, ' + activeUser.nama + '!');
  }, 400);
}

function doLogout() {
  showConfirm({
    icon:'🚪', title:'Keluar dari Sistem',
    msg:'Sesi Anda akan diakhiri. Yakin ingin logout?',
    okLabel:'Ya, Logout', danger:true,
    onOk:function(){
      activeUser = null;
      sessionStorage.removeItem('snackpos_user');
      cart = [];
      document.getElementById('login-screen').classList.remove('hidden');
      document.getElementById('login-error').classList.remove('show');
      document.getElementById('li-username').value = '';
      document.getElementById('li-password').value = '';
      setTimeout(()=>document.getElementById('li-username').focus(), 100);
    }
  });
}

function applyUserUI() {
  if(!activeUser) return;
  // Sidebar
  document.getElementById('sb-avatar').textContent = activeUser.initial;
  document.getElementById('sb-name').textContent   = activeUser.nama;
  document.getElementById('sb-role').textContent   = activeUser.role;
  // Topbar
  document.getElementById('topbar-avatar').textContent  = activeUser.initial;
  document.getElementById('topbar-username').textContent = activeUser.nama;
  // Sembunyikan menu admin jika bukan Administrator
  const isAdmin = activeUser.role === 'Administrator';
  document.querySelectorAll('.nav-item').forEach(n => {
    const pg = n.getAttribute('onclick') || '';
    if(pg.includes("'kasir-user'") && !isAdmin) n.style.display='none';
    else n.style.display='';
  });
}

// ============================================================
// TOAST
// ============================================================
function showToast(msg) {
  const t = document.createElement('div');
  t.style.cssText='position:fixed;bottom:28px;right:28px;background:#1A0A00;color:#fff;padding:12px 20px;border-radius:10px;font-size:13.5px;font-weight:700;font-family:Nunito,sans-serif;z-index:9999;animation:slideIn 0.3s ease;box-shadow:0 8px 24px rgba(0,0,0,0.2)';
  t.textContent=msg;
  document.body.appendChild(t);
  setTimeout(()=>t.remove(),2800);
}

// ============================================================
// INIT
// ============================================================
document.addEventListener('DOMContentLoaded',()=>{
  const now = new Date();
  document.getElementById('today-date').textContent = now.toLocaleDateString('id-ID',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
  renderDashboard();
  // inisialisasi kategori dinamis dan dropdown
  updateCategoryCounts();
  renderCatButtons();
  populateCategorySelect();
  document.getElementById('msk-qty').addEventListener('input',()=>{
    const q=parseInt(document.getElementById('msk-qty').value)||0;
    const h=parseInt(document.getElementById('msk-harga').value)||0;
    document.getElementById('msk-total').value=fmt(q*h);
  });
  document.getElementById('msk-harga').addEventListener('input',()=>{
    const q=parseInt(document.getElementById('msk-qty').value)||0;
    const h=parseInt(document.getElementById('msk-harga').value)||0;
    document.getElementById('msk-total').value=fmt(q*h);
  });
});
</script>
</body>
</html>