<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>SheSecure – SafeRoute AI | Women's Safety Navigation</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  :root {
    --rose: #C0394B;
    --rose-dark: #8B1A2A;
    --rose-light: #E8697A;
    --blush: #F2B8BC;
    --blush-soft: #FAE8EA;
    --cream: #FFF7F5;
    --charcoal: #1C1116;
    --muted: #6B4A52;
    --white: #FFFFFF;
    --safe-green: #2A9D5C;
    --warn-amber: #E9A227;
    --glass-bg: rgba(255, 255, 255, 0.7);
    --glass-border: rgba(255, 255, 255, 0.5);
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }

  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--charcoal);
    overflow-x: hidden;
    position: relative;
  }

  /* ─── PRELOADER ─── */
  #preloader {
    position: fixed; inset: 0; background: var(--charcoal); z-index: 99999;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    transition: opacity 0.8s var(--graceful), visibility 0.8s var(--graceful);
  }
  .loader-icon {
    font-size: 4rem; color: var(--rose-light); margin-bottom: 1.5rem;
    animation: pulse-loader 1.5s infinite alternate var(--graceful);
  }
  .loader-text {
    color: white; font-family: 'Playfair Display', serif; font-size: 1.5rem;
    letter-spacing: 0.15em; text-transform: uppercase;
  }
  @keyframes pulse-loader {
    0% { transform: scale(0.85); opacity: 0.6; filter: drop-shadow(0 0 0 transparent); }
    100% { transform: scale(1.15); opacity: 1; filter: drop-shadow(0 0 20px var(--rose)); }
  }
  .preloader-hidden { opacity: 0; visibility: hidden; }

  /* ─── AMBIENT BACKGROUND & PARTICLES ─── */
  .ambient-bg {
    position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
    z-index: -1; overflow: hidden; pointer-events: none; background: var(--cream);
  }
  .blob {
    position: absolute; border-radius: 50%; filter: blur(90px); opacity: 0.4;
    animation: float-blob 15s infinite alternate var(--graceful);
  }
  .blob-1 { top: -10%; left: -10%; width: 45vw; height: 45vw; background: var(--blush); }
  .blob-2 { bottom: -20%; right: -10%; width: 55vw; height: 55vw; background: rgba(192, 57, 75, 0.08); animation-delay: -5s; }
  .blob-3 { top: 30%; left: 50%; width: 35vw; height: 35vw; background: rgba(232, 105, 122, 0.12); animation-duration: 20s; }
  
  .particle {
    position: absolute; width: 6px; height: 6px; background: var(--rose-light);
    border-radius: 50%; opacity: 0.3; pointer-events: none;
    animation: drift 20s linear infinite;
  }

  @keyframes float-blob {
    0% { transform: translate(0, 0) scale(1) rotate(0deg); }
    100% { transform: translate(40px, -60px) scale(1.1) rotate(10deg); }
  }
  @keyframes drift {
    0% { transform: translateY(100vh) translateX(0); opacity: 0; }
    10% { opacity: 0.4; }
    90% { opacity: 0.4; }
    100% { transform: translateY(-10vh) translateX(100px); opacity: 0; }
  }

  /* ─── TOAST NOTIFICATION ─── */
  .toast {
    position: fixed; bottom: 2rem; right: 2rem;
    background: rgba(28, 17, 22, 0.95); color: white;
    padding: 1rem 1.8rem; border-radius: 50px;
    backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.3), 0 0 0 1px rgba(192,57,75,0.4);
    transform: translateY(100px); opacity: 0; transition: all 0.4s var(--graceful);
    z-index: 9999; display: flex; align-items: center; gap: 0.8rem;
    font-weight: 500; font-size: 0.95rem; 
  }
  .toast.show { transform: translateY(0); opacity: 1; }
  .toast i { color: var(--rose-light); font-size: 1.4rem; }

  /* ─── NAV ─── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 5rem; background: rgba(255, 247, 245, 0.8);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(192,57,75,0.05); transition: all 0.4s var(--graceful);
  }
  nav.scrolled { padding: 0.8rem 5rem; box-shadow: 0 10px 40px rgba(192, 57, 75, 0.05); background: rgba(255, 247, 245, 0.95); }
  .nav-logo {
    display: flex; align-items: center; gap: .6rem; font-family: 'Playfair Display', serif;
    font-size: 1.5rem; font-weight: 900; color: var(--charcoal); text-decoration: none;
  }
  .nav-logo span { color: var(--rose); }
  .logo-icon {
    width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark));
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white;
    box-shadow: 0 4px 15px rgba(192,57,75,0.3);
  }
  
  /* NEW NAV ACTIONS (LOGIN & SIGN UP) */
  .nav-actions { display: flex; gap: 1.5rem; align-items: center; }
  .btn-login { 
    text-decoration: none; font-size: 1rem; font-weight: 700; color: var(--charcoal); 
    transition: all .3s var(--graceful); position: relative; 
  }
  .btn-login::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -4px; left: 0; background: var(--rose); transition: width 0.3s var(--graceful); }
  .btn-login:hover { color: var(--rose); transform: translateY(-2px); }
  .btn-login:hover::after { width: 100%; }
  
  .btn-signup { 
    background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; border: none; 
    padding: .7rem 2rem; border-radius: 50px; font-size: 1rem; font-weight: 700; text-decoration: none; 
    transition: all .4s var(--graceful); display: flex; align-items: center; gap: 0.5rem; 
    box-shadow: 0 6px 20px rgba(192,57,75,0.25); border: 2px solid transparent;
  }
  .btn-signup:hover { 
    transform: translateY(-3px) scale(1.02); 
    box-shadow: 0 12px 30px rgba(192,57,75,.4); 
    border-color: rgba(255,255,255,0.5); 
  }

  /* ─── HERO ─── */
  #hero {
    min-height: 100vh; display: grid; grid-template-columns: 1fr 1fr; align-items: center; padding: 9rem 5rem 5rem; position: relative; overflow: hidden;
  }
  .hero-text { position: relative; z-index: 2; padding-right: 2rem; }
  .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: white; color: var(--rose-dark); padding: .5rem 1.2rem; border-radius: 50px; font-size: .85rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 2rem; border: 1px solid rgba(192,57,75,.1); box-shadow: 0 10px 30px rgba(192,57,75,0.05); }
  .hero-badge i { font-size: 1.2rem; color: var(--rose); animation: pulse-icon 2s infinite; }
  @keyframes pulse-icon { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }
  
  .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3.2rem, 5vw, 5.5rem); line-height: 1.05; font-weight: 900; color: var(--charcoal); margin-bottom: 1.5rem; }
  .hero-title em { color: var(--rose); font-style: italic; position: relative; display: inline-block; }
  .hero-title em::after { content: ''; position: absolute; bottom: 8px; left: 0; width: 100%; height: 8px; background: var(--blush); z-index: -1; opacity: 0.6; }
  
  .hero-subtitle { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-style: italic; color: var(--muted); margin-bottom: 2.5rem; line-height: 1.5; max-width: 500px; }
  .hero-btns { display: flex; gap: 1.2rem; flex-wrap: wrap; }
  .btn-primary { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; padding: 1.1rem 2.5rem; border-radius: 50px; font-size: 1.05rem; font-weight: 600; text-decoration: none; transition: all .4s var(--graceful); display: inline-flex; align-items: center; gap: .6rem; box-shadow: 0 10px 30px rgba(192,57,75,.3); }
  .btn-primary:hover { transform: translateY(-4px); box-shadow: 0 15px 40px rgba(192,57,75,.4); }
  .btn-secondary { background: rgba(255,255,255,0.9); color: var(--charcoal); border: 1px solid rgba(192,57,75,0.2); padding: 1.1rem 2.5rem; border-radius: 50px; font-size: 1.05rem; font-weight: 600; text-decoration: none; transition: all .4s var(--graceful); display: inline-flex; align-items: center; gap: .6rem; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
  .btn-secondary:hover { background: white; transform: translateY(-4px); border-color: var(--rose-light); color: var(--rose); }

  /* ─── BULLETPROOF FLOATING UI CARDS ─── */
  .floating-ui {
    position: absolute !important; background: #ffffff !important; border: 1px solid rgba(192,57,75,0.15) !important; border-radius: 16px !important; padding: 12px 20px !important; display: flex !important; flex-direction: row !important; align-items: center !important; gap: 15px !important; box-shadow: 0 20px 40px rgba(0,0,0,0.1) !important; z-index: 50 !important; width: max-content !important; min-width: 200px !important; animation: float-ui 6s ease-in-out infinite alternate;
  }
  .f-ui-1 { top: 15%; right: 5%; animation-delay: 0s; }
  .f-ui-2 { bottom: 15%; left: 0%; animation-delay: -3s; animation-duration: 8s; }
  .f-icon-box { width: 48px !important; height: 48px !important; border-radius: 12px !important; display: flex !important; align-items: center !important; justify-content: center !important; font-size: 24px !important; flex-shrink: 0 !important; }
  .f-ui-1 .f-icon-box { background: rgba(42, 157, 92, 0.15) !important; color: var(--safe-green) !important; }
  .f-ui-2 .f-icon-box { background: rgba(192, 57, 75, 0.15) !important; color: var(--rose) !important; }
  .f-text { display: flex !important; flex-direction: column !important; text-align: left !important; }
  .f-text h4 { font-family: 'DM Sans', sans-serif !important; font-size: 16px !important; color: var(--charcoal) !important; font-weight: 700 !important; margin: 0 0 2px 0 !important; line-height: 1.2 !important; }
  .f-text p { font-family: 'DM Sans', sans-serif !important; font-size: 13px !important; color: var(--muted) !important; font-weight: 500 !important; margin: 0 !important; line-height: 1.2 !important; }
  @keyframes float-ui { 0% { transform: translateY(0px) rotate(0deg); } 100% { transform: translateY(-15px) rotate(2deg); } }

  /* ─── RADAR SWEEP ANIMATION ─── */
  .hero-radar {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 450px; height: 450px; border-radius: 50%; border: 1px dashed rgba(192,57,75,0.3); z-index: 1; display: flex; align-items: center; justify-content: center;
  }
  .hero-radar::before {
    content: ''; position: absolute; width: 100%; height: 100%; border-radius: 50%; background: conic-gradient(from 0deg, transparent 70%, rgba(192,57,75,0.2) 100%); animation: spin-radar 4s linear infinite;
  }
  .hero-radar::after { content: ''; position: absolute; width: 300px; height: 300px; border-radius: 50%; border: 1px solid rgba(192,57,75,0.1); }
  @keyframes spin-radar { 100% { transform: rotate(360deg); } }

  /* ─── LIVE GOOGLE MAP PHONE MOCKUP ─── */
  .hero-visual { display: flex; justify-content: center; align-items: center; position: relative; z-index: 2; perspective: 1000px; }
  .phone-wrapper { position: relative; transform-style: preserve-3d; animation: float-phone 8s ease-in-out infinite; z-index: 5; }
  @keyframes float-phone { 0%,100% { transform: translateY(0) rotateX(4deg) rotateY(-4deg); } 50% { transform: translateY(-20px) rotateX(1deg) rotateY(-1deg); } }
  
  .phone-mockup { width: 310px; height: 620px; background: linear-gradient(160deg, #3d2a33 0%, #170d12 100%); border-radius: 55px; padding: 8px; box-shadow: 20px 40px 80px rgba(28,17,22,.3), 0 0 0 2px rgba(192,57,75,.3), inset 0 0 20px rgba(255,255,255,0.15); position: relative; }
  .phone-inner { background: linear-gradient(180deg, #1c1116 0%, #2d1520 100%); border-radius: 47px; height: 100%; overflow: hidden; display: flex; flex-direction: column; position: relative; }
  .phone-notch { position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 120px; height: 25px; background: #170d12; border-bottom-left-radius: 20px; border-bottom-right-radius: 20px; z-index: 20; }
  
  .phone-status { display: flex; justify-content: space-between; padding: 1.2rem 1.8rem .4rem; color: rgba(255,255,255,.9); font-size: .8rem; font-weight: 600; z-index: 21; position: relative;}
  .status-icons { display: flex; gap: 0.4rem; align-items: center; }
  .phone-header { display: flex; flex-direction: column; align-items: center; padding: 1rem 1.5rem 1rem; }
  .app-logo-phone { width: 70px; height: 70px; border-radius: 50%; background: radial-gradient(circle, rgba(192,57,75,.6) 0%, transparent 70%); border: 1px solid rgba(192,57,75,.8); display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 1rem; position: relative; color: white; box-shadow: 0 0 30px rgba(192,57,75,0.4);}
  .app-logo-phone::after { content: ''; position: absolute; inset: -15px; border-radius: 50%; border: 1px solid rgba(192,57,75,.4); animation: pulse-ring 2.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
  @keyframes pulse-ring { 0% { transform: scale(0.8); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; } }
  .phone-app-name { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; color: white; text-align: center; line-height: 1.1; }
  .phone-app-name small { display: block; font-size: .85rem; color: var(--rose-light); font-style: italic; font-weight: 400; margin-top: 0.3rem;}
  
  .phone-map-area { flex: 1; background: #1a0d14; margin: 0 .8rem; border-radius: 24px; position: relative; overflow: hidden; border: 1px solid rgba(255,255,255,0.08); }
  .map-loading-overlay { position: absolute; inset: 0; z-index: 5; background: linear-gradient(180deg, #2a1520 0%, #1a0d14 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.8s ease; }
  .map-loading-overlay i { font-size: 3rem; color: var(--rose); margin-bottom: 1.5rem; animation: pulse-icon 1.5s infinite alternate; }
  .map-loading-overlay span { color: rgba(255,255,255,0.9); font-size: 0.85rem; letter-spacing: 0.15em; font-weight: 600;}
  
  .gps-pulse-dot { position: absolute; top: 40%; left: 50%; transform: translate(-50%, -50%); width: 15px; height: 15px; background: var(--safe-green); border-radius: 50%; z-index: 8; opacity: 0; transition: opacity 0.5s; box-shadow: 0 0 15px var(--safe-green), inset 0 0 5px white; border: 2px solid white; }
  .gps-pulse-dot::before { content:''; position: absolute; inset: -20px; border-radius: 50%; border: 2px solid var(--safe-green); animation: pulse-gps 2s infinite; }
  @keyframes pulse-gps { 0% { transform: scale(0.5); opacity: 1; } 100% { transform: scale(2); opacity: 0; } }
  .live-gmap-iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: none; opacity: 0; transition: opacity 1s ease; pointer-events: none;}
  
  .safety-score-badge { position: absolute; bottom: 1.5rem; left: 50%; transform: translateX(-50%); background: rgba(20, 10, 15, 0.95); border: 1px solid rgba(42, 157, 92, 0.6); border-radius: 30px; padding: .6rem 1.5rem; display: flex; align-items: center; gap: 1rem; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); z-index: 10; box-shadow: 0 15px 30px rgba(0,0,0,0.6); width: max-content;}
  .score-num { font-size: 1.6rem; font-weight: 700; color: var(--safe-green); font-family: 'DM Sans', sans-serif; line-height: 1;}
  .score-label { font-size: .75rem; color: rgba(255,255,255,.9); font-weight: 700; letter-spacing: 0.05em; margin-top: 2px;}
  
  .phone-bottom { padding: 1.2rem 1.5rem 1.8rem; display: flex; justify-content: space-around; align-items: center; }
  .phone-icon { width: 50px; height: 50px; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--rose-light); background: rgba(192,57,75,.05); border: 1px solid rgba(192,57,75,.15); transition: all 0.3s; cursor: pointer; }
  .phone-icon:hover { background: rgba(192,57,75,.2); transform: translateY(-3px); color: white; border-color: var(--rose); }
  .sos-btn-phone { width: 65px; height: 65px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; box-shadow: 0 0 30px rgba(192,57,75,.6); animation: sos-pulse-soft 2s ease-in-out infinite; cursor: pointer; transition: transform 0.2s; border: 2px solid rgba(255,255,255,0.2); }
  .sos-btn-phone:active { transform: scale(0.92); }

  /* ─── PARTNERS LOGO BANNER (FIXED SPACING) ─── */
  .partners-banner { padding: 3rem 5rem; border-top: 1px solid rgba(192,57,75,0.05); border-bottom: 1px solid rgba(192,57,75,0.05); background: rgba(255,255,255,0.4); display: flex; flex-direction: column; align-items: center; gap: 1.5rem; position: relative; z-index: 2; margin-bottom: 6rem; /* FIX: Added gap below banner */ }
  .partners-title { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.15em; font-weight: 700; color: var(--muted); }
  .partners-logos { display: flex; gap: 4rem; flex-wrap: wrap; justify-content: center; align-items: center; opacity: 0.6; filter: grayscale(100%); transition: all 0.4s; }
  .partners-logos:hover { opacity: 1; filter: grayscale(0%); }
  .p-logo { font-size: 1.2rem; font-weight: 700; font-family: 'Playfair Display', serif; display: flex; align-items: center; gap: 0.5rem; color: var(--charcoal); }
  .p-logo i { font-size: 1.8rem; color: var(--rose); }

  /* ─── SECTIONS COMMON ─── */
  section { padding: 6rem 5rem; position: relative; z-index: 2; }
  .section-label { display: inline-flex; align-items: center; gap: .8rem; font-size: .85rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--rose); margin-bottom: 1.2rem; }
  .section-label::before { content: ''; width: 40px; height: 2px; background: var(--rose); }
  .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 4vw, 3.5rem); font-weight: 900; line-height: 1.15; color: var(--charcoal); margin-bottom: 1.5rem; }
  .section-title em { color: var(--rose); font-style: italic; }
  .section-sub { font-size: 1.15rem; color: var(--muted); max-width: 650px; line-height: 1.7; margin-bottom: 4rem; }

  /* ─── MISSION SECTION WITH REAL IMAGE ─── */
  #mission { background: white; border-radius: 40px; margin: 0 5rem; padding: 6rem; box-shadow: 0 20px 50px rgba(0,0,0,0.02); display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; }
  .mission-img-wrapper { position: relative; border-radius: 30px; overflow: hidden; box-shadow: 0 30px 60px rgba(192,57,75,0.15); }
  .mission-img-wrapper::before { content: ''; display: block; padding-top: 110%; } 
  .mission-img-wrapper img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; }
  .mission-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(28,17,22,0.95) 0%, rgba(192,57,75,0.1) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 2.5rem; color: white; }
  .mission-overlay h3 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 0.5rem; line-height: 1.1; }
  .mission-overlay p { font-size: 1rem; color: rgba(255,255,255,0.8); }
  
  .mission-content p { font-size: 1.1rem; line-height: 1.8; color: var(--muted); margin-bottom: 1.5rem; }
  .mission-list { list-style: none; margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem;}
  .mission-list li { display: flex; align-items: center; gap: 1rem; font-size: 1.05rem; font-weight: 600; color: var(--charcoal); }
  .mission-list i { color: var(--safe-green); font-size: 1.4rem; background: rgba(42, 157, 92, 0.1); padding: 0.5rem; border-radius: 50%; }

  /* ─── HIGHLIGHTED USP SECTION ─── */
  .usp-highlight {
    margin: 5rem 5rem; background: linear-gradient(135deg, #1c1116 0%, #3d0e1e 100%);
    border-radius: 40px; padding: 4rem; color: white; display: flex; align-items: center; gap: 4rem;
    box-shadow: 0 30px 60px rgba(192, 57, 75, 0.25); position: relative; overflow: hidden; z-index: 2;
  }
  .usp-highlight::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml;utf8,<svg width="20" height="20" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1" fill="rgba(255,255,255,0.05)"/></svg>'); opacity: 0.5; pointer-events: none;}
  .usp-highlight::after {
    content: ''; position: absolute; top: -50%; right: -10%; width: 60%; height: 200%;
    background: radial-gradient(circle, rgba(232,105,122,0.2) 0%, transparent 60%); pointer-events: none;
  }
  .usp-icon-container {
    width: 120px; height: 120px; border-radius: 50%; background: rgba(255,255,255,0.05);
    display: flex; align-items: center; justify-content: center; font-size: 4rem;
    color: var(--rose-light); border: 2px dashed rgba(232,105,122,0.4); flex-shrink: 0;
    animation: spin-slow 20s linear infinite; position: relative; z-index: 2;
    backdrop-filter: blur(5px);
  }
  .usp-icon-container i { animation: counter-spin 20s linear infinite; }
  
  .usp-content { position: relative; z-index: 2; }
  .usp-content h2 { font-family: 'Playfair Display', serif; font-size: 2.8rem; margin-bottom: 1.2rem; color: white; line-height: 1.1; }
  .usp-content h2 em { color: var(--blush); font-style: italic; }
  .usp-content p { font-size: 1.15rem; line-height: 1.7; color: rgba(255,255,255,0.8); font-weight: 300; }
  .usp-content strong { color: white; font-weight: 600; background: rgba(192,57,75,0.4); padding: 0.2rem 0.6rem; border-radius: 6px; }

  /* ─── FEATURES GRID ─── */
  #features { background: transparent; }
  /* GRID CHANGED TO 3 COLUMNS FOR 9 ITEMS (Perfect Symmetry) */
  .features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2.5rem; } 
  .feature-card { background: rgba(255,255,255,0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-radius: 30px; padding: 2.5rem; border: 1px solid rgba(255,255,255,0.8); transition: all .4s var(--graceful); position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03); display: flex; flex-direction: column; }
  .feature-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 6px; background: linear-gradient(90deg, var(--rose), var(--rose-light)); opacity: 0; transition: opacity .4s ease; }
  .feature-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(192,57,75,.1); border-color: rgba(192,57,75,.2); background: white;}
  .feature-card:hover::before { opacity: 1; }
  .feature-card h3 { font-size: 1.2rem; font-weight: 700; margin-bottom: 0.8rem; color: var(--charcoal); }
  .feature-card p { font-size: 0.95rem; color: var(--muted); line-height: 1.6; }

  /* ========================================= */
  /* ─── CUSTOM CSS FEATURE ANIMATIONS ─────── */
  /* ========================================= */
  .feat-anim-box {
    width: 100%; height: 110px; border-radius: 20px; background: linear-gradient(135deg, var(--blush-soft), var(--cream));
    border: 1px solid rgba(192,57,75,0.1); margin-bottom: 1.5rem; position: relative; overflow: hidden;
    display: flex; align-items: center; justify-content: center;
  }

  /* 1. Encrypted Path Anim */
  .anim-encrypt { display: flex; align-items: center; width: 80%; position: relative; justify-content: space-between; }
  .anim-encrypt .dot-start, .anim-encrypt .dot-end { width: 14px; height: 14px; background: var(--rose-dark); border-radius: 50%; z-index: 2; box-shadow: 0 0 10px var(--rose-dark);}
  .anim-encrypt .line { position: absolute; top: 50%; left: 0; width: 100%; height: 2px; border-top: 2px dashed rgba(192,57,75,0.3); transform: translateY(-50%); z-index: 1;}
  .anim-encrypt .packet { position: absolute; top: 50%; left: 0; transform: translateY(-50%); background: var(--safe-green); color: white; padding: 6px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; z-index: 3; animation: sendPacket 3s ease-in-out infinite; box-shadow: 0 0 15px rgba(42, 157, 92, 0.8); }
  @keyframes sendPacket { 0% { left: 0; opacity: 0; } 15% { opacity: 1; } 85% { opacity: 1; } 100% { left: 85%; opacity: 0; } }

  /* 2. Instant SOS Anim */
  .anim-sos { position: relative; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
  .anim-sos .sos-btn-mini { width: 45px; height: 45px; background: var(--rose); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.2rem; font-weight:bold; z-index: 2; position: absolute; left: 20px; animation: buttonPress 4s infinite; }
  .anim-sos .hand-cursor { position: absolute; left: 35px; top: 60px; font-size: 2.2rem; color: var(--charcoal); z-index: 4; animation: handTap 4s infinite; }
  .anim-sos .signal-waves { position: absolute; left: 45px; top: 50%; transform: translateY(-50%); border-top: 3px dotted var(--rose); width: 0; height: 0; animation: sendSignal 4s infinite; z-index: 1;}
  .anim-sos .police-station { position: absolute; right: 20px; font-size: 2.5rem; color: #1E3A8A; z-index: 2; animation: policeAlert 4s infinite; }
  @keyframes handTap { 0%, 10% { transform: translateY(0); opacity: 0; } 20% { transform: translateY(-20px); opacity: 1; } 30% { transform: translateY(-15px) scale(0.9); } 40%, 100% { transform: translateY(30px); opacity: 0; } }
  @keyframes buttonPress { 0%, 25% { transform: scale(1); box-shadow: none; } 30% { transform: scale(0.85); box-shadow: 0 0 25px var(--rose); } 35%, 100% { transform: scale(1); } }
  @keyframes sendSignal { 0%, 30% { width: 0; opacity: 0; } 35% { opacity: 1; } 55% { width: 80px; opacity: 0; } 100% { width: 80px; opacity: 0; } }
  @keyframes policeAlert { 0%, 45% { color: #1E3A8A; filter: drop-shadow(0 0 0 transparent); } 50%, 80% { color: var(--rose); filter: drop-shadow(0 0 15px var(--rose)); transform: scale(1.1); } 100% { color: #1E3A8A; filter: drop-shadow(0 0 0 transparent); transform: scale(1); } }

  /* 3. Guardian Control Anim */
  .anim-guardian { position: relative; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; }
  .anim-guardian .user-node { font-size: 2.2rem; color: var(--rose); z-index: 3; position: relative; }
  .anim-guardian .user-node::after { content:''; position: absolute; inset: -12px; border-radius: 50%; border: 2px solid var(--rose); animation: pulse-ring 2s infinite; }
  .anim-guardian .guardian-node { position: absolute; font-size: 1.8rem; color: var(--safe-green); z-index: 2; }
  .anim-guardian .g1 { top: 10px; left: 20px; }
  .anim-guardian .g2 { bottom: 10px; right: 20px; }
  .anim-guardian .data-dot { position: absolute; width: 8px; height: 8px; background: var(--rose-dark); border-radius: 50%; z-index: 1; opacity: 0; box-shadow: 0 0 10px var(--rose);}
  .anim-guardian .d1 { animation: trackG1 3s infinite; }
  .anim-guardian .d2 { animation: trackG2 3s infinite; animation-delay: 1.5s; }
  @keyframes trackG1 { 0% { top: 50%; left: 50%; opacity: 1; transform: scale(1); } 100% { top: 20px; left: 30px; opacity: 0; transform: scale(1.5); } }
  @keyframes trackG2 { 0% { top: 50%; left: 50%; opacity: 1; transform: scale(1); } 100% { top: 75px; left: calc(100% - 30px); opacity: 0; transform: scale(1.5); } }

  /* 4. Community Reporting Anim */
  .anim-report { position: relative; width: 100%; height: 100%; background: #1a1a2e; overflow: hidden;}
  .anim-report .street-beam { position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: radial-gradient(circle at center, rgba(255,255,255,0.4) 0%, transparent 40%); animation: searchBeam 4s infinite alternate ease-in-out; }
  .anim-report .danger-icon { position: absolute; bottom: 15px; right: 30px; color: var(--warn-amber); font-size: 1.8rem; opacity: 0; animation: spotDanger 8s infinite; filter: drop-shadow(0 0 10px var(--warn-amber)); }
  .anim-report .drop-pin { position: absolute; bottom: 35px; right: 30px; color: var(--rose); font-size: 2.5rem; opacity: 0; animation: dropPin 8s infinite; filter: drop-shadow(0 5px 5px rgba(0,0,0,0.8));}
  @keyframes searchBeam { 0% { transform: translateX(-30%); } 100% { transform: translateX(30%); } }
  @keyframes spotDanger { 0%, 35% { opacity: 0; } 40%, 90% { opacity: 1; } 100% { opacity: 0; } }
  @keyframes dropPin { 0%, 45% { transform: translateY(-50px); opacity: 0; } 50% { transform: translateY(0); opacity: 1; } 55% { transform: translateY(-10px); opacity: 1; } 60%, 90% { transform: translateY(0); opacity: 1; } 100% { opacity: 0; } }

  /* 5. Voice Trigger Anim */
  .anim-voice { display: flex; align-items: center; justify-content: center; gap: 20px; }
  .anim-voice .mic { font-size: 3rem; color: var(--charcoal); position: relative; animation: micListen 3s infinite;}
  .anim-voice .bars { display: flex; gap: 5px; align-items: center; height: 50px; }
  .anim-voice .bar { width: 8px; background: var(--rose); border-radius: 10px; animation: equalize 1s infinite ease-in-out alternate; }
  .anim-voice .bar:nth-child(1) { height: 15px; animation-delay: 0.1s; }
  .anim-voice .bar:nth-child(2) { height: 45px; animation-delay: 0.3s; }
  .anim-voice .bar:nth-child(3) { height: 25px; animation-delay: 0.2s; }
  .anim-voice .bar:nth-child(4) { height: 40px; animation-delay: 0.4s; }
  @keyframes equalize { 0% { transform: scaleY(0.3); background: var(--rose-light); } 100% { transform: scaleY(1); background: var(--rose-dark); } }
  @keyframes micListen { 0%, 100% { color: var(--charcoal); filter: drop-shadow(0 0 0 transparent);} 50% { color: var(--rose); filter: drop-shadow(0 0 15px rgba(192,57,75,0.6)); transform: scale(1.1);} }

  /* 6. Simulated Fake Call Anim */
  .anim-phone { position: relative; display: flex; align-items: center; justify-content: center; }
  .anim-phone .phone-icon { font-size: 3.5rem; color: var(--charcoal); animation: ringVibrate 2.5s infinite; }
  .anim-phone .btn-ans, .anim-phone .btn-dec { position: absolute; width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.9rem; opacity: 0; animation: showBtns 4s infinite; }
  .anim-phone .btn-ans { background: var(--safe-green); bottom: -15px; left: -30px; box-shadow: 0 0 15px rgba(42,157,92,0.6); }
  .anim-phone .btn-dec { background: var(--rose); bottom: -15px; right: -30px; box-shadow: 0 0 15px rgba(192,57,75,0.6); }
  @keyframes ringVibrate { 0%, 10%, 20%, 30%, 40%, 50% { transform: rotate(0deg); } 5%, 15%, 25%, 35%, 45% { transform: rotate(-15deg) scale(1.15); color: var(--safe-green); } 10%, 20%, 30%, 40% { transform: rotate(15deg) scale(1.15); color: var(--safe-green); } 55%, 100% { transform: rotate(0deg); color: var(--charcoal);} }
  @keyframes showBtns { 0%, 5% { opacity: 0; transform: translateY(15px); } 10%, 50% { opacity: 1; transform: translateY(0); } 55%, 100% { opacity: 0; transform: translateY(15px); } }

  /* 7. Wearable Sync Anim */
  .anim-watch { position: relative; display: flex; align-items: center; justify-content: center; }
  .anim-watch .watch-icon { font-size: 4rem; color: var(--charcoal); z-index: 2; }
  .anim-watch .sos-ping { position: absolute; width: 100%; height: 100%; border-radius: 50%; border: 3px solid var(--rose); z-index: 1; animation: watchPing 2s infinite ease-out; }
  @keyframes watchPing { 0% { transform: scale(0.3); opacity: 1; } 100% { transform: scale(1.5); opacity: 0; border-width: 0px; } }

  /* 8. Offline Mode Anim */
  .anim-offline { position: relative; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 5px;}
  .anim-offline .sat-icon { font-size: 2rem; color: var(--muted); animation: floatSat 3s infinite alternate ease-in-out; }
  .anim-offline .beam { width: 4px; height: 25px; background: linear-gradient(to bottom, var(--safe-green), transparent); animation: beamDown 2s infinite linear; }
  .anim-offline .map-icon { font-size: 2rem; color: var(--safe-green); }
  @keyframes floatSat { 0% { transform: translateX(-10px) rotate(-10deg); } 100% { transform: translateX(10px) rotate(10deg); } }
  @keyframes beamDown { 0% { transform: translateY(-10px); opacity: 0; } 50% { opacity: 1; } 100% { transform: translateY(10px); opacity: 0; } }

  /* 9. NEW: AR Safe Path Anim */
  .anim-ar { position: relative; display: flex; align-items: center; justify-content: center; width: 100%; height: 100%; }
  .anim-ar .ar-cam { font-size: 2.5rem; color: var(--charcoal); z-index: 2; animation: camHover 3s infinite ease-in-out; }
  .anim-ar .ar-scan { position: absolute; width: 60px; height: 3px; background: var(--safe-green); z-index: 3; box-shadow: 0 0 10px var(--safe-green); animation: scanLine 2s infinite linear; }
  .anim-ar .ar-path { position: absolute; bottom: 10px; width: 40px; height: 40px; border-left: 3px dashed var(--rose); border-bottom: 3px dashed var(--rose); transform: rotate(-45deg) perspective(100px) rotateX(45deg); opacity: 0.5; animation: pathGlow 2s infinite; }
  @keyframes camHover { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-5px); } }
  @keyframes scanLine { 0% { top: 20%; opacity: 0; } 10% { opacity: 1; } 90% { opacity: 1; } 100% { top: 80%; opacity: 0; } }
  @keyframes pathGlow { 0%, 100% { border-color: rgba(192,57,75,0.3); } 50% { border-color: rgba(192,57,75,1); } }

  /* ─── SOS INTERACTIVE MODULE (DEMO SEQUENCE ENHANCED) ─── */
  #sos { background: linear-gradient(135deg, #1c1116 0%, #3d0e1e 100%); color: white; border-radius: 40px; margin: 4rem 5rem; padding: 7rem 5rem; box-shadow: 0 30px 60px rgba(0,0,0,0.3); transition: all 0.5s ease;}
  .police-flash { animation: policeFlash 1s infinite; }
  @keyframes policeFlash { 
    0%, 100% { box-shadow: 0 30px 60px rgba(0,0,0,0.3); } 
    25% { box-shadow: 0 30px 60px rgba(220, 38, 38, 0.4), inset 0 0 80px rgba(220, 38, 38, 0.2); } 
    75% { box-shadow: 0 30px 60px rgba(37, 99, 235, 0.4), inset 0 0 80px rgba(37, 99, 235, 0.2); } 
  }

  #sos .section-title { color: white; }
  #sos .section-sub { color: rgba(255,255,255,.7); }
  .sos-layout { display: grid; grid-template-columns: 1.2fr 1fr; gap: 6rem; align-items: center; }
  
  .sos-flow { display: flex; flex-direction: column; gap: 2rem; }
  .sos-step { display: flex; align-items: flex-start; gap: 1.5rem; background: rgba(255,255,255,.04); border: 1px solid rgba(255,255,255,.08); border-radius: 24px; padding: 2rem; transition: all .4s var(--graceful); backdrop-filter: blur(10px); position: relative; }
  .sos-step:hover { border-color: rgba(232,105,122,.6); background: rgba(232,105,122,.08); transform: translateX(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
  
  /* SOS Sequential Active State */
  .sos-step.active-step { border-color: var(--rose-light); background: rgba(232,105,122,0.15); transform: scale(1.05) translateX(10px); box-shadow: 0 15px 35px rgba(192,57,75,0.3); z-index: 10; }
  
  .sos-step-num { width: 45px; height: 45px; border-radius: 50%; background: var(--rose); color: white; font-weight: 700; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 1.2rem; box-shadow: 0 0 20px rgba(192,57,75,0.5);}
  .sos-step.active-step .sos-step-num { background: white; color: var(--rose); box-shadow: 0 0 30px rgba(255,255,255,0.8); }

  .sos-step-text h4 { color: white; font-size: 1.2rem; margin-bottom: .6rem; }
  .sos-step-text p { color: rgba(255,255,255,.7); font-size: 1rem; line-height: 1.6; }
  
  .sos-visual { display: flex; flex-direction: column; align-items: center; justify-content: center; }
  .sos-interactive-container { position: relative; width: 350px; max-width: 100%; height: 350px; display: flex; align-items: center; justify-content: center; margin: 0 auto; }
  .sos-ring { position: absolute; inset: 0; border-radius: 50%; border: 2px dashed rgba(232,105,122,0.4); animation: spin-slow 15s linear infinite; }
  .sos-ring::before { content:''; position: absolute; inset: 20px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.1); }
  
  .sos-btn-interactive { 
    width: 180px; height: 180px; border-radius: 50%; 
    background: linear-gradient(135deg, #1c1116, #2d1520); 
    border: 4px solid var(--rose); display: flex; flex-direction: column; 
    align-items: center; justify-content: center; cursor: pointer; 
    position: relative; overflow: hidden; box-shadow: 0 0 40px rgba(192,57,75,.4), inset 0 0 20px rgba(192,57,75,0.2); 
    transition: transform 0.2s, box-shadow 0.2s; z-index: 10; 
    user-select: none; -webkit-tap-highlight-color: transparent; 
    touch-action: none; -webkit-touch-callout: none;
  }
  .sos-btn-interactive:hover { box-shadow: 0 0 60px rgba(192,57,75,.6), inset 0 0 30px rgba(192,57,75,0.4); transform: scale(1.02);}
  .sos-btn-interactive:active { transform: scale(0.95); }
  
  .sos-fill { position: absolute; bottom: 0; left: 0; width: 100%; height: 0%; background: var(--rose); z-index: 1; transition: height 0.1s linear; }
  .sos-btn-content { position: relative; z-index: 2; display: flex; flex-direction: column; align-items: center; pointer-events: none;}
  .sos-btn-content i { font-size: 3rem; color: white; margin-bottom: 0.5rem; }
  .sos-btn-content span { font-weight: 900; font-size: 1.8rem; color: white; letter-spacing: .1em; line-height: 1;}
  .sos-btn-content small { font-size: .75rem; color: rgba(255,255,255,.8); font-weight: 500; margin-top: .6rem; text-transform: uppercase; letter-spacing: 0.15em;}
  .sos-status-text { margin-top: 3rem; font-size: 1.1rem; color: var(--blush); font-weight: 600; min-height: 28px; letter-spacing: 0.05em; text-align: center;}

  /* ─── TESTIMONIALS ─── */
  #testimonials { background: var(--cream); position: relative; text-align: center; }
  .test-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-top: 3rem; text-align: left; }
  .test-card { background: white; border-radius: 24px; padding: 2.5rem; border: 1px solid rgba(192,57,75,.05); box-shadow: 0 10px 30px rgba(0,0,0,0.02); transition: all 0.4s var(--graceful); }
  .test-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(192,57,75,.08); }
  .stars { color: var(--warn-amber); font-size: 1.2rem; margin-bottom: 1.5rem; display: flex; gap: 0.2rem; }
  .test-text { font-size: 1.05rem; color: var(--charcoal); font-style: italic; line-height: 1.6; margin-bottom: 2rem; }
  .test-user { display: flex; align-items: center; gap: 1rem; border-top: 1px solid rgba(0,0,0,0.05); padding-top: 1.5rem;}
  .user-avatar { width: 45px; height: 45px; border-radius: 50%; background: var(--blush-soft); color: var(--rose-dark); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.2rem; }
  .user-info h5 { font-size: 1rem; color: var(--charcoal); margin-bottom: 0.2rem; }
  .user-info span { font-size: 0.85rem; color: var(--muted); }

  /* ─── FOOTER ─── */
  footer { background: #110A0D; padding: 5rem 5rem 3rem; display: flex; flex-direction: column; gap: 4rem; position: relative; z-index: 5; }
  .footer-top { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 4rem; }
  .footer-brand-col { max-width: 380px; }
  .footer-brand { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 900; color: white; display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.2rem;}
  .footer-brand span { color: var(--rose-light); }
  .footer-tagline { font-size: 1rem; color: rgba(255,255,255,.6); line-height: 1.7; margin-bottom: 2rem;}
  .social-links { display: flex; gap: 1rem; }
  .social-links a { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.05); color: white; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; transition: all 0.3s; text-decoration: none;}
  .social-links a:hover { background: var(--rose); transform: translateY(-3px); }
  
  .footer-links-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 5rem; }
  .footer-col h4 { color: white; font-size: 1.15rem; margin-bottom: 1.5rem; font-family: 'Playfair Display', serif; letter-spacing: 0.05em; }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 1rem; }
  .footer-col a { color: rgba(255,255,255,.6); font-size: 0.95rem; text-decoration: none; transition: color .3s; font-weight: 500; }
  .footer-col a:hover { color: var(--rose-light); }
  
  .footer-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem; flex-wrap: wrap; gap: 1rem; }
  .footer-copy { font-size: 0.9rem; color: rgba(255,255,255,.4); }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 1400px) { 
    /* Features grid adjusts dynamically based on screen size, currently standard is 3x3 */
  }
  @media (max-width: 1200px) { #hero { padding: 9rem 3rem 4rem; } .f-ui-1 { right: 0; } .usp-highlight { flex-direction: column; text-align: center; gap: 2rem; } }
  @media (max-width: 1024px) {
    #hero { grid-template-columns: 1fr; text-align: center; gap: 4rem; }
    .hero-text { padding-right: 0; }
    .hero-subtitle, .hero-btns { justify-content: center; margin-left: auto; margin-right: auto; }
    .floating-ui { display: none !important; }
    .sos-layout, .footer-top, #mission { grid-template-columns: 1fr; }
    #mission { margin: 2rem; padding: 4rem 3rem; text-align: center; }
    .mission-list { align-items: center; }
    #sos { margin: 2rem; padding: 5rem 3rem; }
    .test-grid { grid-template-columns: repeat(2, 1fr); }
    .features-grid { grid-template-columns: repeat(2, 1fr); } /* 2 columns on tablet */
  }
  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; } /* Hide auth buttons on small mobile for space if needed */
    section { padding: 4rem 1.5rem; }
    .features-grid, .footer-links-grid, .test-grid { grid-template-columns: 1fr; gap: 2rem; }
    .usp-highlight { margin: 2rem 1.5rem; padding: 3rem 2rem; }
    #sos { margin: 2rem 1.5rem; padding: 4rem 1.5rem; }
    .sos-interactive-container { width: 300px; height: 300px; }
    .sos-btn-interactive { width: 160px; height: 160px; }
    footer { padding: 4rem 1.5rem 2rem; }
    .footer-bottom { flex-direction: column; text-align: center; justify-content: center;}
    .footer-bottom .footer-copy { text-align: center !important; }
  }
  
  .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s var(--graceful), transform 0.8s var(--graceful); }
  .reveal.visible { opacity: 1; transform: translateY(0); }
