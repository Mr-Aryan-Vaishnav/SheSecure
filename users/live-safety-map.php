<?php 
// 1. SECURITY CHECK: Ensures only logged-in users access the map
require_once 'auth_check.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Live Safety Map – SheSecure | Team Coffee To Code</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* =========================================
     STRICT FLEXBOX LAYOUT ARCHITECTURE
     ========================================= */
  :root {
    --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A;
    --charcoal: #120A0E; --charcoal-light: #1C1116;
    --panel-bg: rgba(20, 10, 15, 0.95); --panel-border: rgba(255, 255, 255, 0.08);
    --safe-green: #2A9D5C; --safe-green-glow: rgba(42, 157, 92, 0.4);
    --warn-amber: #E9A227; --auth-blue: #3b82f6;
    --text-main: #FFFFFF; --text-muted: rgba(255, 255, 255, 0.5);
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  
  /* 1. Base Layout: Prevents scrolling, forces side-by-side flex */
  body {
    font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: var(--text-main);
    overflow: hidden; display: flex; height: 100vh; width: 100vw;
  }

  /* 2. Sidebar: Fixed width, never shrinks */
  .sidebar {
    width: 280px; height: 100%; background: var(--charcoal-light);
    border-right: 1px solid var(--panel-border); z-index: 1000;
    display: flex; flex-direction: column; flex-shrink: 0;
  }

  /* 3. Main Wrapper: Takes remaining width, stacks children vertically */
  .main-wrapper {
    flex: 1; display: flex; flex-direction: column; 
    position: relative; height: 100%; min-width: 0;
  }

  /* 4. Header Placeholder Styles (Handled by include, but ensure bounds) */
  .top-status-bar {
    height: 70px; width: 100%; background: rgba(18, 10, 14, 0.8);
    backdrop-filter: blur(20px); border-bottom: 1px solid var(--panel-border);
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 2rem; z-index: 900; flex-shrink: 0;
  }

  /* 5. Map Master Container: The crucial element to prevent overlapping */
  .map-master-container {
    flex: 1; /* Takes remaining height below header */
    position: relative; /* All floating elements are trapped inside this box */
    background: #0a0e17; overflow: hidden; width: 100%;
  }

  #googleMap { position: absolute; inset: 0; width: 100%; height: 100%; z-index: 1; }
  #googleMap { filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(110%); }

  .map-scanner {
    position: absolute; top: 0; left: 0; width: 100%; height: 5px; background: var(--safe-green);
    box-shadow: 0 0 20px var(--safe-green); z-index: 2;
    animation: radarScan 6s linear infinite alternate; opacity: 0.3; pointer-events: none;
  }
  @keyframes radarScan { 0% { top: -10%; } 100% { top: 110%; } }

  /* ─── FLOATING PANELS (Confined to map-master-container) ─── */
  
  /* HUD Panel (Top Left) */
  .hud-panel {
    position: absolute; top: 20px; left: 20px; width: 340px; 
    background: var(--panel-bg); backdrop-filter: blur(15px);
    border: 1px solid var(--panel-border); border-radius: 24px;
    z-index: 100; box-shadow: 0 20px 40px rgba(0,0,0,0.5); overflow: hidden;
  }
  .hud-header { padding: 1.5rem; background: rgba(0,0,0,0.3); border-bottom: 1px solid rgba(255,255,255,0.05); }
  .hud-city { font-family: 'Playfair Display', serif; font-size: 1.8rem; font-weight: 700; color: white; }
  .hud-sub { font-size: 0.8rem; color: var(--safe-green); text-transform: uppercase; letter-spacing: 0.1em; display: flex; align-items: center; gap: 0.5rem; margin-top: 0.3rem; }
  .hud-score-card { padding: 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.05); }
  .hud-score-info h4 { font-size: 0.9rem; color: rgba(255,255,255,0.8); margin-bottom: 0.2rem;}
  .hud-score-circle { width: 70px; height: 70px; border-radius: 50%; border: 4px solid var(--safe-green); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; font-weight: 700; color: var(--safe-green); box-shadow: 0 0 15px var(--safe-green-glow); transition: 0.3s; }
  .report-item { display: flex; gap: 1rem; padding: 1.2rem 1.5rem; border-bottom: 1px dashed rgba(255,255,255,0.1); }
  .report-icon { width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; flex-shrink: 0; }
  .report-text h5 { font-size: 0.9rem; color: white; margin-bottom: 0.2rem;}
  .report-text p { font-size: 0.75rem; color: var(--text-muted); line-height: 1.4;}

  /* Layer Controls (Top Right) */
  .layer-controls {
    position: absolute; top: 20px; right: 20px;
    display: flex; flex-direction: column; gap: 0.8rem; z-index: 100;
  }
  .layer-btn {
    width: 50px; height: 50px; border-radius: 14px; background: var(--panel-bg);
    backdrop-filter: blur(15px); border: 1px solid var(--panel-border);
    color: var(--text-muted); display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 30px rgba(0,0,0,0.3);
  }
  .layer-btn:hover { background: rgba(255,255,255,0.1); color: white; }
  .layer-btn.active { color: var(--safe-green); border-color: rgba(42, 157, 92, 0.4); box-shadow: 0 0 15px rgba(42, 157, 92, 0.2); }
  .layer-btn.active.danger-toggle { color: var(--rose-light); border-color: rgba(192, 57, 75, 0.4); }

  /* Timeline (Bottom Center) */
  .timeline-panel {
    position: absolute; bottom: 30px; left: 50%; transform: translateX(-50%);
    width: 90%; max-width: 800px; background: var(--panel-bg);
    backdrop-filter: blur(15px); border: 1px solid var(--panel-border);
    border-radius: 20px; padding: 1.5rem 2rem; z-index: 100;
    box-shadow: 0 30px 60px rgba(0,0,0,0.5);
  }
  .timeline-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
  .time-display { font-family: 'JetBrains Mono', monospace; font-size: 0.9rem; color: var(--safe-green); font-weight: 700; transition: 0.3s;}
  .slider-container { position: relative; width: 100%; height: 6px; display: flex; align-items: center; background: rgba(255,255,255,0.1); border-radius: 5px; }
  .time-slider { -webkit-appearance: none; width: 100%; height: 100%; background: transparent; outline: none; z-index: 2; }
  .time-slider::-webkit-slider-thumb { -webkit-appearance: none; width: 20px; height: 20px; border-radius: 50%; background: white; cursor: pointer; border: 3px solid var(--auth-blue); box-shadow: 0 0 10px rgba(59, 130, 246, 0.6); }
  .risk-gradient { position: absolute; width: 100%; height: 100%; border-radius: 5px; background: linear-gradient(90deg, var(--safe-green) 0%, var(--warn-amber) 60%, var(--rose) 100%); opacity: 0.3; }

  /* Floating SOS (Bottom Right) */
  .floating-sos {
    position: absolute; bottom: 120px; right: 20px; z-index: 1000;
    width: 70px; height: 70px; border-radius: 50%;
    background: linear-gradient(135deg, var(--rose), var(--rose-dark));
    border: 3px solid var(--charcoal); display: flex; align-items: center; justify-content: center;
    color: white; font-size: 2.2rem; font-weight: 900; box-shadow: 0 15px 40px rgba(192,57,75,0.5);
    cursor: pointer; transition: 0.2s;
  }
  .floating-sos:hover { transform: scale(1.05); }
  .floating-sos::before { content: ''; position: absolute; inset: -8px; border-radius: 50%; border: 2px solid var(--rose); animation: pulse-sos 2s infinite; pointer-events: none; }
  @keyframes pulse-sos { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(1.4); opacity: 0; } }

  .toast { position: fixed; top: 2rem; right: 2rem; padding: 1rem 2rem; border-radius: 50px; background: var(--safe-green); color: white; font-weight: 600; transform: translateY(-100px); opacity: 0; transition: 0.5s; z-index: 9999; }
  .toast.show { transform: translateY(0); opacity: 1; }
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

