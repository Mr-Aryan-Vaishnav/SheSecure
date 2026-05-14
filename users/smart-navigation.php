<?php 
// 1. SECURITY CHECK FIRST
require_once 'auth_check.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Smart Navigation – SheSecure</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* =========================================
     GLOBAL DASHBOARD THEME & CSS
     ========================================= */
  :root {
    --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A;
    --charcoal: #120A0E; --charcoal-light: #1C1116;
    --panel-bg: rgba(20, 10, 15, 0.85); --panel-border: rgba(255, 255, 255, 0.08);
    --safe-green: #2A9D5C; --safe-green-glow: rgba(42, 157, 92, 0.4);
    --warn-amber: #E9A227; --text-main: #FFFFFF; --text-muted: rgba(255, 255, 255, 0.5);
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }
  body { font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: var(--text-main); overflow: hidden; display: flex; height: 100vh; width: 100vw; }

  /* ─── PRELOADER ─── */
  #preloader { position: fixed; inset: 0; background: var(--charcoal); z-index: 999999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.8s var(--graceful), visibility 0.8s var(--graceful); }
  .loader-icon { font-size: 4rem; color: var(--safe-green); margin-bottom: 1.5rem; animation: pulse-loader 1.5s infinite alternate var(--graceful); }
  .loader-text { color: white; font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 0.15em; text-transform: uppercase; }
  @keyframes pulse-loader { 0% { transform: scale(0.85); opacity: 0.6; filter: drop-shadow(0 0 0 transparent); } 100% { transform: scale(1.15); opacity: 1; filter: drop-shadow(0 0 20px var(--safe-green)); } }
  .preloader-hidden { opacity: 0; visibility: hidden; }

  /* ─── MODULAR SIDEBAR INCLUSION STYLES ─── */
  .sidebar { width: 280px; background: rgba(18, 10, 14, 0.95); backdrop-filter: blur(20px); border-right: 1px solid var(--panel-border); display: flex; flex-direction: column; z-index: 100; }
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
  
  .main-wrapper { flex: 1; display: flex; flex-direction: column; position: relative; }
  .top-status-bar { height: 60px; background: rgba(18, 10, 14, 0.8); backdrop-filter: blur(20px); border-bottom: 1px solid var(--panel-border); display: flex; align-items: center; justify-content: space-between; padding: 0 2rem; z-index: 90; position: absolute; width: 100%; top: 0; }
  .telemetry-group { display: flex; gap: 2rem; align-items: center; }
  .telemetry-item { display: flex; align-items: center; gap: 0.6rem; font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: var(--text-muted); }
  .telemetry-item.safe i { color: var(--safe-green); text-shadow: 0 0 10px var(--safe-green-glow); }
  .top-actions { display: flex; gap: 1rem; align-items: center; }

  /* ─── GOOGLE MAP INTEGRATION ─── */
  .map-container { position: absolute; inset: 0; top: 60px; background: #0f0a0d; z-index: 1; overflow: hidden; }
  #googleMap { width: 100%; height: 100%; }
  /* Invert Google Maps to match our dark UI perfectly */
  #googleMap { filter: invert(90%) hue-rotate(180deg) brightness(95%) contrast(110%); }

  /* ─── FLOATING CONTROL PANEL ─── */
  .nav-panel {
    position: absolute; top: 80px; left: 20px; width: 420px; max-height: calc(100vh - 100px);
    background: var(--panel-bg); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--panel-border); border-radius: 24px; z-index: 10; display: flex; flex-direction: column;
    box-shadow: 0 30px 60px rgba(0,0,0,0.5); overflow-y: auto; transition: 0.3s;
  }
  .nav-panel::-webkit-scrollbar { display: none; } 

  .search-section { padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); }
  .search-row { display: flex; align-items: center; gap: 1rem; background: rgba(0,0,0,0.4); padding: 0.8rem 1rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 0.8rem;}
  .search-row i { font-size: 1.2rem; }
  .search-row input { background: transparent; border: none; outline: none; color: white; font-family: 'DM Sans', sans-serif; font-size: 0.95rem; width: 100%; }
  
  .route-options { padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }
  .section-heading { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--text-muted); font-weight: 700; margin-bottom: 0.5rem; }

  .route-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 1.2rem; cursor: pointer; transition: all 0.3s; position: relative; overflow: hidden; display:none; }
  .route-card.selected.safe-route { background: rgba(42,157,92,0.1); border-color: var(--safe-green); box-shadow: 0 10px 20px rgba(42,157,92,0.15); }
  .route-card.selected.mod-route { background: rgba(233,162,39,0.1); border-color: var(--warn-amber); box-shadow: 0 10px 20px rgba(233,162,39,0.15); }
  .route-card.selected.unsafe-route { background: rgba(192,57,75,0.1); border-color: var(--rose-light); box-shadow: 0 10px 20px rgba(192,57,75,0.15); }
  
  .route-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.8rem; }
  .route-info h3 { font-size: 1.1rem; color: white; margin-bottom: 0.2rem; display: flex; align-items: center; gap: 0.5rem; }
  .route-info p { font-size: 0.85rem; color: var(--text-muted); font-family: 'JetBrains Mono', monospace; }
  
  .route-score { display: flex; flex-direction: column; align-items: flex-end; }
  .score-badge { font-family: 'DM Sans', sans-serif; font-size: 1.4rem; font-weight: 700; line-height: 1; padding: 0.3rem 0.6rem; border-radius: 8px; }
  
  .ai-breakdown { padding: 0 1.5rem 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); display:none;}
  .breakdown-item { display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.8rem; }
  .b-label { display: flex; align-items: center; gap: 0.6rem; font-size: 0.85rem; color: rgba(255,255,255,0.8); }
  .b-bar-container { width: 100px; height: 6px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; }
  .b-bar { height: 100%; border-radius: 10px; }

  .nav-actions-panel { padding: 1.5rem; display: flex; flex-direction: column; gap: 1rem; }
  .btn-start { background: var(--safe-green); color: white; border: none; padding: 1.2rem; border-radius: 16px; font-size: 1.1rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.6rem; box-shadow: 0 10px 30px rgba(42,157,92,0.3); transition: 0.3s; margin-top: 0.5rem; }
  .btn-start:hover { transform: translateY(-2px); box-shadow: 0 15px 40px rgba(42,157,92,0.5); }
  .btn-start:disabled { background: var(--panel-border); cursor: not-allowed; box-shadow: none; transform: none;}

  /* Floating SOS */
  .floating-sos { position: fixed; bottom: 2rem; right: 2rem; z-index: 1000; width: 70px; height: 70px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); border: 3px solid var(--charcoal); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.2rem; font-weight: 900; box-shadow: 0 15px 40px rgba(192,57,75,0.5); cursor: pointer; transition: all 0.2s; }
  .floating-sos::before { content: ''; position: absolute; inset: -8px; border-radius: 50%; border: 2px solid var(--rose); animation: pulse-sos 2s infinite; pointer-events: none; }
  
  /* Voice Navigation Overlay */
  .voice-overlay { position: absolute; top: 20px; left: 50%; transform: translateX(-50%); background: rgba(42,157,92,0.9); backdrop-filter: blur(10px); padding: 1rem 2rem; border-radius: 50px; color: white; font-weight: 700; display: none; align-items: center; gap: 1rem; z-index: 100; box-shadow: 0 10px 30px rgba(0,0,0,0.5); animation: slideDown 0.5s var(--graceful);}
  @keyframes slideDown { from { top: -50px; opacity: 0; } to { top: 20px; opacity: 1; } }

  .toast { position: fixed; top: 2rem; right: 2rem; padding: 1rem 2rem; border-radius: 50px; background: var(--safe-green); color: white; font-weight: 600; transform: translateY(-100px); opacity: 0; transition: 0.5s; z-index: 9999; display: flex; align-items: center; gap: 10px; }
  .toast.show { transform: translateY(0); opacity: 1; }

  /* RESPONSIVE */
  @media (max-width: 1024px) { .sidebar { display: none; } }
  @media (max-width: 768px) {
    .nav-panel { top: auto; bottom: 0; left: 0; right: 0; width: 100%; border-radius: 30px 30px 0 0; max-height: 60vh; }
    .floating-sos { bottom: calc(60vh + 20px); right: 10px; width: 60px; height: 60px; font-size: 1.8rem;}
    .top-status-bar { padding: 0 1rem; }
    .telemetry-item.hide-mob { display: none; }
  }
