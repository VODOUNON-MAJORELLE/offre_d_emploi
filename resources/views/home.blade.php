<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Talentlink — Trouvez votre job idéal</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --accent: #5040e8;
      --accent-light: #eeeeff;
      --accent-mid: #6c5ce7;
      --text-primary: #1a1550;
      --text-secondary: #6b6b8d;
      --text-muted: #a0a0c0;
      --border: #e4e4f0;
      --bg: #f6f7fb;
      --white: #ffffff;
      --radius: 16px;
      --radius-sm: 10px;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--white);
      color: var(--text-primary);
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* ── NAVBAR ── */
    .navbar {
      position: sticky; top: 0; z-index: 200;
      background: rgba(255,255,255,0.95);
      backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
      height: 60px;
      display: flex; align-items: center;
      padding: 0 2.5rem; gap: 2rem;
    }

    .nav-logo { display: flex; align-items: center; gap: 9px; text-decoration: none; margin-right: 1.5rem; }
    .nav-logo-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 12px; color: #fff;
    }
    .nav-logo-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; color: var(--text-primary); }

    .nav-links { display: flex; gap: 0.2rem; flex: 1; }
    .nav-link {
      padding: 6px 14px; font-size: 14px; font-weight: 500;
      color: var(--text-secondary); text-decoration: none;
      border-radius: 8px; transition: color 0.15s, background 0.15s;
    }
    .nav-link:hover { color: var(--text-primary); background: var(--bg); }
    .nav-link.active {
      color: var(--accent);
      border-bottom: 2px solid var(--accent);
      border-radius: 0; background: none;
    }

    .nav-right { display: flex; align-items: center; gap: 10px; margin-left: auto; }
    .btn-ghost-nav {
      padding: 8px 18px; font-size: 14px; font-weight: 500;
      color: var(--accent); background: none;
      border: 1.5px solid var(--accent); border-radius: 10px;
      cursor: pointer; text-decoration: none; transition: border-color 0.15s, background-color 0.15s, color 0.15s;
    }
    .btn-ghost-nav:hover { border-color: var(--accent-mid); background-color: var(--accent-light); color: var(--accent-mid); }
    .btn-primary-nav {
      padding: 8px 20px; font-size: 14px; font-weight: 500;
      color: #fff; background: var(--accent);
      border: none; border-radius: 10px; cursor: pointer;
      text-decoration: none; transition: opacity 0.15s;
    }
    .btn-primary-nav:hover { opacity: 0.88; }

    /* ── HERO ── */
    .hero-section {
      background: linear-gradient(175deg, #dde6ff 0%, #e8eeff 35%, #edf2ff 60%, #f0f4ff 80%, #d8e8fc 100%);
      min-height: calc(100vh - 58px);
      display: flex; flex-direction: column;
      align-items: center;
      padding: 0 2rem;
      overflow: hidden;
      position: relative;
    }

    /* Background subtle blobs */
    .hero-section::before {
      content: "";
      position: absolute;
      width: 600px; height: 600px; border-radius: 50%;
      background: radial-gradient(circle, rgba(100,130,255,0.12) 0%, transparent 70%);
      top: -100px; right: -100px;
      pointer-events: none;
    }

    /* ── Top part: title left + images right ── */
    .hero-top {
      width: 100%; max-width: 1160px;
      display: flex; align-items: flex-start;
      gap: 0; padding-top: 5rem;
    }

    .hero-text { flex: 1; padding-top: 2rem; }

    .hero-text h1 {
      font-family: "Syne", sans-serif;
      font-weight: 800;
      font-size: clamp(2.8rem, 5vw, 4rem);
      line-height: 1.05;
      color: var(--text-primary);
      margin-bottom: 1.2rem;
      word-wrap: break-word; overflow-wrap: break-word;
    }
    .hero-text h1 span {
      color: var(--accent);
      display: block;
    }

    .hero-text p {
      font-size: 15px; color: var(--text-secondary);
      line-height: 1.7; max-width: 440px;
      word-wrap: break-word; overflow-wrap: break-word;
    }

    /* Search bar */
    .search-bar {
      width: 100%;
      display: flex; gap: 10px;
      background: #fff;
      border-radius: 50px;
      padding: 6px 6px 6px 22px;
      box-shadow: 0 4px 24px rgba(70,60,180,0.12);
      border: 1px solid rgba(180,180,220,0.3);
      max-width: 480px;
    }
    .search-bar i { color: var(--text-muted); font-size: 18px; align-self: center; }
    .search-bar input {
      flex: 1; border: none; outline: none;
      font-size: 14.5px; font-family: "DM Sans", sans-serif;
      color: var(--text-primary); background: transparent;
    }
    .search-bar input::placeholder { color: var(--text-muted); }
    .search-btn {
      padding: 11px 28px;
      background: var(--accent); color: #fff;
      border: none; border-radius: 40px;
      font-size: 14.5px; font-weight: 500;
      font-family: "DM Sans", sans-serif; cursor: pointer;
      display: flex; align-items: center; gap: 8px;
      transition: opacity 0.15s; white-space: nowrap;
    }
    .search-btn:hover { opacity: 0.88; }

    .tag-list { display: flex; gap: 8px; flex-wrap: wrap; justify-content: center; }
    .tag {
      padding: 6px 16px;
      background: rgba(255,255,255,0.7);
      border: 1px solid rgba(180,180,220,0.5);
      border-radius: 30px; font-size: 13px;
      color: var(--text-secondary); cursor: pointer;
      backdrop-filter: blur(4px);
      transition: border-color 0.15s, color 0.15s, background 0.15s;
    }
    .tag:hover { border-color: var(--accent); color: var(--accent); background: rgba(255,255,255,0.95); }

    /* Hero image */
    .hero-right { flex: 0 0 auto; }
    .hero-images {
      flex: 0 0 480px;
      position: relative;
      height: 460px;
    }

    .photo-card {
      position: absolute;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 16px 48px rgba(60,52,160,0.18);
    }

    /* Back card: group photo, tilted slightly, left */
    .photo-back {
      width: 280px; height: 360px;
      top: 30px; left: 30px;
      z-index: 1;
      transform: rotate(-2deg);
    }

    /* Front card: solo person, right, overlapping */
    .photo-front {
      width: 240px; height: 380px;
      top: 50px; right: 0px;
      z-index: 2;
      transform: rotate(1deg);
    }

    /* Purple gradient top bar on front card */
    .photo-front::before {
      content: "";
      position: absolute; top: 0; left: 0; right: 0;
      height: 6px;
      background: linear-gradient(90deg, var(--accent), var(--accent-mid));
      z-index: 3;
    }

    .photo-card img {
      width: 100%; height: 100%; object-fit: cover; display: block;
    }

    /* Hero section wrapper */
    .hero-section {
      background: linear-gradient(160deg, #e8eeff 0%, #f0f4ff 40%, #fafbff 100%);
    }

    /* Stats row */
    .stats-row {
      width: 100%; max-width: 700px;
      display: flex; justify-content: center;
      gap: 4rem; margin-top: 1rem;
      flex-wrap: wrap;
    }
    .stat { text-align: center; }
    .stat-num {
      font-family: "Syne", sans-serif; font-weight: 800;
      font-size: 30px; color: var(--text-primary);
      line-height: 1;
      word-wrap: break-word; overflow-wrap: break-word;
    }
    .stat-label { font-size: 12.5px; color: var(--text-muted); margin-top: 4px; word-wrap: break-word; overflow-wrap: break-word; }

    /* Hero bottom */
    .hero-bottom {
      width: 100%; max-width: 760px;
      display: flex; flex-direction: column;
      align-items: center;
      gap: 1rem;
      margin-top: 3.5rem;
      padding-bottom: 3.5rem;
    }

    .search-row {
      width: 100%;
      display: flex; gap: 10px;
      background: #fff;
      border-radius: 50px;
      padding: 6px 6px 6px 22px;
      box-shadow: 0 4px 24px rgba(70,60,180,0.12);
      border: 1px solid rgba(180,180,220,0.3);
    }
    .search-row i { color: var(--text-muted); font-size: 18px; align-self: center; }
    .search-row input {
      flex: 1; border: none; outline: none;
      font-size: 14.5px; font-family: "DM Sans", sans-serif;
      color: var(--text-primary); background: transparent;
    }
    .search-row input::placeholder { color: var(--text-muted); }

    /* ── SECTIONS COMMON ── */
    section { padding: 5rem 2.5rem; width: 100%; }
    .section-inner { max-width: 1160px; margin: 0 auto; width: 100%; }

    .section-tag {
      font-size: 11.5px; font-weight: 600; letter-spacing: 0.1em;
      text-transform: uppercase; color: var(--accent);
      margin-bottom: 1rem; display: block; word-wrap: break-word; overflow-wrap: break-word;
    }

    .section-title {
      font-family: 'Syne', sans-serif; font-weight: 700;
      font-size: clamp(1.7rem, 3vw, 2.4rem); color: var(--text-primary);
      line-height: 1.2; margin-bottom: 1rem; word-wrap: break-word; overflow-wrap: break-word;
    }

    .section-sub {
      font-size: 14.5px; color: var(--text-secondary);
      max-width: 520px; line-height: 1.7; word-wrap: break-word; overflow-wrap: break-word;
    }

    /* ── FEATURES ── */
    .features-section { background: var(--white); }

    .features-header { text-align: center; margin-bottom: 3rem; }
    .features-header .section-sub { margin: 0 auto; }

    .features-grid {
      display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;
      width: 100%;
    }

    .feature-card {
      background: var(--bg); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 1.8rem;
      transition: box-shadow 0.2s, transform 0.15s; width: 100%;
    }
    .feature-card:hover { box-shadow: 0 8px 30px rgba(80,64,232,0.1); transform: translateY(-3px); }

    .feature-icon {
      width: 48px; height: 48px; border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 22px; margin-bottom: 1.1rem;
    }
    .feature-icon.blue   { background: #eef2ff; color: var(--accent); }
    .feature-icon.purple { background: #f3eeff; color: #7c3aed; }
    .feature-icon.green  { background: #eafaf1; color: #16a34a; }

    .feature-card h3 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 16px; margin-bottom: 8px; color: var(--text-primary); word-wrap: break-word; overflow-wrap: break-word; }
    .feature-card p  { font-size: 13.5px; color: var(--text-secondary); line-height: 1.65; word-wrap: break-word; overflow-wrap: break-word; }

    /* ── HOW IT WORKS ── */
    .how-section { background: var(--bg); }

    .how-inner {
      display: flex; gap: 4rem; align-items: center;
    }

    .how-left { flex: 1; }
    .how-left .section-tag { margin-bottom: 0.6rem; }
    .how-left .section-title { margin-bottom: 2.4rem; }

    .steps { display: flex; flex-direction: column; gap: 1.6rem; }

    .step { display: flex; gap: 16px; align-items: flex-start; }
    .step-num {
      width: 36px; height: 36px; border-radius: 50%;
      background: var(--accent-light); color: var(--accent);
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .step-body h4 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 15px; margin-bottom: 4px; color: var(--text-primary); }
    .step-body p  { font-size: 13.5px; color: var(--text-secondary); line-height: 1.6; }

    .how-cta {
      margin-top: 2rem; display: inline-flex; align-items: center; gap: 8px;
      padding: 12px 24px; background: var(--accent); color: #fff;
      border: none; border-radius: 12px; font-size: 14.5px; font-weight: 500;
      font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none;
      transition: opacity 0.15s;
    }
    .how-cta:hover { opacity: 0.88; }

    /* Compat card */
    .compat-card {
      flex: 0 0 340px;
      background: #fff; border: 1px solid var(--border);
      border-radius: var(--radius); padding: 1.6rem;
      box-shadow: 0 12px 40px rgba(80,64,232,0.1);
    }

    .compat-tag {
      font-size: 11px; font-weight: 600; letter-spacing: 0.08em;
      text-transform: uppercase; color: var(--text-muted);
      margin-bottom: 0.4rem; display: block;
    }

    .compat-pct {
      font-family: 'Syne', sans-serif; font-weight: 800;
      font-size: 42px; color: var(--accent); line-height: 1;
      margin-bottom: 2px;
    }

    .compat-role { font-size: 13px; color: var(--text-muted); margin-bottom: 1.4rem; }

    .compat-bars { display: flex; flex-direction: column; gap: 10px; }

    .compat-row { }
    .compat-row-top {
      display: flex; justify-content: space-between;
      font-size: 12.5px; color: var(--text-secondary); margin-bottom: 4px;
    }
    .bar-track {
      height: 6px; background: #f0f0f8; border-radius: 4px; overflow: hidden;
    }
    .bar-fill {
      height: 100%; border-radius: 4px;
      background: linear-gradient(90deg, var(--accent), var(--accent-mid));
    }

    .compat-footer {
      margin-top: 1.2rem; padding-top: 1rem;
      border-top: 1px solid var(--border);
      display: flex; align-items: center; gap: 8px;
      font-size: 12.5px; color: var(--text-secondary);
    }
    .compat-footer i { color: #22c55e; font-size: 18px; }

    /* ── OFFRES ── */
    .offers-section { background: var(--white); }

    .offers-header {
      display: flex; align-items: flex-end; justify-content: space-between;
      margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;
    }
    .see-all {
      font-size: 13.5px; color: var(--accent); text-decoration: none;
      font-weight: 500; display: flex; align-items: center; gap: 5px;
    }
    .see-all:hover { text-decoration: underline; }

    .offers-grid {
      display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;
      width: 100%;
    }

    .offer-card {
      background: var(--bg); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 1.4rem;
      display: flex; flex-direction: column; gap: 12px;
      transition: box-shadow 0.2s, transform 0.15s; cursor: pointer; width: 100%;
    }
    .offer-card:hover { box-shadow: 0 8px 30px rgba(80,64,232,0.1); transform: translateY(-2px); }

    .offer-top { display: flex; align-items: flex-start; gap: 12px; }
    .offer-logo {
      width: 42px; height: 42px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px; color: #fff;
      flex-shrink: 0;
    }
    .offer-info h4 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14.5px; color: var(--text-primary); margin-bottom: 2px; word-wrap: break-word; overflow-wrap: break-word; }
    .offer-company { font-size: 12.5px; color: var(--text-muted); word-wrap: break-word; overflow-wrap: break-word; }

    .offer-meta { display: flex; gap: 12px; flex-wrap: wrap; }
    .offer-meta-item {
      display: flex; align-items: center; gap: 5px;
      font-size: 12.5px; color: var(--text-secondary);
    }
    .offer-meta-item i { font-size: 14px; }

    .offer-footer { display: flex; align-items: center; justify-content: space-between; }
    .offer-salary { font-family: 'Syne', sans-serif; font-size: 13.5px; font-weight: 700; color: var(--text-primary); }

    .badge {
      padding: 4px 10px; border-radius: 20px;
      font-size: 11.5px; font-weight: 600;
    }
    .badge.green  { background: #eafaf1; color: #16a34a; }
    .badge.orange { background: #fff7ed; color: #ea580c; }
    .badge.blue   { background: #eef2ff; color: var(--accent); }
    .badge.purple { background: #f3eeff; color: #7c3aed; }

    .offers-cta { text-align: center; margin-top: 2.4rem; }
    .btn-outline {
      padding: 12px 28px; border: 1.5px solid var(--accent);
      border-radius: 12px; color: var(--accent); font-size: 14.5px;
      font-weight: 500; font-family: 'DM Sans', sans-serif;
      background: none; cursor: pointer; text-decoration: none;
      transition: background 0.15s;
    }
    .btn-outline:hover { background: var(--accent-light); }

    /* ── ENTREPRISES ── */
    .companies-section { background: var(--bg); }

    .companies-header { text-align: center; margin-bottom: 2.6rem; }
    .companies-header .section-tag { justify-content: center; display: block; }

    .companies-grid {
      display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;
      width: 100%;
    }

    .company-card {
      background: #fff; border: 1px solid var(--border);
      border-radius: var(--radius); padding: 1.3rem;
      display: flex; align-items: center; gap: 14px;
      cursor: pointer; transition: box-shadow 0.2s, transform 0.15s; width: 100%;
    }
    .company-card:hover { box-shadow: 0 6px 24px rgba(80,64,232,0.09); transform: translateY(-2px); }

    .company-logo {
      width: 46px; height: 46px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 15px; color: #fff;
      flex-shrink: 0;
    }
    .company-info h4 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px; color: var(--text-primary); margin-bottom: 2px; word-wrap: break-word; overflow-wrap: break-word; }
    .company-sector { font-size: 12px; color: var(--text-muted); margin-bottom: 4px; word-wrap: break-word; overflow-wrap: break-word; }
    .company-location { font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 4px; word-wrap: break-word; overflow-wrap: break-word; }
    .company-offers { font-size: 12px; color: var(--accent); font-weight: 500; margin-top: 3px; word-wrap: break-word; overflow-wrap: break-word; }

    /* ── CTA SECTION ── */
    .cta-section {
      background: linear-gradient(145deg, #f0eeff, #e8eeff);
      text-align: center; padding: 5rem 2.5rem;
    }
    .cta-section .section-title { margin: 0 auto 1rem; max-width: 560px; }
    .cta-section p { font-size: 14.5px; color: var(--text-secondary); margin-bottom: 2.4rem; }
    .cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
    .btn-primary-lg {
      padding: 13px 30px; background: var(--accent); color: #fff;
      border: none; border-radius: 12px; font-size: 15px; font-weight: 500;
      font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none;
      transition: opacity 0.15s;
    }
    .btn-primary-lg:hover { opacity: 0.88; }
    .btn-secondary-lg {
      padding: 13px 30px; background: #fff; color: var(--text-primary);
      border: 1px solid var(--border); border-radius: 12px; font-size: 15px; font-weight: 500;
      font-family: 'DM Sans', sans-serif; cursor: pointer; text-decoration: none;
      transition: border-color 0.15s;
    }
    .btn-secondary-lg:hover { border-color: #aaa; }

    /* ── FOOTER ── */
    footer {
      background: var(--white); border-top: 1px solid var(--border);
      padding: 3rem 2.5rem 2rem;
    }
    .footer-inner { max-width: 1160px; margin: 0 auto; }

    .footer-top { display: flex; gap: 4rem; margin-bottom: 2.5rem; flex-wrap: wrap; }

    .footer-brand { flex: 0 0 180px; }
    .footer-logo { display: flex; align-items: center; gap: 9px; margin-bottom: 0.8rem; }
    .footer-logo-avatar {
      width: 30px; height: 30px; border-radius: 50%; background: var(--accent);
      display: flex; align-items: center; justify-content: center;
      font-family: 'Syne', sans-serif; font-weight: 700; font-size: 11px; color: #fff;
    }
    .footer-logo-name { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 14px; color: var(--text-primary); }

    .footer-cols { display: flex; gap: 3rem; flex: 1; flex-wrap: wrap; }
    .footer-col h5 { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 13px; color: var(--text-primary); margin-bottom: 1rem; }
    .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
    .footer-col ul li a { font-size: 13px; color: var(--text-muted); text-decoration: none; transition: color 0.15s; }
    .footer-col ul li a:hover { color: var(--accent); }

    .footer-bottom {
      display: flex; justify-content: space-between; align-items: center;
      padding-top: 1.5rem; border-top: 1px solid var(--border);
      font-size: 12.5px; color: var(--text-muted); flex-wrap: wrap; gap: 8px;
    }
    .footer-bottom a { color: var(--accent); text-decoration: none; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .hero-top { flex-direction: column; align-items: center; padding-top: 3rem; }
      .hero-images { width: 100%; max-width: 400px; }
      .features-grid { grid-template-columns: 1fr; }
      .how-inner { flex-direction: column; }
      .compat-card { flex: none; width: 100%; }
      .offers-grid { grid-template-columns: 1fr; }
      .companies-grid { grid-template-columns: repeat(2,1fr); }
      .stats-row { gap: 1.5rem; }
    }
    @media (max-width: 600px) {
      .navbar { padding: 0 1rem; }
      .nav-links { display: none; }
      section { padding: 3rem 1rem; }
      .companies-grid { grid-template-columns: 1fr; }
      .hero-images { height: 300px; }
      .photo-back { width: 200px; height: 260px; }
      .photo-front { width: 180px; height: 280px; }
    }
  </style>
</head>
<body>

<!-- ── NAVBAR ── -->
<nav class="navbar">
  <a class="nav-logo" href="#">
    <div class="nav-logo-avatar">JR</div>
    <span class="nav-logo-name">Talentlink</span>
  </a>
  <div class="nav-links">
    <a href="#offres" class="nav-link active">Trouver un job</a>
    <a href="#entreprises" class="nav-link">Entreprises</a>
    <a href="#how" class="nav-link">Ressources</a>
  </div>
  <div class="nav-right">
    <a href="{{ route('login') }}" class="btn-ghost-nav">Connexion</a>
    <a href="{{ route('register.entreprise') }}" class="btn-ghost-nav">Je recrute</a>
    <a href="{{ route('register.candidat') }}" class="btn-primary-nav">S'inscrire</a>
  </div>
</nav>

<!-- ── HERO ── -->
<div class="hero-section">

  <!-- Top: text left + images right -->
  <div class="hero-top">
    <div class="hero-text">
      <h1>Ne cherchez plus<span>n'importe quel job</span></h1>
      <p>
        Trouvez l'emploi fait pour vous parmi {{ $stats['offres'] }}+ offres vérifiées.<br>
        Notre IA analyse votre profil et vous connecte avec les meilleures opportunités.
      </p>
    </div>

    <div class="hero-images">
      <!-- Back card: left, rotated -->
      <div class="photo-card photo-back">
        <img src="{{ asset('images/hero-back.jpg') }}" alt="Candidats Talentlink" />
      </div>

      <!-- Front card: right, overlapping -->
      <div class="photo-card photo-front">
        <img src="{{ asset('images/hero-front.jpg') }}" alt="Offres Talentlink" />
      </div>
    </div>
  </div>

  <!-- Bottom: search + tags + stats -->
  <div class="hero-bottom">
    <div class="search-row">
      <i class="ti ti-search"></i>
      <input type="text" placeholder="Poste, compétence, entreprise…" />
      <button class="search-btn"><i class="ti ti-search"></i> Rechercher</button>
    </div>

    <div class="tag-list">
      <span class="tag">React Développeur</span>
      <span class="tag">UX Designer</span>
      <span class="tag">Data Science</span>
      <span class="tag">Product Manager</span>
      <span class="tag">DevOps</span>
    </div>

    <div class="stats-row">
      <div class="stat">
        <div class="stat-num">{{ $stats['offres'] }}+</div>
        <div class="stat-label">Offres d'emploi</div>
      </div>
      <div class="stat">
        <div class="stat-num">{{ $stats['entreprises'] }}+</div>
        <div class="stat-label">Entreprises</div>
      </div>
      <div class="stat">
        <div class="stat-num">{{ $stats['candidats'] }}+</div>
        <div class="stat-label">Candidats</div>
      </div>
    </div>
  </div>
</div>

<!-- ── FEATURES ── -->
<section class="features-section">
  <div class="section-inner">
    <div class="features-header">
      <span class="section-tag">Pourquoi Talentlink</span>
      <h2 class="section-title">Une plateforme pensée<br>pour votre succès</h2>
      <p class="section-sub">La technologie au service de votre carrière. Retrouvez toutes les fonctionnalités dont vous avez besoin en un seul endroit.</p>
    </div>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon blue"><i class="ti ti-sparkles"></i></div>
        <h3>Matching IA en temps réel</h3>
        <p>Notre moteur analyse 50+ critères pour vous proposer les offres les plus pertinentes.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon purple"><i class="ti ti-building-check"></i></div>
        <h3>Entreprises vérifiées</h3>
        <p>Toutes les entreprises sont vérifiées et évaluées par notre équipe.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon green"><i class="ti ti-chart-line"></i></div>
        <h3>Suivi de candidature</h3>
        <p>Suivez vos candidatures en temps réel et communiquez avec les recruteurs.</p>
      </div>
    </div>
  </div>
</section>

<!-- ── HOW IT WORKS ── -->
<section class="how-section" id="how">
  <div class="section-inner">
    <div class="how-inner">
      <div class="how-left">
        <span class="section-tag">Comment ça marche</span>
        <h2 class="section-title">Trouvez votre job<br>en 3 étapes simples.</h2>

        <div class="steps">
          <div class="step">
            <div class="step-num">01</div>
            <div class="step-body">
              <h4>Parlez-nous de vous</h4>
              <p>Inscrivez votre CV et dites-nous ce que vous cherchez. Nous lisons entre les lignes.</p>
            </div>
          </div>
          <div class="step">
            <div class="step-num">02</div>
            <div class="step-body">
              <h4>Découvrez vos matchs IA</h4>
              <p>Notre algorithme sélectionne uniquement les offres qui correspondent vraiment à votre profil.</p>
            </div>
          </div>
          <div class="step">
            <div class="step-num">03</div>
            <div class="step-body">
              <h4>Les jobs viennent à vous</h4>
              <p>Les recruteurs peuvent consulter votre profil et vous contacter directement.</p>
            </div>
          </div>
        </div>

        <a href="{{ route('register.candidat') }}" class="how-cta">
          Inscrivez-vous gratuitement <i class="ti ti-arrow-right"></i>
        </a>
      </div>

      <!-- Compat card -->
      <div class="compat-card">
        <span class="compat-tag">Analyse de compatibilité</span>
        <div class="compat-pct">94%</div>
        <div class="compat-role">Développeur Full Stack · TechVision Paris</div>
        <div class="compat-bars">
          <div class="compat-row">
            <div class="compat-row-top"><span>Compétences techniques</span><span>96%</span></div>
            <div class="bar-track"><div class="bar-fill" style="width:96%"></div></div>
          </div>
          <div class="compat-row">
            <div class="compat-row-top"><span>Expérience requise</span><span>92%</span></div>
            <div class="bar-track"><div class="bar-fill" style="width:92%"></div></div>
          </div>
          <div class="compat-row">
            <div class="compat-row-top"><span>Culture d'entreprise</span><span>88%</span></div>
            <div class="bar-track"><div class="bar-fill" style="width:88%"></div></div>
          </div>
          <div class="compat-row">
            <div class="compat-row-top"><span>Prétentions salariales</span><span>95%</span></div>
            <div class="bar-track"><div class="bar-fill" style="width:95%"></div></div>
          </div>
          <div class="compat-row">
            <div class="compat-row-top"><span>Localisation</span><span>100%</span></div>
            <div class="bar-track"><div class="bar-fill" style="width:100%"></div></div>
          </div>
        </div>
        <div class="compat-footer">
          <i class="ti ti-circle-check-filled"></i>
          Profil fortement recommandé pour ce poste
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ── OFFRES ── -->
<section class="offers-section" id="offres">
  <div class="section-inner">
    <div class="offers-header">
      <div>
        <span class="section-tag">Offres sélectionnées</span>
        <h2 class="section-title">Opportunités du moment</h2>
      </div>
      <a href="{{ route('login') }}" class="see-all">Voir toutes <i class="ti ti-arrow-right"></i></a>
    </div>

    <div class="offers-grid">
      @forelse($offres as $offre)
        <div class="offer-card">
          <div class="offer-top">
            @if($offre->entreprise && $offre->entreprise->logo_entreprise)
              <div class="offer-logo" style="background-image: url('{{ asset('storage/' . $offre->entreprise->logo_entreprise) }}'); background-size: cover; background-position: center;"></div>
            @else
              <div class="offer-logo" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">
                {{ substr($offre->entreprise->nom_entreprise ?? 'TE', 0, 2) }}
              </div>
            @endif
            <div class="offer-info">
              <h4>{{ $offre->titre_poste }}</h4>
              <span class="offer-company">{{ $offre->entreprise->nom_entreprise ?? 'Entreprise' }} · {{ $offre->ville ?? 'Non spécifié' }}</span>
            </div>
          </div>
          <div class="offer-meta">
            <span class="offer-meta-item"><i class="ti ti-clock"></i> {{ $offre->created_at->diffForHumans() }}</span>
            <span class="offer-meta-item"><i class="ti ti-map-pin"></i> {{ $offre->ville ?? 'Non spécifié' }}</span>
            <span class="offer-meta-item"><i class="ti ti-users"></i> {{ $offre->experience_requise ?? 'Non spécifié' }}</span>
          </div>
          <div class="offer-footer">
            <span class="offer-salary">{{ $offre->salaire_min ?? 'N/A' }} – {{ $offre->salaire_max ?? 'N/A' }} {{ $offre->devise ?? 'FCFA' }}/an</span>
            <span class="badge blue">Nouveau</span>
          </div>
        </div>
      @empty
        <p>Aucune offre disponible pour le moment.</p>
      @endforelse
    </div>

    <div class="offers-cta">
      <a href="{{ route('login') }}" class="btn-outline">Voir toutes les offres</a>
    </div>
  </div>
</section>

<!-- ── ENTREPRISES ── -->
<section class="companies-section" id="entreprises">
  <div class="section-inner">
    <div class="companies-header">
      <span class="section-tag">{{ $stats['entreprises'] }}+ entreprises</span>
      <h2 class="section-title">Choisissez l'entreprise<br>faite pour vous.</h2>
      <p class="section-sub" style="margin:0 auto">Découvrez la culture, les équipes et les valeurs des entreprises avant même de postuler.</p>
    </div>

    <div class="companies-grid">
      @forelse($entreprises as $entreprise)
        <div class="company-card">
          @if($entreprise->logo_entreprise)
            <div class="company-logo" style="background-image: url('{{ asset('storage/' . $entreprise->logo_entreprise) }}'); background-size: cover; background-position: center;"></div>
          @else
            <div class="company-logo" style="background:linear-gradient(135deg,#6366f1,#8b5cf6)">
              {{ substr($entreprise->nom_entreprise, 0, 2) }}
            </div>
          @endif
          <div class="company-info">
            <h4>{{ $entreprise->nom_entreprise }}</h4>
            <div class="company-sector">{{ $entreprise->secteur_activite ?? 'Non spécifié' }}</div>
            <div class="company-location"><i class="ti ti-map-pin" style="font-size:12px"></i> {{ $entreprise->ville ?? 'Non spécifié' }}</div>
            <div class="company-offers">● {{ $entreprise->offres_count }} offres</div>
          </div>
        </div>
      @empty
        <p>Aucune entreprise disponible pour le moment.</p>
      @endforelse
    </div>
  </div>
</section>

<!-- ── CTA ── -->
<section class="cta-section">
  <div class="section-inner">
    <h2 class="section-title">Prêt à trouver votre job idéal ?</h2>
    <p>Rejoignez {{ $stats['candidats'] }}+ candidats qui ont trouvé leur place avec <strong>Talentlink</strong>.</p>
    <div class="cta-btns">
      <a href="{{ route('register.candidat') }}" class="btn-primary-lg">Inscrivez-vous gratuitement</a>
      <a href="{{ route('register.entreprise') }}" class="btn-secondary-lg">Je recrute →</a>
    </div>
  </div>
</section>

<!-- ── FOOTER ── -->
<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <div class="footer-logo">
          <div class="footer-logo-avatar">JR</div>
          <span class="footer-logo-name">Talentlink</span>
        </div>
      </div>
      <div class="footer-cols">
        <div class="footer-col">
          <h5>Candidats</h5>
          <ul>
            <li><a href="#">Trouver un job</a></li>
            <li><a href="#">Mon profil</a></li>
            <li><a href="#">Candidatures</a></li>
            <li><a href="#">Newsletter</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h5>Entreprises</h5>
          <ul>
            <li><a href="#">Recruter</a></li>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Publier une offre</a></li>
            <li><a href="#">Tarifs</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h5>Plateforme</h5>
          <ul>
            <li><a href="#">Comment ça marche</a></li>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Partenaires</a></li>
            <li><a href="#">API</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h5>Légal</h5>
          <ul>
            <li><a href="#">CGU</a></li>
            <li><a href="#">Confidentialité</a></li>
            <li><a href="#">Cookies</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-bottom">
      <span>© 2026 Talentlink · Tous droits réservés</span>
      <span>Fait avec ♥ pour les chercheurs d'emploi</span>
    </div>
  </div>
</footer>

</body>
</html>
