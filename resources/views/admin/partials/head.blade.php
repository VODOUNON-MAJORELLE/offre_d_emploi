{{-- resources/views/admin/partials/head.blade.php --}}
{{-- Fonts, icons, et styles partagés de toutes les pages admin --}}
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'DM Sans', sans-serif;
    background: #f0f1f8;
    min-height: 100vh;
    display: flex;
    color: #1a1550;
  }
  /* ── SIDEBAR ── */
  .sidebar {
    width: 240px;
    background: #fff;
    border-right: 1px solid #e8e8f4;
    padding: 24px 16px;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
  }
  .logo {
    display: flex; align-items: center; gap: 12px;
    font-family: 'Syne', sans-serif; font-weight: 800; font-size: 18px;
    color: #1a1550; margin-bottom: 32px; padding: 0 8px;
  }
  .logo-av {
    width: 38px; height: 38px; border-radius: 10px;
    background: linear-gradient(135deg, #5040e8, #7c6ff0);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: #fff; flex-shrink: 0;
  }
  .nav-section-label {
    font-size: 10px; font-weight: 700; letter-spacing: 0.1em;
    text-transform: uppercase; color: #c0c0d8; padding: 0 10px;
    margin: 16px 0 6px;
  }
  .nav-links { display: flex; flex-direction: column; gap: 2px; }
  .nav-link {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    font-size: 13.5px; font-weight: 500; color: #7070a0;
    text-decoration: none; transition: all 0.15s;
  }
  .nav-link:hover { background: #f4f5fa; color: #5040e8; }
  .nav-link.active { background: #5040e8; color: #fff; font-weight: 600; }
  .nav-link i { font-size: 18px; flex-shrink: 0; }
  .nav-link .badge-count {
    margin-left: auto;
    font-size: 10.5px; font-weight: 700;
    padding: 2px 7px; border-radius: 99px;
    background: #f0f0fa; color: #5040e8;
  }
  .nav-link.active .badge-count { background: rgba(255,255,255,0.25); color: #fff; }
  .sidebar-footer {
    margin-top: auto; padding-top: 20px;
    border-top: 1px solid #e8e8f4;
  }
  .logout-btn {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 14px; border-radius: 10px;
    font-size: 13.5px; font-weight: 600; color: #dc2626;
    background: none; border: none; width: 100%;
    transition: all 0.15s; cursor: pointer; font-family: inherit;
  }
  .logout-btn:hover { background: #fff2f2; }
  /* ── MAIN CONTENT ── */
  .main {
    flex: 1;
    padding: 2rem 2.2rem;
    overflow-y: auto;
    min-width: 0;
  }
  @media (max-width: 768px) {
    .sidebar { display: none; }
    .main { padding: 1rem; }
  }
</style>
