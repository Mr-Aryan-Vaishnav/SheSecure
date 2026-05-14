<header class="top-status-bar">
  <div class="telemetry-group">
    <div class="telemetry-item safe"><i class="ph-fill ph-satellite"></i> GPS: ONLINE</div>
    <div class="telemetry-item enc hide-mob"><i class="ph-fill ph-lock-key"></i> E2EE: ACTIVE</div>
    <div class="telemetry-item safe hide-mob"><i class="ph-fill ph-users-three"></i> GUARDIANS: READY</div>
  </div>
  
  <div class="top-actions">
    <div class="telemetry-item" style="margin-right:1rem;"><i class="ph-fill ph-clock"></i> <span id="liveClock">--:--:-- IST</span></div>
    
    <div class="user-dropdown">
        <button class="btn-profile" onclick="toggleDropdown()">
            <div class="header-avatar"><?php echo $user_initial; ?></div>
            <span class="header-name"><?php echo htmlspecialchars($user_name); ?></span>
            <i class="ph-bold ph-caret-down"></i>
        </button>
        
        <div class="dropdown-menu" id="profileDropdown">
            <a href="#" class="dropdown-item sos-action"><i class="ph-fill ph-siren"></i> Trigger SOS</a>
            <a href="#" class="dropdown-item"><i class="ph-fill ph-user"></i> My Profile</a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item"><i class="ph-fill ph-sign-out"></i> Secure Logout</a>
        </div>
    </div>

  </div>
</header>