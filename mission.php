<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Our Mission – SheSecure | Team Coffee To Code</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* ==========================================================================
     GLOBAL VARIABLES & RESET
     ========================================================================== */
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
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  html { scroll-behavior: smooth; }

  /* ─── CONTENT PROTECTION CSS ─── */
  body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    color: var(--charcoal);
    overflow-x: hidden;
    position: relative;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
  }
  input, textarea {
    -webkit-user-select: text;
    -moz-user-select: text;
    -ms-user-select: text;
    user-select: text;
  }

  /* ==========================================================================
     UTILITIES & BACKGROUND ANIMATIONS
     ========================================================================== */
  /* ─── PRELOADER ─── */
  #preloader {
    position: fixed; inset: 0; background: var(--charcoal); z-index: 999999;
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

  /* ==========================================================================
     GLOBAL COMPONENTS (NAV, SECTIONS, FOOTER)
     ========================================================================== */
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

  /* ─── SECTIONS COMMON ─── */
  section { padding: 6rem 5rem; position: relative; z-index: 2; }
  .section-label { display: inline-flex; align-items: center; gap: .8rem; font-size: .85rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--rose); margin-bottom: 1.2rem; }
  .section-label::before { content: ''; width: 40px; height: 2px; background: var(--rose); }
  .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 4vw, 3.5rem); font-weight: 900; line-height: 1.15; color: var(--charcoal); margin-bottom: 1.5rem; }
  .section-title em { color: var(--rose); font-style: italic; }

  /* ==========================================================================
     MISSION PAGE SPECIFIC CSS
     ========================================================================== */
  /* ─── MISSION HERO ─── */
  #mission-hero {
    min-height: 90vh; display: flex; flex-direction: column; justify-content: center;
    padding: 12rem 5rem 6rem; position: relative; z-index: 2;
  }
  .hero-container { max-width: 900px; }
  .m-hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3.5rem, 6vw, 6.5rem); line-height: 1.05; font-weight: 900; color: var(--charcoal); margin-bottom: 2rem; }
  .m-hero-title em { color: var(--rose); font-style: italic; position: relative; }
  .m-hero-title em::after { content: ''; position: absolute; bottom: 10px; left: 0; width: 100%; height: 10px; background: var(--blush); z-index: -1; opacity: 0.6; }
  .m-hero-subtitle { font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-style: italic; color: var(--muted); line-height: 1.5; border-left: 3px solid var(--rose-light); padding-left: 1.5rem; margin-bottom: 3rem;}

  /* ─── DATA STRIP ─── */
  .data-strip { display: flex; justify-content: center; gap: 6rem; padding: 4rem 5rem; border-bottom: 1px solid rgba(192,57,75,0.05); position: relative; z-index: 2; }
  .d-stat { text-align: center; }
  .d-num { font-family: 'Playfair Display', serif; font-size: 3.5rem; font-weight: 900; color: var(--rose); line-height: 1; margin-bottom: 0.5rem; }
  .d-label { font-size: 0.9rem; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.1em; }

  /* ─── THE MANIFESTO (STICKY SCROLL LAYOUT) ─── */
  #manifesto { background: white; border-radius: 40px; margin: 0 5rem; padding: 0; box-shadow: 0 20px 50px rgba(0,0,0,0.03); display: flex; overflow: hidden; border: 1px solid rgba(192,57,75,0.05); position: relative; z-index: 2;}
  
  .manifesto-sticky { width: 45%; background: linear-gradient(160deg, #1c1116 0%, #3d2a33 100%); color: white; padding: 6rem 4rem; position: sticky; top: 0; height: 100vh; display: flex; flex-direction: column; justify-content: center; overflow: hidden;}
  .manifesto-sticky .section-label { color: var(--blush); position: relative; z-index: 5;}
  .manifesto-sticky .section-label::before { background: var(--blush); }
  .manifesto-sticky h2 { font-family: 'Playfair Display', serif; font-size: 3.5rem; line-height: 1.1; margin-bottom: 1.5rem; position: relative; z-index: 5;}
  .manifesto-sticky h2 em { color: var(--rose-light); font-style: italic; }
  .manifesto-sticky p { font-size: 1.1rem; color: rgba(255,255,255,0.7); line-height: 1.6; position: relative; z-index: 5;}
  
  /* NEW: Custom Animated Background Graphic for Blank Space */
  .manifesto-graphic {
    position: absolute; bottom: -50px; left: 50%; transform: translateX(-50%);
    width: 300px; height: 300px; z-index: 1; opacity: 0.8;
  }
  .m-ring {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    border-radius: 50%; border: 1px solid rgba(232, 105, 122, 0.2);
    animation: radar-pulse 4s infinite ease-out;
  }
  .m-ring:nth-child(1) { width: 100px; height: 100px; animation-delay: 0s; }
  .m-ring:nth-child(2) { width: 200px; height: 200px; animation-delay: 1s; }
  .m-ring:nth-child(3) { width: 300px; height: 300px; animation-delay: 2s; }
  .m-dot {
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 15px; height: 15px; background: var(--rose); border-radius: 50%;
    box-shadow: 0 0 20px var(--rose);
  }
  .m-line {
    position: absolute; top: 50%; left: 50%; width: 150px; height: 2px;
    background: linear-gradient(90deg, var(--rose) 0%, transparent 100%);
    transform-origin: left center; animation: radar-sweep 6s linear infinite;
  }
  @keyframes radar-pulse {
    0% { transform: translate(-50%, -50%) scale(0.5); opacity: 1; border-color: rgba(232, 105, 122, 0.6); }
    100% { transform: translate(-50%, -50%) scale(1.5); opacity: 0; border-color: rgba(232, 105, 122, 0); }
  }
  @keyframes radar-sweep { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

  .manifesto-scroll { width: 55%; padding: 6rem 5rem; }
  .m-block { margin-bottom: 6rem; position: relative; }
  .m-block:last-child { margin-bottom: 0; }
  .m-icon { width: 60px; height: 60px; background: var(--blush-soft); color: var(--rose-dark); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 1.5rem; border: 1px solid rgba(192,57,75,0.1); }
  .m-block h3 { font-size: 1.8rem; font-weight: 700; color: var(--charcoal); margin-bottom: 1rem; font-family: 'Playfair Display', serif;}
  .m-block p { font-size: 1.1rem; color: var(--muted); line-height: 1.8; margin-bottom: 1rem; }
  .m-quote { font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-style: italic; color: var(--rose-dark); margin: 2rem 0; padding: 1.5rem; background: var(--cream); border-radius: 16px; border-left: 4px solid var(--rose); }

  /* ─── THE PARADIGM SHIFT (COMPARISON CARDS & ANIMATIONS) ─── */
  #paradigm { padding: 8rem 5rem; text-align: center; position: relative; z-index: 2;}
  .paradigm-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; margin-top: 4rem; text-align: left; }
  
  .p-card { 
    background: white; border-radius: 30px; padding: 3.5rem; 
    box-shadow: 0 15px 40px rgba(0,0,0,0.03); border: 1px solid rgba(192,57,75,0.05); 
    position: relative; overflow: hidden; transition: transform 0.4s var(--graceful); 
  }
  .p-card:hover { transform: translateY(-10px); }
  
  /* Flawed Card Styling */
  .p-card.flawed { background: #fdfafb; border-color: rgba(28,17,22,0.1); }
  .p-card.flawed h3 { color: var(--charcoal); opacity: 0.6; }
  .p-card.flawed .p-icon { background: rgba(28,17,22,0.05); color: var(--charcoal); }
  
  /* Solution Card Styling & Animated Border */
  .p-card.solution { 
    background: linear-gradient(135deg, white, var(--blush-soft)); 
    box-shadow: 0 20px 50px rgba(192,57,75,0.1); 
  }
  .p-card.solution::before {
    content: ''; position: absolute; inset: 0; padding: 3px; border-radius: 30px; 
    background: linear-gradient(45deg, var(--safe-green), var(--rose), var(--rose-light), var(--safe-green)); 
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor; mask-composite: exclude;
    background-size: 300% 300%; animation: glowing-border 4s linear infinite;
  }
  @keyframes glowing-border { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
  
  .p-card.solution h3 { color: var(--rose-dark); position: relative; z-index: 2;}
  .p-card.solution .p-icon { background: var(--rose); color: white; box-shadow: 0 10px 20px rgba(192,57,75,0.3); position: relative; z-index: 2;}

  .p-icon { width: 70px; height: 70px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; margin-bottom: 2rem; }
  .p-card h3 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 1.5rem; }
  
  /* Custom Animated List Items */
  .p-list { list-style: none; display: flex; flex-direction: column; gap: 1.5rem; position: relative; z-index: 2;}
  .p-list li { display: flex; align-items: flex-start; gap: 1rem; font-size: 1.05rem; color: var(--muted); line-height: 1.6; }
  .p-list li i { font-size: 1.5rem; flex-shrink: 0; margin-top: 2px; }
  
  /* Red 'X' Animation (Error Pulse) */
  .flawed .p-list li i { 
    color: var(--rose); opacity: 0.8; 
    animation: error-shake 3s infinite ease-in-out; 
  }
  @keyframes error-shake {
    0%, 100% { transform: translateX(0); opacity: 0.8; }
    5%, 15% { transform: translateX(-2px); opacity: 1; filter: drop-shadow(0 0 5px rgba(192,57,75,0.5));}
    10%, 20% { transform: translateX(2px); opacity: 1; filter: drop-shadow(0 0 5px rgba(192,57,75,0.5));}
    25% { transform: translateX(0); opacity: 0.8;}
  }

  /* Green Checkmark Animation (Success Pop) */
  .solution .p-list li i { 
    color: var(--safe-green); 
    animation: success-pop 3s infinite ease-in-out; 
    transform-origin: center;
  }
  @keyframes success-pop {
    0%, 100% { transform: scale(1); filter: drop-shadow(0 0 0 transparent); }
    10% { transform: scale(1.3); filter: drop-shadow(0 0 8px rgba(42, 157, 92, 0.6)); }
    20% { transform: scale(1); filter: drop-shadow(0 0 0 transparent); }
  }

  /* ─── IMPACT VISUAL ─── */
  #impact { margin: 4rem 5rem; border-radius: 40px; overflow: hidden; position: relative; height: 600px; display: flex; align-items: center; justify-content: center; box-shadow: 0 30px 60px rgba(192,57,75,0.15); z-index: 2;}
  
  /* Replaced broken image with a reliable high-res safe street image */
  #impact img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
  
  .impact-overlay { position: absolute; inset: 0; background: linear-gradient(135deg, rgba(28,17,22,0.85) 0%, rgba(192,57,75,0.6) 100%); display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; color: white; padding: 4rem; }
  .impact-overlay h2 { font-family: 'Playfair Display', serif; font-size: 4rem; margin-bottom: 1rem; line-height: 1.1; }
  .impact-overlay em { color: var(--blush); font-style: italic; }
  .impact-overlay p { font-size: 1.2rem; max-width: 600px; color: rgba(255,255,255,0.9); line-height: 1.6; }

  /* ─── MISSION CTA ─── */
  .mission-cta { 
    text-align: center; margin: 4rem 5rem 6rem; padding: 6rem 3rem; 
    background: linear-gradient(135deg, var(--blush-soft) 0%, var(--cream) 100%); 
    border: 1px solid rgba(192,57,75,0.1); border-radius: 40px; position: relative; 
    overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.02); z-index: 2;
  }
  .mission-cta h2 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 4vw, 3.5rem); margin-bottom: 1.5rem; color: var(--charcoal); }
  .mission-cta p { font-size: 1.1rem; color: var(--muted); margin-bottom: 2.5rem; max-width: 600px; margin-left: auto; margin-right: auto;}
  .btn-cta-mission { 
    background: linear-gradient(135deg, var(--rose), var(--rose-dark)); 
    color: white; padding: 1.2rem 3.5rem; border-radius: 50px; 
    font-size: 1.1rem; font-weight: 700; text-decoration: none; 
    transition: all .4s var(--graceful); display: inline-flex; 
    align-items: center; gap: .8rem; box-shadow: 0 15px 35px rgba(192,57,75,0.3); 
    border: 2px solid transparent;
  }
  .btn-cta-mission:hover { 
    transform: translateY(-5px) scale(1.02); 
    box-shadow: 0 25px 50px rgba(192,57,75,0.5); 
    background: linear-gradient(135deg, var(--rose-dark), #5a0d1e);
  }
  .btn-cta-mission i { transition: transform 0.4s var(--graceful); }
  .btn-cta-mission:hover i { transform: translateX(6px); }

  /* ==========================================================================
     RESPONSIVE MEDIA QUERIES
     ========================================================================== */
  @media (max-width: 1200px) {
    #manifesto { flex-direction: column; height: auto; }
    .manifesto-sticky { width: 100%; height: auto; position: relative; padding: 5rem; text-align: center; }
    .manifesto-graphic { display: none; } /* Hide complex graphics on small screens */
    .manifesto-scroll { width: 100%; }
    .paradigm-grid { grid-template-columns: 1fr; }
  }
  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; }
    section, .data-strip { padding: 4rem 1.5rem; }
    #mission-hero { padding: 10rem 1.5rem 4rem; text-align: left; }
    .data-strip { flex-direction: column; gap: 3rem; }
    
    #manifesto { margin: 0 1.5rem; border-radius: 24px; }
    .manifesto-sticky { padding: 4rem 2rem; text-align: left;}
    .manifesto-scroll { padding: 3rem 1.5rem; }
    
    #impact { margin: 2rem 1.5rem; border-radius: 24px; height: 500px; }
    .impact-overlay { padding: 2rem; }
    .impact-overlay h2 { font-size: 2.5rem; }
    
    .mission-cta { margin: 2rem 1.5rem; padding: 4rem 1.5rem; border-radius: 24px; }
  }

  .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s var(--graceful), transform 0.8s var(--graceful); }
  .reveal.visible { opacity: 1; transform: translateY(0); }
  .parallax { transition: transform 0.1s ease-out; }
