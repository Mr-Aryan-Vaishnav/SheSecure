<?php 
// 1. SECURITY CHECK FIRST: Ensures no one accesses this without logging in
require_once 'auth_check.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Command Center – SheSecure</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* =========================================
     GLOBAL DASHBOARD THEME & CSS
     ========================================= */
  :root {
    --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A;
    --charcoal: #120A0E; --charcoal-light: #1C1116;
    --panel-bg: rgba(255, 255, 255, 0.03); --panel-border: rgba(255, 255, 255, 0.08);
    --safe-green: #2A9D5C; --safe-green-glow: rgba(42, 157, 92, 0.4);
    --warn-amber: #E9A227; --text-main: #FFFFFF; --text-muted: rgba(255, 255, 255, 0.5);
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  
  body {
    font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: var(--text-main);
    overflow: hidden; display: flex; height: 100vh; width: 100vw; -webkit-user-select: none; user-select: none;
  }

  /* Ambient Background */
  .ambient-bg { position: fixed; inset: 0; z-index: -1; overflow: hidden; pointer-events: none; background: radial-gradient(circle at 50% 0%, #2a1620 0%, var(--charcoal) 70%); }
  .grid-overlay { position: absolute; inset: 0; background-image: linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px); background-size: 40px 40px; opacity: 0.5; }

  /* Sidebar Styles */
  .sidebar { width: 280px; background: rgba(18, 10, 14, 0.8); backdrop-filter: blur(20px); border-right: 1px solid var(--panel-border); display: flex; flex-direction: column; z-index: 100; }
  .sidebar-header { padding: 2rem 1.5rem; border-bottom: 1px solid var(--panel-border); display: flex; align-items: center; gap: 0.8rem; }
  .logo-icon { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 0 15px rgba(192,57,75,0.4); }
  .logo-text { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; }
  .logo-text span { color: var(--rose-light); }
  .nav-menu { padding: 1.5rem 1rem; flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem; }
  .nav-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin: 1rem 0 0.5rem 1rem; font-weight: 700; }
  .nav-item { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1rem; border-radius: 12px; color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: 0.3s; border: 1px solid transparent; }
  .nav-item i { font-size: 1.3rem; }
  .nav-item:hover { background: rgba(255,255,255,0.05); color: white; }
  .nav-item.active { background: rgba(192,57,75,0.1); color: var(--rose-light); border-color: rgba(192,57,75,0.2); box-shadow: inset 4px 0 0 var(--rose); }
  .sidebar-footer { padding: 1.5rem; border-top: 1px solid var(--panel-border); }
  .user-profile { display: flex; align-items: center; gap: 1rem; }
  .user-avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--rose-light); color: var(--charcoal); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; }
  .user-info h4 { font-size: 0.95rem; color: white; }
  .user-info p { font-size: 0.75rem; color: var(--safe-green); display: flex; align-items: center; gap: 0.3rem;}

  /* Main Layout & Header */
  .main-wrapper { flex: 1; display: flex; flex-direction: column; overflow: hidden; position: relative; }
  .top-status-bar { height: 70px; background: rgba(28, 17, 22, 0.6); backdrop-filter: blur(20px); border-bottom: 1px solid var(--panel-border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; z-index: 90; }
  .telemetry-group { display: flex; gap: 2rem; align-items: center; }
  .telemetry-item { display: flex; align-items: center; gap: 0.6rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--text-muted); }
  .telemetry-item.safe i { color: var(--safe-green); text-shadow: 0 0 10px var(--safe-green-glow); }
  .telemetry-item.enc i { color: #3b82f6; text-shadow: 0 0 10px rgba(59, 130, 246, 0.4); }
  .top-actions { display: flex; gap: 1rem; align-items: center; }

  /* HEADER DROPDOWN STYLES */
  .user-dropdown { position: relative; display: inline-block; margin-left: 1rem; }
  .btn-profile { display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--panel-border); padding: 0.4rem 0.8rem 0.4rem 0.4rem; border-radius: 50px; color: white; cursor: pointer; transition: 0.3s; }
  .btn-profile:hover { background: rgba(255,255,255,0.1); }
  .header-avatar { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem; }
  .header-name { font-weight: 600; font-size: 0.9rem; }
  
  .dropdown-menu { position: absolute; top: calc(100% + 15px); right: 0; width: 220px; background: rgba(28, 17, 22, 0.98); backdrop-filter: blur(20px); border: 1px solid var(--panel-border); border-radius: 16px; padding: 0.5rem; box-shadow: 0 15px 40px rgba(0,0,0,0.6); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s var(--graceful); z-index: 1000; }
  .dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0); }
  .dropdown-item { display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem 1rem; color: white; text-decoration: none; border-radius: 10px; transition: 0.3s; font-size: 0.95rem; font-weight: 500; }
  .dropdown-item:hover { background: rgba(255,255,255,0.08); }
  .dropdown-item.sos-action { color: var(--rose-light); }
  .dropdown-item.sos-action:hover { background: rgba(192,57,75,0.15); }
  .dropdown-divider { height: 1px; background: rgba(255,255,255,0.05); margin: 0.5rem 0; }

  /* Dashboard Content Areas */
  .dashboard-content { flex: 1; overflow-y: auto; padding: 2rem; display: flex; flex-direction: column; gap: 2rem; scroll-behavior: smooth; }
  .dash-hero { display: grid; grid-template-columns: 1fr 350px; gap: 2rem; }
  
  .location-card { background: linear-gradient(135deg, rgba(42,157,92,0.1), rgba(28,17,22,0.8)); border: 1px solid rgba(42,157,92,0.3); border-radius: 24px; padding: 2.5rem; position: relative; overflow: hidden; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
  .location-card::after { content: ''; position: absolute; top: 0; right: 0; width: 300px; height: 100%; background: radial-gradient(circle, var(--safe-green-glow) 0%, transparent 70%); opacity: 0.3; pointer-events: none;}
  .loc-header { display: flex; justify-content: space-between; margin-bottom: 2rem; position: relative; z-index: 2;}
  .loc-title h2 { font-size: 2.5rem; font-weight: 700; margin-bottom: 0.3rem;}
  .loc-title p { color: var(--text-muted); font-family: 'JetBrains Mono', monospace; font-size: 0.9rem;}
  .safety-score-display { text-align: right; }
  .score-circle { width: 90px; height: 90px; border-radius: 50%; border: 4px solid var(--safe-green); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: 700; color: var(--safe-green); box-shadow: 0 0 20px var(--safe-green-glow), inset 0 0 20px var(--safe-green-glow); margin-bottom: 0.5rem; }
  .score-label { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--safe-green); }
  .env-metrics { display: flex; gap: 2rem; position: relative; z-index: 2; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 1.5rem;}
  .env-item { display: flex; align-items: center; gap: 0.8rem; }
  .env-item i { font-size: 1.8rem; color: rgba(255,255,255,0.8); }
  .env-text h5 { font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase;}
  .env-text p { font-size: 1.1rem; font-weight: 600; }

  .weather-card { background: var(--panel-bg); border: 1px solid var(--panel-border); border-radius: 24px; padding: 2rem; display: flex; flex-direction: column; justify-content: center; backdrop-filter: blur(10px); text-align: center; }
  .weather-card i { font-size: 3.5rem; color: #38bdf8; margin-bottom: 1rem; filter: drop-shadow(0 0 10px rgba(56,189,248,0.3));}

  /* Quick Actions */
  .section-title { font-family: 'Playfair Display', serif; font-size: 1.6rem; margin-bottom: 1.2rem; color: white;}
  .quick-actions { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1.5rem; }
  .action-card { background: var(--panel-bg); border: 1px solid var(--panel-border); border-radius: 20px; padding: 1.5rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem; cursor: pointer; transition: 0.3s; text-align: center; text-decoration: none; color: white; }
  .action-card:hover { transform: translateY(-5px); background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.2); box-shadow: 0 15px 30px rgba(0,0,0,0.3); }
  .action-icon { width: 60px; height: 60px; border-radius: 16px; background: rgba(0,0,0,0.4); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; border: 1px solid rgba(255,255,255,0.05); transition: 0.3s;}
  .action-card:hover .action-icon { transform: scale(1.1); }
  .action-card.primary { background: linear-gradient(135deg, var(--rose-dark), var(--charcoal)); border-color: rgba(192,57,75,0.4); }
  .action-card.primary .action-icon { background: var(--rose); border-color: var(--rose-light); box-shadow: 0 0 20px rgba(192,57,75,0.5); }
  
  /* Widgets */
  .widgets-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;}
  .widget-card { background: var(--panel-bg); border: 1px solid var(--panel-border); border-radius: 24px; padding: 1.5rem; display: flex; flex-direction: column; backdrop-filter: blur(10px); }
  .widget-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 1rem;}
  .widget-header h3 { font-size: 1.1rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;}
  .intel-list, .guardian-list { display: flex; flex-direction: column; gap: 1rem; }
  .intel-item { display: flex; align-items: center; gap: 1rem; background: rgba(0,0,0,0.3); padding: 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.03); }
  .intel-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; }
  .intel-icon.good { background: rgba(42,157,92,0.1); color: var(--safe-green); }
  .intel-icon.warn { background: rgba(233,162,39,0.1); color: var(--warn-amber); }
  .intel-info h5 { font-size: 0.95rem; margin-bottom: 0.2rem;}
  .intel-info p { font-size: 0.8rem; color: var(--text-muted); }
  .guardian-item { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; }
  .g-profile { display: flex; align-items: center; gap: 1rem; }
  .g-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--charcoal-light); border: 1px solid var(--panel-border); display: flex; align-items: center; justify-content: center; font-weight: 700; color: white;}
  .g-status { width: 10px; height: 10px; border-radius: 50%; background: var(--safe-green); box-shadow: 0 0 8px var(--safe-green); }
  .trip-item { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 0; border-bottom: 1px solid rgba(255,255,255,0.05); }
  .trip-icon { width: 35px; height: 35px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: var(--text-muted); }
  .trip-details h5 { font-size: 0.9rem;}
  .trip-details p { font-size: 0.75rem; color: var(--text-muted); }
  .trip-score { font-family: 'JetBrains Mono', monospace; font-size: 0.85rem; color: var(--safe-green); background: rgba(42,157,92,0.1); padding: 0.2rem 0.5rem; border-radius: 6px;}

  /* Floating SOS */
  .floating-sos { position: fixed; bottom: 3rem; right: 3rem; z-index: 1000; width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); border: 4px solid var(--charcoal); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 900; box-shadow: 0 15px 40px rgba(192,57,75,0.5); cursor: pointer; transition: all 0.2s; }
  .floating-sos::before { content: ''; position: absolute; inset: -10px; border-radius: 50%; border: 2px solid var(--rose); animation: pulse-sos 2s infinite; pointer-events: none; }
  .floating-sos:hover { transform: scale(1.05); box-shadow: 0 20px 50px rgba(192,57,75,0.7); }
  @keyframes pulse-sos { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(1.4); opacity: 0; } }

  /* Scrollbar */
  ::-webkit-scrollbar { width: 8px; }
  ::-webkit-scrollbar-track { background: var(--charcoal); }
  ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>
