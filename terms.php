<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Terms and Conditions – SheSecure | Team Coffee To Code</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,600;1,300;1,600&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  /* =========================================
     GLOBAL THEME & RESET
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
  @keyframes pulse-loader { 0% { transform: scale(0.85); opacity: 0.6; } 100% { transform: scale(1.15); opacity: 1; } }
  .preloader-hidden { opacity: 0; visibility: hidden; }

  /* ─── AMBIENT BACKGROUND ─── */
  .ambient-bg { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; overflow: hidden; pointer-events: none; background: var(--cream); }
  .blob { position: absolute; border-radius: 50%; filter: blur(90px); opacity: 0.3; animation: float-blob 15s infinite alternate var(--graceful); }
  .blob-1 { top: -10%; left: -10%; width: 45vw; height: 45vw; background: var(--blush); }
  .blob-2 { bottom: -20%; right: -10%; width: 55vw; height: 55vw; background: rgba(192, 57, 75, 0.05); animation-delay: -5s; }
  @keyframes float-blob { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(40px, -60px) scale(1.1); } }

  /* ─── NAV ─── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000;
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 5rem; background: rgba(255, 247, 245, 0.8);
    backdrop-filter: blur(20px); border-bottom: 1px solid rgba(192,57,75,0.05); transition: all 0.4s var(--graceful);
  }
  nav.scrolled { padding: 0.8rem 5rem; background: rgba(255, 247, 245, 0.98); box-shadow: 0 10px 40px rgba(192, 57, 75, 0.05); }
  .nav-logo { display: flex; align-items: center; gap: .6rem; font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: var(--charcoal); text-decoration: none; }
  .nav-logo span { color: var(--rose); }
  .logo-icon { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; }
  .nav-actions { display: flex; gap: 1.5rem; align-items: center; }
  .btn-login { text-decoration: none; font-size: 1rem; font-weight: 700; color: var(--charcoal); position: relative; }
  .btn-signup { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; border: none; padding: .7rem 2rem; border-radius: 50px; font-weight: 700; text-decoration: none; box-shadow: 0 6px 20px rgba(192,57,75,0.25); }

  /* ─── LEGAL HERO ─── */
  #legal-hero { background: var(--charcoal); color: white; padding: 12rem 5rem 6rem; position: relative; z-index: 2; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1); }
  .legal-badge { display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(255,255,255,0.05); color: var(--blush); padding: 0.5rem 1.2rem; border-radius: 50px; font-size: 0.85rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 2rem; border: 1px solid rgba(255,255,255,0.1); }
  .legal-title { font-family: 'Playfair Display', serif; font-size: clamp(3rem, 5vw, 5.5rem); line-height: 1.1; font-weight: 900; margin-bottom: 1rem; }
  .legal-title em { color: var(--rose-light); font-style: italic; }

  /* ─── CONTENT LAYOUT ─── */
  #legal-content { background: white; padding: 6rem 5rem; position: relative; z-index: 2; border-radius: 0 0 40px 40px; box-shadow: 0 20px 50px rgba(0,0,0,0.05); max-width: 1400px; margin: 0 auto; }
  .legal-header-meta { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--charcoal); padding-bottom: 1.5rem; margin-bottom: 4rem; }
  .legal-row { display: grid; grid-template-columns: 300px 1fr; gap: 4rem; border-bottom: 1px solid rgba(0,0,0,0.1); padding: 4rem 0; }
  .legal-col-left h2 { font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--charcoal); position: sticky; top: 120px; }
  .section-num { display: block; font-size: 0.85rem; font-weight: 700; color: var(--rose); margin-bottom: 0.5rem; letter-spacing: 0.1em; }
  .legal-col-right { font-size: 1.1rem; color: var(--muted); line-height: 1.8; }
  .legal-list { list-style: none; display: flex; flex-direction: column; gap: 1.2rem; margin: 2rem 0; }
  .legal-callout { background: var(--blush-soft); border-left: 4px solid var(--rose); padding: 2rem; border-radius: 0 16px 16px 0; margin: 2rem 0; }

  /* ─── FOOTER STYLES ─── */
  footer { background: #110A0D; padding: 5rem 5rem 3rem; display: flex; flex-direction: column; gap: 4rem; position: relative; z-index: 5; margin-top: 4rem;}
  .footer-top { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 4rem; }
  .footer-brand { font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 900; color: white; display: flex; align-items: center; gap: 0.6rem; margin-bottom: 1.2rem;}
  .footer-brand span { color: var(--rose-light); }
  .footer-tagline { font-size: 1rem; color: rgba(255,255,255,.6); line-height: 1.7; margin-bottom: 2rem;}
  .social-links { display: flex; gap: 1rem; }
  .social-links a { width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.05); color: white; display: flex; align-items: center; justify-content: center; text-decoration: none;}
  .footer-links-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 5rem; }
  .footer-col h4 { color: white; font-size: 1.15rem; margin-bottom: 1.5rem; font-family: 'Playfair Display', serif; }
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 1rem; }
  .footer-col a { color: rgba(255,255,255,.6); text-decoration: none; transition: 0.3s; }
  .footer-col a:hover { color: var(--rose-light); }
  .footer-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem; }

  .back-to-top { position: fixed; bottom: 2rem; right: 2rem; width: 50px; height: 50px; background: var(--charcoal); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; opacity: 0; visibility: hidden; transition: 0.3s; z-index: 999; }
  .back-to-top.visible { opacity: 1; visibility: visible; }

  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; }
    #legal-content { padding: 3rem 1.5rem; }
    .legal-row { grid-template-columns: 1fr; }
    .legal-col-left h2 { position: relative; top: 0; }
    .footer-links-grid { grid-template-columns: 1fr; }
  }
