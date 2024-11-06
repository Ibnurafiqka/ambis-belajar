<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>INNOSPHERE TEAM</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="innosphere-team/assets-1/img/clients/logo.png" rel="icon">
  <link href="assets-1/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets-1/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets-1/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets-1/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets-1/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets-1/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets-1/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.php" class="logo d-flex align-items-center me-auto">
        <img src="assets-1/img/clients/logo.png" alt="">
        <h1 class="sitename">INNOSPHERE</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.php#hero" class="active">Home</a></li>
          <li><a href="blog.php">Blog</a></li>
          <li><a href="about.php">About</a></li>

          </li>
          <!-- <li><a href="index.html#contact" class="daftar">Sign Up</a></li> -->
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

<a href="login.php" class="btn-getstarted">Login</a>
</div>

  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up">Welcome to <span>INNOSPHERE</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Menjadi generasi Lebih Inovatif dan kreatif dengan innosphere<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="#about" class="btn-get-started">Get Started</a>
            <a href="https://youtu.be/f5qS24ZCRiQ?si=9cMJq5YY4DMA9aeq" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
          <img src="assets-1/img/hero-services-img.webp" class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section light-background">
    
      <div class="container">
        <h1 class="why innosphere">Kenapa Innosphere</h1>

        <div class="row gy-4">

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Proyek yang realistis</a></h4>
                <p class="description">Innosphere menyediakan pembelajaran praktis berbasis proyek dengan memahami cara kerja industri yang nyata</p>
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Mentor &   Sertifikasi </a></h4>
                <p class="description"> bimbingan dari mentor berpengalaman  serta sertifikasi yang meningkatkan daya saing Anda di pasar kerja.</p>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-bar-chart"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Komunitas Belajar</a></h4>
                <p class="description">komunitas belajar  yang produktif dan solutif dengan sesama pelajar maupun professional </p>
              </div>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Featured Services Section -->
<!-- About Section -->
<section id="about" class="about section">
  <div class="container">
      <div class="row gy-4">
          <div class="col-lg-6 content text-light" data-aos="fade-up" data-aos-delay="100">
              <h4>Innosphere Profile</h4>
              <p class="fst-italic">
                  Innosphere merupakan platform yang membantu generasi muda menguasai keterampilan teknologi yang relevan di era digital.
              </p>
              <h4>Visi Innosphere</h4>
              <p>Menjadi platform pembelajaran teknologi terdepan yang mempersiapkan generasi inovatif untuk masa depan digital yang lebih baik.</p>
              <h4>Misi Innosphere</h4>
              <ul>
                  <li><i class="bi bi-check-circle text-light"></i> Menyediakan kursus berkualitas tinggi yang relevan dengan kebutuhan industri.</li>
                  <li><i class="bi bi-check-circle text-light"></i> Membangun komunitas pembelajaran yang mendukung kolaborasi dan pertumbuhan.</li>
                  <li><i class="bi bi-check-circle text-light"></i> Membantu setiap pengguna mencapai keterampilan impian mereka dengan bimbingan profesional dan sertifikasi terpercaya.</li>
              </ul>
          </div>

          <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">
                  <div class="col-lg-6">
                      <img src="assets-1/img/about-company-1.jpg" class="img-fluid rounded shadow" alt="About Image 1">
                  </div>
                  <div class="col-lg-6">
                      <img src="assets-1/img/about-company-2.jpg" class="img-fluid rounded shadow mb-3" alt="About Image 2">
                      <img src="assets-1/img/about-company-3.jpg" class="img-fluid rounded shadow" alt="About Image 3">
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

