<?php $title = "FarmEase - Smart Farming Platform"; $css = "css/style.css"; include 'includes/header.php'; ?>

  <!-- Hero Section -->
  <section class="hero">
    <header>
      <img class="logo" src="assets/logo.png" alt="FarmEase Logo">
    </header>
    <button class="lang-switch" id="langSwitch">اردو</button>
    <h1 id="title">Welcome to FarmEase</h1>
    <h3 id="subtitle">A Bilingual Farming Support System</h3>
    <div class="hero-links">
      <a href="crop-info.php" class="link">
        <div class="card" id="cropInfo">
          <i class="fa-solid fa-seedling"></i>
          <span>Crop Information</span>
        </div>
      </a>
      <a href="agri-cost.php" class="link">
        <div class="card" id="calculator">
          <i class="fa-solid fa-calculator"></i>
          <span>AgriCost &amp; Profit Guide</span>
        </div>
      </a>
      <a href="contact.php" class="link">
        <div class="card" id="helpline">
          <i class="fa-solid fa-headset"></i>
          <span>Contact with Experts</span>
        </div>
      </a>
    </div>
  </section>

  <!-- About Us Section -->
  <section class="about-us">
    <div class="about-card">
      <div class="about-left">
        <div class="about-heading">
          <img src="assets/about-top.png" alt="About Icon" class="about-leaf-icon">
          <div>
            <h2 id="about-heading">About Us</h2>
            <div class="about-underline"></div>
          </div>
        </div>
        <div class="about-text-block">
          <p id="about-p1">Our project is a user-friendly agricultural platform that provides accurate and organized information about different crops, including costs and farming details.</p>
          <p id="about-p2">With a simple interface and bilingual support, the platform ensures accessibility for a wider audience.</p>
          <p id="about-p3">This project aims to promote smart farming and improve decision-making through the use of technology.</p>
        </div>
        <img src="assets/about-bottom-img.png" alt="About Bottom" class="about-bottom-full-img">
      </div>
      <div class="about-right">
        <img src="assets/about-us.png" alt="Farmer in field">
      </div>
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="how-it-works">
    <h2>How It Works</h2>
    <p class="section-subtitle">Three simple steps to smart farming</p>
    <div class="steps-grid">
      <div class="step-card">
        <div class="step-number">01</div>
        <h3>Choose a Crop</h3>
        <p>Browse our database of crops and select the one you are interested in growing.</p>
      </div>
      <div class="step-card">
        <div class="step-number">02</div>
        <h3>View Details</h3>
        <p>Access detailed information on soil type, watering needs, seasonal cycles, and more.</p>
      </div>
      <div class="step-card">
        <div class="step-number">03</div>
        <h3>Calculate Costs</h3>
        <p>Use our AgriCost tool to estimate your investment and projected profit accurately.</p>
      </div>
    </div>
  </section>

  <!-- Features Section -->
  <section class="features">
    <h2>Why Choose FarmEase</h2>
    <p class="section-subtitle">Everything a modern farmer needs in one place</p>
    <div class="features-grid">
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-wheat-awn"></i></div>
        <h3>Crop Details</h3>
        <p>Learn about soil requirements, watering schedules, and the full lifecycle of each crop.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-coins"></i></div>
        <h3>Cost Estimator</h3>
        <p>Get accurate insights into the investment needed and projected profits for your farm.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-language"></i></div>
        <h3>Bilingual Support</h3>
        <p>Toggle seamlessly between English and Urdu for a wider range of users.</p>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-mobile-screen"></i></div>
        <h3>Easy Access</h3>
        <p>Use the platform on any device, anywhere, anytime without any installation.</p>
      </div>
    </div>
  </section>

<?php include 'includes/footer.php'; ?>
<script src="js/home.js"></script>
</body>
</html>