</style>
</head>
<body>

<div id="preloader">
  <i class="ph-fill ph-globe-hemisphere-east loader-icon"></i>
  <div class="loader-text">Loading Our Mission...</div>
</div>

<div class="ambient-bg">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>
  <div id="particles-container"></div>
</div>

<nav id="navbar">
  <a class="nav-logo" href="index.php">
    <div class="logo-icon"><i class="ph-fill ph-gender-female"></i></div>
    She<span>Secure</span>
  </a>
  <div class="nav-actions">
    <a href="login.php" class="btn-login">Login</a>
    <a href="signup.php" class="btn-signup">Sign Up <i class="ph-bold ph-arrow-right"></i></a>
  </div>
</nav>

<header id="mission-hero">
  <div class="hero-container reveal">
    <div class="section-label">Team Coffee To Code</div>
    <h1 class="m-hero-title parallax" data-speed="1.5">
      Reclaiming the <em>Night.</em>
    </h1>
    <p class="m-hero-subtitle parallax" data-speed="1">
      We believe that walking home should never be an act of bravery. Our mission is to shift the paradigm of navigation from speed-first to safety-first.
    </p>
  </div>
</header>

<div class="data-strip reveal">
  <div class="d-stat">
    <div class="d-num">71%</div>
    <div class="d-label">Of women feel unsafe at night</div>
  </div>
  <div class="d-stat">
    <div class="d-num">0%</div>
    <div class="d-label">Safety metrics in traditional maps</div>
  </div>
  <div class="d-stat">
    <div class="d-num">< 3s</div>
    <div class="d-label">To dispatch our SOS alerts</div>
  </div>