</style>
</head>
<body>

<!-- PRELOADER -->
<div id="preloader">
  <i class="ph-fill ph-shield-check loader-icon"></i>
  <div class="loader-text">Securing Your Path...</div>
</div>

<!-- AMBIENT BACKGROUND & PARTICLES -->
<div class="ambient-bg">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>
  <div id="particles-container"></div>
</div>

<div id="toast" class="toast"></div>

<!-- NAVIGATION -->
<nav id="navbar">
  <a class="nav-logo" href="index.php">
    <div class="logo-icon"><i class="ph-fill ph-gender-female"></i></div>
    She<span>Secure</span>
  </a>
  
  <!-- REPLACED LINKS WITH LOGIN & SIGNUP -->
  <div class="nav-actions">
    <a href="login.php" class="btn-login">Login</a>
    <a href="signup.php" class="btn-signup">Sign Up <i class="ph-bold ph-arrow-right"></i></a>
  </div>
</nav>

<!-- HERO SECTION -->
<section id="hero">
  <div class="hero-text reveal">
    <div class="hero-badge"><i class="ph-fill ph-check-circle"></i> Over 500,000 Safe Journeys Navigated</div>
    <h1 class="hero-title">
      Navigate Every<br>Street with <em>Confidence</em>
    </h1>
    <p class="hero-subtitle">
      AI-powered route safety offering real-time risk scores, instant SOS, and end-to-end encrypted tracking to keep you completely secure.
    </p>
    <div class="hero-btns">
      <a href="#features" class="btn-primary"><i class="ph-bold ph-sparkle"></i> Explore Platform</a>
      <button onclick="document.getElementById('sos').scrollIntoView({behavior:'smooth'})" class="btn-secondary"><i class="ph-bold ph-siren"></i> SOS Demo</button>
    </div>
  </div>

  <div class="hero-visual reveal">
    <div class="floating-ui f-ui-1">
      <div class="f-icon-box"><i class="ph-fill ph-shield-check"></i></div>
      <div class="f-text">
        <h4>Route Secured</h4>
        <p>End-to-End Encrypted</p>
      </div>
    </div>
    <div class="floating-ui f-ui-2">
      <div class="f-icon-box"><i class="ph-fill ph-bell-ringing"></i></div>
      <div class="f-text">
        <h4>Live Alert</h4>
        <p>Police notified instantly.</p>
      </div>
    </div>

    <!-- RADAR BACKGROUND -->
    <div class="hero-radar"></div>

    <div class="phone-wrapper">
      <div class="phone-mockup">
        <div class="phone-inner">
          <div class="phone-notch"></div>
          <div class="phone-status">
            <span id="phone-time">5:15</span>
            <div class="status-icons">
              <i class="ph-fill ph-cell-signal-full"></i>
              <i class="ph-fill ph-wifi-high"></i>
              <i class="ph-fill ph-battery-full"></i>
            </div>
          </div>
          <div class="phone-header">
            <div class="app-logo-phone"><i class="ph-fill ph-gender-female"></i></div>
            <div class="phone-app-name">
              SheSecure
              <small>SafeRoute AI</small>
            </div>
          </div>
          
          <div class="phone-map-area">
            <div class="map-loading-overlay" id="map-loader">
              <i class="ph-fill ph-crosshair"></i>
              <span>ACQUIRING GPS...</span>
            </div>
            
            <iframe 
              id="gmap-live" 
              class="live-gmap-iframe" 
              allowfullscreen>
            </iframe>

            <div class="gps-pulse-dot" id="gps-dot"></div>
            
            <div class="safety-score-badge" id="live-score-badge">
              <i class="ph-fill ph-shield-warning" style="color:var(--warn-amber); font-size: 1.2rem;"></i>
              <div>
                <div class="score-num" style="color:var(--warn-amber)">--</div>
                <div class="score-label">LOCATING YOU</div>
              </div>
            </div>
          </div>
          
          <div class="phone-bottom">
            <div class="phone-icon" onclick="locateUser()"><i class="ph ph-crosshair"></i></div>
            <div class="sos-btn-phone" onclick="document.getElementById('sos').scrollIntoView({behavior:'smooth'})"><i class="ph-fill ph-siren"></i></div>
            <div class="phone-icon" onclick="showToast('Loading Encrypted Path...', 'ph-lock-key')"><i class="ph ph-shield-check"></i></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PARTNERS BANNER -->
