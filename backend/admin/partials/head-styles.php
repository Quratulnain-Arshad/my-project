<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: 'Poppins', sans-serif; background: #f0f4f0; color: #222; }
.layout { display: flex; min-height: 100vh; }

/* ── Sidebar ── */
.sidebar {
  width: 240px;
  background: #021f0a;
  color: #fff;
  display: flex;
  flex-direction: column;
  flex-shrink: 0;
  position: fixed;
  top: 0;
  left: 0;
  bottom: 0;
  z-index: 300;
  overflow-y: auto;
}
.sidebar-logo {
  padding: 22px 20px 18px;
  border-bottom: 1px solid rgba(255,255,255,.08);
}
.sidebar-logo .logo-wrap {
  display: flex;
  align-items: center;
  gap: 10px;
  font-size: 1.1rem;
  font-weight: 700;
  color: #a5d6a7;
  margin-bottom: 2px;
}
.sidebar-logo .logo-wrap i { color: #69f0ae; font-size: 1.2rem; }
.sidebar-logo p { font-size: .68rem; color: #4caf50; letter-spacing: .5px; text-transform: uppercase; padding-left: 30px; }

.sidebar-section-label {
  font-size: .62rem;
  font-weight: 600;
  color: #4caf50;
  text-transform: uppercase;
  letter-spacing: 1px;
  padding: 16px 20px 6px;
  opacity: .7;
}

.sidebar nav a {
  display: flex;
  align-items: center;
  gap: 11px;
  padding: 10px 20px;
  color: #a5d6a7;
  text-decoration: none;
  font-size: .84rem;
  transition: background .15s, color .15s;
  border-left: 3px solid transparent;
}
.sidebar nav a:hover { background: rgba(255,255,255,.07); color: #fff; }
.sidebar nav a.active {
  background: rgba(76,175,80,.15);
  color: #69f0ae;
  border-left-color: #4caf50;
}
.sidebar nav a i { width: 16px; text-align: center; font-size: .9rem; flex-shrink: 0; }

.sidebar-footer {
  margin-top: auto;
  padding: 14px 20px;
  border-top: 1px solid rgba(255,255,255,.08);
}
.sidebar-footer a {
  display: flex;
  align-items: center;
  gap: 9px;
  color: #ef9a9a;
  text-decoration: none;
  font-size: .82rem;
  transition: color .15s;
}
.sidebar-footer a:hover { color: #ff5252; }

/* ── Fixed Top Bar ── */
.admin-topbar {
  position: fixed;
  top: 0;
  left: 240px;
  right: 0;
  height: 52px;
  background: #fff;
  border-bottom: 1px solid #e0f0e0;
  display: flex;
  align-items: center;
  justify-content: flex-end;
  padding: 0 24px;
  z-index: 200;
  gap: 14px;
  box-shadow: 0 1px 6px rgba(0,0,0,.06);
}
.topbar-user {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: .82rem;
  color: #555;
  font-weight: 500;
}
.topbar-user i { color: #4caf50; font-size: 1rem; }
.topbar-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 5px 13px;
  border-radius: 6px;
  font-size: .78rem;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  text-decoration: none;
  transition: background .2s;
  cursor: pointer;
  border: none;
}
.topbar-btn-view { background: #e8f5e9; color: #043915; }
.topbar-btn-view:hover { background: #c8e6c9; }
.topbar-btn-logout { background: #ffebee; color: #c62828; }
.topbar-btn-logout:hover { background: #ffcdd2; }

/* ── Main Content area (offset for fixed sidebar + topbar) ── */
.content {
  flex: 1;
  margin-left: 240px;
  padding: 74px 28px 32px;
  overflow-y: auto;
  min-width: 0;
}

/* ── Page Header ── */
.page-header {
  margin-bottom: 24px;
}
.page-header h1 {
  font-size: 1.4rem;
  font-weight: 700;
  color: #043915;
  display: flex;
  align-items: center;
  gap: 10px;
}
.page-header h1 i { color: #4caf50; font-size: 1.2rem; }

/* ── Dashboard Stats ── */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(190px, 1fr));
  gap: 16px;
  margin-bottom: 28px;
}
.stat-card {
  background: #fff;
  border-radius: 12px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 16px;
  text-decoration: none;
  color: inherit;
  box-shadow: 0 2px 8px rgba(0,0,0,.07);
  transition: transform .15s, box-shadow .15s;
  border-left: 4px solid #4caf50;
  cursor: pointer;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,.12); }
.stat-icon {
  width: 46px;
  height: 46px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
  flex-shrink: 0;
}
.stat-num { font-size: 1.7rem; font-weight: 700; color: #043915; line-height: 1; }
.stat-label { font-size: .72rem; color: #777; margin-top: 4px; font-weight: 500; }

/* ── Cards ── */
.card {
  background: #fff;
  border-radius: 10px;
  padding: 22px 24px;
  box-shadow: 0 2px 8px rgba(0,0,0,.07);
  margin-bottom: 20px;
}
.card h2 {
  font-size: .95rem;
  color: #043915;
  margin-bottom: 16px;
  padding-bottom: 10px;
  border-bottom: 2px solid #e8f5e9;
  display: flex;
  align-items: center;
  gap: 8px;
}
.card h2 i { color: #4caf50; }

/* ── Forms ── */
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.form-grid.full { grid-template-columns: 1fr; }
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-group label {
  font-size: .75rem;
  font-weight: 600;
  color: #555;
  text-transform: uppercase;
  letter-spacing: .4px;
}
.form-group input,
.form-group select,
.form-group textarea {
  border: 1.5px solid #d4ebd4;
  border-radius: 7px;
  padding: 9px 11px;
  font-size: .86rem;
  font-family: 'Poppins', sans-serif;
  outline: none;
  transition: border-color .2s, box-shadow .2s;
  width: 100%;
  background: #fff;
}
.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
  border-color: #4caf50;
  box-shadow: 0 0 0 3px rgba(76,175,80,.1);
}
.form-group textarea { resize: vertical; min-height: 90px; }
.form-group textarea.tall { min-height: 170px; }

/* ── Buttons ── */
.btn {
  padding: 9px 18px;
  border-radius: 7px;
  border: none;
  cursor: pointer;
  font-size: .84rem;
  font-weight: 600;
  font-family: 'Poppins', sans-serif;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 7px;
  transition: background .2s, transform .15s;
}
.btn:hover { transform: translateY(-1px); }
.btn-primary { background: #043915; color: #fff; }
.btn-primary:hover { background: #1b5e20; }
.btn-danger { background: #c62828; color: #fff; }
.btn-danger:hover { background: #b71c1c; }
.btn-outline { background: transparent; color: #043915; border: 1.5px solid #c8e6c9; }
.btn-outline:hover { background: #e8f5e9; }
.btn-sm { padding: 5px 12px; font-size: .76rem; }
.btn-group { display: flex; gap: 8px; margin-top: 14px; flex-wrap: wrap; }

/* ── Table ── */
.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; font-size: .83rem; }
th {
  background: #043915;
  color: #fff;
  padding: 10px 14px;
  text-align: left;
  font-weight: 600;
  font-size: .78rem;
  letter-spacing: .3px;
}
td { padding: 9px 14px; border-bottom: 1px solid #e8f5e9; vertical-align: middle; }
tr:hover td { background: #f1f8e9; }

/* ── Alerts ── */
.alert {
  padding: 11px 16px;
  border-radius: 8px;
  font-size: .85rem;
  margin-bottom: 18px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.alert-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #a5d6a7; }
.alert-error { background: #ffebee; color: #c62828; border: 1px solid #ef9a9a; }

/* ── Tabs ── */
.tabs { display: flex; gap: 0; margin-bottom: 20px; border-bottom: 2px solid #e0f0e0; }
.tab {
  padding: 9px 22px;
  cursor: pointer;
  font-size: .84rem;
  font-weight: 600;
  color: #888;
  border-bottom: 3px solid transparent;
  margin-bottom: -2px;
  transition: color .15s;
  text-decoration: none;
}
.tab.active, .tab:hover { color: #043915; border-bottom-color: #4caf50; }

/* ── Image upload groups ── */
.img-upload-group {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 14px;
  padding: 10px;
  background: #f1f8e9;
  border-radius: 8px;
}
.img-upload-group img {
  width: 80px; height: 56px;
  object-fit: cover; border-radius: 4px;
  border: 1px solid #c8e6c9; flex-shrink: 0;
}
.img-upload-group .no-img {
  width: 80px; height: 56px;
  background: #e8f5e9; border-radius: 4px;
  display: flex; align-items: center;
  justify-content: center; font-size: 1.4rem; flex-shrink: 0;
}
.img-upload-group label { font-weight: 600; font-size: .82rem; color: #043915; min-width: 100px; }

@media (max-width: 900px) {
  .sidebar { width: 200px; }
  .admin-topbar { left: 200px; }
  .content { margin-left: 200px; padding: 74px 16px 28px; }
}
@media (max-width: 680px) {
  .sidebar { transform: translateX(-100%); }
  .admin-topbar { left: 0; }
  .content { margin-left: 0; padding: 74px 14px 24px; }
  .form-grid { grid-template-columns: 1fr; }
}
</style>