<!-- Popup Section -->
<div id="popup" class="popup">
  <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <div class="popup-header">
          <img src="assets-1/img/clients/logo.png" class="popup-logo" alt="Innosphere Logo">
          <h2>Innosphere - More Information</h2>
      </div>
      <div class="popup-body">
          <p>Innosphere adalah platform pembelajaran berbasis teknologi yang dirancang untuk memberikan akses kepada generasi muda dalam menguasai keterampilan digital terkini. Kami berfokus pada memberikan kursus dengan pendekatan praktis dan langsung diterapkan, yang memungkinkan pengguna untuk belajar dari pakar industri yang terpercaya.</p>
          <p>Innosphere menyediakan beragam program yang mencakup topik seperti pengembangan web, ilmu data, kecerdasan buatan, dan desain UX/UI. Setiap kursus didesain untuk mempersiapkan pengguna menghadapi tantangan dunia kerja yang sesungguhnya.</p>
          <h4>Keunggulan Innosphere</h4>
          <ul>
              <li><i class="bi bi-award text-primary"></i> Kursus berbasis proyek langsung dengan mentor profesional.</li>
              <li><i class="bi bi-globe text-primary"></i> Komunitas global untuk berbagi ide dan kolaborasi.</li>
              <li><i class="bi bi-file-earmark-medical text-primary"></i> Sertifikasi yang diakui oleh industri.</li>
          </ul>
          <img src="assets-1/img/about-company-3.jpg" class="img-fluid rounded mt-4" alt="Innosphere Learning">
      </div>
  </div>
</div>


<!-- Popup Section -->
<div id="popup" class="popup">
  <div class="popup-content">
      <span class="close-btn" onclick="closePopup()">&times;</span>
      <div class="popup-header">
          <img src="assets-1/img/clients/logo.png" class="popup-logo" alt="Innosphere Logo">
          <h2>Innosphere - More Information</h2>
      </div>
      <div class="popup-body">
          <p>Innosphere adalah platform pembelajaran berbasis teknologi yang dirancang untuk memberikan akses kepada generasi muda dalam menguasai keterampilan digital terkini. Kami berfokus pada memberikan kursus dengan pendekatan praktis dan langsung diterapkan, yang memungkinkan pengguna untuk belajar dari pakar industri yang terpercaya.</p>
          <p>Innosphere menyediakan beragam program yang mencakup topik seperti pengembangan web, ilmu data, kecerdasan buatan, dan desain UX/UI. Setiap kursus didesain untuk mempersiapkan pengguna menghadapi tantangan dunia kerja yang sesungguhnya.</p>
          <h4>Keunggulan Innosphere</h4>
          <ul>
              <li><i class="bi bi-award text-primary"></i> Kursus berbasis proyek langsung dengan mentor profesional.</li>
              <li><i class="bi bi-globe text-primary"></i> Komunitas global untuk berbagi ide dan kolaborasi.</li>
              <li><i class="bi bi-file-earmark-medical text-primary"></i> Sertifikasi yang diakui oleh industri.</li>
          </ul>
          <img src="assets-1/img/about-company-3.jpg" class="img-fluid rounded mt-4" alt="Innosphere Learning">
      </div>
  </div>
