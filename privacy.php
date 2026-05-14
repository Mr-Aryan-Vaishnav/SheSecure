<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Privacy Policy – SheSecure | Team Coffee To Code</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* =========================================
     GLOBAL VARIABLES & RESET
     ========================================= */
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
    --glass-bg: rgba(255, 255, 255, 0.85);
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

  /* ─── PRELOADER ─── */
  #preloader {
    position: fixed; inset: 0; background: var(--charcoal); z-index: 999999;
    display: flex; flex-direction: column; align-items: center; justify-content: center;
    transition: opacity 0.8s var(--graceful), visibility 0.8s var(--graceful);
  }
  .loader-icon { font-size: 4rem; color: var(--rose-light); margin-bottom: 1.5rem; animation: pulse-loader 1.5s infinite alternate var(--graceful); }
  .loader-text { color: white; font-family: 'Playfair Display', serif; font-size: 1.5rem; letter-spacing: 0.15em; text-transform: uppercase; }
  @keyframes pulse-loader { 0% { transform: scale(0.85); opacity: 0.6; filter: drop-shadow(0 0 0 transparent); } 100% { transform: scale(1.15); opacity: 1; filter: drop-shadow(0 0 20px var(--rose)); } }
  .preloader-hidden { opacity: 0; visibility: hidden; }

  /* ─── AMBIENT BACKGROUND & PARTICLES ─── */
  .ambient-bg { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; overflow: hidden; pointer-events: none; background: var(--cream); }
  .blob { position: absolute; border-radius: 50%; filter: blur(90px); opacity: 0.4; animation: float-blob 15s infinite alternate var(--graceful); }
  .blob-1 { top: -10%; left: -10%; width: 45vw; height: 45vw; background: var(--blush); }
  .blob-2 { bottom: -20%; right: -10%; width: 55vw; height: 55vw; background: rgba(192, 57, 75, 0.08); animation-delay: -5s; }
  .blob-3 { top: 30%; left: 50%; width: 35vw; height: 35vw; background: rgba(232, 105, 122, 0.12); animation-duration: 20s; }
  .particle { position: absolute; width: 6px; height: 6px; background: var(--rose-light); border-radius: 50%; opacity: 0.3; pointer-events: none; animation: drift 20s linear infinite; }
  @keyframes float-blob { 0% { transform: translate(0, 0) scale(1) rotate(0deg); } 100% { transform: translate(40px, -60px) scale(1.1) rotate(10deg); } }
  @keyframes drift { 0% { transform: translateY(100vh) translateX(0); opacity: 0; } 10% { opacity: 0.4; } 90% { opacity: 0.4; } 100% { transform: translateY(-10vh) translateX(100px); opacity: 0; } }

  /* ─── NAV ─── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 5rem; background: rgba(255, 247, 245, 0.8);
    backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    border-bottom: 1px solid rgba(192,57,75,0.05); transition: all 0.4s var(--graceful);
  }
  nav.scrolled { padding: 0.8rem 5rem; box-shadow: 0 10px 40px rgba(192, 57, 75, 0.05); background: rgba(255, 247, 245, 0.95); }
  .nav-logo { display: flex; align-items: center; gap: .6rem; font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--charcoal); text-decoration: none; }
  .nav-logo span { color: var(--rose); }
  .logo-icon { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; box-shadow: 0 4px 15px rgba(192,57,75,0.3); }
  .nav-actions { display: flex; gap: 1.5rem; align-items: center; }
  .btn-login { text-decoration: none; font-size: 1rem; font-weight: 700; color: var(--charcoal); transition: all .3s var(--graceful); position: relative; }
  .btn-login::after { content: ''; position: absolute; width: 0; height: 2px; bottom: -4px; left: 0; background: var(--rose); transition: width 0.3s var(--graceful); }
  .btn-login:hover { color: var(--rose); transform: translateY(-2px); }
  .btn-login:hover::after { width: 100%; }
  .btn-signup { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; border: none; padding: .7rem 2rem; border-radius: 50px; font-size: 1rem; font-weight: 700; text-decoration: none; transition: all .4s var(--graceful); display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 6px 20px rgba(192,57,75,0.25); border: 2px solid transparent; }
  .btn-signup:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 12px 30px rgba(192,57,75,.4); border-color: rgba(255,255,255,0.5); }

  /* ─── POLICY HERO ─── */
  #policy-hero { min-height: 45vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 12rem 5rem 4rem; position: relative; z-index: 2; }
  .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: white; color: var(--rose-dark); padding: .5rem 1.2rem; border-radius: 50px; font-size: .85rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 2rem; border: 1px solid rgba(192,57,75,.1); box-shadow: 0 10px 30px rgba(192,57,75,0.05); }
  .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3rem, 5vw, 5rem); line-height: 1.1; font-weight: 900; color: var(--charcoal); margin-bottom: 1.5rem; }
  .hero-title em { color: var(--rose); font-style: italic; position: relative; display: inline-block; }
  .hero-title em::after { content: ''; position: absolute; bottom: 8px; left: 0; width: 100%; height: 8px; background: var(--blush); z-index: -1; opacity: 0.6; }
  .hero-subtitle { font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-style: italic; color: var(--muted); max-width: 600px; line-height: 1.6; }

  /* ─── POLICY CONTENT LAYOUT ─── */
  #policy-section { padding: 4rem 5rem 8rem; position: relative; z-index: 2; display: grid; grid-template-columns: 280px 1fr; gap: 5rem; max-width: 1200px; margin: 0 auto; align-items: start;}

  /* ─── SIDEBAR ─── */
  .policy-sidebar { position: sticky; top: 120px; display: flex; flex-direction: column; gap: 1rem; }
  .sidebar-title { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); margin-bottom: 0.5rem; padding-left: 1rem;}
  .sidebar-link { font-size: 1.05rem; color: var(--charcoal); text-decoration: none; padding: 0.8rem 1rem; border-radius: 12px; transition: all 0.3s var(--graceful); border-left: 3px solid transparent; font-weight: 500;}
  .sidebar-link:hover, .sidebar-link.active { background: rgba(192,57,75,0.05); color: var(--rose-dark); border-left-color: var(--rose); }

  /* ─── MAIN CONTENT ─── */
  .policy-content-wrapper { background: white; border-radius: 40px; padding: 4.5rem; box-shadow: 0 30px 60px rgba(192,57,75,0.05); border: 1px solid rgba(192,57,75,0.05); }
  .last-updated { display: inline-block; background: var(--blush-soft); color: var(--rose-dark); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.85rem; font-weight: 600; margin-bottom: 2.5rem; }
  .policy-block { margin-bottom: 4rem; }
  .policy-block:last-child { margin-bottom: 0; }
  .policy-block h2 { font-family: 'Playfair Display', serif; font-size: 2.2rem; color: var(--charcoal); margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(192,57,75,0.1); }
  .policy-block p { font-size: 1.05rem; color: var(--muted); line-height: 1.8; margin-bottom: 1.5rem; }
  .policy-block strong { color: var(--charcoal); font-weight: 700; }
  .policy-list { list-style: none; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem; padding-left: 0.5rem;}
  .policy-list li { display: flex; align-items: flex-start; gap: 1rem; font-size: 1.05rem; color: var(--muted); line-height: 1.7; }
  .policy-list li i { color: var(--rose); font-size: 1.4rem; flex-shrink: 0; margin-top: 3px; }
  .highlight-box { background: rgba(42, 157, 92, 0.05); border-left: 4px solid var(--safe-green); padding: 1.5rem 2rem; border-radius: 0 16px 16px 0; margin: 2rem 0; }
  .highlight-box p { margin: 0; color: #1e663a; font-weight: 500; }

  /* ─── FOOTER STYLES ─── */
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
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 1rem; padding: 0; margin: 0; }
  .footer-col a { color: rgba(255,255,255,.6); font-size: 0.95rem; text-decoration: none; transition: color .3s; font-weight: 500; }
  .footer-col a:hover { color: var(--rose-light); }
  .footer-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem; flex-wrap: wrap; gap: 1rem; }
  .footer-copy { font-size: 0.9rem; color: rgba(255,255,255,.4); }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 1024px) {
    #policy-section { grid-template-columns: 1fr; gap: 3rem; }
    .policy-sidebar { display: none; }
    .footer-top { grid-template-columns: 1fr; }
  }
  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; }
    #policy-hero { padding: 10rem 1.5rem 3rem; }
    #policy-section { padding: 2rem 1.5rem 6rem; }
    .policy-content-wrapper { padding: 2.5rem 1.5rem; border-radius: 30px; }
    .policy-block h2 { font-size: 1.8rem; }
    footer { padding: 4rem 1.5rem 2rem; }
    .footer-links-grid { grid-template-columns: 1fr; gap: 2.5rem; }
    .footer-bottom { flex-direction: column; text-align: center; justify-content: center;}
    .footer-bottom .footer-copy { text-align: center !important; }
  }

  .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s var(--graceful), transform 0.8s var(--graceful); }
  .reveal.visible { opacity: 1; transform: translateY(0); }
