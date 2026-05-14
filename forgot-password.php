<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Forgot Password – SheSecure</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  :root { --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A; --blush: #F2B8BC; --charcoal: #1C1116; --white: #FFFFFF; --safe-green: #2A9D5C; --warn-amber: #E9A227; --graceful: cubic-bezier(0.4, 0, 0.2, 1); }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: var(--white); overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; }

  /* Ambient Background */
  .ambient-bg { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; overflow: hidden; pointer-events: none; }
  .blob { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.15; animation: float-blob 15s infinite alternate var(--graceful); }
  .blob-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: var(--rose-light); }
  .blob-2 { bottom: -20%; right: -10%; width: 60vw; height: 60vw; background: var(--blush); animation-delay: -5s; }
  @keyframes float-blob { 0% { transform: translate(0, 0) scale(1); } 100% { transform: translate(30px, -50px) scale(1.1); } }

  /* Nav */
  nav { position: absolute; top: 0; left: 0; right: 0; z-index: 1000; display: flex; align-items: center; justify-content: space-between; padding: 2rem 5rem; }
  .nav-logo { display: flex; align-items: center; gap: .6rem; font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: white; text-decoration: none; }
  .nav-logo span { color: var(--rose-light); }
  .logo-icon { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; }

  /* Card Setup */
  .auth-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 8rem 2rem 4rem; z-index: 2; }
  .auth-card { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 30px; width: 100%; max-width: 480px; padding: 3.5rem 3rem; box-shadow: 0 30px 60px rgba(0,0,0,0.4); }
  
  .auth-header { margin-bottom: 2.5rem; text-align: center; }
  .lock-icon-wrapper { width: 60px; height: 60px; margin: 0 auto 1.5rem; background: rgba(192,57,75,0.1); border: 1px solid rgba(192,57,75,0.3); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--rose-light); font-size: 1.8rem; }
  .auth-header h1 { font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 0.8rem; color: white; }
  .auth-header p { color: rgba(255,255,255,0.6); font-size: 0.95rem; line-height: 1.5; }

  /* Form Elements */
  .form-group { display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.5rem; position: relative; }
  .form-group label { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.8); text-transform: uppercase; }
  .input-wrapper { position: relative; display: flex; align-items: center; }
  .input-icon { position: absolute; left: 1.2rem; color: rgba(255,255,255,0.4); font-size: 1.2rem; pointer-events: none; }
  .form-input { width: 100%; padding: 1rem 1.2rem 1rem 3rem; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; font-family: 'DM Sans', sans-serif; font-size: 1rem; color: white; transition: 0.3s; outline: none; }
  .form-input:focus { border-color: var(--rose-light); background: rgba(0,0,0,0.4); }
  
  .pass-toggle { position: absolute; right: 1.2rem; color: rgba(255,255,255,0.4); font-size: 1.2rem; cursor: pointer; transition: 0.3s;}
  .pass-toggle:hover { color: white; }

  /* Buttons */
  .btn-primary { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; width: 100%; border: none; padding: 1.2rem; border-radius: 50px; font-size: 1.05rem; font-weight: 700; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-top: 1rem; }
  .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 15px 35px rgba(192,57,75,0.5); }
  
  .auth-footer { text-align: center; margin-top: 2rem; font-size: 0.95rem; }
  .auth-footer a { color: var(--rose-light); text-decoration: none; font-weight: 700; transition: 0.3s; display: inline-flex; align-items: center; gap: 0.3rem;}
  .auth-footer a:hover { color: white; text-decoration: underline; }

  /* Password Validation Box */
  .pass-rules { display: flex; flex-wrap: wrap; gap: 0.8rem; margin-top: 0.5rem; list-style: none; display: none;}
  .rule-item { display: flex; align-items: center; gap: 0.4rem; font-size: 0.75rem; color: rgba(255,255,255,0.4); }
  .rule-item.valid { color: var(--safe-green); }

  /* Dynamic Steps */
  #step2 { display: none; animation: fadeIn 0.6s var(--graceful); }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

  /* Toast Notification */
  #toast { position: fixed; top: 2rem; right: 2rem; padding: 1rem 2rem; border-radius: 50px; background: var(--safe-green); color: white; font-weight: 600; transform: translateY(-100px); opacity: 0; transition: 0.5s; z-index: 9999; display: flex; align-items: center; gap: 10px; }
  #toast.show { transform: translateY(0); opacity: 1; }
  #toast.error { background: var(--warn-amber); color: #1C1116; }

  .error-shake { animation: shake 0.4s; border-color: #ff4757 !important; }
  @keyframes shake { 0%,100% { transform:translateX(0); } 25% { transform:translateX(-5px); } 75% { transform:translateX(5px); } }
</style>
</head>
<body>

<div class="ambient-bg"><div class="blob blob-1"></div><div class="blob blob-2"></div></div>
<div id="toast"><i class="ph-fill ph-bell-ringing"></i> <span id="toastMsg"></span></div>

<nav>
  <a class="nav-logo" href="index.php">
    <div class="logo-icon"><i class="ph-fill ph-gender-female"></i></div>
    She<span>Secure</span>
  </a>
</nav>

<div class="auth-wrapper">
  <div class="auth-card" id="authCard">
    
    <div class="auth-header">
      <div class="lock-icon-wrapper" id="headerIcon"><i class="ph-fill ph-lock-key"></i></div>
      <h1 id="headerTitle">Reset Password</h1>
      <p id="headerDesc">Enter your email address to receive a 12-character secure verification token.</p>
    </div>

    <form id="step1Form">
      <input type="hidden" name="action" value="request">
      <div class="form-group">
        <label>Secure Email Address</label>
        <div class="input-wrapper">
          <i class="ph-fill ph-envelope-simple input-icon"></i>
          <input type="email" id="email" name="email" class="form-input" placeholder="e.g. user@example.com" required>
        </div>
      </div>
      <button type="submit" class="btn-primary" id="requestBtn">Send Reset Token <i class="ph-bold ph-paper-plane-right"></i></button>
    </form>
    
    <form id="step2Form" style="display:none;">
      <input type="hidden" name="action" value="reset">
      <input type="hidden" name="email" id="hiddenEmail">
      
      <div class="form-group">
        <label>12-Character Token</label>
        <div class="input-wrapper">
          <i class="ph-fill ph-ticket input-icon"></i>
          <input type="text" name="token" class="form-input" placeholder="Paste your token here" required maxlength="12" style="letter-spacing: 2px; font-weight: bold; text-align: center; padding-left: 1.2rem;">
        </div>
      </div>

      <div class="form-group">
        <label>New Master Password</label>
        <div class="input-wrapper">
          <i class="ph-fill ph-lock-key input-icon"></i>
          <input type="password" id="new_password" name="new_password" class="form-input" placeholder="Create new password" required oninput="validatePassword()">
          <i class="ph-fill ph-eye pass-toggle" onclick="togglePass('new_password', this)"></i>
        </div>
      </div>

      <div class="form-group">
        <label>Re-Type Password</label>
        <div class="input-wrapper">
          <i class="ph-fill ph-lock-key input-icon"></i>
          <input type="password" id="confirm_password" class="form-input" placeholder="Confirm new password" required oninput="validatePassword()">
        </div>
      </div>

      <ul class="pass-rules" id="passRules">
        <li class="rule-item" id="rule-len"><i class="ph-bold ph-x"></i> 8+ chars</li>
        <li class="rule-item" id="rule-upper"><i class="ph-bold ph-x"></i> 1 Uppercase</li>
        <li class="rule-item" id="rule-lower"><i class="ph-bold ph-x"></i> 1 Lowercase</li>
        <li class="rule-item" id="rule-num"><i class="ph-bold ph-x"></i> 1 Number</li>
        <li class="rule-item" id="rule-sym"><i class="ph-bold ph-x"></i> 1 Symbol</li>
        <li class="rule-item" id="rule-match"><i class="ph-bold ph-x"></i> Match</li>
      </ul>

      <button type="submit" class="btn-primary" id="resetBtn" style="opacity: 0.5; pointer-events: none;">Update Password <i class="ph-bold ph-check-circle"></i></button>
    </form>

    <div class="auth-footer" id="footerContent">
      <a href="login.php"><i class="ph-bold ph-arrow-left"></i> Back to Login</a>
    </div>

  </div>
</div>

<script>
  function showToast(message, isError = false) {
    const toast = document.getElementById('toast');
    document.getElementById('toastMsg').innerText = message;
    if(isError) toast.classList.add('error'); else toast.classList.remove('error');
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 5000);
  }

  function togglePass(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('ph-eye'); icon.classList.toggle('ph-eye-slash');
  }

  let isPassValid = false;
  function validatePassword() {
    document.getElementById('passRules').style.display = 'flex';
    const p = document.getElementById('new_password').value;
    const c = document.getElementById('confirm_password').value;
    
    const rules = {
      len: p.length >= 8, upper: /[A-Z]/.test(p), lower: /[a-z]/.test(p),
      num: /[0-9]/.test(p), sym: /[^A-Za-z0-9]/.test(p), match: p === c && p.length > 0
    };

    isPassValid = true;
    for (const [key, valid] of Object.entries(rules)) {
      const el = document.getElementById(`rule-${key}`);
      const icon = el.querySelector('i');
      if(valid) { el.classList.add('valid'); icon.className = 'ph-fill ph-check-circle'; } 
      else { el.classList.remove('valid'); icon.className = 'ph-bold ph-x'; isPassValid = false; }
    }

    const resetBtn = document.getElementById('resetBtn');
    if (isPassValid) {
        resetBtn.style.opacity = '1'; resetBtn.style.pointerEvents = 'auto';
    } else {
        resetBtn.style.opacity = '0.5'; resetBtn.style.pointerEvents = 'none';
    }
  }

  // --- Submit Step 1: Request Token ---
  document.getElementById('step1Form').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('requestBtn');
    const email = document.getElementById('email').value;
    
    btn.innerHTML = `<i class="ph-bold ph-spinner ph-spin"></i> Securing Line...`;
    btn.style.pointerEvents = 'none';

    fetch('process_forgot.php', { method: 'POST', body: new FormData(this) })
    .then(res => res.json())
    .then(data => {
      if(data.status === 'success') {
        showToast("Email sent! Check your inbox and spam folder.");
        
        // Hide Step 1, Show Step 2
        document.getElementById('step1Form').style.display = 'none';
        document.getElementById('step2Form').style.display = 'block';
        document.getElementById('hiddenEmail').value = email;
        
        // Update Header Design
        document.getElementById('headerIcon').innerHTML = '<i class="ph-fill ph-envelope-open"></i>';
        document.getElementById('headerTitle').innerText = 'Enter Security Token';
        document.getElementById('headerDesc').innerText = `We sent a 12-character token to ${email}. It expires in 15 minutes.`;
      } else {
        showToast(data.message, true);
        btn.innerHTML = `Send Reset Token <i class="ph-bold ph-paper-plane-right"></i>`;
        btn.style.pointerEvents = 'auto';
      }
    });
  });

  // --- Submit Step 2: Verify & Update Password ---
  document.getElementById('step2Form').addEventListener('submit', function(e) {
    e.preventDefault();
    if (!isPassValid) return;

    const btn = document.getElementById('resetBtn');
    btn.innerHTML = `<i class="ph-bold ph-spinner ph-spin"></i> Verifying...`;
    btn.style.pointerEvents = 'none';

    fetch('process_forgot.php', { method: 'POST', body: new FormData(this) })
    .then(res => res.json())
    .then(data => {
      if(data.status === 'success') {
        
        // Morph to Success State
        document.getElementById('headerIcon').style.background = 'rgba(42, 157, 92, 0.1)';
        document.getElementById('headerIcon').style.borderColor = 'rgba(42, 157, 92, 0.3)';
        document.getElementById('headerIcon').style.color = 'var(--safe-green)';
        document.getElementById('headerIcon').innerHTML = '<i class="ph-fill ph-check-circle"></i>';
        
        document.getElementById('headerTitle').innerText = 'Password Updated';
        document.getElementById('headerDesc').innerText = 'Your master password has been successfully reset. You may now login.';
        
        document.getElementById('step2Form').style.display = 'none';
        document.getElementById('footerContent').innerHTML = `<a href="login.php" class="btn-primary" style="margin-top: 1rem;">Login to Dashboard <i class="ph-bold ph-arrow-right"></i></a>`;
      } else {
        showToast(data.message, true);
        btn.innerHTML = `Update Password <i class="ph-bold ph-check-circle"></i>`;
        btn.style.pointerEvents = 'auto';
      }
    });
  });
</script>
</body>
</html>