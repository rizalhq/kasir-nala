<!DOCTYPE html>

<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
==============================================================

* Product Page: https://themeselection.com/products/sneat-bootstrap-html-admin-template/
* Created by: ThemeSelection
* License: You must have a valid license purchased in order to legally use the theme for your project.
* Copyright ThemeSelection (https://themeselection.com)

=========================================================
 -->
<!-- beautify ignore:start -->
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url('aset/sneat')?>/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Dashboard - Nala Media</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('aset/sneat')?>/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="<?= base_url('aset/sneat')?>/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('aset/sneat')?>/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('aset/sneat')?>/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('aset/sneat')?>/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('aset/sneat')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="<?= base_url('aset/sneat')?>/assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="<?= base_url('aset/sneat')?>/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('aset/sneat')?>/assets/js/config.js"></script>
    <style>
        .green-filter {
            filter: brightness(0) saturate(100%) invert(50%) sepia(100%) saturate(500%) hue-rotate(90deg) brightness(1);
        }
        .red-filter {
            filter: brightness(0) saturate(100%) invert(50%) sepia(100%) saturate(5000%) hue-rotate(-10deg) brightness(1.2);
        }
    </style>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo text-center d-flex justify-content-center align-items-center">
              <a href="<?= base_url('home') ?>" class="app-brand-link">
                <span class="app-brand-logo demo text-primary" style="font-size: 30px; font-weight: bold; margin-top: 20px;">
                    Nala Media
                    <div style="font-size: 16px; color: #6c757d; margin-top: -3px; margin-bottom: 3px; letter-spacing: 2px;">
                        Digital Printing
                    </div>
                </span>
              </a>

              <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                  <i class="bx bx-chevron-left bx-sm align-middle"></i>
              </a>
          </div>

          <?php $halaman = $this->uri->segment(1);?>
          <ul class="menu-inner py-1">
              <!-- Dashboard -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Navigasi</span></li>
            <?php if($this->session->userdata('level')=='admin'){?>
            <li class="menu-item <?php if($halaman=='home'){ echo "active"; }?>">
              <a href="<?= base_url('home') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
            <?php } ?>
            <li class="menu-item <?php if($halaman=='penjualan'){ echo "active"; }?>">
              <a href="<?= base_url('penjualan') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-line-chart"></i>
                <div data-i18n="Analytics">Penjualan</div>
              </a>
            </li>
            <!-- <li class="menu-item <?php if($halaman=='pembelian'){ echo "active"; }?>">
              <a href="<?= base_url('pembelian') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Analytics">Pembelian Bahan</div>
              </a>
            </li> -->
            <li class="menu-item <?php if($halaman=='stok'){ echo "active"; }?>">
              <a href="<?= base_url('stok') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-cart"></i>
                <div data-i18n="Analytics"> Pembelian Stok Bahan</div>
              </a>
            </li>
            <li class="menu-item <?php if($halaman=='pengeluaran'){ echo "active"; }?>">
              <a href="<?= base_url('pengeluaran') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Analytics">Pengeluaran</div>
              </a>
            </li>
            <li class="menu-item <?php if($halaman=='produk'){ echo "active"; }?>">
              <a href="<?= base_url('produk') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-store"></i>
                <div data-i18n="Analytics">Produk</div>
              </a>
            </li>
            <?php if($this->session->userdata('level')=='admin'){?>
            <li class="menu-item <?php if($halaman=='staff'){ echo "active"; }?>">
              <a href="<?= base_url('staff') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-lock"></i>
                <div data-i18n="Analytics">Staff</div>
              </a>
            </li>
            <?php } ?>
            <li class="menu-item <?php if($halaman=='pelanggan'){ echo "active"; }?>">
              <a href="<?= base_url('pelanggan') ?>" class="menu-link">
                <i class="menu-icon tf-icons bx bx-group"></i>
                <div data-i18n="Analytics">Pelanggan</div>
              </a>
            </li>
          </ul>
        </aside>
        <!-- / Menu -->
        
        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->

          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <?= $judul_halaman; ?>
              <!-- /Search -->

              <ul class="navbar-nav flex-row align-items-center ms-auto">

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="<?= base_url('aset/sneat')?>/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="<?= base_url('aset/sneat')?>/assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block"><?= $this->session->userdata('username'); ?></span>
                            <small class="text-muted"><?= $this->session->userdata('level'); ?></small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="<?= base_url('auth/logout')?>">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <?= $contents ?>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                <div class="mb-2 mb-md-0">
                  ©
                  <script>
                    document.write(new Date().getFullYear());
                  </script>
                  , Nala Media
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url('aset/sneat')?>/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url('aset/sneat')?>/assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url('aset/sneat')?>/assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url('aset/sneat')?>/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="<?= base_url('aset/sneat')?>/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?= base_url('aset/sneat')?>/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="<?= base_url('aset/sneat')?>/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="<?= base_url('aset/sneat')?>/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