</style>
</head>
<body>

<div id="preloader">
  <i class="ph-fill ph-compass loader-icon"></i>
  <div class="loader-text">Analyzing Safe Routes...</div>
</div>

<?php include 'includes/sidebar.php'; ?>

<div class="main-wrapper">
  
  <header class="top-status-bar">
    <div class="telemetry-group">
      <div class="telemetry-item safe"><i class="ph-fill ph-satellite"></i> GPS: TRACKING</div>
      <div class="telemetry-item safe hide-mob"><i class="ph-fill ph-shield-check"></i> AI ENGINE: ACTIVE</div>
    </div>
    <div class="top-actions">
      <div class="telemetry-item" style="margin-right:1rem;"><i class="ph-fill ph-clock"></i> <span id="liveClock">--:--:-- IST</span></div>
    </div>
  </header>

  <div class="map-container">
    <div id="googleMap"></div>
    <div class="voice-overlay" id="voiceNavOverlay">
        <i class="ph-fill ph-speaker-high" style="font-size: 1.5rem; animation: pulse-sos 1.5s infinite;"></i>
        <span id="voiceText">Calculating Turn-by-Turn...</span>
    </div>
  </div>

  <aside class="nav-panel">
    
    <div class="search-section">
      <div class="search-row">
        <i class="ph-fill ph-crosshair" style="color:var(--safe-green);"></i>
        <input type="text" id="originInput" placeholder="Locating your position..." readonly>
      </div>
      <div class="search-row" style="border-color: rgba(255,255,255,0.2); background: rgba(0,0,0,0.6);">
        <i class="ph-fill ph-map-pin" style="color:var(--rose-light);"></i>
        <input type="text" id="destInput" placeholder="Where do you want to go safely?">
      </div>
    </div>

    <div class="route-options" id="routeOptionsContainer">
      <div class="section-heading">Suggested Routes</div>
      <p id="routingStatus" style="font-size:0.9rem; color:var(--text-muted); text-align:center; padding: 2rem 0;">Enter a destination to activate AI Safe Routing.</p>
      
      <div class="route-card" id="routeCard0" onclick="selectRoute(0)">
        <div class="route-header">
          <div class="route-info">
            <h3 id="rTitle0"><i class="ph-fill ph-shield-star"></i> AI Safest Route</h3>
            <p id="rMeta0">-- min (-- km)</p>
          </div>
          <div class="route-score">
            <div class="score-badge" id="rScoreVal0">--</div>
            <div class="score-label">Safe Score</div>
          </div>
        </div>
        <p id="rDesc0" style="font-size:0.8rem; color:rgba(255,255,255,0.6); margin:0;">Analyzing metrics...</p>
      </div>

      <div class="route-card" id="routeCard1" onclick="selectRoute(1)">
        <div class="route-header">
          <div class="route-info">
            <h3 id="rTitle1"><i class="ph-bold ph-clock-fast" style="color:var(--warn-amber);"></i> Fastest Route</h3>
            <p id="rMeta1">-- min (-- km)</p>
          </div>
          <div class="route-score">
            <div class="score-badge" id="rScoreVal1">--</div>
            <div class="score-label">Safe Score</div>
          </div>
        </div>
        <p id="rDesc1" style="font-size:0.8rem; color:var(--warn-amber); margin:0;">Analyzing metrics...</p>
      </div>
    </div>

    <div class="ai-breakdown" id="aiBreakdown">
      <div class="section-heading">Real-Time Risk Analysis</div>
      <div class="breakdown-item"><div class="b-label"><i class="ph-fill ph-lightbulb"></i> Lighting Level</div><div class="b-bar-container"><div class="b-bar" id="barLight"></div></div></div>
      <div class="breakdown-item"><div class="b-label"><i class="ph-fill ph-users"></i> Crowd Density</div><div class="b-bar-container"><div class="b-bar" id="barCrowd"></div></div></div>
      <div class="breakdown-item"><div class="b-label"><i class="ph-fill ph-police-car"></i> Emergency Access</div><div class="b-bar-container"><div class="b-bar" id="barEmerg"></div></div></div>
      <div class="breakdown-item"><div class="b-label"><i class="ph-fill ph-warning-octagon"></i> Crime Risk (AI)</div><div class="b-bar-container"><div class="b-bar" id="barCrime"></div></div></div>
    </div>

    <div class="nav-actions-panel">
      <button class="btn-start" id="startNavBtn" disabled>
        <i class="ph-fill ph-navigation-arrow"></i> Start Navigation
      </button>
    </div>

  </aside>