</div>

    
    <div class="container-slide">
      <div class="title">
          <h1>Partner Innosphere</h1>
      </div>
      <div class="slider">
          <div class="slide-track">
              <!-- Repeat the partner logos twice to create an infinite loop effect -->
              <div class="slide satu"><img src="assets-1/img/partner/resize/dblimbing.png" alt="Partner 1"></div>
              <div class="slide dua"><img src="assets-1/img/partner/resize/w3school.png" alt="Partner 2"></div>
              <div class="slide tiga"><img src="assets-1/img/partner/resize/codepolitan.png" alt="Partner 3"></div>
              <div class="slide empat"><img src="assets-1/img/partner/resize/udemy.png" alt="Partner 4"></div>
              <div class="slide lima"><img src="assets-1/img/partner/resize/surabayadev.png" alt="Partner 5"></div>
              <div class="slide enam"><img src="assets-1/img/partner/resize/coursera.png" alt="Partner 6"></div>
              <div class="slide tujuh"><img src="assets-1/img/partner/resize/dblimbing.png" alt="Partner 7"></div>
              <div class="slide delapan"><img src="assets-1/img/partner/resize/sololearn.png" alt="Partner 8"></div>
              <div class="slide sembilan"><img src="assets-1/img/partner/resize/codepolitan.png" alt="Partner 9"></div>
              <div class="slide sepuluh"><img src="assets-1/img/partner/resize/udemy.png" alt="Partner 10"></div>
              <div class="slide sebelas"><img src="assets-1/img/partner/resize/vocasia.png" alt="Partner 11"></div>

              <!-- Repeat the same set of logos to create the continuous effect -->
              <div class="slide satu"><img src="assets-1/img/partner/resize/dblimbing.png" alt="Partner 1"></div>
              <div class="slide dua"><img src="assets-1/img/partner/resize/w3school.png" alt="Partner 2"></div>
              <div class="slide tiga"><img src="assets-1/img/partner/resize/codepolitan.png" alt="Partner 3"></div>
              <div class="slide empat"><img src="assets-1/img/partner/resize/udemy.png" alt="Partner 4"></div>
              <div class="slide lima"><img src="assets-1/img/partner/resize/surabayadev.png" alt="Partner 5"></div>
              <div class="slide enam"><img src="assets-1/img/partner/resize/coursera.png" alt="Partner 6"></div>
              <div class="slide tujuh"><img src="assets-1/img/partner/resize/dblimbing.png" alt="Partner 7"></div>
              <div class="slide delapan"><img src="assets-1/img/partner/resize/sololearn.png" alt="Partner 8"></div>
              <div class="slide sembilan"><img src="assets-1/img/partner/resize/codepolitan.png" alt="Partner 9"></div>
              <div class="slide sepuluh"><img src="assets-1/img/partner/resize/udemy.png" alt="Partner 10"></div>
              <div class="slide sebelas"><img src="assets-1/img/partner/resize/vocasia.png" alt="Partner 11"></div>
          </div>
      </div>
  </div>
    
    <!-- Features Section -->
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title text-light" data-aos="fade-up">
        <h2>Features</h2>
        <p>Fitur Innosphere yang Membuat Belajar Lebih Efektif</p>
      </div><!-- End Section Title -->

      <div class="container">
        <div class="row justify-content-between">

          <div class="col-lg-5 d-flex align-items-center">

            <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
              <li class="nav-item">
                <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                  <i class="bi bi-binoculars"></i>
                  <div>
                    <h4 class="d-none d-lg-block">Jadwal Belajar Fleksibel</h4>
                    <p class="text-light">
                      Innosphere dirancang agar Anda bisa belajar kapan saja dan di mana saja sesuai dengan waktu luang Anda.
                    </p>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-2">
                  <i class="bi bi-box-seam"></i>
                  <div>
                    <h4 class="d-none d-lg-block">Konten Terupdate Sesuai Perkembangan Teknologi</h4>
                    <p>
                      Setiap kursus di Innosphere diperbarui secara berkala untuk memastikan materi yang diajarkan relevan dengan perkembangan industri terkini. 
                    </p>
                  </div>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#features-tab-3">
                  <i class="bi bi-brightness-high"></i>
                  <div>
                    <h4 class="d-none d-lg-block"> Penilaian Diri dan Progress Tracker</h4>
                    <p>
                      Fitur tracker di innosphere digunakan untuk melacak kemajuan belajar, mengukur hasil, dan mengevaluasi perkembangan keterampilan secara mandiri.
                    </p>
                  </div>
                </a>
              </li>
            </ul><!-- End Tab Nav -->

          </div>

          <div class="col-lg-6">

            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

              <div class="tab-pane fade active show" id="features-tab-1">
                <img src="assets-1/img/tabs-1.jpg" alt="" class="img-fluid">
              </div><!-- End Tab Content Item -->

              <div class="tab-pane fade" id="features-tab-2">
                <img src="assets-1/img/tabs-2.jpg" alt="" class="img-fluid">
              </div><!-- End Tab Content Item -->

              <div class="tab-pane fade" id="features-tab-3">
                <img src="assets-1/img/tabs-3.jpg" alt="" class="img-fluid">
              </div><!-- End Tab Content Item -->
            </div>

          </div>

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Features Details Section -->
    <section id="features-details" class="features-details section">

      

    </section><!-- /Features Details Section -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 class="text-dark">Services</h2>
        <p>layanan service yang dapat meningkatkan pengalaman belajar dan mempersiapkan sukses di dunia kerja. </p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row g-5">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item item-cyan position-relative">
              <i class="bi bi-activity icon"></i>
              <div>
                <h3 class="text-dark">Platform Pembelajaran Adaptif</h3>
                <p>Meningkatkan efektivitas belajar dengan menyesuaikan materi dan metode pengajaran berdasarkan gaya dan kecepatan belajar masing-masing pengguna.</p>
              
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item item-orange position-relative">
              <i class="bi bi-broadcast icon"></i>
              <div>
                <h3 class="text-dark">Akses ke Konten Eksklusif</h3>
                <p>Memberikan pengguna sumber daya tambahan yang berkualitas, memperluas wawasan mereka tentang topik tertentu, serta mendukung pemahaman yang lebih mendalam melalui materi yang tidak tersedia di platform lain.</p>
              
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item item-teal position-relative">
              <i class="bi bi-easel icon"></i>
              <div>
                <h3 class="text-dark">Pembelajaran Berkelanjutan</h3>
                <p>Dukungan berkelanjutan melalui forum dan sesi tanya jawab memungkinkan pengguna untuk terus belajar, beradaptasi dengan perubahan industri, dan tetap terhubung dengan mentor dan komunitas.</p>
              
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
            <div class="service-item item-red position-relative">
              <i class="bi bi-bounding-box-circles icon"></i>
              <div>
                <h3 class="text-dark">Uji Coba Gratis dan Penawaran Spesial</h3>
                <p>Innosphere menawarkan uji coba gratis untuk kursus tertentu, memungkinkan pengguna untuk merasakan pengalaman belajar sebelum berkomitmen. </p>
              
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
            <div class="service-item item-indigo position-relative">
              <i class="bi bi-calendar4-week icon"></i>
              <div>
                <h3 class="text-dark">Pelatihan Soft SKill</h3>
                <p>Innosphere juga menawarkan pelatihan soft skill seperti komunikasi, kepemimpinan, dan manajemen waktu. Keterampilan ini penting untuk pengembangan profesional dan keberhasilan karir.</p>
              
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
            <div class="service-item item-pink position-relative">
              <i class="bi bi-chat-square-text icon"></i>
              <div>
                <h3 class="text-dark">Bimbingan Karir dan Konsultasi</h3>
                <p>Innosphere memberikan layanan konsultasi karir seperti bimbingan tentang keterampilan yang diperlukan, persiapan wawancara, dan penyusunan CV yang efektif.</p>
              
              </div>
            </div>
          </div><!-- End Service Item -->

        </div>

      </div>

    </section><!-- /Services Section -->

    <!-- More Features Section -->
    <section id="more-features" class="more-features section">

      <div class="container">

        <div class="row justify-content-around gy-4">

          <div class="col-lg-6   d-flex flex-column justify-content-center order-2 order-lg-1 text-light" data-aos="fade-up" data-aos-delay="100">
            <h3> Program unggulan di Innosphere </h3>
            <p>program ini dirancang dengan metode pembelajaran berbasis proyek, studi kasus dari industri, serta bimbingan mentor ahli. </p>

            <div class="row">

              <div class="col-lg-6 icon-box d-flex">
                <i class="bi bi-easel flex-shrink-0"></i>
                <div>
                  <h4>Pengembangan Web Full Stack</h4>
                  <p>Program intensif yang mencakup pengembangan front-end dan back-end.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-lg-6 icon-box d-flex">
                <i class="bi bi-patch-check flex-shrink-0"></i>
                <div>
                  <h4>AI & Machine Learning</h4>
                  <p>mengajarkan dasar-dasar dan aplikasi AI serta machine learning dengan Python</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-lg-6 icon-box d-flex">
                <i class="bi bi-brightness-high flex-shrink-0"></i>
                <div>
                  <h4>Desain UX/UI</h4>
                  <p>berfokus pada prinsip-prinsip desain antarmuka yang user-friendly, estetika, dan fungsional.</p>
                </div>
              </div><!-- End Icon Box -->

              <div class="col-lg-6 icon-box d-flex">
                <i class="bi bi-brightness-high flex-shrink-0"></i>
                <div>
                  <h4>Mobile App</h4>
                  <p>mencakup pengembangan aplikasi mobile untuk Android dan iOS</p>
                </div>
              </div><!-- End Icon Box -->

            </div>

          </div>

          <div class="features-image col-lg-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
            <img src="assets-1/img/features-3.jpg" alt="">
          </div>

        </div>

      </div>

    </section><!-- /More Features Section -->



    <!-- Faq Section -->
    <section id="faq" class="faq section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Frequently Asked Questions (FAQ)</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row justify-content-center">

          <div class="col-lg-10" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              <div class="faq-item text-light border-light">
                <h3>Apa itu Innosphere?</h3>
                <div class="faq-content">
                  <p>Innosphere adalah platform pembelajaran online yang menawarkan berbagai kursus teknologi, seperti pengembangan web, data science, dan kecerdasan buatan, yang dirancang untuk mempersiapkan peserta menjadi profesional di bidang teknologi.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item  text-light border-light">
                <h3>Bagaimana cara mendaftar di kursus Innosphere?</h3>
                <div class="faq-content">
                  <p>Anda bisa mendaftar dengan membuat akun gratis di website Innosphere, lalu memilih kursus atau program yang diinginkan. Setelah pembayaran, Anda akan mendapat akses ke materi kursus dan dapat mulai belajar kapan saja.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item  text-light border-light">
                <h3>Apakah kursus di Innosphere dapat diakses kapan saja?</h3>
                <div class="faq-content">
                  <p>Ya, sebagian besar kursus kami berbasis self-paced, artinya Anda dapat mengakses dan mempelajarinya kapan pun sesuai jadwal Anda. Kami juga memiliki program pelatihan intensif dengan jadwal khusus untuk pembelajaran yang lebih terstruktur.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item  text-light border-light">
                <h3>Apakah ada sertifikat yang diberikan setelah menyelesaikan kursus?</h3>
                <div class="faq-content">
                  <p>Ya, setiap kursus di Innosphere menawarkan sertifikat yang bisa Anda gunakan untuk menambah nilai di resume atau profil LinkedIn Anda. Sertifikat ini diberikan setelah Anda menyelesaikan semua modul dan lulus ujian akhir kursus.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

              <div class="faq-item  text-light border-light">
                <h3>Apakah ada sesi tanya jawab atau mentor yang bisa membantu saya belajar?</h3>
                <div class="faq-content">
                  <p>Tentu! Di Innosphere, Anda bisa berinteraksi dengan mentor ahli dan mengajukan pertanyaan di forum diskusi atau sesi tanya jawab. Bimbingan ini dirancang untuk membantu Anda memahami materi lebih dalam.p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section light-background">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2 style="color: black;">Testimoni</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Innosphere benar-benar mengubah cara saya belajar teknologi. Materinya up-to-date dan relevan
                </p>
                <div class="profile mt-auto">
                  <img src="assets-1/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                  <h3>Saul Goodman</h3>
                  <h4>Ceo &amp; Founder</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Mentor di Innosphere sangat berpengalaman dan selalu membantu. Pembelajarannya jelas dan terarah.
                </p>
                <div class="profile mt-auto">
                  <img src="assets-1/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                  <h3>Sara Wilsson</h3>
                  <h4>Designer</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Setelah belajar di sini, saya lebih percaya diri dan siap menghadapi tantangan di dunia kerja
                </p>
                <div class="profile mt-auto">
                  <img src="assets-1/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                  <h3>Jena Karlis</h3>
                  <h4>Store Owner</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Platform Innosphere user-friendly dan penuh dengan konten berkualitas tinggi. Sangat puas!
                </p>
                <div class="profile mt-auto">
                  <img src="assets-1/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                  <h3>Matt Brandon</h3>
                  <h4>Freelancer</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  Dari nol sampai mahir! Innosphere punya kursus lengkap yang sangat membantu perkembangan saya
                </p>
                <div class="profile mt-auto">
                  <img src="assets-1/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                  <h3>John Larson</h3>
                  <h4>Entrepreneur</h4>
                </div>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Contact</h2>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center p-3"  data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-geo-alt"></i>
              <h3>Address</h3>
              <p">Jl. Arief Rahman Hakim No.100, Klampis Ngasem, Kec. Sukolilo, Surabaya, Jawa Timur 60117</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6 ">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-telephone"></i>
              <h3>Call Us</h3>
              <p>+62 857-3104-0360</p>
            </div>
          </div><!-- End Info Item -->

          <div class="col-lg-3 col-md-6">
            <div class="info-item d-flex flex-column justify-content-center align-items-center" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-envelope"></i>
              <h3>Email Us</h3>
              <p>itats@gmail.com</p>
            </div>
          </div><!-- End Info Item -->

        </div>

        <div class="row gy-4 mt-1">
          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.558779015599!2d112.77634647379682!3d-7.290934921660813!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fa469f2b37b5%3A0x8d971ebe4e20a0d5!2sInstitut%20Teknologi%20Adhi%20Tama%20Surabaya!5e0!3m2!1sid!2sid!4v1730466262070!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div><!-- End Google Maps -->

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="400">
              <div class="row gy-4">

                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" placeholder="Your Name" required="">
                </div>

                <div class="col-md-6 ">
                  <input type="email" class="form-control" name="email" placeholder="Your Email" required="">
                </div>

                <div class="col-md-12">
                  <input type="text" class="form-control" name="subject" placeholder="Subject" required="">
                </div>

                <div class="col-md-12">
                  <textarea class="form-control" name="message" rows="6" placeholder="Message" required=""></textarea>
                </div>

                <div class="col-md-12 text-center">
                  <div class="loading">Loading</div>
                  <div class="error-message"></div>
                  <div class="sent-message">Your message has been sent. Thank you!</div>

                  <button type="submit">Send Message</button>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

  <footer id="footer" class="footer position-relative light-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="logo d-flex align-items-center ">
            <span class="sitename text-dark">INNOSPHERE</span>
          </a>
          <div class="footer-contact pt-3">
            <p>Jl. Arief Rahman Hakim No.100</p>
            <p> Klampis Ngasem, Kec. Sukolilo</p>
            <p>Surabaya, Jawa Timur 60117</p>
            <p class="mt-3"><strong>Phone:</strong> <span>+62 857-3104-0360</span></p>
            <p><strong>Email:</strong> <span>itats@gmail.com</span></p>
          </div>
          <div class="social-links d-flex mt-4">
            <a href=""><i class="bi bi-twitter-x"></i></a>
            <a href=""><i class="bi bi-facebook"></i></a>
            <a href=""><i class="bi bi-instagram"></i></a>
            <a href=""><i class="bi bi-linkedin"></i></a>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4 class="text-dark">Useful Links</h4>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">About us</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Terms of service</a></li>
            <li><a href="#">Privacy policy</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4 class="text-dark">Our Services</h4>
          <ul>
            <li><a href="#">Web Design</a></li>
            <li><a href="#">Web Development</a></li>
            <li><a href="#">Product Management</a></li>
            <li><a href="#">AI & Machine learning</a></li>
            <li><a href="#">Graphic Design</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12 footer-newsletter">
          <h4 class="text-dark">Our Newsletter</h4>
          <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
          <form action="forms/newsletter.php" method="post" class="php-email-form">
            <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your subscription request has been sent. Thank you!</div>
          </form>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">Innosphere</strong><span>All Rights Reserved</span></p>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets-1/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets-1/vendor/php-email-form/validate.js"></script>
  <script src="assets-1/vendor/aos/aos.js"></script>
  <script src="assets-1/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets-1/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets-1/js/main.js">
    
  </script>

</body>

</html>