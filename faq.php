<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>FAQ – SheSecure | Team Coffee To Code</title>

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

  /* ─── FAQ HERO SECTION ─── */
  #faq-hero {
    min-height: 50vh; display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 12rem 5rem 6rem; position: relative; z-index: 2;
  }
  .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: white; color: var(--rose-dark); padding: .5rem 1.2rem; border-radius: 50px; font-size: .85rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 2rem; border: 1px solid rgba(192,57,75,.1); box-shadow: 0 10px 30px rgba(192,57,75,0.05); }
  .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3.5rem, 5vw, 5.5rem); line-height: 1.1; font-weight: 900; color: var(--charcoal); margin-bottom: 1.5rem; }
  .hero-title em { color: var(--rose); font-style: italic; position: relative; display: inline-block; }
  .hero-title em::after { content: ''; position: absolute; bottom: 8px; left: 0; width: 100%; height: 8px; background: var(--blush); z-index: -1; opacity: 0.6; }
  .hero-subtitle { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-style: italic; color: var(--muted); max-width: 600px; line-height: 1.6; }

  /* ─── FAQ CONTAINER & ACCORDION ─── */
  #faq-content { padding: 4rem 5rem 8rem; position: relative; z-index: 2; max-width: 1000px; margin: 0 auto; }
  
  .faq-category { margin-top: 4rem; margin-bottom: 1.5rem; font-family: 'Playfair Display', serif; font-size: 2rem; font-weight: 700; color: var(--charcoal); display: flex; align-items: center; gap: 1rem;}
  .faq-category i { color: var(--rose); font-size: 1.8rem; }
  
  .faq-list { display: flex; flex-direction: column; gap: 1rem; }
  
  .faq-item {
    background: white; border-radius: 20px; border: 1px solid rgba(192,57,75,0.1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.02); overflow: hidden; transition: all 0.3s var(--graceful);
  }
  .faq-item:hover { border-color: rgba(192,57,75,0.3); box-shadow: 0 15px 40px rgba(192,57,75,0.05); }
  
  .faq-question {
    padding: 1.8rem 2rem; width: 100%; text-align: left; background: transparent; border: none;
    display: flex; justify-content: space-between; align-items: center; cursor: pointer;
    font-family: 'DM Sans', sans-serif; font-size: 1.15rem; font-weight: 700; color: var(--charcoal);
    transition: color 0.3s var(--graceful);
  }
  .faq-question:hover { color: var(--rose); }
  
  .faq-icon {
    flex-shrink: 0; width: 32px; height: 32px; border-radius: 50%; background: var(--blush-soft);
    color: var(--rose-dark); display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; transition: transform 0.4s var(--graceful), background 0.4s;
  }
  
  .faq-item.active .faq-icon { transform: rotate(135deg); background: var(--rose); color: white; }
  .faq-item.active .faq-question { color: var(--rose); }
  
  .faq-answer {
    padding: 0 2rem; font-size: 1.05rem; color: var(--muted); line-height: 1.7;
    max-height: 0; overflow: hidden; transition: all 0.5s var(--graceful); opacity: 0;
  }
  .faq-item.active .faq-answer { padding-bottom: 2rem; opacity: 1; }
  .faq-answer strong { color: var(--charcoal); font-weight: 700; }

  /* ─── CTA SECTION ─── */
  .about-cta { text-align: center; margin: 0 5rem 6rem; padding: 6rem 3rem; background: linear-gradient(135deg, #1c1116 0%, #3d0e1e 100%); border-radius: 40px; color: white; position: relative; overflow: hidden; box-shadow: 0 30px 60px rgba(192,57,75,0.2); }
  .about-cta::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml;utf8,<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1.5" fill="rgba(255,255,255,0.05)"/></svg>'); pointer-events: none;}
  .about-cta h2 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 4vw, 3.5rem); margin-bottom: 1.5rem; position: relative; z-index: 2;}
  .about-cta p { font-size: 1.2rem; color: rgba(255,255,255,0.8); margin-bottom: 2.5rem; position: relative; z-index: 2; max-width: 600px; margin-left: auto; margin-right: auto;}
  
  .btn-cta-white { 
    background: white; color: var(--charcoal); padding: 1.2rem 3rem; border-radius: 50px; 
    font-size: 1.1rem; font-weight: 700; text-decoration: none;
    transition: all .4s var(--graceful); display: inline-flex; align-items: center; gap: .6rem; 
    position: relative; z-index: 2; box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
  }
  .btn-cta-white:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); color: var(--rose); }

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
  .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 1rem; }
  .footer-col a { color: rgba(255,255,255,.6); font-size: 0.95rem; text-decoration: none; transition: color .3s; font-weight: 500; }
  .footer-col a:hover { color: var(--rose-light); }
  .footer-bottom { display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2.5rem; flex-wrap: wrap; gap: 1rem; }
  .footer-copy { font-size: 0.9rem; color: rgba(255,255,255,.4); }

  /* ─── RESPONSIVE ─── */
  @media (max-width: 1024px) { .footer-top { grid-template-columns: 1fr; } }
  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; }
    #faq-hero { padding: 10rem 1.5rem 4rem; }
    #faq-content { padding: 2rem 1.5rem 6rem; }
    .faq-question { padding: 1.5rem; font-size: 1.05rem; }
    .faq-answer { padding: 0 1.5rem; font-size: 1rem; }
    .faq-item.active .faq-answer { padding-bottom: 1.5rem; }
    .about-cta { margin: 2rem 1.5rem; padding: 4rem 1.5rem; border-radius: 24px; }
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
  <i class="ph-fill ph-question loader-icon"></i>
  <div class="loader-text">Loading Knowledge...</div>
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