</style>
</head>
<body>

<div id="preloader">
  <i class="ph-fill ph-shield-check loader-icon"></i>
  <div class="loader-text">Securing Data...</div>
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

<section id="policy-hero">
  <div class="hero-badge reveal"><i class="ph-fill ph-lock-key"></i> Transparency & Trust</div>
  <h1 class="hero-title reveal">Your Data is <em>Yours</em></h1>
  <p class="hero-subtitle reveal">We believe safety should never come at the cost of privacy. Read exactly how we protect, process, and secure your information.</p>
</section>

<section id="policy-section">
  <aside class="policy-sidebar reveal">
    <div class="sidebar-title">Contents</div>
    <a href="#introduction" class="sidebar-link active">1. Introduction</a>
    <a href="#data-collection" class="sidebar-link">2. Data We Collect</a>
    <a href="#data-usage" class="sidebar-link">3. How We Use Data</a>
    <a href="#sos-protocol" class="sidebar-link">4. SOS Protocol Data</a>
    <a href="#data-security" class="sidebar-link">5. Data Security</a>
    <a href="#your-rights" class="sidebar-link">6. Your Privacy Rights</a>
  </aside>

  <div class="policy-content-wrapper reveal">
    <div class="last-updated">Last Updated: May 10, 2026</div>

    <div class="policy-block" id="introduction">
      <h2>1. Introduction</h2>
      <p>Welcome to <strong>SheSecure – SafeRoute AI</strong>, developed by Team Coffee To Code. We are fundamentally committed to protecting the privacy and security of our users. Because our application deals with sensitive location and safety data, we have designed our entire architecture around a <strong>Privacy-First, Zero-Knowledge</strong> philosophy.</p>
    </div>

    <div class="policy-block" id="data-collection">
      <h2>2. Data We Collect</h2>
      <p>We strictly practice data minimization—we only collect what is absolutely necessary.</p>
      <ul class="policy-list">
        <li><i class="ph-fill ph-check-circle"></i> <strong>Account Information:</strong> Name, email, and secure profile picture.</li>
        <li><i class="ph-fill ph-check-circle"></i> <strong>Location Data (Ephemeral):</strong> GPS coordinates are collected <em>only</em> during active use of navigation or SOS features.</li>
        <li><i class="ph-fill ph-check-circle"></i> <strong>Emergency Contacts:</strong> Names and numbers of your designated "Guardians".</li>
      </ul>
    </div>

    <div class="policy-block" id="data-usage">
      <h2>3. How We Use Your Data</h2>
      <p>Your data is used solely to operate the ecosystem, calculate safe paths, and notify guardians.</p>
      <div class="highlight-box">
        <p><strong>Zero Data-Selling Promise:</strong> We never sell or monetize your personal information to third parties.</p>
      </div>
    </div>

    <div class="policy-block" id="sos-protocol">
      <h2>4. SOS Protocol & Emergency Data</h2>
      <p>When you trigger SOS, standard privacy protocols are temporarily overridden for your safety:</p>
      <ul class="policy-list">
        <li><i class="ph-fill ph-siren"></i> <strong>Location Dispatch:</strong> E2EE location is transmitted to Guardians.</li>
        <li><i class="ph-fill ph-police-car"></i> <strong>Authority Alert:</strong> GPS and identity tokens are sent to local law enforcement.</li>
      </ul>
    </div>

    <div class="policy-block" id="data-security">
      <h2>5. Data Security & Encryption</h2>
      <ul class="policy-list">
        <li><i class="ph-fill ph-shield-check"></i> <strong>End-to-End Encryption (E2EE):</strong> Location sharing uses AES-256 bit encryption.</li>
        <li><i class="ph-fill ph-file-dashed"></i> <strong>Ephemeral Processing:</strong> Data is deleted immediately after a route is completed; we do not store long-term logs.</li>
      </ul>
    </div>

    <div class="policy-block" id="your-rights">
      <h2>6. Your Privacy Rights</h2>
      <p>In accordance with global privacy laws, you retain full ownership of your data.</p>
      <p>Contact our Data Protection Officer at <a href="mailto:official.shesecure@gmail.com" style="color:var(--rose); text-decoration:none; font-weight:600;">official.shesecure@gmail.com</a>.</p>
    </div>
  </div>
</section>

<?php include 'Include/footer.php'; ?>

<script>
  window.addEventListener('load', () => {
    setTimeout(() => { document.getElementById('preloader').classList.add('preloader-hidden'); }, 600); 
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

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    if (window.scrollY > 50) nav.classList.add('scrolled'); else nav.classList.remove('scrolled');
  });

  const sections = document.querySelectorAll('.policy-block');
  const navLinks = document.querySelectorAll('.sidebar-link');
  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => { if (pageYOffset >= (section.offsetTop - 200)) { current = section.getAttribute('id'); } });
    navLinks.forEach(link => { link.classList.remove('active'); if (link.getAttribute('href').includes(current) && current !== "") { link.classList.add('active'); } });
  });
</script>

<script src="Include/content-protection.js"></script>

</body>
</html>