</div>

<section style="padding: 4rem 0;">
  <div id="manifesto" class="reveal">
    <div class="manifesto-sticky">
      <div class="section-label">The Problem</div>
      <h2>Built for Cars,<br><em>Not Humans.</em></h2>
      <p>Modern mapping applications are engineering marvels, but they share a fatal flaw: they optimize strictly for vehicular efficiency. They calculate the shortest distance and the fastest time, completely blind to the human experience on the ground.</p>
      
      <div class="manifesto-graphic">
        <div class="m-ring"></div>
        <div class="m-ring"></div>
        <div class="m-ring"></div>
        <div class="m-line"></div>
        <div class="m-dot"></div>
      </div>
    </div>
    
    <div class="manifesto-scroll">
      <div class="m-block reveal">
        <div class="m-icon"><i class="ph-fill ph-moon-stars"></i></div>
        <h3>The Blind Spots of Algorithms</h3>
        <p>A route that saves two minutes might take a pedestrian through an unlit alleyway, an abandoned industrial zone, or an area with a history of incidents. Traditional GPS does not know what a street feels like at 2 AM.</p>
        <p>For decades, vulnerable groups have had to mentally calculate their own safety maps—avoiding certain streets, sticking to well-lit main roads, or calling friends while walking. Technology has failed to support them.</p>
      </div>

      <div class="m-block reveal">
        <div class="m-quote">
          "A map that only shows distance is an incomplete map. A true navigation tool must understand the environment it is guiding you through."
        </div>
      </div>

      <div class="m-block reveal">
        <div class="m-icon"><i class="ph-fill ph-brain"></i></div>
        <h3>The AI Intervention</h3>
        <p>This is where Team Coffee To Code stepped in. We realized that with modern Machine Learning, we could quantify safety. By analyzing historical crime data, real-time lighting infrastructure, and active crowd density, we can generate a dynamic "Safety Score" for any route.</p>
        <p>Our algorithms don't just find the path; they find the path that ensures you arrive safely.</p>
      </div>
    </div>
  </div>