<section id="faq-hero">
  <div class="hero-badge reveal"><i class="ph-fill ph-info"></i> Support & Knowledge</div>
  <h1 class="hero-title reveal">
    Frequently Asked <em>Questions</em>
  </h1>
  <p class="hero-subtitle reveal">
    Everything you need to know about SheSecure AI, how we protect your data, and how our emergency systems work.
  </p>
</section>

<section id="faq-content">
  
  <div class="faq-category reveal"><i class="ph-fill ph-map-trifold"></i> Navigation & Routing</div>
  <div class="faq-list">
    
    <div class="faq-item reveal">
      <button class="faq-question">
        How does SheSecure AI determine if a path is safe?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p>Our proprietary AI Risk Engine calculates a dynamic <strong>Safety Score (0-100)</strong> by analyzing multiple data points in real-time. This includes historical crime data, current lighting infrastructure, street activity/crowd density, time of day, and verified community incident reports. Instead of finding the fastest route, the AI explicitly routes you through the highest-scoring zones.</p>
      </div>
    </div>

    <div class="faq-item reveal">
      <button class="faq-question">
        Does the app work if I lose my internet connection?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p>Yes. SheSecure AI features an <strong>Offline Safety Maps</strong> function. When you plan a route, the app automatically pre-caches the map data and the safety metrics for your entire corridor. If you lose signal in a tunnel or a dead zone, the app will continue to guide you accurately without interruption.</p>
      </div>
    </div>

  </div>

  <div class="faq-category reveal"><i class="ph-fill ph-siren"></i> Emergency & SOS Features</div>
  <div class="faq-list">
    
    <div class="faq-item reveal">
      <button class="faq-question">
        What exactly happens when I trigger the SOS button?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p>Pressing and holding the SOS button for 2 seconds initiates a silent alarm. The app instantly generates a secure, end-to-end encrypted live tracking link. Within <strong>3 seconds</strong>, this link is dispatched via SMS and Push Notification to your pre-selected Guardian contacts, and your exact GPS coordinates are forwarded to the nearest local police precinct.</p>
      </div>
    </div>

    <div class="faq-item reveal">
      <button class="faq-question">
        How does the Voice Trigger Activation work?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p>If your hands are full or you are unable to reach your phone, you can use Voice Trigger. You set a custom, discrete safe-word during onboarding. The app listens locally on your device (no audio is recorded or sent to the cloud) while active. If it detects your safe-word, it silently triggers the full SOS protocol.</p>
      </div>
    </div>

    <div class="faq-item reveal">
      <button class="faq-question">
        What is the Simulated Fake Call?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p>If you find yourself in an uncomfortable situation (like being followed or harassed), you can tap the Fake Call button. Your phone will simulate an incoming call with a realistic caller ID and ringtone. This provides a safe, non-escalating excuse to step away from the situation.</p>
      </div>
    </div>

  </div>

  <div class="faq-category reveal"><i class="ph-fill ph-lock-key"></i> Privacy & Data Security</div>
  <div class="faq-list">
    
    <div class="faq-item reveal">
      <button class="faq-question">
        Is my location constantly tracked by the company?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p><strong>Absolutely not.</strong> Team Coffee To Code operates on a strict zero-data-selling policy. Your location data is protected using AES-256 end-to-end encryption. The system only actively streams your location when you explicitly start a "Guardian Control" session or when you trigger an SOS alert.</p>
      </div>
    </div>

    <div class="faq-item reveal">
      <button class="faq-question">
        Are community reports anonymous?
        <div class="faq-icon"><i class="ph-bold ph-plus"></i></div>
      </button>
      <div class="faq-answer">
        <p>Yes. When you spot an unlit street, suspicious activity, or a broken sidewalk and drop a pin to warn others, your report is stripped of all personal identifiers before being added to the map. This protects you while still allowing the community to benefit from the alert.</p>
      </div>
    </div>

  </div>
</section>

<div class="about-cta reveal">
  <h2>Still have questions?</h2>
  <p>Our support team is available 24/7 to help you set up your guardians, understand our privacy protocols, or assist with your account.</p>
  <a href="contact.php" class="btn-cta-white">Contact Support <i class="ph-bold ph-envelope-simple"></i></a>
</div>


<?php include 'Include/footer.php'; ?>

<script>
  // --- Preloader & Particles Logic ---
  window.addEventListener('load', () => {
    setTimeout(() => {
      document.getElementById('preloader').classList.add('preloader-hidden');
    }, 600); 

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

  // --- FAQ Accordion Logic ---
  const faqItems = document.querySelectorAll('.faq-item');
  
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    const answer = item.querySelector('.faq-answer');
    
    question.addEventListener('click', () => {
      const isActive = item.classList.contains('active');
      
      // Close all other open items
      faqItems.forEach(otherItem => {
        if (otherItem !== item) {
          otherItem.classList.remove('active');
          otherItem.querySelector('.faq-answer').style.maxHeight = null;
        }
      });
      
      // Toggle current item
      if (!isActive) {
        item.classList.add('active');
        answer.style.maxHeight = answer.scrollHeight + 50 + "px"; 
      } else {
        item.classList.remove('active');
        answer.style.maxHeight = null;
      }
    });
  });
</script>

<script src="Include/content-protection.js"></script>

</body>
</html>