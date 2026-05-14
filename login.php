<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Login – SheSecure | Team Coffee To Code</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  :root {
    --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A;
    --blush: #F2B8BC; --charcoal: #1C1116; --white: #FFFFFF;
    --safe-green: #2A9D5C; --warn-amber: #E9A227;
    --graceful: cubic-bezier(0.4, 0, 0.2, 1);
  }

  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: var(--white); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; }

  /* ─── PRELOADER ─── */
  #preloader { position: fixed; inset: 0; background: var(--charcoal); z-index: 999999; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.8s var(--graceful), visibility 0.8s var(--graceful); }
  .loader-icon { font-size: 4rem; color: var(--rose-light); margin-bottom: 1.5rem; animation: pulse-loader 1.5s infinite alternate var(--graceful); }
  @keyframes pulse-loader { 0% { transform: scale(0.85); opacity: 0.6; } 100% { transform: scale(1.15); opacity: 1; } }
  .preloader-hidden { opacity: 0; visibility: hidden; }

  /* ─── AMBIENT BACKGROUND ─── */
  .ambient-bg { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; overflow: hidden; pointer-events: none; }
  .blob { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.15; animation: float-blob 15s infinite alternate var(--graceful); }
  .blob-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: var(--rose-light); }
  .blob-2 { bottom: -20%; right: -10%; width: 60vw; height: 60vw; background: var(--blush); animation-delay: -5s; }
  @keyframes float-blob { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(30px, -50px) scale(1.1); } }

  /* ─── NAV ─── */
  nav { position: absolute; top: 0; left: 0; right: 0; z-index: 1000; display: flex; align-items: center; justify-content: space-between; padding: 2rem 5rem; }
  .nav-logo { display: flex; align-items: center; gap: .6rem; font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: white; text-decoration: none; }
  .nav-logo span { color: var(--rose-light); }
  .logo-icon { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; }

  /* ─── LOGIN CONTAINER ─── */
  .auth-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 8rem 2rem 4rem; z-index: 2; }
  .auth-card { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 30px; width: 100%; max-width: 480px; padding: 3.5rem 3rem; box-shadow: 0 30px 60px rgba(0,0,0,0.4); animation: fadeIn 0.8s var(--graceful); }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

  .auth-header { margin-bottom: 2.5rem; text-align: center; }
  .auth-header h1 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 0.5rem; color: white; }
  .auth-header p { color: rgba(255,255,255,0.6); font-size: 1rem; }

  .form-group { display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.5rem; position: relative; }
  .form-group label { display: flex; justify-content: space-between; font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.8); text-transform: uppercase; }
  .forgot-link { color: var(--rose-light); text-transform: none; text-decoration: none; transition: 0.3s;}
  .forgot-link:hover { color: white; }
  
  .input-wrapper { position: relative; display: flex; align-items: center; }
  .input-icon { position: absolute; left: 1.2rem; color: rgba(255,255,255,0.4); font-size: 1.2rem; pointer-events: none; }
  .form-input { width: 100%; padding: 1rem 1.2rem 1rem 3rem; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; font-family: 'DM Sans', sans-serif; font-size: 1rem; color: white; outline: none; transition: 0.3s; }
  .form-input:focus { background: rgba(0,0,0,0.4); border-color: var(--rose-light); }
  .pass-toggle { position: absolute; right: 1.2rem; color: rgba(255,255,255,0.4); font-size: 1.2rem; cursor: pointer; transition: 0.3s;}
  .pass-toggle:hover { color: white; }

  .btn-primary { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; width: 100%; border: none; padding: 1.2rem; border-radius: 50px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1rem; }
  .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(192,57,75,0.5); }

  .auth-footer { text-align: center; margin-top: 2.5rem; color: rgba(255,255,255,0.6); }
  .auth-footer a { color: var(--rose-light); font-weight: 700; text-decoration: none; }
  .auth-footer a:hover { color: white; text-decoration: underline; }

  /* Error Toast */
  #toast { position: fixed; top: 2rem; right: 2rem; padding: 1rem 2rem; border-radius: 50px; background: var(--warn-amber); color: #1C1116; font-weight: 600; transform: translateY(-100px); opacity: 0; transition: 0.5s; z-index: 9999; display: flex; align-items: center; gap: 10px; }
  #toast.show { transform: translateY(0); opacity: 1; }

  @media (max-width: 768px) { nav { padding: 1.5rem; } .auth-wrapper { padding: 6rem 1.5rem 2rem; } .auth-card { padding: 2.5rem 1.5rem; border-radius: 24px; } }
