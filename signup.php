<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Initialize Identity – SheSecure | Team Coffee To Code</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
<script src="https://unpkg.com/@phosphor-icons/web"></script>

<style>
  :root { --rose: #C0394B; --rose-dark: #8B1A2A; --rose-light: #E8697A; --blush: #F2B8BC; --charcoal: #1C1116; --safe-green: #2A9D5C; --warn-amber: #E9A227; --graceful: cubic-bezier(0.4, 0, 0.2, 1); }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: 'DM Sans', sans-serif; background: var(--charcoal); color: white; overflow-x: hidden; min-height: 100vh; display: flex; flex-direction: column; -webkit-user-select: none; user-select: none; }
  input, select { user-select: text; }

  /* ─── AMBIENT BACKGROUND ─── */
  .ambient-bg { position: fixed; inset: 0; z-index: -1; overflow: hidden; }
  .blob { position: absolute; border-radius: 50%; filter: blur(100px); opacity: 0.15; animation: float 15s infinite alternate var(--graceful); }
  .blob-1 { top: -10%; left: -10%; width: 50vw; height: 50vw; background: var(--rose-light); }
  @keyframes float { 0% { transform: translate(0, 0); } 100% { transform: translate(30px, -50px); } }

  /* ─── NAV ─── */
  nav { position: absolute; top: 0; left: 0; right: 0; z-index: 1000; display: flex; align-items: center; justify-content: space-between; padding: 2rem 5rem; }
  .nav-logo { display: flex; align-items: center; gap: .6rem; font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 900; color: white; text-decoration: none; }
  .nav-logo span { color: var(--rose-light); }
  .logo-icon { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--rose), var(--rose-dark)); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: white; }

  /* ─── SIGN UP CONTAINER ─── */
  .auth-wrapper { flex: 1; display: flex; align-items: center; justify-content: center; padding: 8rem 2rem 4rem; z-index: 2; }
  .auth-card { background: rgba(255,255,255,0.03); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.08); border-radius: 30px; width: 100%; max-width: 650px; padding: 3rem; box-shadow: 0 30px 60px rgba(0,0,0,0.4); position: relative; }

  /* Progress Bar */
  .progress-container { margin-bottom: 2.5rem; }
  .progress-bar { width: 100%; height: 6px; background: rgba(255,255,255,0.1); border-radius: 10px; overflow: hidden; margin-bottom: 1rem;}
  .progress-fill { height: 100%; background: linear-gradient(90deg, var(--rose), var(--rose-light)); width: 50%; transition: width 0.5s var(--graceful); }
  .step-indicators { display: flex; justify-content: space-between; font-size: 0.8rem; font-weight: 600; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 0.05em;}
  .step-ind.active { color: var(--rose-light); }

  .auth-header h1 { font-family: 'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 0.5rem; text-align: center;}
  .auth-header p { color: rgba(255,255,255,0.6); text-align: center; margin-bottom: 2rem;}

  /* ─── FORM ELEMENTS ─── */
  .form-step { display: none; animation: fadeIn 0.5s var(--graceful); }
  .form-step.active { display: block; }
  @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

  .form-group { display: flex; flex-direction: column; gap: 0.6rem; margin-bottom: 1.5rem; position: relative;}
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
  .form-group label { font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.8); text-transform: uppercase; letter-spacing: 0.05em; }
  
  .form-input, .form-select { width: 100%; padding: 1.1rem 1.2rem; background: rgba(0,0,0,0.2); border: 1px solid rgba(255,255,255,0.1); border-radius: 14px; font-family: 'DM Sans', sans-serif; font-size: 1rem; color: white; transition: 0.3s; outline: none;}
  .form-input:focus, .form-select:focus { background: rgba(0,0,0,0.4); border-color: var(--rose-light); }
  .form-input::placeholder { color: rgba(255,255,255,0.3); }

  /* File Upload */
  .file-upload-wrapper { position: relative; width: 100px; height: 100px; margin: 0 auto 1.5rem; border-radius: 50%; border: 2px dashed rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.2); cursor: pointer; transition: 0.3s; overflow: hidden;}
  .file-upload-wrapper:hover { border-color: var(--rose-light); }
  .file-upload-wrapper i { font-size: 2.5rem; color: rgba(255,255,255,0.5); }
  .preview-img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; display: none; }

  /* Password Validation */
  .pass-wrapper { position: relative; display: flex; align-items: center; }
  .pass-toggle { position: absolute; right: 1.2rem; color: rgba(255,255,255,0.4); font-size: 1.2rem; cursor: pointer; transition: 0.3s;}
  .pass-toggle:hover { color: white; }
  .pass-rules { display: flex; flex-wrap: wrap; gap: 0.8rem; margin-top: 0.5rem; list-style: none; }
  .rule-item { display: flex; align-items: center; gap: 0.4rem; font-size: 0.75rem; color: rgba(255,255,255,0.4); }
  .rule-item.valid { color: var(--safe-green); }

  /* Guardians */
  .guardian-block { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem; position: relative;}
  .guardian-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;}
  .btn-remove { background: transparent; border: none; color: var(--rose); cursor: pointer; font-size: 1.2rem;}
  .btn-add { background: rgba(255,255,255,0.05); border: 1px dashed rgba(255,255,255,0.2); color: white; width: 100%; padding: 1rem; border-radius: 14px; cursor: pointer; margin-bottom: 2rem;}

  /* Buttons */
  .auth-actions { display: flex; justify-content: space-between; gap: 1rem; margin-top: 2rem; }
  .btn { padding: 1.1rem 2rem; border-radius: 50px; font-size: 1rem; font-weight: 700; cursor: pointer; text-align: center; border: none; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: 0.3s; }
  .btn-outline { background: transparent; color: white; border: 1px solid rgba(255,255,255,0.2); }
  .btn-primary { background: linear-gradient(135deg, var(--rose), var(--rose-dark)); color: white; flex: 1; }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 25px rgba(192,57,75,0.4); }

  /* Toast & Shake */
  .error-shake { animation: shake 0.4s; border-color: #ff4757 !important; }
  @keyframes shake { 0%,100% { transform:translateX(0); } 25% { transform:translateX(-5px); } 75% { transform:translateX(5px); } }
  #toast { position:fixed; top:2rem; right:2rem; padding:1rem 2rem; border-radius:50px; background:var(--rose-dark); color:white; transform:translateY(-100px); transition:0.5s; opacity:0; z-index:9999; }
  #toast.show { transform:translateY(0); opacity:1; }

  @media (max-width: 768px) { nav { padding: 1.5rem; } .auth-wrapper { padding: 6rem 1.5rem 2rem; } .auth-card { padding: 2rem 1.5rem; } .form-row { grid-template-columns: 1fr; gap: 0; } }
</style>
</head>
<body>

<div class="ambient-bg"><div class="blob blob-1"></div></div>
<div id="toast"></div>

<nav>
  <a class="nav-logo" href="index.php">
    <div class="logo-icon"><i class="ph-fill ph-gender-female"></i></div>
    She<span>Secure</span>
  </a>
</nav>

<div class="auth-wrapper">
  <div class="auth-card">
    
    <div class="progress-container">
      <div class="progress-bar"><div class="progress-fill" id="progressFill"></div></div>
      <div class="step-indicators">
        <span class="step-ind active" id="ind-1">1. Profile Identity</span>
        <span class="step-ind" id="ind-2">2. Emergency Guardians</span>
      </div>
    </div>

    <form id="signupForm" enctype="multipart/form-data">
      
      <div class="form-step active" id="step-1">
        <div class="auth-header">
          <h1>Identity Setup</h1>
          <p>Your data is secured with AES-256 military-grade encryption.</p>
        </div>

        <div class="file-upload-wrapper" onclick="document.getElementById('profile_photo').click()">
          <i class="ph-fill ph-camera" id="uploadIcon"></i>
          <img src="" id="photoPreview" class="preview-img">
          <input type="file" id="profile_photo" name="profile_photo" style="display:none;" accept="image/*" onchange="previewImage(event)">
        </div>

        <div class="form-group"><label>Full Legal Name</label><input type="text" name="full_name" class="form-input" required></div>
        
        <div class="form-row">
          <div class="form-group"><label>Email Address</label><input type="email" name="email" class="form-input" required></div>
          <div class="form-group"><label>Phone Number</label><input type="tel" name="phone" class="form-input" placeholder="+91" required></div>
        </div>

        <div class="form-row">
          <div class="form-group"><label>Date of Birth</label><input type="date" name="dob" class="form-input" required></div>
          <div class="form-group"><label>Gender</label>
            <select name="gender" class="form-select" required>
              <option value="" disabled selected>Select</option><option value="female">Female</option><option value="other">Other</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label>Master Password</label>
            <div class="pass-wrapper">
              <input type="password" id="password" name="password" class="form-input" required oninput="validatePassword()">
              <i class="ph-fill ph-eye pass-toggle" onclick="togglePass('password', this)"></i>
            </div>
          </div>
          <div class="form-group">
            <label>Confirm Password</label>
            <div class="pass-wrapper">
              <input type="password" id="confirm_password" class="form-input" required oninput="validatePassword()">
            </div>
          </div>
        </div>

        <ul class="pass-rules">
          <li class="rule-item" id="rule-len"><i class="ph-bold ph-x"></i> 8+ chars</li>
          <li class="rule-item" id="rule-upper"><i class="ph-bold ph-x"></i> 1 Upper</li>
          <li class="rule-item" id="rule-lower"><i class="ph-bold ph-x"></i> 1 Lower</li>
          <li class="rule-item" id="rule-num"><i class="ph-bold ph-x"></i> 1 Number</li>
          <li class="rule-item" id="rule-sym"><i class="ph-bold ph-x"></i> 1 Symbol</li>
          <li class="rule-item" id="rule-match"><i class="ph-bold ph-x"></i> Match</li>
        </ul>

        <div class="auth-actions">
          <div style="flex:1;"></div>
          <button type="button" class="btn btn-primary" onclick="nextStep(1)">Secure Identity <i class="ph-bold ph-arrow-right"></i></button>
        </div>
      </div>

      <div class="form-step" id="step-2">
        <div class="auth-header">
          <h1>Guardian Assignment</h1>
          <p>These contacts will receive your live GPS link if SOS is triggered.</p>
        </div>

        <div id="guardiansContainer">
          <div class="guardian-block">
            <h3 style="margin-bottom:1rem; color:var(--rose-light);"><i class="ph-fill ph-shield-star"></i> Primary Guardian</h3>
            <div class="form-group"><label>Name</label><input type="text" name="g_names[]" class="form-input" required></div>
            <div class="form-row">
              <div class="form-group"><label>Email</label><input type="email" name="g_emails[]" class="form-input" required></div>
              <div class="form-group"><label>Phone</label><input type="tel" name="g_phones[]" class="form-input" required></div>
            </div>
            <div class="form-group">
              <label>Relationship</label>
              <select name="g_relations[]" class="form-select" required>
                <option value="Parent">Parent</option><option value="Sibling">Sibling</option>
                <option value="Partner">Partner</option><option value="Friend">Friend</option>
              </select>
            </div>
          </div>
        </div>

        <button type="button" class="btn-add" onclick="addGuardian()"><i class="ph-bold ph-plus"></i> Add Additional Guardian</button>

        <div class="auth-actions">
          <button type="button" class="btn btn-outline" onclick="prevStep(2)"><i class="ph-bold ph-arrow-left"></i> Back</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Finalize Encryption <i class="ph-bold ph-shield-check"></i></button>
        </div>
      </div>

    </form>
  </div>
</div>

<script>
  // --- Photo Preview ---
  function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('photoPreview').src = e.target.result;
        document.getElementById('photoPreview').style.display = 'block';
        document.getElementById('uploadIcon').style.display = 'none';
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  // --- Password Logic ---
  function togglePass(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('ph-eye'); icon.classList.toggle('ph-eye-slash');
  }

  let isPassValid = false;
  function validatePassword() {
    const p = document.getElementById('password').value;
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
  }

  // --- Dynamic Guardians ---
  let gCount = 1;
  function addGuardian() {
    gCount++;
    const html = `
      <div class="guardian-block" id="g-${gCount}">
        <div class="guardian-header">
          <h3 style="color:white;"><i class="ph-fill ph-shield-plus"></i> Additional Guardian</h3>
          <button type="button" class="btn-remove" onclick="document.getElementById('g-${gCount}').remove()"><i class="ph-bold ph-trash"></i></button>
        </div>
        <div class="form-group"><input type="text" name="g_names[]" class="form-input" placeholder="Name" required></div>
        <div class="form-row">
          <div class="form-group"><input type="email" name="g_emails[]" class="form-input" placeholder="Email" required></div>
          <div class="form-group"><input type="tel" name="g_phones[]" class="form-input" placeholder="Phone" required></div>
        </div>
        <div class="form-group">
          <select name="g_relations[]" class="form-select" required>
            <option value="Parent">Parent</option><option value="Sibling">Sibling</option><option value="Friend">Friend</option>
          </select>
        </div>
      </div>`;
    document.getElementById('guardiansContainer').insertAdjacentHTML('beforeend', html);
  }

  // --- Step Navigation ---
  function nextStep(step) {
    const inputs = document.getElementById(`step-${step}`).querySelectorAll('input[required], select[required]');
    let isValid = true;
    inputs.forEach(i => { if(!i.value) { i.classList.add('error-shake'); isValid = false; } else i.classList.remove('error-shake'); });
    
    if(!isValid || (step === 1 && !isPassValid)) return;

    document.getElementById(`step-1`).classList.remove('active');
    document.getElementById(`step-2`).classList.add('active');
    document.getElementById('progressFill').style.width = '100%';
    document.getElementById('ind-2').classList.add('active');
  }

  function prevStep(step) {
    document.getElementById(`step-2`).classList.remove('active');
    document.getElementById(`step-1`).classList.add('active');
    document.getElementById('progressFill').style.width = '50%';
    document.getElementById('ind-2').classList.remove('active');
  }

  // --- AJAX Submit ---
  document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = `<i class="ph-bold ph-spinner ph-spin"></i> Initializing...`;
    btn.style.pointerEvents = 'none';

    fetch('process_signup.php', { method: 'POST', body: new FormData(this) })
    .then(res => res.json())
    .then(data => {
      const toast = document.getElementById('toast');
      toast.innerHTML = data.message;
      toast.classList.add('show');
      if(data.status === 'success') {
        btn.innerHTML = `<i class="ph-bold ph-check"></i> Account Secured`;
        btn.style.background = 'var(--safe-green)';
        setTimeout(() => window.location.href = "login.php", 2000);
      } else {
        btn.innerHTML = "Retry Finalization";
        btn.style.pointerEvents = 'auto';
        setTimeout(() => toast.classList.remove('show'), 4000);
      }
    });
  });
</script>
</body>
</html>