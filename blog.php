<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Innosphere Blog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
        <style>
            :root {
                --default-color: #090b85;
                --accent-color: #4e44ff;
                --nav-color: #333;
            }

            :root {
                --default-font: "Roboto", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial,
                    "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol",
                    "Noto Color Emoji";
                --heading-font: "Nunito", sans-serif;
                --nav-font: "Inter", sans-serif;
            }

            body {
                font-family: "Poppins", sans-serif;
                margin: 0;
                padding: 0;
                font-family: var(--default-font);
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
                font-family: var(--default-font);
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
            /* Hero Section */
            .blog-hero {
                background: linear-gradient(rgba(9, 11, 133, 0.9), rgba(9, 11, 133, 0.9)),
                    url("https://source.unsplash.com/random/1920x1080/?technology") no-repeat center center;
                background-size: cover;
                padding: 120px 0 60px;
                color: white;
                text-align: center;
                margin-bottom: 50px;
            }

            /* Blog Cards */
            .blog-card {
                border: none;
                transition: transform 0.3s;
                margin-bottom: 30px;
                overflow: hidden;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                border-radius: 15px;
            }

            .blog-card:hover {
                transform: translateY(-10px);
            }

            .blog-card img {
                height: 200px;
                object-fit: cover;
                transition: transform 0.3s;
            }

            .blog-card:hover img {
                transform: scale(1.1);
            }

            .blog-card .card-body {
                padding: 25px;
            }

            .blog-category {
                background-color: var(--accent-color);
                color: white;
                padding: 5px 15px;
                border-radius: 20px;
                font-size: 12px;
                display: inline-block;
                margin-bottom: 10px;
            }

            .blog-meta {
                color: #666;
                font-size: 14px;
                margin-bottom: 15px;
            }

            .read-more {
                color: var(--accent-color);
                font-weight: 600;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
            }

            .read-more:hover {
                color: var(--default-color);
            }

            /* Newsletter Section */
            .newsletter {
                background-color: #f8f9fa;
                padding: 60px 0;
                margin: 50px 0;
            }

            .newsletter-box {
                background: white;
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            }

            /* Footer */
            .footer {
                background-color: var(--default-color);
                padding: 50px 0 20px;
                color: white;
            }

            .footer-links {
                list-style: none;
                padding: 0;
            }

            .footer-links li {
                margin-bottom: 10px;
            }

            .footer-links a {
                color: white;
                text-decoration: none;
                transition: 0.3s;
            }

            .footer-links a:hover {
                color: var(--accent-color);
                padding-left: 5px;
            }

            .social-links {
                margin-top: 20px;
            }

            .social-links a {
                color: white;
                font-size: 18px;
                margin-right: 15px;
                transition: 0.3s;
            }

            .social-links a:hover {
                color: var(--accent-color);
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">
                <a href="index.php" class="logo d-flex align-items-center me-auto " style="text-decoration: none;">
                    <img src="assets-1/img/clients/logo.png" alt="" />
                    <h1>INNOSPHERE</h1>
                </a>
                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="index.php#hero" class="active">Home</a></li>
                        <li><a href="blog.php">Blog</a></li>
                        <li><a href="about.php">About</a></li>
                    </ul>
                </nav>
                <a href="login.php" class="btn-getstarted">Login</a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="blog-hero">
            <div class="container">
                <h1 class="display-4 fw-bold mb-4">Blog Innosphere</h1>
                <p class="lead mb-4">Temukan insight terbaru seputar teknologi, programming, dan pengembangan diri</p>
                <div class="col-md-6 mx-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari artikel..." />
                        <button class="btn btn-warning" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Blog Section -->
        <section class="py-5">
            <div class="container">
                <!-- Featured Post -->
                <div class="row mb-5">
                    <div class="col-lg-8 mx-auto text-center">
                        <h2 class="fw-bold mb-4">Artikel Terbaru</h2>
                        <p class="text-muted">
                            Pelajari berbagai insight dan pengetahuan terkini dari para ahli di bidangnya
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="blog-card card">
                            <img
                                src="assets-1/img/blog/blog_dua.jpg"
                                class="card-img-top"
                                alt="Web Development"
                            />
                            <div class="card-body">
                                <span class="blog-category">Web Development</span>
                                <h3 class="card-title h5 fw-bold">Tips Menjadi Full Stack Developer di Tahun 2024</h3>
                                <div class="blog-meta">
                                    <i class="far fa-calendar me-2"></i>March 15, 2024
                                    <i class="far fa-user ms-3 me-2"></i>John Doe
                                </div>
                                <p class="card-text">
                                    Pelajari langkah-langkah dan skill yang dibutuhkan untuk menjadi full stack
                                    developer yang kompeten di era modern.
                                </p>
                                <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="blog-card card">
                            <img
                                src="assets-1/img/blog/blog_tiga.jpg"
                                class="card-img-top"
                                alt="AI"
                            />
                            <div class="card-body">
                                <span class="blog-category">Artificial Intelligence</span>
                                <h3 class="card-title h5 fw-bold">Pengenalan Machine Learning untuk Pemula</h3>
                                <div class="blog-meta">
                                    <i class="far fa-calendar me-2"></i>March 14, 2024
                                    <i class="far fa-user ms-3 me-2"></i>Jane Smith
                                </div>
                                <p class="card-text">
                                    Memahami dasar-dasar machine learning dan implementasinya dalam kehidupan
                                    sehari-hari.
                                </p>
                                <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="blog-card card">
                            <img
                                src="assets-1/img/blog/blog_satu.jpg"
                                class="card-img-top"
                                alt="Security"
                            />
                            <div class="card-body">
                                <span class="blog-category">Cyber Security</span>
                                <h3 class="card-title h5 fw-bold">Pentingnya Keamanan Siber di Era Digital</h3>
                                <div class="blog-meta">
                                    <i class="far fa-calendar me-2"></i>March 13, 2024
                                    <i class="far fa-user ms-3 me-2"></i>Mike Johnson
                                </div>
                                <p class="card-text">
                                    Tips dan strategi untuk melindungi data dan privasi Anda di dunia digital yang
                                    semakin kompleks.
                                </p>
                                <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="blog-card card">
                            <img
                                src="assets-1/img/blog/blog_dua.jpg"
                                class="card-img-top"
                                alt="Web Development"
                            />
                            <div class="card-body">
                                <span class="blog-category">Web Development</span>
                                <h3 class="card-title h5 fw-bold">Tips Menjadi Full Stack Developer di Tahun 2024</h3>
                                <div class="blog-meta">
                                    <i class="far fa-calendar me-2"></i>March 15, 2024
                                    <i class="far fa-user ms-3 me-2"></i>John Doe
                                </div>
                                <p class="card-text">
                                    Pelajari langkah-langkah dan skill yang dibutuhkan untuk menjadi full stack
                                    developer yang kompeten di era modern.
                                </p>
                                <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="blog-card card">
                            <img
                                src="assets-1/img/blog/blog_tiga.jpg"
                                class="card-img-top"
                                alt="AI"
                            />
                            <div class="card-body">
                                <span class="blog-category">Artificial Intelligence</span>
                                <h3 class="card-title h5 fw-bold">Pengenalan Machine Learning untuk Pemula</h3>
                                <div class="blog-meta">
                                    <i class="far fa-calendar me-2"></i>March 14, 2024
                                    <i class="far fa-user ms-3 me-2"></i>Jane Smith
                                </div>
                                <p class="card-text">
                                    Memahami dasar-dasar machine learning dan implementasinya dalam kehidupan
                                    sehari-hari.
                                </p>
                                <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="blog-card card">
                            <img
                                src="assets-1/img/blog/blog_satu.jpg"
                                class="card-img-top"
                                alt="Security"
                            />
                            <div class="card-body">
                                <span class="blog-category">Cyber Security</span>
                                <h3 class="card-title h5 fw-bold">Pentingnya Keamanan Siber di Era Digital</h3>
                                <div class="blog-meta">
                                    <i class="far fa-calendar me-2"></i>March 13, 2024
                                    <i class="far fa-user ms-3 me-2"></i>Mike Johnson
                                </div>
                                <p class="card-text">
                                    Tips dan strategi untuk melindungi data dan privasi Anda di dunia digital yang
                                    semakin kompleks.
                                </p>
                                <a href="#" class="read-more">Baca Selengkapnya <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    
        </section>

        <!-- Newsletter Section -->
        <section class="newsletter">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="newsletter-box text-center">
                            <h3 class="fw-bold mb-4">Subscribe Newsletter</h3>
                            <p class="text-muted mb-4">Dapatkan update artikel terbaru langsung di inbox Anda</p>
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Masukkan email Anda" />
                                <button class="btn btn-primary">Subscribe</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <h3 class="mb-4">INNOSPHERE</h3>
                        <p>Platform pembelajaran teknologi terdepan untuk mengembangkan skill digital Anda.</p>
                        <div class="social-links">
                            <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h5 class="mb-4">Quick Links</h5>
                        <ul class="footer-links">
                            <li><a href="#">Home</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Courses</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="mb-4">Categories</h5>
                        <ul class="footer-links">
                            <li><a href="#">Web Development</a></li>
                            <li><a href="#">Mobile Development</a></li>
                            <li><a href="#">Data Science</a></li>
                            <li><a href="#">Cyber Security</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <h5 class="mb-4">Contact Info</h5>
                        <ul class="footer-links">
                            <li><i class="fas fa-map-marker-alt me-2"></i> Jakarta, Indonesia</li>
                            <li><i class="fas fa-phone me-2"></i> +62 123 456 789</li>
                            <li><i class="fas fa-envelope me-2"></i> info@innosphere.com</li>
                        </ul>
                    </div>
                </div>
                <hr class="mt-4 mb-4" />
                <div class="text-center">
                    <p class="mb-0">&copy; 2024 Innosphere. All rights reserved.</p>
                </div>
            </div>

        </footer>
       
        <script src="assets-1/js/blog.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