</style>
</head>
<body>

<div id="preloader"><i class="ph-fill ph-lock-key loader-icon"></i></div>
<div class="ambient-bg"><div class="blob blob-1"></div><div class="blob blob-2"></div></div>
<div id="toast"><i class="ph-bold ph-warning-circle"></i> <span id="toastMsg"></span></div>

<nav>
  <a class="nav-logo" href="index.php">
    <div class="logo-icon"><i class="ph-fill ph-gender-female"></i></div>
    She<span>Secure</span>
  </a>
</nav>

<div class="auth-wrapper">
  <div class="auth-card">
    <div class="auth-header">
      <h1>Welcome Back</h1>
      <p>Enter your credentials to access your secure dashboard.</p>
    </div>

    <form id="loginForm">
      <div class="form-group">
        <label>Email Address</label>
        <div class="input-wrapper">
          <i class="ph-fill ph-user input-icon"></i>
          <input type="email" name="email" id="email" class="form-input" placeholder="e.g. user@example.com" required>
        </div>
      </div>
      
      <div class="form-group">
        <label><span>Master Password</span> <a href="forgot-password.php" class="forgot-link">Forgot?</a></label>
        <div class="input-wrapper">
          <i class="ph-fill ph-lock-key input-icon"></i>
          <input type="password" name="password" id="password" class="form-input" placeholder="Enter your password" required>
          <i class="ph-fill ph-eye pass-toggle" id="togglePassword" onclick="togglePasswordVisibility()"></i>
        </div>
      </div>

      <button type="submit" class="btn-primary" id="loginBtn">Sign In <i class="ph-bold ph-arrow-right"></i></button>
    </form>
    
    <div class="auth-footer">
      Don't have an account? <a href="signup.php">Create one here</a>
    </div>
  </div>
</div>

<script>
  window.addEventListener('load', () => { setTimeout(() => { document.getElementById('preloader').classList.add('preloader-hidden'); }, 600); });

  function togglePasswordVisibility() {
    const passInput = document.getElementById('password');
    const toggleIcon = document.getElementById('togglePassword');
    if (passInput.type === 'password') { passInput.type = 'text'; toggleIcon.classList.replace('ph-eye', 'ph-eye-slash'); } 
    else { passInput.type = 'password'; toggleIcon.classList.replace('ph-eye-slash', 'ph-eye'); }
  }

  // --- Real Backend AJAX Submission ---
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('loginBtn');
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMsg');
    
    btn.innerHTML = `<i class="ph-bold ph-spinner ph-spin"></i> Decrypting...`;
    btn.style.pointerEvents = 'none';

    fetch('process_login.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(response => response.json())
    .then(data => {
        if(data.status === 'success') {
            btn.innerHTML = `<i class="ph-bold ph-check"></i> Access Granted`;
            btn.style.background = 'var(--safe-green)';
            btn.style.boxShadow = '0 10px 25px rgba(42,157,92,0.4)';
            
            // Redirect to dashboard securely
            setTimeout(() => { window.location.href = data.redirect; }, 1000);
        } else {
            // Show error
            toastMsg.innerText = data.message;
            toast.style.background = 'var(--warn-amber)';
            toast.classList.add('show');
            
            btn.innerHTML = `Sign In <i class="ph-bold ph-arrow-right"></i>`;
            btn.style.pointerEvents = 'auto';
            
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }
    })
    .catch(error => {
        toastMsg.innerText = "Connection error. Please try again.";
        toast.classList.add('show');
        btn.innerHTML = `Sign In <i class="ph-bold ph-arrow-right"></i>`;
        btn.style.pointerEvents = 'auto';
        setTimeout(() => { toast.classList.remove('show'); }, 3000);
    });
  });
</script>
</body>
</html>