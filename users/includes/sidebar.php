<aside class="sidebar">
  <div class="sidebar-header">
    <div class="logo-icon"><i class="ph-fill ph-gender-female"></i></div>
    <div class="logo-text">She<span>Secure</span></div>
  </div>

  <nav class="nav-menu">
    <div class="nav-label">Core Systems</div>
    <a href="dashboard.php" class="nav-item active"><i class="ph-fill ph-squares-four"></i> Dashboard Home</a>
    <a href="smart-navigation.php" class="nav-item"><i class="ph-fill ph-map-trifold"></i> Smart Navigation</a>
    <a href="live-safety-map.php" class="nav-item"><i class="ph-fill ph-crosshair"></i> Live Safety Map</a>
    <a href="sos-emergency.php" class="nav-item" style="color:var(--rose-light);"><i class="ph-fill ph-siren"></i> SOS Emergency</a>

    <div class="nav-label">Intelligence</div>
    <a href="community-reports.php" class="nav-item"><i class="ph-fill ph-megaphone"></i> Community Reports</a>
    <a href="ai-safety-insights.php" class="nav-item"><i class="ph-fill ph-brain"></i> AI Safety Insights</a>

    
  </nav>

  <div class="sidebar-footer">
    <div class="user-profile">
      <div class="user-avatar"><?php echo $user_initial; ?></div>
      <div class="user-info">
        <h4><?php echo htmlspecialchars($user_name); ?></h4>
        <p><i class="ph-fill ph-shield-check"></i> Account Protected</p>
      </div>
    </div>
  </div>
</aside>