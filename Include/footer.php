<style>
  /* =========================================
   FOOTER STYLES
   ========================================= */
footer { 
  background: #110A0D; 
  padding: 5rem 5rem 3rem; 
  display: flex; 
  flex-direction: column; 
  gap: 4rem; 
  position: relative; 
  z-index: 5; 
}

.footer-top { 
  display: flex; 
  justify-content: space-between; 
  align-items: flex-start; 
  flex-wrap: wrap; 
  gap: 4rem; 
}

.footer-brand-col { 
  max-width: 380px; 
}

.footer-brand { 
  font-family: 'Playfair Display', serif; 
  font-size: 2rem; 
  font-weight: 900; 
  color: white; 
  display: flex; 
  align-items: center; 
  gap: 0.6rem; 
  margin-bottom: 1.2rem;
}

.footer-brand span { 
  color: var(--rose-light); 
}

.footer-tagline { 
  font-size: 1rem; 
  color: rgba(255,255,255,.6); 
  line-height: 1.7; 
  margin-bottom: 2rem;
}

.social-links { 
  display: flex; 
  gap: 1rem; 
}

.social-links a { 
  width: 40px; 
  height: 40px; 
  border-radius: 50%; 
  background: rgba(255,255,255,0.05); 
  color: white; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  font-size: 1.2rem; 
  transition: all 0.3s; 
  text-decoration: none;
}

.social-links a:hover { 
  background: var(--rose); 
  transform: translateY(-3px); 
}

.footer-links-grid { 
  display: grid; 
  grid-template-columns: repeat(3, 1fr); 
  gap: 5rem; 
}

.footer-col h4 { 
  color: white; 
  font-size: 1.15rem; 
  margin-bottom: 1.5rem; 
  font-family: 'Playfair Display', serif; 
  letter-spacing: 0.05em; 
}

.footer-col ul { 
  list-style: none; 
  display: flex; 
  flex-direction: column; 
  gap: 1rem; 
}

.footer-col a { 
  color: rgba(255,255,255,.6); 
  font-size: 0.95rem; 
  text-decoration: none; 
  transition: color .3s; 
  font-weight: 500; 
}

.footer-col a:hover { 
  color: var(--rose-light); 
}

.footer-bottom { 
  display: flex; 
  justify-content: space-between; 
  align-items: center; 
  border-top: 1px solid rgba(255,255,255,0.1); 
  padding-top: 2.5rem; 
  flex-wrap: wrap; 
  gap: 1rem; 
}

.footer-copy { 
  font-size: 0.9rem; 
  color: rgba(255,255,255,.4); 
}

/* ─── FOOTER RESPONSIVE FIXES ─── */
@media (max-width: 1024px) {
  .footer-top { 
    grid-template-columns: 1fr; 
  }
}

@media (max-width: 768px) {
  footer { 
    padding: 4rem 1.5rem 2rem; 
  }
  .footer-links-grid { 
    grid-template-columns: 1fr; 
    gap: 2.5rem; 
  }
  .footer-bottom { 
    flex-direction: column; 
    text-align: center; 
    justify-content: center;
  }
  .footer-bottom .footer-copy { 
    text-align: center !important; 
  }
}
</style>
<!-- COMPLETE FOOTER -->
<footer>
  <div class="footer-top">
    <div class="footer-brand-col">
      <div class="footer-brand"><i class="ph-fill ph-shield-check" style="color:var(--rose);"></i> She<span>Secure</span></div>
      <p class="footer-tagline">Navigating towards safer cities for everyone. Empowering journeys with encrypted paths and instant SOS protection.</p>
      <div class="social-links">
        <a href="https://twitter.com" target="_blank"><i class="ph-fill ph-twitter-logo"></i></a>
        <a href="https://instagram.com" target="_blank"><i class="ph-fill ph-instagram-logo"></i></a>
        <a href="https://linkedin.com" target="_blank"><i class="ph-fill ph-linkedin-logo"></i></a>
      </div>
    </div>
    
    <div class="footer-links-grid">
      <div class="footer-col">
        <h4>Platform</h4>
        <ul>
          <li><a href="about.php">About Us</a></li>
          <li><a href="mission.php">Our Mission</a></li>
          <li><a href="contact.php">Contact Us</a></li>
          <li><a href="faq.php">FAQ</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Legal</h4>
        <ul>
          <li><a href="privacy.php">Privacy Policy</a></li>
          <li><a href="terms.php">Terms and Conditions</a></li>
          <li><a href="ethics.php">Data Ethics</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Account</h4>
        <ul>
          <li><a href="login.php">Login</a></li>
          <li><a href="signup.php">Sign Up</a></li>
        
        </ul>
      </div>
    </div>
  </div>
  
  <div class="footer-bottom">
    <div class="footer-copy">© 2026 Team Coffee To Code · Built for safety, by mission.</div>
    <div class="footer-copy" style="text-align:right;">All Rights Reserved.</div>
  </div>
</footer>