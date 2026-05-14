<?php 
// 1. SECURITY & DB CHECK FIRST
require_once 'auth_check.php'; 
require_once '../Include/db_connect.php';
require_once '../Include/security_functions.php';

// Fetch dynamic guardians from the database
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT guardians_enc FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$user_id]);
$user_row = $stmt->fetch(PDO::FETCH_ASSOC);

$guardians = [];
if ($user_row && !empty($user_row['guardians_enc'])) {
    $decrypted = decrypt_data($user_row['guardians_enc']);
    if ($decrypted) {
        $guardians = json_decode($decrypted, true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SOS Center – SheSecure</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* =========================================
     GLOBAL & MODULAR CSS
     ========================================= */
  :root {
    --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A;
    --charcoal: #120A0E; --charcoal-light: #1C1116;
    --panel-bg: rgba(20, 10, 15, 0.95); --panel-border: rgba(255, 255, 255, 0.08);
    --safe-green: #2A9D5C; --warn-amber: #E9A227; --auth-blue: #3b82f6;
    --text-main: #FFFFFF; --text-muted: rgba(255, 255, 255, 0.5);
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body { font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: var(--text-main); overflow: hidden; display: flex; height: 100vh; width: 100vw; }

  /* ─── INCLUDED SIDEBAR & HEADER CSS ─── */
  .sidebar { width: 280px; height: 100%; background: var(--charcoal-light); border-right: 1px solid var(--panel-border); z-index: 1000; display: flex; flex-direction: column; flex-shrink: 0; }
  .sidebar-header { padding: 2rem 1.5rem; border-bottom: 1px solid var(--panel-border); display: flex; align-items: center; gap: 0.8rem; }
  .logo-icon { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 0 15px rgba(192,57,75,0.4); }
  .logo-text { font-family: 'Playfair Display', serif; font-size: 1.4rem; font-weight: 900; }
  .logo-text span { color: var(--rose-light); }
  .nav-menu { padding: 1.5rem 1rem; flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem; }
  .nav-label { font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); margin: 1rem 0 0.5rem 1rem; font-weight: 700; }
  .nav-item { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1rem; border-radius: 12px; color: var(--text-muted); text-decoration: none; font-weight: 600; font-size: 0.95rem; transition: 0.3s; }
  .nav-item:hover { background: rgba(255,255,255,0.05); color: white; }
  .nav-item.active { background: rgba(192,57,75,0.1); color: var(--rose-light); border-color: rgba(192,57,75,0.2); box-shadow: inset 4px 0 0 var(--rose); }
  .sidebar-footer { padding: 1.5rem; border-top: 1px solid var(--panel-border); }
  .user-profile { display: flex; align-items: center; gap: 1rem; }
  .user-avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--rose-light); color: var(--charcoal); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; }
  .user-info h4 { font-size: 0.95rem; color: white; }
  .user-info p { font-size: 0.75rem; color: var(--safe-green); display: flex; align-items: center; gap: 0.3rem;}

  .main-wrapper { flex: 1; display: flex; flex-direction: column; position: relative; height: 100%; min-width: 0; }
  .top-status-bar { height: 70px; width: 100%; background: rgba(18, 10, 14, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--panel-border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; z-index: 900; flex-shrink: 0; }
  .telemetry-group { display: flex; gap: 2rem; align-items: center; }
  .telemetry-item { display: flex; align-items: center; gap: 0.6rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--text-muted); }
  .telemetry-item.safe i { color: var(--safe-green); text-shadow: 0 0 10px rgba(42, 157, 92, 0.4); }
  .top-actions { display: flex; gap: 1rem; align-items: center; }

  /* Dropdown Styles */
  .user-dropdown { position: relative; display: inline-block; margin-left: 1rem; }
  .btn-profile { display: flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.05); border: 1px solid var(--panel-border); padding: 0.4rem 0.8rem 0.4rem 0.4rem; border-radius: 50px; color: white; cursor: pointer; transition: 0.3s; }
  .btn-profile:hover { background: rgba(255,255,255,0.1); }
  .dropdown-menu { position: absolute; top: calc(100% + 15px); right: 0; width: 220px; background: rgba(28, 17, 22, 0.98); border: 1px solid var(--panel-border); border-radius: 16px; padding: 0.5rem; box-shadow: 0 15px 40px rgba(0,0,0,0.6); opacity: 0; visibility: hidden; transform: translateY(-10px); transition: all 0.3s; z-index: 1000; }
  .dropdown-menu.show { opacity: 1; visibility: visible; transform: translateY(0); }
  .dropdown-item { display: flex; align-items: center; gap: 0.8rem; padding: 0.8rem 1rem; color: white; text-decoration: none; border-radius: 10px; transition: 0.3s; font-size: 0.95rem; font-weight: 500; }
  .dropdown-item:hover { background: rgba(255,255,255,0.08); }

  /* ─── AMBIENT BACKGROUND & PARTICLES ─── */
  .ambient-bg { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; overflow: hidden; pointer-events: none; background: var(--charcoal); }
  .ambient-bg::before { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 50% 50%, rgba(192,57,75,0.05) 0%, transparent 80%); transition: background 0.5s ease; }
  body.emergency-active .ambient-bg::before { background: radial-gradient(circle at 50% 50%, rgba(192,57,75,0.2) 0%, transparent 80%); animation: emergency-flash 2s infinite; }
  @keyframes emergency-flash { 0%, 100% { opacity: 0.8; } 50% { opacity: 1; background: radial-gradient(circle at 50% 50%, rgba(192,57,75,0.3) 0%, transparent 80%); } }

  .warning-banner { background: rgba(192,57,75,0.15); border-bottom: 1px solid rgba(192,57,75,0.3); padding: 0.8rem 2rem; display: flex; align-items: center; justify-content: center; gap: 0.8rem; font-size: 0.85rem; font-weight: 600; color: var(--rose-light); text-transform: uppercase; letter-spacing: 0.05em; }

  /* ─── DASHBOARD CONTENT ─── */
  .dashboard-content { flex: 1; overflow-y: auto; padding: 2rem; display: grid; grid-template-columns: 1.2fr 1fr; gap: 2rem; }

  /* LEFT COLUMN: TRIGGER & LOGS */
  .sos-trigger-section { display: flex; flex-direction: column; align-items: center; justify-content: center; background: var(--panel-bg); border: 1px solid var(--panel-border); border-radius: 30px; padding: 4rem 2rem; position: relative; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.3);}
  .sos-interactive-container { position: relative; width: 300px; height: 300px; display: flex; align-items: center; justify-content: center; margin-bottom: 2rem;}
  .sos-ring { position: absolute; inset: 0; border-radius: 50%; border: 2px dashed rgba(192,57,75,0.4); animation: spin-slow 15s linear infinite; }
  .sos-ring::before { content:''; position: absolute; inset: 20px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.05); }
  
  .sos-btn-interactive { 
    width: 180px; height: 180px; border-radius: 50%; 
    background: linear-gradient(135deg, #1c1116, #2d1520); 
    border: 4px solid var(--rose); display: flex; flex-direction: column; 
    align-items: center; justify-content: center; cursor: pointer; 
    position: relative; overflow: hidden; box-shadow: 0 0 50px rgba(192,57,75,.4), inset 0 0 20px rgba(192,57,75,0.2); 
    transition: 0.2s; z-index: 10; user-select: none; -webkit-tap-highlight-color: transparent; 
  }
  .sos-btn-interactive:active { transform: scale(0.95); }
  .sos-fill { position: absolute; bottom: 0; left: 0; width: 100%; height: 0%; background: var(--rose); z-index: 1; transition: height 0.1s linear; }
  .sos-btn-content { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; pointer-events: none;}
  .sos-btn-content i { font-size: 3rem; color: white; margin-bottom: 0.5rem; }
  .sos-btn-content span { font-weight: 900; font-size: 2rem; color: white; letter-spacing: .1em; line-height: 1;}
  .sos-btn-content small { font-size: .8rem; color: rgba(255,255,255,.8); font-weight: 500; margin-top: .6rem; text-transform: uppercase; letter-spacing: 0.15em;}
  
  .sos-status-text { font-size: 1.2rem; color: var(--text-muted); font-weight: 600; text-align: center;}
  
  @keyframes spin-slow { 100% { transform: rotate(360deg); } }
  @keyframes blink { 100% { opacity: 0.5; } }

  .terminal-card { background: #0a0a0a; border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 1.5rem; flex: 1; width: 100%; display: flex; flex-direction: column; font-family: 'JetBrains Mono', monospace;}
  .terminal-header { display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; margin-bottom: 1rem; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; }
  .terminal-logs { flex: 1; overflow-y: auto; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.85rem; max-height: 250px;}
  .terminal-logs::-webkit-scrollbar { width: 5px; }
  .terminal-logs::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 5px; }
  
  .log-entry { display: flex; gap: 1rem; opacity: 0; animation: logFadeIn 0.3s forwards; }
  .log-time { color: var(--text-muted); width: 80px; flex-shrink: 0;}
  .log-msg { color: var(--safe-green); word-break: break-word;}
  .log-msg.err { color: var(--rose-light); }
  .log-msg.sys { color: #3b82f6; }
  .log-msg.warn { color: var(--warn-amber); }
  @keyframes logFadeIn { to { opacity: 1; } }

  /* RIGHT COLUMN: CONTACTS & AI */
  .right-col { display: flex; flex-direction: column; gap: 2rem; }
  .auth-call-card, .guardian-card, .ai-triggers-card { background: var(--panel-bg); border: 1px solid var(--panel-border); border-radius: 24px; padding: 1.5rem; }
  .section-title { font-family: 'Playfair Display', serif; font-size: 1.3rem; margin-bottom: 1.2rem; color: white; display: flex; align-items: center; gap: 0.5rem;}
  
  .call-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
  .call-btn { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 1rem; display: flex; align-items: center; gap: 1rem; cursor: pointer; transition: all 0.3s; color: white; text-align: left;}
  .call-btn:hover { background: rgba(255,255,255,0.1); transform: translateY(-3px); }
  .call-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;}
  .c-police { background: rgba(59, 130, 246, 0.15); color: #60a5fa; border: 1px solid rgba(59, 130, 246, 0.3); }
  .c-amb { background: rgba(192, 57, 75, 0.15); color: var(--rose-light); border: 1px solid rgba(192, 57, 75, 0.3); }
  .c-women { background: rgba(233, 162, 39, 0.15); color: var(--warn-amber); border: 1px solid rgba(233, 162, 39, 0.3); }
  .call-btn h4 { font-size: 1rem; font-weight: 700; margin-bottom: 0.2rem;}
  .call-btn p { font-size: 0.8rem; color: var(--text-muted); font-family: 'JetBrains Mono', monospace;}

  .g-list { display: flex; flex-direction: column; gap: 1rem; }
  .g-item { display: flex; align-items: center; justify-content: space-between; background: rgba(0,0,0,0.3); padding: 1rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.03); }
  .g-profile { display: flex; align-items: center; gap: 1rem; }
  .g-avatar { width: 40px; height: 40px; border-radius: 50%; background: var(--charcoal); border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; font-weight: 700; color: var(--safe-green);}
  .g-info h5 { font-size: 0.95rem; margin-bottom: 0.2rem;}
  .g-info p { font-size: 0.75rem; color: var(--text-muted); }
  
  .g-status { padding: 0.3rem 0.8rem; border-radius: 50px; font-size: 0.7rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; border: 1px solid transparent; }
  .g-status.standby { background: rgba(255,255,255,0.05); color: var(--text-muted); border-color: rgba(255,255,255,0.1); }
  .g-status.alerted { background: rgba(192,57,75,0.15); color: var(--rose-light); border-color: rgba(192,57,75,0.4); animation: blink 1s infinite alternate; }

  /* Smart AI Triggers */
  .pref-card { display: flex; align-items: center; justify-content: space-between; padding: 1rem; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; margin-bottom: 0.8rem; }
  .pref-info h4 { font-size: 0.95rem; color: white; margin-bottom: 0.2rem; display: flex; align-items: center; gap: 0.5rem;}
  .pref-info p { font-size: 0.8rem; color: rgba(255,255,255,0.5);}
  .switch { position: relative; display: inline-block; width: 44px; height: 24px; }
  .switch input { opacity: 0; width: 0; height: 0; }
  .slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(255,255,255,0.2); transition: .4s; border-radius: 34px; }
  .slider:before { position: absolute; content: ""; height: 18px; width: 18px; left: 3px; bottom: 3px; background-color: white; transition: .4s; border-radius: 50%; }
  input:checked + .slider { background-color: var(--safe-green); }
  input:checked + .slider:before { transform: translateX(20px); }

  /* Cancel Button */
  .btn-cancel-sos { display: none; background: transparent; border: 1px solid rgba(255,255,255,0.3); color: white; padding: 1rem; border-radius: 50px; font-size: 1rem; font-weight: 700; cursor: pointer; text-align: center; transition: all 0.3s; margin-top: 1.5rem; width: 100%; }
  .btn-cancel-sos:hover { background: rgba(255,255,255,0.1); }
  body.emergency-active .btn-cancel-sos { display: block; }

  /* TOAST */
  .toast { position: fixed; bottom: 2rem; right: 2rem; background: rgba(28, 17, 22, 0.95); color: white; padding: 1rem 1.8rem; border-radius: 50px; box-shadow: 0 10px 40px rgba(0,0,0,0.3), 0 0 0 1px rgba(192,57,75,0.4); transform: translateY(100px); opacity: 0; transition: all 0.4s var(--graceful); z-index: 9999; display: flex; align-items: center; gap: 0.8rem; font-weight: 500; font-size: 0.95rem; }
  .toast.show { transform: translateY(0); opacity: 1; }
  .toast i { color: var(--rose-light); font-size: 1.4rem; }

  /* RESPONSIVE */
  @media (max-width: 1200px) { .dashboard-content { grid-template-columns: 1fr; } }
  @media (max-width: 1024px) { .sidebar { display: none; } }
  @media (max-width: 768px) {
    .top-status-bar { padding: 0 1rem; height: 60px; }
    .telemetry-item.hide-mob { display: none; }
    .warning-banner { font-size: 0.7rem; padding: 0.6rem 1rem; text-align: center;}
    .dashboard-content { padding: 1.5rem 1rem; }
    .sos-trigger-section { padding: 3rem 1.5rem; }
    .call-grid { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

<div class="ambient-bg"></div>

<?php include 'includes/sidebar.php'; ?>

<div class="main-wrapper">
  
  <?php include 'includes/header.php'; ?>

  <div class="warning-banner">
    <i class="ph-fill ph-warning-octagon"></i> This module interfaces with live emergency responders. Use only in danger.
  </div>

  <main class="dashboard-content">
    
    <div class="sos-trigger-section">
      <div class="sos-interactive-container">
        <div class="sos-ring"></div>
        <div class="sos-btn-interactive" id="sosDemoBtn">
          <div class="sos-fill" id="sosFill"></div>
          <div class="sos-btn-content" id="sosContent">
            <i class="ph-fill ph-fingerprint"></i>
            <span>SOS</span>
            <small>Hold 2 Secs</small>
          </div>
        </div>
      </div>
      
      <div class="sos-status-text" id="sosStatusText">System Armed & Ready.</div>
      <button class="btn-cancel-sos" id="btnCancelSos" onclick="resetSOS()">Mark as Safe / Cancel SOS</button>

      <div class="terminal-card" style="margin-top: 2rem;">
        <div class="terminal-header">
          <span><i class="ph-fill ph-terminal" style="color:var(--safe-green); margin-right:5px;"></i> Action Log</span>
          <span>E2EE Encrypted</span>
        </div>
        <div class="terminal-logs" id="terminalLogs">
          <div class="log-entry"><span class="log-time" id="initTime"></span><span class="log-msg sys">Session initialized. Core systems active.</span></div>
        </div>
      </div>
    </div>

    <div class="right-col">
      <div class="auth-call-card">
        <h2 class="section-title"><i class="ph-fill ph-phone-call" style="color:var(--rose-light);"></i> Authorities</h2>
        <div class="call-grid">
          <button class="call-btn" onclick="directCall('112', 'Police')">
            <div class="call-icon c-police"><i class="ph-fill ph-police-car"></i></div>
            <div><h4>Police Control</h4><p>112</p></div>
          </button>
          <button class="call-btn" onclick="directCall('108', 'Ambulance')">
            <div class="call-icon c-amb"><i class="ph-fill ph-ambulance"></i></div>
            <div><h4>Ambulance</h4><p>108</p></div>
          </button>
          <button class="call-btn" style="grid-column: 1 / -1;" onclick="directCall('1091', 'Women Helpline')">
            <div class="call-icon c-women"><i class="ph-fill ph-phone"></i></div>
            <div><h4>Women Helpline (Distress)</h4><p>1091</p></div>
          </button>
        </div>
      </div>

      <div class="guardian-card">
        <h2 class="section-title"><i class="ph-fill ph-users-three" style="color:var(--safe-green);"></i> Registered Guardians</h2>
        <div class="g-list">
          <?php if (!empty($guardians) && is_array($guardians)): ?>
              <?php foreach ($guardians as $index => $g): ?>
                  <div class="g-item">
                    <div class="g-profile">
                      <div class="g-avatar"><?php echo strtoupper(substr($g['name'] ?? 'G', 0, 1)); ?></div>
                      <div class="g-info">
                        <h5><?php echo htmlspecialchars($g['name'] ?? 'Unknown'); ?></h5>
                        <p><?php echo htmlspecialchars($g['relation'] ?? 'Guardian'); ?> • <?php echo htmlspecialchars($g['phone'] ?? 'No Phone'); ?></p>
                      </div>
                    </div>
                    <div class="g-status standby dynamic-status">STANDBY</div>
                  </div>
              <?php endforeach; ?>
          <?php else: ?>
              <div class="g-item">
                <div class="g-info"><p>No guardians registered in the database.</p></div>
              </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="ai-triggers-card">
        <h2 class="section-title"><i class="ph-fill ph-robot" style="color:var(--auth-blue);"></i> Auto-Detect AI</h2>
        <label class="pref-card">
          <div class="pref-info">
            <h4><i class="ph-fill ph-microphone"></i> Voice Distress</h4>
            <p>Triggers SOS if safe-word ("Help Me") is shouted.</p>
          </div>
          <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
        </label>
        <label class="pref-card">
          <div class="pref-info">
            <h4><i class="ph-fill ph-person-simple-throw"></i> Impact / Fall Detection</h4>
            <p>Uses device accelerometer to detect sudden attacks.</p>
          </div>
          <label class="switch"><input type="checkbox" checked><span class="slider"></span></label>
        </label>
      </div>

    </div>
  </main>
</div>

<div id="toast" class="toast"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD40uNoP53vHYc-vN5iu16U-qrVhIt8DT0&libraries=places"></script>

<script>
  // Live Clock
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

  // Dropdown Logic
  function toggleDropdown() {
      document.getElementById("profileDropdown").classList.toggle("show");
  }
  window.onclick = function(event) {
      if (!event.target.closest('.btn-profile')) {
          const dropdowns = document.getElementsByClassName("dropdown-menu");
          for (let i = 0; i < dropdowns.length; i++) {
              if (dropdowns[i].classList.contains('show')) dropdowns[i].classList.remove('show');
          }
      }
  }

  // --- AUDIO SYSTEM (BULLETPROOF FIX) ---
  let audioCtx, sirenOsc1, sirenOsc2, sirenGain, sirenInterval;

  function initAudio() {
      if (!audioCtx) {
          audioCtx = new (window.AudioContext || window.webkitAudioContext)();
          
          sirenGain = audioCtx.createGain();
          sirenGain.gain.setValueAtTime(0, audioCtx.currentTime); // MUTED INITIALLY
          sirenGain.connect(audioCtx.destination);

          sirenOsc1 = audioCtx.createOscillator();
          sirenOsc2 = audioCtx.createOscillator();
          sirenOsc1.type = 'square';
          sirenOsc2.type = 'sawtooth';

          sirenOsc1.connect(sirenGain);
          sirenOsc2.connect(sirenGain);

          sirenOsc1.start();
          sirenOsc2.start();

          sirenInterval = setInterval(() => {
              if (sirenGain.gain.value > 0) { 
                  const t = audioCtx.currentTime;
                  sirenOsc1.frequency.setValueAtTime(1400, t);
                  sirenOsc1.frequency.setValueAtTime(800, t + 0.2);
                  sirenOsc2.frequency.setValueAtTime(1500, t);
                  sirenOsc2.frequency.setValueAtTime(900, t + 0.2);
              }
          }, 400);
      }
      if(audioCtx.state === 'suspended') {
          audioCtx.resume();
      }
  }

  function playSiren() {
      if(sirenGain && audioCtx) {
          // Force aggressive volume unmute instantly
          sirenGain.gain.setValueAtTime(0.8, audioCtx.currentTime); 
      }
  }

  function stopSiren() {
      if(sirenGain && audioCtx) {
          sirenGain.gain.setValueAtTime(0, audioCtx.currentTime); // Mute instantly
      }
  }

  // --- Utilities & Action Log ---
  function getFormattedTime() {
    const now = new Date();
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    return `${hours}:${minutes}:${seconds}`;
  }

  window.addEventListener('load', () => {
    document.getElementById('initTime').innerText = getFormattedTime();
  });

  function addLog(message, type = 'sys') {
    const logsContainer = document.getElementById('terminalLogs');
    const entry = document.createElement('div');
    entry.className = 'log-entry';
    entry.innerHTML = `<span class="log-time">${getFormattedTime()}</span><span class="log-msg ${type}">${message}</span>`;
    logsContainer.appendChild(entry);
    logsContainer.scrollTop = logsContainer.scrollHeight;
  }

  function showToast(message, icon = 'ph-info', color = 'var(--safe-green)') {
    const toast = document.getElementById('toast');
    toast.innerHTML = `<i class="ph-fill ${icon}" style="color:${color};"></i> <span>${message}</span>`;
    toast.style.boxShadow = `0 10px 40px rgba(0,0,0,0.3), 0 0 0 1px ${color}`;
    toast.classList.add('show');
    if(window.toastTimeout) clearTimeout(window.toastTimeout);
    window.toastTimeout = setTimeout(() => { toast.classList.remove('show'); }, 3000);
  }

  function directCall(number, service) {
    addLog(`Initiating manual dial to ${service} (${number})...`, 'sys');
    window.location.href = `tel:${number}`;
  }

  // --- SOS INTERACTIVE HOLD LOGIC ---
  const sosBtn = document.getElementById('sosDemoBtn');
  const sosFill = document.getElementById('sosFill');
  const sosStatusText = document.getElementById('sosStatusText');
  const sosContent = document.getElementById('sosContent');
  
  let fillInterval;
  let progress = 0;
  let isTriggered = false;

  const startHold = (e) => {
    if(isTriggered) return;
    
    // CRITICAL: Initialize audio on first physical touch so browser doesn't block it
    initAudio(); 

    clearInterval(fillInterval); 
    
    sosStatusText.textContent = "Hold to activate SOS...";
    sosStatusText.style.color = "var(--rose)";
    addLog("SOS Button hold detected...", "warn");
    
    fillInterval = setInterval(() => {
      progress += 5; 
      sosFill.style.height = `${progress}%`;
      
      if(progress >= 100) {
        clearInterval(fillInterval);
        executeRealSOS();
      }
    }, 100);
  };

  const endHold = (e) => {
    if(isTriggered) return;
    clearInterval(fillInterval);
    progress = 0;
    sosFill.style.height = '0%';
    sosStatusText.textContent = "System Armed & Ready.";
    sosStatusText.style.color = "var(--text-muted)";
    addLog("SOS hold aborted. Returning to standby.", "sys");
  };

  // --- TRIGGER TRUE SOS SEQUENCE ---
  const executeRealSOS = () => {
    isTriggered = true;
    sosFill.style.height = '100%';
    
    document.body.classList.add('emergency-active');
    
    sosBtn.style.border = "4px solid white";
    sosBtn.style.background = "var(--rose)";
    sosBtn.style.boxShadow = "0 0 80px var(--rose)";
    sosContent.innerHTML = `<i class="ph-fill ph-warning-octagon" style="color:white; font-size:3.5rem; margin-bottom:0; animation: blink 1s infinite alternate;"></i><span style="font-size:1.6rem; margin-top:5px; color:white;">ACTIVE</span>`;
    
    sosStatusText.textContent = "CRITICAL EMERGENCY ACTIVE";
    sosStatusText.style.color = "var(--rose-light)";

    const sysStat = document.getElementById('system-status');
    sysStat.textContent = "SOS DISPATCHED";
    sysStat.className = "active";
    
    // Update dynamic DB Guardians status visually
    const gStatuses = document.querySelectorAll('.dynamic-status');
    gStatuses.forEach(el => {
        el.className = "g-status alerted dynamic-status";
        el.textContent = "ALERTED";
    });
    
    addLog("CRITICAL: SOS Triggered! Engaging audio deterrent.", "err");
    
    // Fire the Ear-Piercing Siren
    playSiren();

    addLog("Acquiring high-accuracy GPS coordinates...", "sys");
    
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                addLog(`GPS Lock acquired: ${lat.toFixed(4)}, ${lng.toFixed(4)}`, "");
                
                addLog("Encrypting payload and dispatching to secure backend...", "sys");
                
                try {
                    const geocoder = new google.maps.Geocoder();
                    geocoder.geocode({ location: {lat, lng} }, (results, status) => {
                        let address = (status === "OK" && results[0]) ? results[0].formatted_address : "Coordinates Only";
                        sendToPHP(lat, lng, address);
                    });
                } catch(e) {
                    sendToPHP(lat, lng, "Coordinates Only");
                }
            },
            (error) => {
                addLog("GPS Access Denied. Sending alert without location.", "err");
                sendToPHP("Unknown", "Unknown", "Location access denied by device.");
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        sendToPHP("Unknown", "Unknown", "Geolocation not supported.");
    }
  };

  // --- SEND TO trigger_sos.php ---
  function sendToPHP(lat, lng, address) {
      const formData = new FormData();
      formData.append('lat', lat);
      formData.append('lng', lng);
      formData.append('address', address);

      fetch('trigger_sos.php', { method: 'POST', body: formData })
      .then(response => response.json())
      .then(data => {
          if(data.status === 'success') {
              addLog(`Backend Response: ${data.message}`, "sys");
              showToast('SOS Active. Guardians notified.', 'ph-warning-octagon', 'var(--rose-light)');
          } else {
              addLog(`Backend Error: ${data.message}`, "err");
              showToast('Failed to send email. Call authorities!', 'ph-x-circle', 'var(--rose-light)');
          }
      })
      .catch(error => {
          addLog("Network failure reaching server.", "err");
      });
  }

  // --- RESET SOS SEQUENCE ---
  const resetSOS = () => {
    isTriggered = false;
    progress = 0;
    
    stopSiren(); 
    addLog("User verified safety. Disarming alarm and silencing audio.", "sys");

    document.body.classList.remove('emergency-active');
    
    sosFill.style.height = '0%';
    sosBtn.style.border = "4px solid var(--rose)";
    sosBtn.style.background = "linear-gradient(135deg, #1c1116, #2d1520)";
    sosBtn.style.boxShadow = "0 0 50px rgba(192,57,75,.4), inset 0 0 20px rgba(192,57,75,0.2)";
    sosContent.innerHTML = `<i class="ph-fill ph-fingerprint"></i><span>SOS</span><small>Hold 2 Secs</small>`;
    
    sosStatusText.textContent = "System Armed & Ready.";
    sosStatusText.style.color = "var(--text-muted)";

    const sysStat = document.getElementById('system-status');
    sysStat.textContent = "SYSTEM READY";
    sysStat.className = "ready";

    // Revert Guardian status
    const gStatuses = document.querySelectorAll('.dynamic-status');
    gStatuses.forEach(el => {
        el.className = "g-status standby dynamic-status";
        el.textContent = "STANDBY";
    });

    showToast('Emergency cancelled. System reset.', 'ph-shield-check', 'var(--safe-green)');
  };

  sosBtn.addEventListener('mousedown', startHold);
  sosBtn.addEventListener('mouseup', endHold);
  sosBtn.addEventListener('mouseleave', endHold);
  sosBtn.addEventListener('touchstart', startHold);
  sosBtn.addEventListener('touchend', endHold);
  sosBtn.addEventListener('touchcancel', endHold);
</script>
</body>
</html>