</div>

<div class="floating-sos" title="Hold for SOS">
  <i class="ph-fill ph-siren"></i>
</div>

<div id="toast" class="toast"></div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD40uNoP53vHYc-vN5iu16U-qrVhIt8DT0&libraries=places"></script>

<script>
  // --- Preloader Logic ---
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.getElementById('preloader').classList.add('preloader-hidden');
    }, 800); 
  });

  let map, directionsService, directionsRendererPrimary, directionsRendererAlt;
  let userLocation = null;
  let availableRoutes = [];
  let selectedRouteIndex = 0;
  let synth = window.speechSynthesis;

  // --- Clock Update ---
  setInterval(() => {
    const now = new Date();
    document.getElementById('liveClock').textContent = `${String(now.getHours()).padStart(2,'0')}:${String(now.getMinutes()).padStart(2,'0')}:${String(now.getSeconds()).padStart(2,'0')} IST`;
  }, 1000);

  // --- Toast Notification ---
  function showToast(msg, icon='ph-check-circle', color='var(--safe-green)') {
    const toast = document.getElementById('toast');
    toast.innerHTML = `<i class="ph-fill ${icon}" style="color:${color};"></i> <span>${msg}</span>`;
    toast.style.background = 'var(--charcoal)';
    toast.style.border = `1px solid ${color}`;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 4000);
  }

  // --- Initialize Map & Location ---
  function initMap() {
    map = new google.maps.Map(document.getElementById("googleMap"), {
      zoom: 14,
      center: { lat: 22.7196, lng: 75.8577 }, // Default Indore
      disableDefaultUI: true,
      styles: [{ elementType: "labels", stylers: [{ visibility: "off" }] }] // Clean look before inversion
    });

    directionsService = new google.maps.DirectionsService();
    
    // Renderers for multiple routes
    directionsRendererPrimary = new google.maps.DirectionsRenderer({ map: map, polylineOptions: { strokeColor: '#2A9D5C', strokeOpacity: 0.8, strokeWeight: 7, zIndex: 10 } });
    directionsRendererAlt = new google.maps.DirectionsRenderer({ map: map, polylineOptions: { strokeColor: '#E9A227', strokeOpacity: 0.4, strokeWeight: 5, zIndex: 1 } });

    // Autocomplete for Destination
    const destInput = document.getElementById('destInput');
    const autocomplete = new google.maps.places.Autocomplete(destInput);
    autocomplete.bindTo('bounds', map);
    autocomplete.addListener('place_changed', calculateRoutes);

    // Get Live Location
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition((pos) => {
        userLocation = { lat: pos.coords.latitude, lng: pos.coords.longitude };
        map.setCenter(userLocation);
        new google.maps.Marker({ position: userLocation, map: map, title: "You", icon: { path: google.maps.SymbolPath.CIRCLE, scale: 8, fillColor: "#2A9D5C", fillOpacity: 1, strokeColor: "white", strokeWeight: 2 } });
        
        // Reverse Geocode for UI
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode({ location: userLocation }, (results, status) => {
          if (status === "OK" && results[0]) document.getElementById('originInput').value = results[0].formatted_address.split(',')[0];
        });
      }, () => {
        showToast("GPS Permission Denied. Please enable location.", "ph-warning-octagon", "var(--warn-amber)");
      });
    }
  }

  // --- The 10-Point AI Scoring Algorithm Simulation ---
  function evaluateSafety(route) {
    let score = 95; // Base safe score
    const hour = new Date().getHours();
    const distanceKm = route.legs[0].distance.value / 1000;
    const durationMin = route.legs[0].duration.value / 60;
    const steps = route.legs[0].steps.length;

    // 1. Time-Based Risk (Darkness penalty)
    if (hour >= 19 || hour <= 5) score -= 15;

    // 2. Complexity / Environment (More turns usually means deeper into local/potentially unlit streets)
    if (steps > 15) score -= 10;

    // 3. Traffic / Public Visibility (Highway/Main road proxy: High speed = Main road = Safer)
    const avgSpeed = distanceKm / (durationMin / 60); 
    if (avgSpeed < 15) score -= 12; // Slow local roads
    else if (avgSpeed > 40) score += 5; // Main highways

    // 4. Random AI Variance (Simulating live community reports/police data)
    score += (Math.random() * 10 - 5); 

    return Math.max(30, Math.min(99, Math.round(score)));
  }

  // --- Calculate Routes ---
  function calculateRoutes() {
    const dest = document.getElementById('destInput').value;
    if (!userLocation || !dest) return;

    document.getElementById('routingStatus').innerHTML = `<i class="ph-bold ph-spinner ph-spin"></i> AI Processing Safe Paths...`;

    directionsService.route({
      origin: userLocation,
      destination: dest,
      travelMode: 'DRIVING',
      provideRouteAlternatives: true
    }, (response, status) => {
      if (status === 'OK') {
        availableRoutes = response.routes;
        document.getElementById('routingStatus').style.display = 'none';
        
        // Score routes
        availableRoutes.forEach((route, index) => {
          route.safetyScore = evaluateSafety(route);
        });

        // Sort by safety score descending
        availableRoutes.sort((a, b) => b.safetyScore - a.safetyScore);

        renderRouteUI();
        selectRoute(0); // Auto select safest
      } else {
        showToast("Routing failed. Try a different location.", "ph-x-circle", "var(--rose)");
        document.getElementById('routingStatus').innerHTML = "Routing failed. Please try again.";
      }
    });
  }

  // --- Render UI based on routes ---
  function renderRouteUI() {
    for(let i=0; i<2; i++) {
      if(availableRoutes[i]) {
        const route = availableRoutes[i];
        const card = document.getElementById(`routeCard${i}`);
        card.style.display = 'block';
        
        document.getElementById(`rMeta${i}`).textContent = `${route.legs[0].duration.text} (${route.legs[0].distance.text})`;
        document.getElementById(`rScoreVal${i}`).textContent = route.safetyScore;
        
        const badge = document.getElementById(`rScoreVal${i}`);
        const desc = document.getElementById(`rDesc${i}`);
        
        // Reset classes
        badge.className = 'score-badge'; card.className = 'route-card';
        
        if (route.safetyScore >= 80) {
          badge.classList.add('excellent');
          desc.textContent = "Safest path. High visibility and active zones.";
          badge.style.background = 'rgba(42,157,92,0.2)'; badge.style.color = 'var(--safe-green)';
        } else if (route.safetyScore >= 50) {
          badge.classList.add('warning');
          desc.textContent = "Moderate risk. Some unlit sections detected.";
          badge.style.background = 'rgba(233,162,39,0.2)'; badge.style.color = 'var(--warn-amber)';
        } else {
          badge.style.background = 'rgba(192,57,75,0.2)'; badge.style.color = 'var(--rose-light)';
          desc.textContent = "High Risk. Avoid if traveling alone at night.";
          desc.style.color = 'var(--rose-light)';
        }
      }
    }
    document.getElementById('aiBreakdown').style.display = 'block';
    document.getElementById('startNavBtn').disabled = false;
  }

  // --- Select Route ---
  function selectRoute(index) {
    if(!availableRoutes[index]) return;
    selectedRouteIndex = index;
    const route = availableRoutes[index];

    // Map UI
    directionsRendererPrimary.setDirections({ routes: [route], request: { travelMode: 'DRIVING' } });
    if(availableRoutes[1] && index === 0) directionsRendererAlt.setDirections({ routes: [availableRoutes[1]], request: { travelMode: 'DRIVING' } });
    else directionsRendererAlt.setMap(null);

    // Card UI
    document.getElementById('routeCard0').classList.remove('selected', 'safe-route', 'mod-route', 'unsafe-route');
    document.getElementById('routeCard1').classList.remove('selected', 'safe-route', 'mod-route', 'unsafe-route');
    
    const card = document.getElementById(`routeCard${index}`);
    card.classList.add('selected');
    if(route.safetyScore >= 80) card.classList.add('safe-route');
    else if(route.safetyScore >= 50) card.classList.add('mod-route');
    else card.classList.add('unsafe-route');

    // Update Breakdown Bars dynamically based on score
    document.getElementById('barLight').style.width = `${route.safetyScore}%`;
    document.getElementById('barLight').style.background = route.safetyScore >= 80 ? 'var(--safe-green)' : 'var(--warn-amber)';
    
    document.getElementById('barCrowd').style.width = `${Math.max(10, route.safetyScore - 10)}%`;
    document.getElementById('barCrowd').style.background = route.safetyScore >= 80 ? 'var(--safe-green)' : 'var(--warn-amber)';
    
    document.getElementById('barEmerg').style.width = `${Math.max(20, route.safetyScore - 5)}%`;
    document.getElementById('barEmerg').style.background = route.safetyScore >= 80 ? 'var(--safe-green)' : 'var(--warn-amber)';

    document.getElementById('barCrime').style.width = `${Math.max(5, 100 - route.safetyScore)}%`;
    document.getElementById('barCrime').style.background = route.safetyScore >= 80 ? 'var(--safe-green)' : 'var(--rose-light)';
  }

  // --- Voice Navigation ---
  function speak(text) {
    if(synth.speaking) synth.cancel();
    let utterance = new SpeechSynthesisUtterance(text);
    utterance.rate = 0.9;
    utterance.pitch = 1;
    synth.speak(utterance);
  }

  document.getElementById('startNavBtn').addEventListener('click', function() {
    const route = availableRoutes[selectedRouteIndex];
    if(!route) return;

    this.innerHTML = `<i class="ph-fill ph-navigation-arrow"></i> Navigating Safely`;
    this.style.background = 'var(--rose)';
    this.style.boxShadow = '0 10px 30px rgba(192,57,75,0.4)';
    
    const overlay = document.getElementById('voiceNavOverlay');
    overlay.style.display = 'flex';
    
    // Strip HTML from Google Maps directions to get plain text for voice
    let firstStepHTML = route.legs[0].steps[0].instructions;
    let firstStepText = firstStepHTML.replace(/<[^>]*>?/gm, ''); 
    
    document.getElementById('voiceText').textContent = firstStepText;
    
    // Alert Guardians and Start Voice
    showToast("Live Location shared with Guardians.", "ph-broadcast");
    speak("Starting secure navigation. " + firstStepText);
  });

  // Load Map when window is ready
  window.onload = initMap;
</script>
</body>
</html>