<div class="partners-banner reveal">
  <div class="partners-title">Trusted By Authorities & Communities</div>
  <div class="partners-logos">
    <div class="p-logo"><i class="ph-fill ph-police-car"></i> City Police Dept</div>
    <div class="p-logo"><i class="ph-fill ph-buildings"></i> Smart City Initiative</div>
    <div class="p-logo"><i class="ph-fill ph-heart"></i> Women's NGO Alliance</div>
    <div class="p-logo"><i class="ph-fill ph-shield-star"></i> Global Safety Council</div>
  </div>
</div>

<!-- MISSION SECTION -->
<section id="mission">
  <div class="mission-img-wrapper reveal">
    <img src="Images/Building a World Without Fear.png" alt="Safe City Night Navigation" />
    <div class="mission-overlay">
      <h3>Building a World Without Fear</h3>
      <!-- <p>Using technology to reclaim the night.</p> -->
    </div>
  </div>
  <div class="mission-content reveal">
    <div class="section-label">Our Mission</div>
    <h2 class="section-title">Safety is a fundamental right, <em>not a privilege.</em></h2>
    <p>Current mapping applications are built for cars, finding the fastest or shortest route. They completely ignore the reality of navigating cities as a vulnerable individual.</p>
    <p><strong>SheSecure</strong> was born out of necessity. We combine advanced machine learning with real-time community reports to evaluate the safety of a street—accounting for lighting, crime data, and crowd density—ensuring you always walk the safest path possible.</p>
    <ul class="mission-list">
      <li><i class="ph-bold ph-check"></i> Designed by women, for women.</li>
      <li><i class="ph-bold ph-check"></i> Absolute zero data-selling policy.</li>
      <li><i class="ph-bold ph-check"></i> Direct integration with local emergency response.</li>
    </ul>
  </div>