</style>
</head>
<body>

<div id="preloader">
  <i class="ph-fill ph-scales loader-icon"></i>
  <div class="loader-text">Loading Terms...</div>
</div>

<div class="ambient-bg">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
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

<section id="legal-hero">
  <div class="legal-badge reveal"><i class="ph-fill ph-gavel"></i> User Agreement</div>
  <h1 class="legal-title reveal">Terms and <em>Conditions</em></h1>
  <p class="legal-subtitle reveal">Please read these terms carefully. By accessing or using SheSecure, you agree to be bound by the terms outlined below.</p>
</section>

<section id="legal-content">
  <div class="legal-header-meta reveal">
    <span class="legal-updated">Last Updated: May 12, 2026</span>
    
  </div>

  <div class="legal-row reveal">
    <div class="legal-col-left">
      <span class="section-num">SECTION 01</span>
      <h2>Acceptance of Terms</h2>
    </div>
    <div class="legal-col-right">
      <p>By downloading, accessing, or using the <strong>SheSecure</strong> application and website provided by Team Coffee To Code, you agree to be bound by these Terms and Conditions.</p>
      <p>If you do not agree with any part of these terms, you must immediately cease use of our Services.</p>
    </div>
  </div>

  <div class="legal-row reveal">
    <div class="legal-col-left">
      <span class="section-num">SECTION 02</span>
      <h2>User Responsibilities</h2>
    </div>
    <div class="legal-col-right">
      <p>As a user of SheSecure, you commit to the following:</p>
      <ul class="legal-list">
        <li><i class="ph-fill ph-caret-right"></i> <strong>Accurate Information:</strong> You must provide up-to-date information for your Guardians.</li>
        <li><i class="ph-fill ph-caret-right"></i> <strong>No Misuse of SOS:</strong> Intentional triggering of false alarms is strictly prohibited.</li>
        <li><i class="ph-fill ph-caret-right"></i> <strong>Honest Reporting:</strong> Community incident reports must be truthful.</li>
      </ul>
    </div>
  </div>

  <div class="legal-row reveal">
    <div class="legal-col-left">
      <span class="section-num">SECTION 03</span>
      <h2>Emergency Services</h2>
    </div>
    <div class="legal-col-right">
      <p>SheSecure is a supplementary tool, <strong>not a replacement for official emergency services.</strong></p>
      <div class="legal-callout">
        <p>Notice: We do not guarantee response times from authorities. In life-threatening situations, always dial 911 or 112 directly.</p>
      </div>
    </div>
  </div>
</section>



<?php include 'Include/footer.php'; ?>

<script>
  window.addEventListener('load', () => {
    setTimeout(() => { document.getElementById('preloader').classList.add('preloader-hidden'); }, 600); 
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
  }, { threshold: 0.15 });
  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  window.addEventListener('scroll', () => {
    const nav = document.getElementById('navbar');
    const btt = document.getElementById('backToTop');
    if (window.scrollY > 50) nav.classList.add('scrolled'); else nav.classList.remove('scrolled');
    if (window.scrollY > 500) btt.classList.add('visible'); else btt.classList.remove('visible');
  });
</script>

<script src="Include/content-protection.js"></script>

</body>
</html>