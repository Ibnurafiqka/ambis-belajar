<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Tentang Kami - Innosphere</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            body {
                font-family: "Poppins", sans-serif;
                margin: 0;
                padding: 0;
            }

            /* Header Styles */
            .header {
                padding: 15px;
                color: var(--default-color);
                background-color: white;
                width: 100%;
                transition: all 0.5s;
                z-index: 997;
            }

            .header .logo {
                line-height: 1;
                display: flex;
                align-items: center;
            }

            .header .logo img {
                height: 50px;
                margin-right: 8px;
            }

            .header .logo h1 {
                font-size: 20px;
                margin: 0;
                font-weight: 700;
            }

            .header .btn-getstarted,
            .header .btn-getstarted:focus {
                color: black;
                background-color: #ffffff;
                font-size: 15px;
                padding: 8px 25px;
                border: none;
                transition: 0.3s;
                border: 1px solid black;
            }

            .header .btn-getstarted:hover {
                background-color: #023e3f;
                color: white;
            }

            /* Navbar Styling */
            .navmenu ul {
                margin: 0;
                padding: 0;
                display: flex;
                list-style: none;
                align-items: center;
            }

            .navmenu li {
                position: relative;
            }

            .navmenu a {
                color: var(--nav-color);
                padding: 15px 20px;
                font-size: 16px;
                font-weight: 500;
                text-decoration: none;
                display: block;
                transition: 0.3s;
            }
            .hero-section {
                background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                    url("assets-1/img/about-company-3.jpg") no-repeat center center;
                background-size: cover;
                height: 60vh;
                color: white;
                display: flex;
                align-items: center;
            }

            .team-member img {
                width: 150px;
                height: 150px;
                object-fit: cover;
                border-radius: 50%;
                margin-bottom: 1rem;
            }

            .stats-box {
                padding: 2rem;
                text-align: center;
                border-radius: 10px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s;
            }

            .stats-box:hover {
                transform: translateY(-5px);
            }

            .value-icon {
                font-size: 2.5rem;
                margin-bottom: 1rem;
                color: #0d6efd;
            }
        </style>
    </head>
    <body>
        <!-- header -->
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">
                <a href="index.html" class="logo d-flex align-items-center me-auto" style="text-decoration: none;">
                    <img src="assets-1/img/clients/logo.png" alt="" />
                    <h1>INNOSPHERE</h1>
                </a>
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="index.html#hero" class="active">Home</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="about.php">About</a></li>
                    </ul>
                </nav>
                <a href="login.php" class="btn-getstarted">Login</a>
            </div>
        </header>
        <!-- header end -->
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container text-center">
                <h1 class="display-3 fw-bold mb-4">Tentang Kami</h1>
                <p class="lead">
                    Memberdayakan Inovator Masa Depan dengan Keterampilan dan Pengetahuan di Bidang Teknologi
                </p>
            </div>
        </section>

        <!-- Our Story Section -->
        <section class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="fw-bold mb-4">Kisah Kami</h2>
                        <p class="lead mb-4">
                            Didirikan pada tahun 2023, Innosphere bertujuan untuk menjembatani kesenjangan antara
                            pendidikan dan industri melalui pengalaman belajar yang inovatif.
                        </p>
                        <p class="mb-4">
                            Innosphere didirikan untuk membantu calon pengembang dan penggemar teknologi memperoleh
                            keterampilan praktis dan tetap mengikuti tren teknologi terbaru. Kami percaya pada
                            pembelajaran interaktif yang memungkinkan pembelajar membangun keterampilan dunia nyata.
                        </p>
                        <button class="btn btn-primary btn-lg">Pelajari Lebih Lanjut</button>
                    </div>
                    <div class="col-lg-6">
                        <img
                            src="assets-1/img/about-company-2.jpg"
                            alt="Kisah Kami"
                            class="img-fluid rounded shadow"
                        />
                    </div>
                </div>
            </div>
        </section>

        <!-- Company Values -->
        <section class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center fw-bold mb-5">Nilai Kami</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="stats-box bg-white">
                            <i class="fas fa-heart value-icon"></i>
                            <h4 class="fw-bold">Semangat Belajar</h4>
                            <p>
                                Kami didorong oleh semangat belajar yang mendalam dan berkomitmen untuk mendukung
                                pertumbuhan orang lain.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-box bg-white">
                            <i class="fas fa-handshake value-icon"></i>
                            <h4 class="fw-bold">Integritas & Komunitas</h4>
                            <p>
                                Kami menghargai transparansi, praktik etis, dan membangun komunitas pembelajaran yang
                                mendukung.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-box bg-white">
                            <i class="fas fa-lightbulb value-icon"></i>
                            <h4 class="fw-bold">Inovasi dalam Pendidikan</h4>
                            <p>
                                Pendekatan kami berfokus pada pendidikan praktis terkini
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="py-5">
            <div class="container">
                <h2 class="text-center fw-bold mb-5">Temui Tim Innosphere</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="text-center team-member">
                            <img
                                src="assets-1/img/testimonials/testimonials-1.jpg"
                                alt="Anggota Tim 1"
                            />
                            <h4 class="fw-bold">John Doe</h4>
                            <p class="text-muted">CEO & Pendiri</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center team-member">
                            <img
                                src="assets-1/img/testimonials/testimonials-2.jpg"
                                alt="Anggota Tim 2"
                            />
                            <h4 class="fw-bold">Jane Smith</h4>
                            <p class="text-muted">Direktur Kreatif</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center team-member">
                            <img
                                src="assets-1/img/testimonials/testimonials-3.jpg"
                                alt="Anggota Tim 3"
                            />
                            <h4 class="fw-bold">Mike Johnson</h4>
                            <p class="text-muted">Pemimpin Teknis</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-5 bg-primary text-white">
            <div class="container">
                <div class="row text-center g-4">
                    <div class="col-md-3">
                        <h2 class="fw-bold">1000+</h2>
                        <p>Siswa Terdaftar</p>
                    </div>
                    <div class="col-md-3">
                        <h2 class="fw-bold">50+</h2>
                        <p>Kursus Tersedia</p>
                    </div>
                    <div class="col-md-3">
                        <h2 class="fw-bold">20+</h2>
                        <p>Instruktur Ahli</p>
                    </div>
                    <div class="col-md-3">
                        <h2 class="fw-bold">10k+</h2>
                        <p>Anggota Komunitas</p>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