</section>

<!-- HIGHLIGHTED USP SECTION -->
<section class="usp-highlight reveal">
  <div class="usp-icon-container">
    <i class="ph-fill ph-lock-key"></i>
  </div>
  <div class="usp-content">
    <h2>The Ultimate <em>Safety Guarantee</em></h2>
    <p>We provide an <strong>End-to-End Encrypted Safest Path</strong> giving you complete control over your journey. In any condition, a single <strong>SOS click</strong> instantly shares your live location with your trusted contacts and alerts the <strong>nearest police station</strong> immediately.</p>
  </div>
</section>

<!-- FEATURES SECTION WITH 9 ITEMS -->
<section id="features">
  <div class="reveal" style="text-align:center; max-width:700px; margin:0 auto 4rem;">
    <div class="section-label">Our Features</div>
    <h2 class="section-title">Everything you need to<br>stay <em>safe</em></h2>
    <p class="section-sub" style="margin-left:auto; margin-right:auto;">A cohesive ecosystem of preemptive routing and reactive emergency systems.</p>
  </div>
  
  <div class="features-grid reveal">
    <!-- Feature 1 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-encrypt">
          <div class="dot-start"></div>
          <div class="line"></div>
          <div class="packet"><i class="ph-bold ph-lock-key"></i></div>
          <div class="dot-end"></div>
        </div>
      </div>
      <h3>Encrypted Safest Path</h3>
      <p>AI-scored routes mapped strictly via end-to-end encryption so your journey remains fully private.</p>
    </div>

    <!-- Feature 2 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-sos">
          <div class="sos-btn-mini">SOS</div>
          <i class="ph-fill ph-hand-pointing hand-cursor"></i>
          <div class="signal-waves"></div>
          <i class="ph-fill ph-police-car police-station"></i>
        </div>
      </div>
      <h3>Instant SOS & Police Link</h3>
      <p>One tap triggers an alert to emergency contacts and dispatches live GPS to local law enforcement.</p>
    </div>

    <!-- Feature 3 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-guardian">
          <i class="ph-fill ph-user user-node"></i>
          <i class="ph-fill ph-shield-check guardian-node g1"></i>
          <i class="ph-fill ph-shield-check guardian-node g2"></i>
          <div class="data-dot d1"></div>
          <div class="data-dot d2"></div>
        </div>
      </div>
      <h3>Live Guardian Control</h3>
      <p>Share your encrypted live route with selected 'Guardians' who can monitor your journey safely.</p>
    </div>

    <!-- Feature 4 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-report">
          <div class="street-beam"></div>
          <i class="ph-fill ph-warning-octagon danger-icon"></i>
          <i class="ph-fill ph-map-pin drop-pin"></i>
        </div>
      </div>
      <h3>Community Reporting</h3>
      <p>Spot an unlit street? Drop an anonymous pin to instantly reroute other users around the danger.</p>
    </div>

    <!-- Feature 5 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-voice">
          <i class="ph-fill ph-microphone mic"></i>
          <div class="bars">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
          </div>
        </div>
      </div>
      <h3>Voice Trigger Activation</h3>
      <p>Hands full? Set a discrete safe-word. Say it aloud, and the app silently triggers the SOS protocol.</p>
    </div>

    <!-- Feature 6 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-phone">
          <i class="ph-fill ph-phone-call phone-icon"></i>
          <div class="btn-ans"><i class="ph-bold ph-phone"></i></div>
          <div class="btn-dec"><i class="ph-bold ph-phone-x"></i></div>
        </div>
      </div>
      <h3>Simulated Fake Call</h3>
      <p>Feel uncomfortable? Receive a highly realistic simulated phone call to exit awkward situations.</p>
    </div>

    <!-- Feature 7 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-watch">
          <i class="ph-fill ph-watch watch-icon"></i>
          <div class="sos-ping"></div>
        </div>
      </div>
      <h3>Smartwatch Integration</h3>
      <p>Trigger your SOS directly from your wrist. Compatible with Apple Watch and major Android wearables.</p>
    </div>

    <!-- Feature 8 -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-offline">
          <i class="ph-fill ph-satellite sat-icon"></i>
          <div class="beam"></div>
          <i class="ph-fill ph-map-trifold map-icon"></i>
        </div>
      </div>
      <h3>Offline Safety Maps</h3>
      <p>Pre-cache your city's safety scores. Even if your cell signal drops, our AI keeps navigating.</p>
    </div>

    <!-- NEW Feature 9: Coming Soon AR Path -->
    <div class="feature-card">
      <div class="feat-anim-box">
        <div class="anim-ar">
          <i class="ph-bold ph-camera ar-cam"></i>
          <div class="ar-scan"></div>
          <div class="ar-path"></div>
        </div>
      </div>
      <h3>AR Safe Path <span style="font-size:0.7rem; background:var(--warn-amber); color:white; padding:2px 8px; border-radius:10px; vertical-align:middle; margin-left:5px;">SOON</span></h3>
      <p>Hold up your device to see augmented reality indicators guiding you along the safest illuminated sidewalks.</p>
    </div>

  </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section id="testimonials">
  <div class="reveal" style="text-align:center; max-width:700px; margin:0 auto;">
    <div class="section-label">Voices of Trust</div>
    <h2 class="section-title">Loved by thousands of<br><em>women globally.</em></h2>
  </div>
  <div class="test-grid reveal">
    <div class="test-card">
      <div class="stars"><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i></div>
      <p class="test-text">"I work late shifts at the hospital. This app has completely changed my commute. The safe routing actively avoids dark alleys that Google Maps usually suggests."</p>
      <div class="test-user">
        <div class="user-avatar">S</div>
        <div class="user-info">
          <h5>Sarah Jenkins</h5>
          <span>Registered Nurse</span>
        </div>
      </div>
    </div>
    <div class="test-card">
      <div class="stars"><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i></div>
      <p class="test-text">"The fake call feature saved me from an incredibly uncomfortable situation at a bus stop. I also love that my roommates can track my walk home live."</p>
      <div class="test-user">
        <div class="user-avatar">P</div>
        <div class="user-info">
          <h5>Priya Sharma</h5>
          <span>University Student</span>
        </div>
      </div>
    </div>
    <div class="test-card">
      <div class="stars"><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star"></i><i class="ph-fill ph-star-half"></i></div>
      <p class="test-text">"Knowing the SOS button is connected directly to local authorities gives me a peace of mind I've never had before. Highly recommend to every woman."</p>
      <div class="test-user">
        <div class="user-avatar">E</div>
        <div class="user-info">
          <h5>Elena Rodriguez</h5>
          <span>Freelance Designer</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SOS INTERACTIVE DEMO MODULE -->