</section>

<section id="paradigm">
  <div class="reveal">
    <div class="section-label">The Shift</div>
    <h2 class="section-title">A new standard in <em>Navigation</em></h2>
  </div>

  <div class="paradigm-grid reveal">
    <div class="p-card flawed">
      <div class="p-icon"><i class="ph-fill ph-map-pin-line"></i></div>
      <h3>Traditional GPS</h3>
      <ul class="p-list">
        <li><i class="ph-bold ph-x"></i> Optimizes purely for the shortest distance or fastest time.</li>
        <li><i class="ph-bold ph-x"></i> Ignores street lighting and pedestrian visibility.</li>
        <li><i class="ph-bold ph-x"></i> Blind to local crime statistics or danger zones.</li>
        <li><i class="ph-bold ph-x"></i> No integrated emergency response system.</li>
      </ul>
    </div>
    
    <div class="p-card solution">
      <div class="p-icon"><i class="ph-fill ph-shield-check"></i></div>
      <h3>SheSecure AI</h3>
      <ul class="p-list">
        <li><i class="ph-bold ph-check"></i> Optimizes for the highest verified Safety Score.</li>
        <li><i class="ph-bold ph-check"></i> Prioritizes well-lit, populated, and active streets.</li>
        <li><i class="ph-bold ph-check"></i> Uses crowd-sourced data to bypass real-time hazards.</li>
        <li><i class="ph-bold ph-check"></i> One-tap SOS directly linked to local police and guardians.</li>
      </ul>
    </div>
  </div>