</head>
<body>

<div class="ambient-bg">
  <div class="grid-overlay"></div>
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
</div>

<?php include 'includes/sidebar.php'; ?>

<div class="main-wrapper">
  
  <?php include 'includes/header.php'; ?>

  <main class="dashboard-content">
    
    <section class="dash-hero">
      <div class="location-card">
        <div class="loc-header">
          <div class="loc-title">
            <p>CURRENT LOCATION • LIVE</p>
            <h2 id="liveCity">Acquiring Signal...</h2>
            <p style="color:var(--text-main); font-size:1.1rem; margin-top:0.5rem;">
              <i class="ph-fill ph-map-pin" style="color:var(--safe-green);"></i> 
              <span id="liveAddress">Establishing secure connection...</span>
            </p>
          </div>
          <div class="safety-score-display">
            <div class="score-circle">94</div>
            <div class="score-label">AI Safety Score</div>
          </div>
        </div>
        
        <div class="env-metrics">
          <div class="env-item">
            <i class="ph-fill ph-lightbulb"></i>
            <div class="env-text">
              <h5>Lighting</h5>
              <p style="color:var(--safe-green);">Excellent</p>
            </div>
          </div>
          <div class="env-item">
            <i class="ph-fill ph-users"></i>
            <div class="env-text">
              <h5>Density</h5>
              <p>Moderate</p>
            </div>
          </div>
          <div class="env-item">
            <i class="ph-fill ph-police-car"></i>
            <div class="env-text">
              <h5>Nearest Help</h5>
              <p id="helpRadiusDist">Scanning radar...</p>
              <span id="helpStationName" style="font-size: 0.75rem; color: var(--text-muted); display:block;">Locating station</span>
              <span id="helpStationPhone" style="font-size: 0.75rem; color: var(--rose-light); display:block; font-weight: bold;"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="weather-card">
        <i id="weatherIcon" class="ph-fill ph-spinner ph-spin"></i>
        <h3 id="weatherTemp">--°C</h3>
        <p id="weatherDesc">Connecting to satellite...</p>
      </div>
    </section>

    <section>
      <h2 class="section-title">Quick Actions</h2>
      <div class="quick-actions">
        <a href="#" class="action-card primary"><div class="action-icon"><i class="ph-fill ph-paper-plane-right"></i></div><h4>Navigate Safely</h4></a>
        <a href="#" class="action-card" style="border-color: rgba(192,57,75,0.4);"><div class="action-icon" style="color:var(--rose-light);"><i class="ph-fill ph-broadcast"></i></div><h4>Share Live Stream</h4></a>
        <a href="#" class="action-card"><div class="action-icon"><i class="ph-fill ph-megaphone"></i></div><h4>Report Incident</h4></a>
        <a href="#" class="action-card"><div class="action-icon"><i class="ph-fill ph-phone-call"></i></div><h4>Call Guardian</h4></a>
        <a href="#" class="action-card"><div class="action-icon"><i class="ph-fill ph-shield-plus"></i></div><h4>Offline Maps</h4></a>
      </div>
    </section>

    <section class="widgets-grid">
      
      <div class="widget-card">
        <div class="widget-header">
          <h3><i class="ph-fill ph-brain"></i> AI Local Intelligence</h3>
          <a href="#" style="color:var(--text-muted); font-size:0.85rem; text-decoration:none;">View Map</a>
        </div>
        <div class="intel-list">
          <div class="intel-item"><div class="intel-icon warn"><i class="ph-fill ph-warning-octagon"></i></div><div class="intel-info"><h5>Avoid Station Road</h5><p>2 recent community reports regarding poor lighting.</p></div></div>
          <div class="intel-item"><div class="intel-icon good"><i class="ph-fill ph-shield-check"></i></div><div class="intel-info"><h5>Main Avenue is Secure</h5><p>High crowd density and excellent visibility detected.</p></div></div>
          <div class="intel-item"><div class="intel-icon good"><i class="ph-fill ph-police-car"></i></div><div class="intel-info"><h5>Active Patrol Nearby</h5><p>City police active within 2km radius.</p></div></div>
        </div>
      </div>

      <div class="widget-card">
        <div class="widget-header">
          <h3><i class="ph-fill ph-users-three"></i> Active Guardians</h3>
        </div>
        <div class="guardian-list">
          <div class="guardian-item"><div class="g-profile"><div class="g-avatar">R</div><div class="g-info"><h5>Rahul S.</h5><p>Brother</p></div></div><div class="g-status" title="Online"></div></div>
          <div class="guardian-item"><div class="g-profile"><div class="g-avatar">A</div><div class="g-info"><h5>Anita S.</h5><p>Mother</p></div></div><div class="g-status" title="Online"></div></div>
        </div>
        <button style="margin-top:auto; width:100%; padding:0.8rem; border-radius:12px; border:1px solid var(--panel-border); background:rgba(255,255,255,0.05); color:white; font-weight:600; cursor:pointer;">Manage Contacts</button>
      </div>

      <div class="widget-card">
        <div class="widget-header">
          <h3><i class="ph-fill ph-clock-counter-clockwise"></i> Recent Routes</h3>
        </div>
        <div class="guardian-list">
          <div class="trip-item"><div class="trip-icon"><i class="ph-fill ph-briefcase"></i></div><div class="trip-details"><h5>Office to Home</h5><p>Yesterday, 6:30 PM</p></div><div class="trip-score">92</div></div>
          <div class="trip-item"><div class="trip-icon"><i class="ph-fill ph-shopping-bag"></i></div><div class="trip-details"><h5>City Mall</h5><p>Sun, 2:15 PM</p></div><div class="trip-score">88</div></div>
        </div>
      </div>
    </section>

    <?php include 'includes/footer.php'; ?>

  </main>