<section id="sos">
  <div class="reveal" style="margin-bottom:4rem;">
    <div class="section-label" style="color:var(--rose-light);">Emergency Module</div>
    <h2 class="section-title">Designed for the<br>critical <em>golden minute</em></h2>
    <p class="section-sub">Try the interactive demo below to see how our system seamlessly alerts contacts and the nearest police station.</p>
  </div>
  
  <div class="sos-layout">
    <div class="sos-visual reveal">
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
      <div class="sos-status-text" id="sosStatus">System Ready.</div>
    </div>

    <!-- SEQUENTIAL HIGHLIGHT FLOW -->
    <div class="sos-flow reveal">
      <div class="sos-step" id="sos-step-1">
        <div class="sos-step-num">1</div>
        <div class="sos-step-text">
          <h4>SOS Button Triggered</h4>
          <p>2-second hold initiates the silent alarm protocol without alerting attackers or creating noise.</p>
        </div>
      </div>
      <div class="sos-step" id="sos-step-2">
        <div class="sos-step-num">2</div>
        <div class="sos-step-text">
          <h4>Encrypted GPS Shared</h4>
          <p>Live, end-to-end encrypted location links are generated instantly, immune to interception.</p>
        </div>
      </div>
      <div class="sos-step" id="sos-step-3">
        <div class="sos-step-num">3</div>
        <div class="sos-step-text">
          <h4>Contacts & Police Alerted</h4>
          <p>Trusted contacts and the absolute nearest police precinct receive your live location simultaneously.</p>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="Include/content-protection.js"></script>
