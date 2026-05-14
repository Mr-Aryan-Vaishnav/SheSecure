<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Contact Us – SheSecure | Team Coffee To Code</title>

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

  /* ─── TOAST NOTIFICATION ─── */
  .toast {
    position: fixed; bottom: 2rem; right: 2rem; background: rgba(28, 17, 22, 0.95); color: white;
    padding: 1rem 1.8rem; border-radius: 50px; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);
    box-shadow: 0 10px 40px rgba(0,0,0,0.3), 0 0 0 1px rgba(192,57,75,0.4);
    transform: translateY(100px); opacity: 0; transition: all 0.4s var(--graceful);
    z-index: 9999; display: flex; align-items: center; gap: 0.8rem; font-weight: 500; font-size: 0.95rem; 
  }
  .toast.show { transform: translateY(0); opacity: 1; }
  .toast i { color: var(--safe-green); font-size: 1.4rem; }
  .toast.error i { color: var(--warn-amber); }

  /* ─── NAV ─── */
  nav {
    position: fixed; top: 0; left: 0; right: 0; z-index: 1000; display: flex; align-items: center; justify-content: space-between;
    padding: 1.2rem 5rem; background: rgba(255, 247, 245, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
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

  /* ─── CONTACT HERO ─── */
  #contact-hero { min-height: 45vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; padding: 12rem 5rem 4rem; position: relative; z-index: 2; }
  .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: white; color: var(--rose-dark); padding: .5rem 1.2rem; border-radius: 50px; font-size: .85rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 2rem; border: 1px solid rgba(192,57,75,.1); box-shadow: 0 10px 30px rgba(192,57,75,0.05); }
  .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3rem, 5vw, 5rem); line-height: 1.1; font-weight: 900; color: var(--charcoal); margin-bottom: 1.5rem; }
  .hero-title em { color: var(--rose); font-style: italic; position: relative; display: inline-block; }
  .hero-title em::after { content: ''; position: absolute; bottom: 8px; left: 0; width: 100%; height: 8px; background: var(--blush); z-index: -1; opacity: 0.6; }
  .hero-subtitle { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-style: italic; color: var(--muted); max-width: 600px; line-height: 1.6; }

  /* ─── CONTACT LAYOUT ─── */
  #contact-section { padding: 4rem 5rem 8rem; position: relative; z-index: 2; display: grid; grid-template-columns: 1fr 1.5fr; gap: 4rem; max-width: 1200px; margin: 0 auto; align-items: start;}

  /* ─── CONTACT INFO ─── */
  .contact-info { display: flex; flex-direction: column; gap: 3rem; }
  .info-card { background: var(--glass-bg); backdrop-filter: blur(20px); border: 1px solid var(--glass-border); border-radius: 30px; padding: 2.5rem; box-shadow: 0 15px 40px rgba(0,0,0,0.03); transition: transform 0.4s var(--graceful); }
  .info-card:hover { transform: translateY(-5px); box-shadow: 0 20px 50px rgba(192,57,75,0.08); }
  .info-icon { width: 60px; height: 60px; background: var(--blush-soft); color: var(--rose-dark); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; margin-bottom: 1.5rem; border: 1px solid rgba(192,57,75,0.1); }
  .info-card h3 { font-family: 'Playfair Display', serif; font-size: 1.6rem; font-weight: 700; color: var(--charcoal); margin-bottom: 0.5rem; }
  .info-card p { font-size: 1.05rem; color: var(--muted); line-height: 1.6; }
  .info-card a { color: var(--rose); text-decoration: none; font-weight: 600; transition: color 0.3s;}
  .info-card a:hover { color: var(--rose-dark); text-decoration: underline;}

  /* ─── CONTACT FORM ─── */
  .contact-form-wrapper { background: white; border-radius: 40px; padding: 4rem; box-shadow: 0 30px 60px rgba(192,57,75,0.05); border: 1px solid rgba(192,57,75,0.05); }
  .form-header { margin-bottom: 2.5rem; }
  .form-header h2 { font-family: 'Playfair Display', serif; font-size: 2.5rem; color: var(--charcoal); margin-bottom: 0.5rem;}
  .form-header p { font-size: 1.05rem; color: var(--muted); }
  .contact-form { display: flex; flex-direction: column; gap: 1.5rem; }
  .form-group { display: flex; flex-direction: column; gap: 0.5rem; position: relative; }
  .form-group label { font-size: 0.9rem; font-weight: 700; color: var(--charcoal); text-transform: uppercase; letter-spacing: 0.05em; }
  .form-input { width: 100%; padding: 1.2rem 1.5rem; background: var(--cream); border: 1px solid rgba(192,57,75,0.1); border-radius: 16px; font-family: 'DM Sans', sans-serif; font-size: 1rem; color: var(--charcoal); transition: all 0.3s var(--graceful); outline: none; }
  .form-input:focus { background: white; border-color: var(--rose); box-shadow: 0 0 0 4px var(--blush-soft); }
  .form-input::placeholder { color: rgba(107, 74, 82, 0.5); }
  textarea.form-input { resize: vertical; min-height: 150px; }
  .btn-submit { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; border: none; padding: 1.2rem 2rem; border-radius: 50px; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: all .4s var(--graceful); display: flex; align-items: center; justify-content: center; gap: 0.8rem; box-shadow: 0 10px 30px rgba(192,57,75,0.25); border: 2px solid transparent; margin-top: 1rem; }
  .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 15px 40px rgba(192,57,75,.4); }

  /* ─── FOOTER BASE STYLES ─── */
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
    #contact-section { grid-template-columns: 1fr; }
    .contact-info { flex-direction: row; }
    .info-card { flex: 1; }
    .footer-top { grid-template-columns: 1fr; }
  }
  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; }
    #contact-hero { padding: 10rem 1.5rem 3rem; }
    #contact-section { padding: 2rem 1.5rem 6rem; gap: 2rem;}
    .contact-info { flex-direction: column; gap: 1.5rem;}
    .contact-form-wrapper { padding: 2.5rem 1.5rem; border-radius: 30px; }
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
  <i class="ph-fill ph-envelope-simple-open loader-icon"></i>
  <div class="loader-text">Connecting...</div>
