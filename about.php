<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>About Us – SheSecure | Team Coffee To Code</title>

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

  /* ─── ABOUT HERO SECTION ─── */
  #about-hero {
    min-height: 80vh; display: flex; flex-direction: column; align-items: center; justify-content: center;
    text-align: center; padding: 10rem 5rem 5rem; position: relative; z-index: 2;
  }
  .hero-badge { display: inline-flex; align-items: center; gap: .5rem; background: white; color: var(--rose-dark); padding: .5rem 1.2rem; border-radius: 50px; font-size: .85rem; font-weight: 700; letter-spacing: .05em; text-transform: uppercase; margin-bottom: 2rem; border: 1px solid rgba(192,57,75,.1); box-shadow: 0 10px 30px rgba(192,57,75,0.05); }
  .hero-badge i { font-size: 1.2rem; color: var(--rose); animation: pulse-icon 2s infinite; }
  @keyframes pulse-icon { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.2); } }
  .hero-title { font-family: 'Playfair Display', serif; font-size: clamp(3.5rem, 6vw, 6.5rem); line-height: 1.1; font-weight: 900; color: var(--charcoal); margin-bottom: 1.5rem; max-width: 900px; }
  .hero-title em { color: var(--rose); font-style: italic; position: relative; display: inline-block; }
  .hero-title em::after { content: ''; position: absolute; bottom: 10px; left: 0; width: 100%; height: 10px; background: var(--blush); z-index: -1; opacity: 0.6; }
  .hero-subtitle { font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; font-style: italic; color: var(--muted); max-width: 600px; line-height: 1.6; }

  /* ─── SECTIONS COMMON ─── */
  section { padding: 6rem 5rem; position: relative; z-index: 2; }
  .section-label { display: inline-flex; align-items: center; gap: .8rem; font-size: .85rem; font-weight: 700; letter-spacing: .15em; text-transform: uppercase; color: var(--rose); margin-bottom: 1.2rem; }
  .section-label::before { content: ''; width: 40px; height: 2px; background: var(--rose); }
  .section-title { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 4vw, 3.5rem); font-weight: 900; line-height: 1.15; color: var(--charcoal); margin-bottom: 1.5rem; }
  .section-title em { color: var(--rose); font-style: italic; }

  /* ─── OUR STORY ─── */
  #our-story { display: grid; grid-template-columns: 1fr 1fr; gap: 6rem; align-items: center; }
  .story-text p { font-size: 1.15rem; color: var(--muted); line-height: 1.8; margin-bottom: 1.5rem; }
  .story-text p strong { color: var(--charcoal); font-weight: 700; }
  .story-visual { position: relative; width: 100%; height: 500px; display: flex; align-items: center; justify-content: center; }
  .story-orbit { position: absolute; width: 350px; height: 350px; border-radius: 50%; border: 1px dashed rgba(192,57,75,0.4); animation: spin-orbit 20s linear infinite; }
  .story-orbit::before { content: ''; position: absolute; top: -10px; left: 50%; transform: translateX(-50%); width: 20px; height: 20px; background: var(--rose); border-radius: 50%; box-shadow: 0 0 20px var(--rose); }
  .story-orbit-2 { position: absolute; width: 250px; height: 250px; border-radius: 50%; border: 1px solid rgba(192,57,75,0.2); animation: spin-orbit-reverse 15s linear infinite; }
  .story-orbit-2::after { content: ''; position: absolute; bottom: -8px; right: 20%; width: 15px; height: 15px; background: var(--warn-amber); border-radius: 50%; box-shadow: 0 0 15px var(--warn-amber); }
  .story-center { width: 120px; height: 120px; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3.5rem; z-index: 5; box-shadow: 0 20px 50px rgba(192,57,75,0.4); animation: pulse-core 3s infinite alternate ease-in-out; border: 4px solid white; }
  @keyframes spin-orbit { 100% { transform: rotate(360deg); } }
  @keyframes spin-orbit-reverse { 100% { transform: rotate(-360deg); } }
  @keyframes pulse-core { 0% { transform: scale(0.95); box-shadow: 0 10px 30px rgba(192,57,75,0.3); } 100% { transform: scale(1.05); box-shadow: 0 25px 60px rgba(192,57,75,0.6); } }

  /* ─── CORE VALUES ─── */
  #core-values { background: rgba(255,255,255,0.5); border-top: 1px solid rgba(192,57,75,0.05); border-bottom: 1px solid rgba(192,57,75,0.05); }
  .values-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; margin-top: 4rem; }
  .value-card { background: white; border-radius: 30px; padding: 3rem 2rem; text-align: center; border: 1px solid rgba(192,57,75,0.08); transition: all 0.5s var(--graceful); position: relative; overflow: hidden; }
  .value-card::before { content: ''; position: absolute; bottom: 0; left: 0; width: 100%; height: 0; background: linear-gradient(to top, var(--blush-soft), transparent); transition: height 0.5s ease; z-index: 1; }
  .value-card:hover { transform: translateY(-15px); box-shadow: 0 30px 60px rgba(192,57,75,0.1); border-color: rgba(192,57,75,0.3); }
  .value-card:hover::before { height: 100%; }
  .value-icon { position: relative; z-index: 2; width: 80px; height: 80px; margin: 0 auto 1.5rem; background: var(--cream); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: var(--rose); transition: all 0.4s; border: 1px solid rgba(192,57,75,0.1); }
  .value-card:hover .value-icon { background: var(--rose); color: white; transform: scale(1.1) rotate(10deg); box-shadow: 0 15px 30px rgba(192,57,75,0.3); }
  .value-card h3 { position: relative; z-index: 2; font-size: 1.3rem; font-weight: 700; color: var(--charcoal); margin-bottom: 1rem; }
  .value-card p { position: relative; z-index: 2; font-size: 1rem; color: var(--muted); line-height: 1.6; }

  /* ─── LEADERSHIP / ORIGINS ─── */
  #leadership { display: flex; flex-direction: column; align-items: center; text-align: center; }
  .leader-container { 
    margin-top: 4rem; display: flex; flex-wrap: wrap; gap: 4rem; justify-content: center; align-items: center; background: white; 
    border-radius: 40px; padding: 4rem 5rem; box-shadow: 0 30px 60px rgba(0,0,0,0.04); 
    border: 1px solid rgba(192,57,75,0.05); max-width: 1100px; text-align: left; position: relative; 
    overflow: hidden;
  }
  .leader-container::after { 
    content: ''; position: absolute; right: 0; top: 0; width: 100%; height: 100%; 
    border-radius: 40px; background: radial-gradient(circle at 90% 10%, var(--blush-soft) 0%, transparent 60%); 
    z-index: 1; pointer-events: none; 
  }
  .leader-avatar-wrapper { 
    position: relative; z-index: 2; flex-shrink: 0; 
    width: 320px; height: 320px; 
    display: flex; align-items: center; justify-content: center;
  }
  .leader-avatar { 
    width: 200px; height: 200px; border-radius: 50%; 
    background: linear-gradient(135deg, #1C1116, #3d2a33); 
    display: flex; align-items: center; justify-content: center; 
    font-size: 5rem; color: white; box-shadow: 0 20px 40px rgba(28,17,22,0.3); 
    position: relative; z-index: 3; border: 8px solid white; 
  }
  .avatar-ring { 
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    width: 240px; height: 240px; border-radius: 50%; border: 2px dashed var(--rose-light); 
    z-index: 1; animation: spin-slow-ring 15s linear infinite; pointer-events: none;
  }
  .avatar-ring-2 { 
    position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);
    border-radius: 50%; border: 1px solid rgba(192,57,75,0.2); 
    z-index: 1; animation: pulse-ring-fixed 3s infinite alternate; pointer-events: none;
  }
  @keyframes spin-slow-ring { 
    0% { transform: translate(-50%, -50%) rotate(0deg); } 
    100% { transform: translate(-50%, -50%) rotate(360deg); } 
  }
  @keyframes pulse-ring-fixed { 
    0% { width: 280px; height: 280px; opacity: 0.4;} 
    100% { width: 315px; height: 315px; opacity: 1;} 
  }
  .leader-info { position: relative; z-index: 2; flex: 1; min-width: 300px; }
  .leader-role { display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.15em; color: var(--rose); margin-bottom: 0.8rem; }
  .leader-name { font-family: 'Playfair Display', serif; font-size: 2.8rem; font-weight: 900; color: var(--charcoal); margin-bottom: 0.5rem; line-height: 1.1; }
  .leader-company { font-size: 1.2rem; font-weight: 600; color: var(--charcoal); margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem;}
  .leader-bio { font-size: 1.1rem; color: var(--muted); line-height: 1.7; margin-bottom: 1.5rem; }
  .leader-location { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--blush-soft); color: var(--rose-dark); padding: 0.6rem 1.2rem; border-radius: 50px; font-weight: 600; font-size: 0.9rem; }

  /* ─── CTA SECTION & MODAL TRIGGER ─── */
  .about-cta { text-align: center; margin: 4rem 5rem 6rem; padding: 6rem 3rem; background: linear-gradient(135deg, #1c1116 0%, #3d0e1e 100%); border-radius: 40px; color: white; position: relative; overflow: hidden; box-shadow: 0 30px 60px rgba(192,57,75,0.2); }
  .about-cta::before { content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: url('data:image/svg+xml;utf8,<svg width="30" height="30" xmlns="http://www.w3.org/2000/svg"><circle cx="2" cy="2" r="1.5" fill="rgba(255,255,255,0.05)"/></svg>'); pointer-events: none;}
  .about-cta h2 { font-family: 'Playfair Display', serif; font-size: clamp(2.5rem, 4vw, 3.5rem); margin-bottom: 1.5rem; position: relative; z-index: 2;}
  .about-cta p { font-size: 1.2rem; color: rgba(255,255,255,0.8); margin-bottom: 2.5rem; position: relative; z-index: 2; max-width: 600px; margin-left: auto; margin-right: auto;}
  .btn-cta-white { 
    background: white; color: var(--charcoal); padding: 1.2rem 3rem; border-radius: 50px; 
    font-size: 1.1rem; font-weight: 700; border: none; cursor: pointer;
    transition: all .4s var(--graceful); display: inline-flex; align-items: center; gap: .6rem; 
    position: relative; z-index: 2; box-shadow: 0 10px 30px rgba(0,0,0,0.3); 
  }
  .btn-cta-white:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,0.5); color: var(--rose); }

  /* ─── HOW IT WORKS POP-UP MODAL ─── */
  .modal-overlay {
    position: fixed; inset: 0; background: rgba(28, 17, 22, 0.85); backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
    z-index: 100000; display: flex; justify-content: center; align-items: flex-start;
    overflow-y: auto; padding: 4rem 2rem; opacity: 0; visibility: hidden; transition: all 0.4s var(--graceful);
  }
  .modal-overlay.open { opacity: 1; visibility: visible; }
  .modal-content {
    background: var(--cream); width: 100%; max-width: 1100px; border-radius: 40px;
    padding: 4rem; position: relative; transform: translateY(50px); transition: all 0.5s var(--graceful);
    box-shadow: 0 30px 80px rgba(0,0,0,0.5);
  }
  .modal-overlay.open .modal-content { transform: translateY(0); }
  .close-modal {
    position: absolute; top: 2rem; right: 2rem; background: rgba(192,57,75,0.1); color: var(--rose);
    border: none; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; cursor: pointer; transition: all 0.3s;
  }
  .close-modal:hover { background: var(--rose); color: white; transform: scale(1.1); }
  .modal-header .section-label { margin-bottom: 0.5rem; }
  .modal-header .section-title { font-size: 3rem; margin-bottom: 1rem; }
  .modal-header .section-sub { max-width: 500px; margin-bottom: 0;}
  .how-grid { display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 4rem; align-items: start; margin-top: 3rem; }
  .scenario-card { background: white; border-radius: 24px; padding: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.03); margin-bottom: 2rem; border: 1px solid rgba(192,57,75,0.05); }
  .scenario-num { display: inline-flex; width: 32px; height: 32px; background: var(--rose-dark); color: white; border-radius: 50%; align-items: center; justify-content: center; font-weight: bold; font-size: 0.9rem; margin-bottom: 1.2rem; box-shadow: 0 5px 15px rgba(192,57,75,0.3);}
  .scenario-card h3 { font-size: 1.3rem; color: var(--charcoal); margin-bottom: 0.5rem;}
  .scenario-card p { font-size: 0.95rem; color: var(--muted); line-height: 1.6;}
  .step-list { list-style: none; display: flex; flex-direction: column; gap: 0.8rem; margin-top: 1.5rem; }
  .step-list li { display: flex; align-items: center; gap: 1rem; font-size: 0.9rem; font-weight: 500; color: var(--muted); }
  .step-list li span { background: var(--blush-soft); color: var(--rose-dark); width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: bold; flex-shrink: 0;}
  .ai-engine-card { background: white; border-radius: 30px; padding: 3rem; box-shadow: 0 20px 50px rgba(0,0,0,0.05); position: sticky; top: 2rem; border: 1px solid rgba(192,57,75,0.05); }
  .ai-engine-card h3 { font-family: 'Playfair Display', serif; font-size: 1.8rem; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.8rem;}
  .ai-engine-card > p { font-size: 0.9rem; color: var(--muted); margin-bottom: 2rem;}
  .engine-core { background: linear-gradient(135deg, var(--rose-dark), var(--rose)); padding: 2rem; border-radius: 16px; color: white; text-align: center; margin: 2rem 0; box-shadow: 0 15px 30px rgba(192,57,75,0.2);}
  .engine-core small { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em; opacity: 0.8; }
  .engine-core h4 { font-family: 'Playfair Display', serif; font-size: 1.6rem; margin: 0.5rem 0;}
  .engine-core p { font-size: 0.8rem; opacity: 0.8; margin:0;}
  .score-section h5 { font-size: 0.9rem; color: var(--charcoal); margin-bottom: 0.8rem;}
  .score-bar-wrapper { display: flex; gap: 5px; height: 8px; border-radius: 4px; overflow: hidden; margin-bottom: 0.8rem;}
  .score-seg { flex: 1; }
  .score-labels { display: flex; justify-content: space-between; font-size: 0.7rem; font-weight: 600;}
  .ai-outputs { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-top: 2rem;}
  .output-chip { background: rgba(42, 157, 92, 0.05); border: 1px solid rgba(42, 157, 92, 0.2); color: #1e663a; padding: 0.8rem; border-radius: 12px; font-size: 0.85rem; font-weight: 600; display: flex; align-items: center; gap: 0.5rem;}
  .output-chip i { font-size: 1.2rem; }

  /* ─── FOOTER (FIXES ISSUE) ─── */
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
  @media (max-width: 1200px) {
    #our-story { grid-template-columns: 1fr; text-align: center; gap: 4rem; }
    .story-visual { order: -1; }
    .leader-container { padding: 3rem; }
  }
  @media (max-width: 1024px) {
    .values-grid { grid-template-columns: repeat(2, 1fr); }
    .footer-top { grid-template-columns: 1fr; }
    .how-grid { grid-template-columns: 1fr; }
    .leader-container { flex-direction: column; text-align: center; } 
  }
  @media (max-width: 768px) {
    nav { padding: 1rem 1.5rem; }
    .nav-actions { display: none; }
    section { padding: 4rem 1.5rem; }
    #about-hero { padding: 8rem 1.5rem 4rem; }
    .values-grid { grid-template-columns: 1fr; }
    
    .leader-container { padding: 2.5rem 1.5rem; gap: 2rem; }
    .leader-avatar-wrapper { width: 260px; height: 260px; }
    .leader-avatar { width: 160px; height: 160px; font-size: 4rem; }
    @keyframes pulse-ring-fixed { 
      0% { width: 220px; height: 220px; opacity: 0.4; transform: translate(-50%, -50%);} 
      100% { width: 250px; height: 250px; opacity: 1; transform: translate(-50%, -50%);} 
    }
    .avatar-ring { width: 200px; height: 200px; }
    .footer-links-grid { grid-template-columns: 1fr; gap: 2.5rem; }
    .about-cta { margin: 2rem 1.5rem; padding: 4rem 1.5rem; }
    .modal-content { padding: 2.5rem 1.5rem; }
    .ai-outputs { grid-template-columns: 1fr; }
  }

  .reveal { opacity: 0; transform: translateY(40px); transition: opacity 0.8s var(--graceful), transform 0.8s var(--graceful); }
  .reveal.visible { opacity: 1; transform: translateY(0); }
  .parallax { transition: transform 0.1s ease-out; }
</style>
</head>
<body>

<!-- PRELOADER -->
<div id="preloader">
  <i class="ph-fill ph-users-three loader-icon"></i>
  <div class="loader-text">Loading Our Story...</div>
</div>

<!-- AMBIENT BACKGROUND & PARTICLES -->
<div class="ambient-bg">
  <div class="blob blob-1"></div>
  <div class="blob blob-2"></div>
  <div class="blob blob-3"></div>
  <div id="particles-container"></div>
</div>

<!-- NAVIGATION -->
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

<!-- ABOUT HERO -->
<section id="about-hero">
  <div class="hero-badge reveal"><i class="ph-fill ph-leaf"></i> Driven By Purpose</div>
  <h1 class="hero-title reveal parallax" data-speed="1.5">
    Empowering Navigation.<br><em>Protecting Lives.</em>
  </h1>
  <p class="hero-subtitle reveal parallax" data-speed="1">
    We are bridging the gap between technology and personal safety, building tools that ensure no one has to walk home in fear.
  </p>
</section>

<!-- OUR STORY -->
<section id="our-story">
  <div class="story-text reveal">
    <div class="section-label">The Origin</div>
    <h2 class="section-title">Why we built<br><em>SheSecure</em></h2>
    <p>For decades, mapping and navigation technologies have been optimized for vehicles—focusing entirely on speed, traffic, and distance. <strong>But what happens when the fastest route isn't the safest?</strong></p>
    <p>Vulnerable groups, particularly women navigating cities at night, face realities that algorithms historically ignore: unlit streets, isolated alleys, and zones lacking public presence.</p>
    <p>We realized that a true navigation app must factor in human safety. By combining AI risk assessment, real-time community reporting, and instant emergency protocols, we built a digital guardian designed to protect the journey, not just calculate the destination.</p>
  </div>
  <div class="story-visual reveal parallax" data-speed="-1">
    <div class="story-orbit"></div>
    <div class="story-orbit-2"></div>
    <div class="story-center">
      <i class="ph-fill ph-shield-check"></i>
    </div>
  </div>
</section>

<!-- CORE VALUES -->
<section id="core-values">
  <div class="reveal" style="text-align: center;">
    <div class="section-label">What Drives Us</div>
    <h2 class="section-title">Our <em>Core Values</em></h2>
  </div>
  <div class="values-grid reveal">
    <div class="value-card">
      <div class="value-icon"><i class="ph-fill ph-lock-key"></i></div>
      <h3>Uncompromising Privacy</h3>
      <p>Your location data belongs to you. End-to-end encryption ensures that we protect your journey without exploiting your data.</p>
    </div>
    <div class="value-card">
      <div class="value-icon"><i class="ph-fill ph-heartbeat"></i></div>
      <h3>Empathy-Driven Design</h3>
      <p>We build features based on real-world experiences and fears, prioritizing emotional peace of mind alongside physical security.</p>
    </div>
    <div class="value-card">
      <div class="value-icon"><i class="ph-fill ph-lightning"></i></div>
      <h3>Rapid Innovation</h3>
      <p>In emergencies, every second counts. We continuously optimize our stack to ensure zero latency in SOS alert deliveries.</p>
    </div>
    <div class="value-card">
      <div class="value-icon"><i class="ph-fill ph-users-three"></i></div>
      <h3>Community First</h3>
      <p>Safety is collective. Our platform thrives on the shared intelligence of users looking out for one another on the streets.</p>
    </div>
  </div>
</section>

<!-- LEADERSHIP SECTION -->
<section id="leadership">
  <div class="reveal">
    <div class="section-label">Leadership</div>
    <h2 class="section-title">The Vision Behind<br><em>The Technology</em></h2>
  </div>
  
  <div class="leader-container reveal">
    
    <!-- FIX: Removed "parallax" class here so the cup stays precisely in the ring -->
    <div class="leader-avatar-wrapper">
      <!-- Fixed Absolute Center Rings -->
      <div class="avatar-ring"></div>
      <div class="avatar-ring-2"></div>
      <!-- Fixed Avatar -->
      <div class="leader-avatar"><i class="ph-fill ph-coffee"></i></div>
    </div>

    <div class="leader-info">
      <div class="leader-role"><i class="ph-fill ph-users-three"></i> The Creators</div>
      <h3 class="leader-name">Team Coffee To Code</h3>
      <div class="leader-company"><i class="ph-fill ph-code"></i> Innovators & Developers</div>
      <p class="leader-bio">
        Driven by a collective passion for creating technology that produces tangible, real-world impact, Team Coffee To Code leads the development of the SafeRoute AI ecosystem. Recognizing the critical lack of safety-focused algorithms in modern mapping tools, the team set out to build a proactive solution. 
      </p>
      <p class="leader-bio">
        As a dedicated group of developers, Team Coffee To Code bridges advanced AI, real-time data processing, and full-stack architecture to build platforms that prioritize human life and security above all else.
      </p>
      <div class="leader-location">
        <i class="ph-fill ph-map-pin"></i> Based in Indore, Madhya Pradesh
      </div>
    </div>
  </div>
</section>

<!-- CTA WITH MODAL TRIGGER -->
<div class="about-cta reveal">
  <h2>Join us in making every street safer.</h2>
  <p>Whether you're a user, a community advocate, or a city official, your participation helps build a world where navigation means protection.</p>
  <button onclick="openModal()" class="btn-cta-white">Discover How It Works <i class="ph-bold ph-arrow-right"></i></button>
</div>

<!-- HOW IT WORKS MODAL POPUP -->
<div id="howModal" class="modal-overlay">
  <div class="modal-content">
    <button class="close-modal" onclick="closeModal()"><i class="ph-bold ph-x"></i></button>
    
    <div class="modal-header">
      <div class="section-label">How It Works</div>
      <h2 class="section-title">Real-world <em>scenarios</em><br>powered by AI</h2>
      <p class="section-sub">See SafeRoute AI in action across three critical situations every woman may face.</p>
    </div>

    <div class="how-grid">
      
      <!-- Scenarios Column -->
      <div class="scenarios-col">
        <div class="scenario-card">
          <div class="scenario-num">1</div>
          <h3>Safe Night Navigation</h3>
          <p>AI analyzes three route options and guides you along the highest-safety path in real-time.</p>
          <ul class="step-list">
            <li><span>1</span> Open app, enter destination</li>
            <li><span>2</span> AI scores 3 route options</li>
            <li><span>3</span> Choose highest-safety route (Score: 87)</li>
            <li><span>4</span> Receive live incident alert midway</li>
            <li><span>5</span> App auto-reroutes to safer path</li>
            <li><span>6</span> Arrive safely — trip logged</li>
          </ul>
        </div>

        <div class="scenario-card">
          <div class="scenario-num">2</div>
          <h3>Emergency SOS Activation</h3>
          <p>One press triggers a cascade of safety actions — location sharing, auto-call, live tracking.</p>
          <ul class="step-list">
            <li><span>1</span> User feels threatened</li>
            <li><span>2</span> Press SOS button once</li>
            <li><span>3</span> 3-sec countdown to cancel</li>
            <li><span>4</span> GPS sent to trusted contacts</li>
            <li><span>5</span> Auto-call to emergency (112)</li>
            <li><span>6</span> Live location tracked until safe</li>
          </ul>
        </div>

        <div class="scenario-card">
          <div class="scenario-num">3</div>
          <h3>Community Incident Report</h3>
          <p>Spot something unsafe? Report it in seconds and protect every woman who follows.</p>
          <ul class="step-list">
            <li><span>1</span> Notice unsafe condition</li>
            <li><span>2</span> Tap 'Report Incident'</li>
            <li><span>3</span> Select type + add photo/note</li>
            <li><span>4</span> Report geotagged & submitted</li>
            <li><span>5</span> AI verifies & updates risk score</li>
            <li><span>6</span> Other users see updated alert</li>
          </ul>
        </div>
      </div>

      <!-- AI Engine Column -->
      <div class="ai-engine-col">
        <div class="ai-engine-card">
          <h3><i class="ph-fill ph-robot" style="color:var(--rose);"></i> AI Risk Analysis Engine</h3>
          <p>Multi-dimensional ML model continuously learning from real-world data</p>
          
          <div class="engine-core">
            <small>POWERED BY</small>
            <h4>AI / ML Risk Engine</h4>
            <p>Random Forest · LSTM · K-Means · NLP</p>
          </div>

          <div class="score-section">
            <h5>Safety Score</h5>
            <div class="score-bar-wrapper">
              <div class="score-seg" style="background:#C0394B;"></div>
              <div class="score-seg" style="background:#E9A227;"></div>
              <div class="score-seg" style="background:#27AE60; opacity:0.6;"></div>
              <div class="score-seg" style="background:#27AE60;"></div>
            </div>
            <div class="score-labels">
              <span style="color:#C0394B;">0–30 High Risk</span>
              <span style="color:#E9A227;">31–60 Moderate</span>
              <span style="color:#27AE60;">61–79 Low Risk</span>
              <span style="color:#27AE60;">80–100 Safe ✓</span>
            </div>
          </div>

          <div class="ai-outputs">
            <div class="output-chip"><i class="ph-fill ph-chart-bar"></i> Safety Score (0–100)</div>
            <div class="output-chip"><i class="ph-fill ph-map-trifold"></i> Risk Zone Heat Map</div>
            <div class="output-chip" style="background:rgba(233,162,39,0.1); color:#b37600; border-color:rgba(233,162,39,0.3);"><i class="ph-fill ph-bell-ringing"></i> Real-Time Alerts</div>
            <div class="output-chip" style="background:rgba(192,57,75,0.05); color:var(--rose); border-color:rgba(192,57,75,0.2);"><i class="ph-fill ph-warning-octagon"></i> Predictive Danger Flags</div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- INCLUDED EXTERNAL FOOTER -->
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

  // --- Modal Logic ---
  function openModal() {
    document.getElementById('howModal').classList.add('open');
    document.body.style.overflow = 'hidden'; 
  }
  
  function closeModal() {
    document.getElementById('howModal').classList.remove('open');
    document.body.style.overflow = 'auto'; 
  }

  document.getElementById('howModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
  });
</script>

<!-- INCLUDED CONTENT PROTECTION JS -->
<script src="Include/content-protection.js"></script>

</body>
</html>