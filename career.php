<?php
session_start();
include 'db.php'; // DB connection

/* =========================
   HANDLE APPLICATION FORM
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resume'])) {

    $maxSize = 2 * 1024 * 1024; // 2MB
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];

    $fileSize = $_FILES['resume']['size'];

    // MIME check (secure)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileType = finfo_file($finfo, $_FILES['resume']['tmp_name']);
    finfo_close($finfo);

    if ($fileSize > $maxSize) {
        $_SESSION['error'] = "File size must be under 2MB.";
        header("Location: career.php");
        exit;
    }

    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION['error'] = "Only PDF, JPG, PNG files are allowed.";
        header("Location: career.php");
        exit;
    }

    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $cleanName = preg_replace("/[^a-zA-Z0-9._-]/", "", $_FILES['resume']['name']);
    $fileName = time() . "_" . $cleanName;
    move_uploaded_file($_FILES['resume']['tmp_name'], $uploadDir . $fileName);

    // Save application
    $stmt = $conn->prepare("
        INSERT INTO job_applications 
        (full_name, email, phone, position, resume) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "sssss",
        $_POST['full_name'],
        $_POST['email'],
        $_POST['phone'],
        $_POST['position'],
        $fileName
    );
    $stmt->execute();

    $_SESSION['success'] = "Application submitted successfully!";
    header("Location: index.php");
    exit;
}

/* =========================
   FETCH ACTIVE JOBS
========================= */
$jobs = mysqli_query($conn, "SELECT * FROM jobs WHERE status='Active' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>AQUA J1 Header</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@1,700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">





</head>
<body>
  <div id="top"></div>

    <div id="navbar"></div>
    <br>
   <br>

<section class="career-hero">

     <img src="assets/images/career-hero.webp" alt="Career Background" class="career-bg">

  <div class="career-overlay"></div>

  <div class="career-content">
    <h1 class="career-title">
      Build the Future of Pure Water
    </h1>

    <p class="career-subtitle">
      Join Aqua J1 Technologies and help us bring clean, safe water to thousands of homes across the country.
    </p>

    <a href="#" class="career-btn">View openings</a>
  </div>

</section>

<section class="why-section">

  <div class="why-container">
    <h2 class="why-title">Why work with us?</h2>
    <p class="why-subtitle">
      We provide the environment for you to grow, innovate, and lead.
    </p>

    <div class="why-cards">

      <!-- Card 1 -->
      <div class="why-card">
        <div class="why-icon">
          <img src="assets/images/growth-mindset.webp" alt="">
        </div>
        <h3>Growth Mindset</h3>
        <p>
          Structured promotion cycles and direct mentorship from industry veterans.
        </p>
      </div>

      <!-- Card 2 -->
      <div class="why-card">
        <div class="why-icon">
          <img src="assets/images/supportive-culture.webp" alt="">
        </div>
        <h3>Supportive Culture</h3>
        <p>
          Full medical coverage and flexible time-off to ensure you and your family are safe.
        </p>
      </div>

      <!-- Card 3 -->
      <div class="why-card">
        <div class="why-icon">
          <img src="assets/images/high-impact.webp" alt="">
        </div>
        <h3>High Impact Work</h3>
        <p>
          Your work directly prevents water borne diseases. Every filter installed is a step toward a healthier India.
        </p>
      </div>

      <!-- Card 4 -->
      <div class="why-card">
        <div class="why-icon">
          <img src="assets/images/recognition.webp" alt="">
        </div>
        <h3>Recognition</h3>
        <p>
          Trusted for quality, performance, and reliable water purification solutions.
        </p>
      </div>

    </div>
  </div>

</section>

<section class="philosophy-section">
  <div class="philosophy-container">

    <!-- LEFT CONTENT -->
    <div class="philosophy-left">

      <p class="philosophy-tag">Our Philosophy</p>

      <h2 class="philosophy-title">
        Engineering the Future <br> of Pure Water.
      </h2>

      <p class="philosophy-text">
        At Aqua J1, we don’t just follow standards; we set them. Our team blends
        deep technical precision with a relentless drive to solve India’s
        water challenges. Here, you are an architect of a healthier nation.
      </p>

      <!-- Feature 1 -->
      <div class="philosophy-box">
        <div class="box-icon">
          <img src="assets/images/guardian-culture.webp" alt="">
        </div>
        <div>
          <h4>Unmatched Precision</h4>
          <p>Our R&D team works on the cutting edge of nano-filtration technology.</p>
        </div>
      </div>

      <!-- Feature 2 -->
      <div class="philosophy-box">
        <div class="box-icon">
          <img src="assets/images/unmatched-precision.png" alt="">
        </div>
        <div>
          <h4>Guardian Culture</h4>
          <p>We take personal responsibility for the safety of every drop we purify.</p>
        </div>
      </div>

    </div>

    <!-- RIGHT IMAGE -->
    <div class="philosophy-right">
      <img src="assets/images/philosophy.webp" alt="Team" class="philosophy-img">

      <div class="quality-badge">
        <span class="zero">Zero</span>
        <span>Compromise on Quality</span>
      </div>
    </div>

  </div>
</section>

<section class="jobs-section">
  <div class="jobs-container">

    <!-- Header -->
    <div class="jobs-header">
      <div>
        <h2 class="jobs-title">Current Openings</h2>
        <p class="jobs-subtitle">Find the role that fits your skills.</p>
      </div>

      <div class="jobs-filter">
        <label>Filter by:</label>
        <select>
          <option>All Departments</option>
          <option>Technical</option>
          <option>Sales</option>
        </select>
      </div>
    </div>

    <div class="jobs-grid">

    <?php if ($jobs && mysqli_num_rows($jobs) > 0): ?>
      <?php while ($job = mysqli_fetch_assoc($jobs)): ?>
        <div class="job-card">

          <span class="job-tag">POSITION</span>

          <h3><?= htmlspecialchars($job['title']) ?></h3>

          <p class="job-location">
            📍 <?= htmlspecialchars($job['location']) ?>
          </p>

          <p class="job-type">
            <span class="job-tag">Experience</span>
            <?= htmlspecialchars($job['experience']) ?>
          </p>

          <div class="job-desc">
            <?= $job['description'] ?>
          </div>

          <button class="apply-btn" data-job="<?= htmlspecialchars($job['title']) ?>">
            Apply Now
          </button>

        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p>No openings available right now.</p>
    <?php endif; ?>

  </div>



    <!-- Job Cards -->
    
</section>

<!-- ================= ALERTS ================= -->
<?php if (isset($_SESSION['success'])): ?>
<div class="alert success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
<div class="alert error"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>


<!-- ================= APPLY POPUP MODAL ================= -->
<div class="apply-modal" id="applyModal">
  <div class="apply-modal-box">

    <div class="apply-modal-header">
      <h2>Join Aqua J1</h2>
      <button class="apply-close">&times;</button>
      <p>
        Applying for <span id="applyRole">Position</span>
      </p>
    </div>

    <!-- 🔴 YOUR EXISTING FORM (UNCHANGED BACKEND) -->
    <form method="POST" enctype="multipart/form-data" class="apply-form">

      <input type="hidden" name="position" id="modalPosition">

      <div class="two-col">
        <input type="text" name="full_name" placeholder="Full Name" required>
        <input type="text" name="phone" placeholder="Phone Number" required>
      </div>

      <input type="email" name="email" placeholder="Email Address" required>

      <textarea name="message" placeholder="Tell us about yourself (optional)"></textarea>

      <label class="upload-box">
        Click to upload <span>Resume/CV</span>
        <input type="file" name="resume" accept=".pdf,.jpg,.png" hidden required>
      </label>

      <button type="submit" class="submit-btn">
        Submit Application
      </button>
    </form>

  </div>
</div>


    <div id="footer"></div>

    <div class="nr-float">
  <a class="nr-float-btn nr-float-top" href="#top" title="Back to top">
    <i class="fa-solid fa-arrow-up"></i>
  </a>

  <a class="nr-float-btn nr-float-wa" href="https://wa.me/91XXXXXXXXXX" target="_blank" title="WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
  </a>
</div>

     </body>

     
<script>
const modal = document.getElementById('applyModal');
const closeBtn = document.querySelector('.apply-close');
const roleText = document.getElementById('applyRole');
const roleInput = document.getElementById('modalPosition');

document.querySelectorAll('.apply-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const role = btn.dataset.job;
    roleText.textContent = role;
    roleInput.value = role;
    modal.classList.add('active');
  });
});

closeBtn.addEventListener('click', () => {
  modal.classList.remove('active');
});

modal.addEventListener('click', e => {
  if (e.target === modal) modal.classList.remove('active');
});
</script>


     <script src="assets/main.js"></script>