</div>

<div class="ambient-bg">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>
  <div id="particles-container"></div>
</div>

<div id="toast" class="toast"></div>

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

<section id="contact-hero">
  <div class="hero-badge reveal"><i class="ph-fill ph-chat-circle-text"></i> We're Here To Listen</div>
  <h1 class="hero-title reveal">
    Get in <em>Touch</em>
  </h1>
  <p class="hero-subtitle reveal">
    Whether you have a question about the platform, want to partner with us, or need support with your account, our team is ready to help.
  </p>
</section>

<section id="contact-section">
  
  <div class="contact-info">
    <div class="info-card reveal">
      <div class="info-icon"><i class="ph-fill ph-paper-plane-tilt"></i></div>
      <h3>Email Us</h3>
      <p>For general inquiries, partnerships, and support.</p>
      <br>
      <a href="mailto:official.shesecure@gmail.com">official.shesecure@gmail.com</a>
    </div>

    <div class="info-card reveal" style="transition-delay: 0.1s;">
      <div class="info-icon"><i class="ph-fill ph-map-pin"></i></div>
      <h3>Headquarters</h3>
      <p>Operating and innovating from the heart of India.</p>
      <br>
      <p style="color:var(--charcoal); font-weight:600;">Indore, Madhya Pradesh<br>India</p>
    </div>
  </div>

  <div class="contact-form-wrapper reveal" style="transition-delay: 0.2s;">
    <div class="form-header">
      <h2>Send a Message</h2>
      <p>Fill out the form below and we'll get back to you within 24 hours.</p>
    </div>

    <form class="contact-form" id="contactForm" onsubmit="handleFormSubmit(event)">
      <div class="form-group">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" class="form-input" placeholder="e.g. Priya Sharma" required>
      </div>
      
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="form-input" placeholder="e.g. priya@example.com" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number</label>
        <input type="tel" id="phone" name="phone" class="form-input" placeholder="e.g. +91 9876543210" required>
      </div>

      <div class="form-group">
        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" class="form-input" placeholder="How can we help?" required>
      </div>
      
      <div class="form-group">
        <label for="message">Message</label>
        <textarea id="message" name="message" class="form-input" placeholder="Write your message here..." required></textarea>
      </div>

      <button type="submit" class="btn-submit">
        Send Message <i class="ph-bold ph-paper-plane-right"></i>
      </button>
    </form>
  </div>

</section>

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

  // --- Toast Notification Logic ---
  function showToast(message, icon = 'ph-check-circle', isError = false) {
    const toast = document.getElementById('toast');
    toast.innerHTML = `<i class="ph-fill ${icon}"></i> <span>${message}</span>`;
    
    if (isError) {
      toast.classList.add('error');
    } else {
      toast.classList.remove('error');
    }

    toast.classList.add('show');
    
    if(window.toastTimeout) clearTimeout(window.toastTimeout);
    window.toastTimeout = setTimeout(() => { toast.classList.remove('show'); }, 4000);
  }

  // --- Real Backend AJAX Form Submission ---
  function handleFormSubmit(event) {
    event.preventDefault(); 
    
    const form = event.target;
    const btn = form.querySelector('.btn-submit');
    const originalText = btn.innerHTML;
    
    // Set UI to loading state
    btn.innerHTML = `<i class="ph-bold ph-spinner ph-spin" style="animation: spin-slow 1s linear infinite;"></i> Sending...`;
    btn.style.opacity = '0.8';
    btn.style.pointerEvents = 'none';

    // Gather Form Data
    const formData = new FormData(form);

    // Send data to the PHP Processor securely
    fetch('process_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            showToast(data.message, 'ph-paper-plane-tilt');
            form.reset();
        } else {
            showToast(data.message, 'ph-warning-circle', true);
        }
    })
    .catch(error => {
        showToast('Something went wrong. Please try again.', 'ph-warning-circle', true);
    })
    .finally(() => {
        // Reset button UI
        btn.innerHTML = originalText;
        btn.style.opacity = '1';
        btn.style.pointerEvents = 'auto';
    });
  }
</script>

<script src="Include/content-protection.js"></script>

</body>
</html>