</section>

<div id="impact" class="reveal">
  <img src="https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80" alt="Safe City Street Night" class="parallax" data-speed="0.2"/>
  <div class="impact-overlay">
    <h2>Technology with<br><em>Empathy</em></h2>
    <p>We are not just a software team; we are advocates for systemic change. By building tools that prioritize human life, we aim to transform how cities are navigated globally.</p>
  </div>
</div>

<div class="mission-cta reveal">
  <h2>Be part of the solution.</h2>
  <p>Whether you want to use the app to stay safe, or contribute community reports to protect others, you are vital to our mission.</p>
  <br>
  <a href="index.php#features" class="btn-cta-mission">View Platform Features <i class="ph-bold ph-arrow-right"></i></a>
</div>

<?php include 'Include/footer.php'; ?>

<script>
  // --- Preloader & Particles Logic ---
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.getElementById('preloader').classList.add('preloader-hidden');
    }, 800); 

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

  // --- Scroll Reveal & Navbar Animation ---
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

  // --- Parallax Scroll Effect ---
  window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallaxElements = document.querySelectorAll('.parallax');
    parallaxElements.forEach((el) => {
      const speed = el.getAttribute('data-speed');
      el.style.transform = `translateY(${scrolled * speed * 0.1}px)`;
    });
  });
</script>

<script src="Include/content-protection.js"></script>

</body>
</html>