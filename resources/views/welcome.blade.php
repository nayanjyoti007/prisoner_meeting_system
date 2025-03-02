<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ASSED - Home</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Lato', sans-serif;
      background-color: #f9f9f9;
    }

    /* Navbar */
    .navbar {
      background: linear-gradient(45deg, #007bff, #0056b3);
    }

    .navbar-brand img {
      height: 60px;
    }

    .navbar-brand, .navbar-nav .nav-link {
      color: #fff !important;
    }

    .navbar-nav .nav-link {
      margin-left: 1rem;
      font-weight: 500;
    }

    .btn-login {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      color: #fff;
      background: #ff9800;
      border: none;
      border-radius: 20px;
      padding: 0.5rem 1rem;
      font-weight: 500;
      transition: all 0.3s;
      text-decoration: none;
    }

    .btn-login i {
      margin-right: 8px;
    }

    .btn-login:hover {
      background: #e68900;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    /* Hero Section */
    .carousel-caption h5 {
      font-weight: 700;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    }

    /* Notifications Section */
    .notification {
      display: flex;
      flex-wrap: wrap;
      gap: 1.5rem;
      justify-content: center;
    }

    .notification-card {
      flex: 1 1 300px;
      max-width: 300px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      text-align: center;
      transition: transform 0.3s, box-shadow 0.3s;
    }

    .notification-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .notification-card i {
      font-size: 2rem;
      color: #007bff;
      margin-bottom: 1rem;
    }

    .notification-card h6 {
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    footer {
      background: #212529;
      color: #fff;
      padding: 2rem 0;
    }

    footer p, footer a {
      margin: 0.5rem 0;
      color: #adb5bd;
    }

    footer a {
      text-decoration: none;
      transition: color 0.3s;
    }

    footer a:hover {
      color: #ffc107;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .carousel-caption {
        font-size: 0.9rem;
      }

      .btn-login {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
      }

      footer p {
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>

  <!-- Header -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{asset('assed_logo.png')}}" alt="Logo">
        ASSED
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="{{url('/')}}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Notifications</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        </ul>
        <div class="ms-3">
          <a href="{{route('login')}}" class="btn btn-login me-2" target="_blank"><i class="bi bi-mortarboard-fill"></i> Institute Login</a>
          <a href="{{route('admin.login')}}" class="btn btn-login" target="_blank"><i class="bi bi-person-lock"></i> Admin Login</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Hero Section with Slider -->
  <section class="hero-section mt-0">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://via.placeholder.com/1200x350" class="d-block w-100" alt="Slide 1">
          <div class="carousel-caption d-none d-md-block">
            <h5>Welcome to ASSED</h5>
            <p>Fostering Excellence in Higher Education</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://via.placeholder.com/1200x350" class="d-block w-100" alt="Slide 2">
          <div class="carousel-caption d-none d-md-block">
            <h5>Announcements</h5>
            <p>Stay Updated with the Latest Notifications</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://via.placeholder.com/1200x350" class="d-block w-100" alt="Slide 3">
          <div class="carousel-caption d-none d-md-block">
            <h5>Commitment to Excellence</h5>
            <p>Empowering Students through Quality Education</p>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </section>

  <!-- Notifications Section -->
  <section class="container my-5">
    <h2 class="text-center mb-4">Latest Notifications</h2>
    <div class="notification">
      <div class="notification-card">
        <i class="bi bi-megaphone"></i>
        <h6>Results Declared</h6>
        <p>Class 12 results announced on 29th Dec 2024.</p>
      </div>
      <div class="notification-card">
        <i class="bi bi-calendar-check"></i>
        <h6>Admissions Open</h6>
        <p>Apply for the 2024-2025 session now!</p>
      </div>
      <div class="notification-card">
        <i class="bi bi-music-note"></i>
        <h6>Cultural Fest</h6>
        <p>Join us on 15th January 2024.</p>
      </div>
      <div class="notification-card">
        <i class="bi bi-exclamation-triangle"></i>
        <h6>Exam Forms</h6>
        <p>Submit your forms before the deadline!</p>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <p>&copy; 2024 Assam Higher Secondary Education Council. All Rights Reserved.</p>
      <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a> | <a href="#">Contact Us</a></p>
      <p>Developed with ❤️ by ASSED Team</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