<?php include 'Include/footer.php'; ?>

<script>
  // --- 0. Preloader & Particles Logic ---
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.getElementById('preloader').classList.add('preloader-hidden');
    }, 1000); 

    const container = document.getElementById('particles-container');
    for(let i=0; i<15; i++) {
      let particle = document.createElement('div');
      particle.className = 'particle';
      particle.style.left = Math.random() * 100 + 'vw';
      particle.style.animationDuration = (Math.random() * 20 + 10) + 's';
      particle.style.animationDelay = (Math.random() * 10) + 's';
      container.appendChild(particle);
    }
  });

  // --- 1. Global Toast Logic ---
  function showToast(message, icon = 'ph-check-circle') {
    const toast = document.getElementById('toast');
    toast.innerHTML = `<i class="ph-fill ${icon}"></i> <span>${message}</span>`;
    toast.classList.add('show');
    
    if(window.toastTimeout) clearTimeout(window.toastTimeout);
    window.toastTimeout = setTimeout(() => { toast.classList.remove('show'); }, 3500);
  }

  // --- 2. Clock Update Function for Phone Mockup ---
  function updatePhoneTime() {
    const now = new Date();
    let hours = now.getHours();
    let minutes = now.getMinutes();
    hours = hours % 12 || 12; 
    minutes = minutes < 10 ? '0' + minutes : minutes;
    document.getElementById('phone-time').innerText = `${hours}:${minutes}`;
  }
  setInterval(updatePhoneTime, 1000);
  updatePhoneTime();

  // --- 3. Live Google Maps Geolocation FIX ---
  function locateUser() {
    const loader = document.getElementById('map-loader');
    const iframe = document.getElementById('gmap-live');
    const badge = document.getElementById('live-score-badge');
    const gpsDot = document.getElementById('gps-dot');
    
    loader.style.opacity = '1';
    iframe.style.opacity = '0';
    if(gpsDot) gpsDot.style.opacity = '0';
    
    showToast('Securing Encrypted Connection...', 'ph-lock-key');
    
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(
        (position) => {
          const lat = position.coords.latitude;
          const lng = position.coords.longitude;
          const gmapUrl = `https://maps.google.com/maps?q=${lat},${lng}&t=m&z=15&output=embed&iwloc=near`;
          
          iframe.src = gmapUrl;
          iframe.onload = () => {
            setTimeout(() => {
              loader.style.opacity = '0';
              iframe.style.opacity = '1';
              if(gpsDot) gpsDot.style.opacity = '1';
              
              badge.innerHTML = `
                <i class="ph-fill ph-shield-check" style="color:var(--safe-green); font-size: 1.2rem;"></i>
                <div>
                  <div class="score-num" style="color:var(--safe-green);">98</div>
                  <div class="score-label">ENCRYPTED</div>
                </div>
              `;
              badge.style.borderColor = 'rgba(42, 157, 92, 0.6)';
              showToast('Location securely tracked.', 'ph-map-pin');
            }, 800);
          };
        },
        (error) => {
          loader.innerHTML = `
            <i class="ph-fill ph-warning-circle" style="color:var(--warn-amber);"></i>
            <span>LOCATION DENIED</span>
          `;
          showToast('GPS Denied. Loading secure default.', 'ph-warning');
          iframe.src = `https://maps.google.com/maps?q=Indore,+Madhya+Pradesh&t=m&z=13&output=embed`;
          
          iframe.onload = () => {
             setTimeout(() => {
                loader.style.opacity = '0';
                iframe.style.opacity = '1'; 
                if(gpsDot) gpsDot.style.opacity = '1';
             }, 500);
          };
        },
        { enableHighAccuracy: true, timeout: 8000, maximumAge: 0 }
      );
    } else {
      loader.innerHTML = "<span>GPS NOT SUPPORTED</span>";
    }
  }

  window.addEventListener('load', () => { setTimeout(locateUser, 2500); });

  // --- 4. Scroll Reveal & Navbar Animation ---
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 50) nav.classList.add('scrolled');
    else nav.classList.remove('scrolled');
  });

  // --- 5. SOS SEQUENTIAL DEMO ANIMATION ---
  const sosBtn = document.getElementById('sosDemoBtn');
  const sosFill = document.getElementById('sosFill');
  const sosStatus = document.getElementById('sosStatus');
  const sosContent = document.getElementById('sosContent');
  const sosContainer = document.getElementById('sos');
  
  const step1 = document.getElementById('sos-step-1');
  const step2 = document.getElementById('sos-step-2');
  const step3 = document.getElementById('sos-step-3');
  
  let fillInterval, step1Timer, step2Timer, resetTimer, statusTimeout;
  let progress = 0;
  let isTriggered = false;

  const startHold = (e) => {
    if(isTriggered) return;
    clearInterval(fillInterval); 
    clearTimeout(statusTimeout);
    
    sosStatus.textContent = "Hold to activate SOS...";
    sosStatus.style.color = "var(--rose)";
    
    fillInterval = setInterval(() => {
      progress += 5; 
      sosFill.style.height = `${progress}%`;
      
      if(progress >= 100) {
        clearInterval(fillInterval);
        triggerSOS();
      }
    }, 100);
  };

  const endHold = (e) => {
    if(isTriggered) return;
    clearInterval(fillInterval);
    progress = 0;
    sosFill.style.height = '0%';
    sosStatus.textContent = "System Ready. Hold aborted.";
    sosStatus.style.color = "rgba(255,255,255,0.5)";
    
    clearTimeout(statusTimeout);
    statusTimeout = setTimeout(() => { 
      if(!isTriggered) {
        sosStatus.textContent = "System Ready."; 
        sosStatus.style.color = "var(--rose-light)";
      }
    }, 2000);
  };

  const triggerSOS = () => {
    isTriggered = true;
    sosFill.style.height = '100%';
    
    // Button styling
    sosBtn.style.border = "4px solid white";
    sosBtn.style.background = "var(--rose)";
    sosBtn.style.boxShadow = "0 0 60px var(--rose)";
    sosContent.innerHTML = `
      <i class="ph-fill ph-check-circle" style="color:white; font-size:3.5rem; margin-bottom:0;"></i>
      <span style="font-size:1.4rem; margin-top:5px;">ALERT SENT</span>
    `;

    // SEQUENCE STEP 1 (0s)
    step1.classList.add('active-step');
    sosStatus.textContent = "Initiating Silent Alarm...";
    sosStatus.style.color = "var(--warn-amber)";

    // SEQUENCE STEP 2 (1.5s)
    step1Timer = setTimeout(() => {
      step1.classList.remove('active-step');
      step2.classList.add('active-step');
      sosStatus.textContent = "Encrypting & Sharing GPS...";
      sosStatus.style.color = "var(--safe-green)";
      showToast('Live Location Link Generated', 'ph-link');
    }, 1500);

    // SEQUENCE STEP 3 (3s)
    step2Timer = setTimeout(() => {
      step2.classList.remove('active-step');
      step3.classList.add('active-step');
      sosStatus.textContent = "Police & Contacts notified. Live Location Shared.";
      sosStatus.style.color = "var(--rose-light)";
      showToast('SOS Sent to Nearest Police Station!', 'ph-siren');
      
      // Start Police Flash
      sosContainer.classList.add('police-flash');
    }, 3000);

    // RESET SEQUENCE (8s)
    resetTimer = setTimeout(() => {
      step3.classList.remove('active-step');
      sosContainer.classList.remove('police-flash');
      
      isTriggered = false;
      progress = 0;
      sosFill.style.height = '0%';
      sosBtn.style.border = "4px solid var(--rose)";
      sosBtn.style.background = "linear-gradient(135deg, #1c1116, #2d1520)";
      sosBtn.style.boxShadow = "0 0 40px rgba(192,57,75,.4), inset 0 0 20px rgba(192,57,75,0.2)";
      sosContent.innerHTML = `
        <i class="ph-fill ph-fingerprint"></i>
        <span>SOS</span>
        <small>Hold 2 Secs</small>
      `;
      sosStatus.textContent = "System Ready.";
      sosStatus.style.color = "var(--rose-light)";
    }, 8000);
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