</div>

<div class="floating-sos" title="Hold for SOS">
  <i class="ph-fill ph-fingerprint"></i>
</div>

<script>
  // 1. Live Clock
  function updateClock() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    const clockEl = document.getElementById('liveClock');
    if(clockEl) clockEl.textContent = `${hours}:${minutes}:${seconds} IST`;
  }
  setInterval(updateClock, 1000);
  updateClock();

  // 2. User Profile Dropdown Toggle
  function toggleDropdown() {
      document.getElementById("profileDropdown").classList.toggle("show");
  }

  // Close dropdown if user clicks anywhere else on the screen
  window.onclick = function(event) {
      if (!event.target.closest('.btn-profile')) {
          const dropdowns = document.getElementsByClassName("dropdown-menu");
          for (let i = 0; i < dropdowns.length; i++) {
              if (dropdowns[i].classList.contains('show')) {
                  dropdowns[i].classList.remove('show');
              }
          }
      }
  }

  // 3. SOS Button Click Animation
  const sosBtn = document.querySelector('.floating-sos');
  if(sosBtn) {
    sosBtn.addEventListener('mousedown', () => {
      sosBtn.style.transform = 'scale(0.9)';
      sosBtn.style.background = 'var(--rose-dark)';
    });
    sosBtn.addEventListener('mouseup', () => {
      sosBtn.style.transform = 'scale(1)';
      sosBtn.style.background = 'linear-gradient(135deg, var(--rose), var(--rose-dark))';
    });
  }

  // 4. --- Distance Calculator (Haversine Formula) ---
  function getDistanceInKm(lat1, lon1, lat2, lon2) {
    const R = 6371; 
    const dLat = (lat2 - lat1) * (Math.PI / 180);
    const dLon = (lon2 - lon1) * (Math.PI / 180);
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return (R * c).toFixed(1);
  }

  // 5. --- Live Real-World Intelligence Engine ---
  function fetchRealLocation() {
    const cityEl = document.getElementById('liveCity');
    const addressEl = document.getElementById('liveAddress');
    const weatherIcon = document.getElementById('weatherIcon');
    const weatherTemp = document.getElementById('weatherTemp');
    const weatherDesc = document.getElementById('weatherDesc');
    const helpDist = document.getElementById('helpRadiusDist');
    const helpName = document.getElementById('helpStationName');
    const helpPhone = document.getElementById('helpStationPhone');

    if (!navigator.geolocation) {
      cityEl.textContent = "GPS Unavailable";
      return;
    }

    navigator.geolocation.getCurrentPosition(
      async (position) => {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        // A. REVERSE GEOCODING (Get City/Street)
        try {
          const locRes = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`);
          const locData = await locRes.json();
          if (locData && locData.address) {
            const city = locData.address.city || locData.address.town || locData.address.county || "Unknown City";
            const street = locData.address.road || locData.address.suburb || "Local Route";
            cityEl.textContent = city;
            addressEl.textContent = street;
          }
        } catch (e) { console.log("Location fetch failed"); }

        // B. LIVE WEATHER (Open-Meteo API)
        try {
          const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current_weather=true`);
          const weatherData = await weatherRes.json();
          if (weatherData && weatherData.current_weather) {
            const temp = Math.round(weatherData.current_weather.temperature);
            const code = weatherData.current_weather.weathercode;
            
            weatherTemp.textContent = `${temp}°C`;
            
            weatherIcon.classList.remove('ph-spinner', 'ph-spin');
            if (code === 0) { weatherIcon.classList.add('ph-sun'); weatherDesc.textContent = "Clear Sky • High Visibility"; }
            else if (code >= 1 && code <= 3) { weatherIcon.classList.add('ph-cloud-sun'); weatherDesc.textContent = "Partly Cloudy • Safe"; }
            else if (code >= 51 && code <= 67) { weatherIcon.classList.add('ph-cloud-rain'); weatherDesc.textContent = "Raining • Reduced Visibility"; }
            else if (code >= 71) { weatherIcon.classList.add('ph-snowflake'); weatherDesc.textContent = "Snowing • Use Caution"; }
            else if (code >= 95) { weatherIcon.classList.add('ph-cloud-lightning'); weatherDesc.textContent = "Thunderstorm • Seek Shelter"; }
            else { weatherIcon.classList.add('ph-cloud'); weatherDesc.textContent = "Overcast"; }
          }
        } catch (e) { weatherDesc.textContent = "Weather offline"; }

        // C. NEAREST POLICE STATION (Advanced Overpass API - 5km Radius)
        try {
          // 'nwr' searches Nodes, Ways, and Relations (buildings)
          const overpassQuery = `[out:json];nwr["amenity"="police"](around:5000,${lat},${lon});out center;`;
          
          const policeRes = await fetch("https://overpass-api.de/api/interpreter", {
              method: "POST",
              body: "data=" + encodeURIComponent(overpassQuery),
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' }
          });
          const policeData = await policeRes.json();

          if (policeData.elements && policeData.elements.length > 0) {
            let closestStation = null;
            let minDistance = Infinity;

            policeData.elements.forEach(station => {
              const sLat = station.lat || station.center.lat;
              const sLon = station.lon || station.center.lon;
              const distance = parseFloat(getDistanceInKm(lat, lon, sLat, sLon));
              
              if (distance < minDistance) {
                minDistance = distance;
                closestStation = station;
              }
            });

            if (closestStation) {
              const tags = closestStation.tags || {};
              const sName = tags.name || tags['name:en'] || "Local Police Station";
              const sPhone = tags.phone || tags['contact:phone'] || "No direct line available";
              
              helpDist.textContent = `${minDistance} km`;
              helpDist.style.color = minDistance <= 2 ? "var(--safe-green)" : "var(--warn-amber)";
              helpName.textContent = sName;
              helpPhone.innerHTML = sPhone !== "No direct line available" ? `<i class="ph-fill ph-phone"></i> ${sPhone}` : '';
            }
          } else {
            helpDist.textContent = "> 5.0 km";
            helpDist.style.color = "var(--rose-light)";
            helpName.textContent = "No stations found in OSM";
          }
        } catch (e) {
          helpDist.textContent = "Radar offline";
          helpName.textContent = "Unable to fetch local authorities";
        }

      },
      (error) => {
        cityEl.textContent = "GPS Denied";
        addressEl.textContent = "Please allow location access.";
        weatherIcon.className = "ph-fill ph-warning-circle";
        weatherDesc.textContent = "Requires Location";
      },
      { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
    );
  }

  // Fire it up
  fetchRealLocation();
</script>
</body>
</html>