<?php include 'includes/sidebar.php'; ?>

<div class="main-wrapper">
  
  <?php include 'includes/header.php'; ?>

  <div class="map-master-container">
    
    <div class="map-scanner"></div>
    <div id="googleMap"></div>

    <aside class="hud-panel">
      <div class="hud-header">
        <h2 class="hud-city" id="cityName">Detecting Location...</h2>
        <div class="hud-sub"><i class="ph-fill ph-broadcast" style="animation: pulse-sos 2s infinite;"></i> Live Intelligence</div>
      </div>
      
      <div class="hud-score-card">
        <div class="hud-score-info">
          <h4>Safety Index</h4>
          <p id="localAddress" style="font-size:0.75rem; color:var(--text-muted); font-family: 'JetBrains Mono';">Acquiring secure signal...</p>
        </div>
        <div class="hud-score-circle" id="cityScore">94</div>
      </div>

      <div class="hud-reports">
        <div class="report-item">
          <div class="report-icon" style="background:rgba(42,157,92,0.1); color:var(--safe-green); border: 1px solid rgba(42,157,92,0.3);">
            <i class="ph-fill ph-shield-check"></i>
          </div>
          <div class="report-text">
            <h5>Area Patrol: Active</h5>
            <p>Verification complete. Authorities are patrolling this sector.</p>
          </div>
        </div>
        <div class="report-item" style="border-bottom: none;">
          <div class="report-icon" style="background:rgba(59, 130, 246, 0.1); color:var(--auth-blue); border: 1px solid rgba(59, 130, 246, 0.3);">
            <i class="ph-fill ph-users-three"></i>
          </div>
          <div class="report-text">
            <h5>High Crowd Density</h5>
            <p>Safe environment. High visibility from public movement detected.</p>
          </div>
        </div>
      </div>
    </aside>

    <div class="layer-controls">
      <button class="layer-btn active danger-toggle" id="btn-danger" title="Unsafe Zones" onclick="toggleLayer('danger')"><i class="ph-fill ph-warning-octagon"></i></button>
      <button class="layer-btn active" id="btn-police" title="Police Radar" onclick="toggleLayer('police')"><i class="ph-fill ph-police-car"></i></button>
      <button class="layer-btn" id="btn-light" title="Lighting Map" onclick="toggleLayer('light')"><i class="ph-fill ph-lightbulb"></i></button>
    </div>

    <div class="timeline-panel">
      <div class="timeline-header">
        <h4 style="font-size:0.9rem; font-weight:600; display:flex; align-items:center; gap:0.5rem;"><i class="ph-fill ph-clock-counter-clockwise" style="color:var(--auth-blue);"></i> Safety Forecast Timeline</h4>
        <div class="time-display" id="sliderTime">12:00 (Current)</div>
      </div>
      <div class="slider-container">
        <div class="risk-gradient"></div>
        <input type="range" min="0" max="23" value="12" class="time-slider" id="timeSlider">
      </div>
    </div>

    <div class="floating-sos" title="Hold for SOS">
      <i class="ph-fill ph-siren"></i>
    </div>

  </div> </div> <div id="toast" class="toast"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&libraries=places"></script>

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
  let map;
  let userMarker;
  
  // Initialize Map with Geolocation
  function initMap() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((position) => {
        const userPos = { lat: position.coords.latitude, lng: position.coords.longitude };
        
        map = new google.maps.Map(document.getElementById("googleMap"), {
          center: userPos, zoom: 15, disableDefaultUI: true
        });

        // Add custom beacon marker for user
        userMarker = new google.maps.Marker({
          position: userPos, map: map,
          icon: { path: google.maps.SymbolPath.CIRCLE, scale: 10, fillColor: "#2A9D5C", fillOpacity: 1, strokeColor: "white", strokeWeight: 2 }
        });

        // Get City and Street name for the HUD
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: userPos }, (results, status) => {
          if (status === "OK" && results[0]) {
            const city = results[0].address_components.find(c => c.types.includes("locality"))?.long_name || "Unknown Area";
            document.getElementById('cityName').textContent = city;
            document.getElementById('localAddress').textContent = results[0].formatted_address.split(',')[0];
          }
        });
      }, () => {
        showToast("GPS Permission Denied. Showing default map.");
        map = new google.maps.Map(document.getElementById("googleMap"), { center: {lat: 22.7196, lng: 75.8577}, zoom: 14, disableDefaultUI: true });
      });
    }
  }

  // Layer Toggles
  function toggleLayer(type) {
    const btn = document.getElementById(`btn-${type}`);
    btn.classList.toggle('active');
    showToast(`${type.charAt(0).toUpperCase() + type.slice(1)} intelligence layer ${btn.classList.contains('active') ? 'enabled' : 'disabled'}.`);
  }

  // Timeline Logic (Updates the Score Circle)
  document.getElementById('timeSlider').addEventListener('input', function() {
    const hour = parseInt(this.value);
    const cityScore = document.getElementById('cityScore');
    const sliderTime = document.getElementById('sliderTime');
    
    let displayTime = hour === 0 ? "00:00 (Midnight)" : `${hour}:00`;
    sliderTime.textContent = displayTime + " Forecast";

    // Simulate AI Score Drop at night
    if (hour >= 19 || hour <= 5) { 
      cityScore.textContent = "68";
      cityScore.style.color = "var(--warn-amber)";
      cityScore.style.borderColor = "var(--warn-amber)";
      cityScore.style.boxShadow = "0 0 15px rgba(233, 162, 39, 0.4)";
      sliderTime.style.color = "var(--warn-amber)";
    } else {
      cityScore.textContent = "94";
      cityScore.style.color = "var(--safe-green)";
      cityScore.style.borderColor = "var(--safe-green)";
      cityScore.style.boxShadow = "0 0 15px var(--safe-green-glow)";
      sliderTime.style.color = "var(--safe-green)";
    }
  });

  function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 3000);
  }

  window.onload = initMap;
</script>
</body>
</html>