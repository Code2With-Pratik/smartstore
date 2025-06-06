<?php
// dashboard.php

session_start();

// Redirect to login if not authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/smartstore/");
    exit();
}

// Dummy balance for demonstration; replace with real data as needed
$balance = isset($_SESSION['balance']) ? number_format($_SESSION['balance'], 2) : "0.00";

// Determine which page/tab is active (default = dashboard)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Whitelist of allowed pages
$allowedPages = [
    'dashboard',
    'profileAnalyzer',
    'orders',
    'favorites',
    'ticket',
    'addFunds',
    'settings'
];
if (!in_array($page, $allowedPages)) {
    // If somehow someone passes a page that doesn't exist, default to dashboard
    $page = 'dashboard';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Dashboard – SmartStore</title>
  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#eef6fc] min-h-screen flex flex-col">

  <!-- ================= Navbar ================= -->
  <header class="w-full bg-white shadow sticky top-0 z-50">
     <?php
     include './dashboardContent/navbar.php';
     ?>
  </header>

  <!-- ================= Main Layout ================= -->
  <div class="flex-1 flex flex-wrap">
    <!-- ================= Sidebar (Desktop only) ================= -->
     <?php
      include './dashboardContent/userCardAndMenuOptions.php'
     ?>

     <!-- ================= Main Content Area ================= -->
    <main class="flex-1 p-6">
      <?php
        switch ($page) {
          case 'dashboard':
            include './dashboardMenuContents/dashboardMainContent.php';
            break;
          case 'profileAnalyzer':
            include './dashboardMenuContents/profileAnalyzer.php';
            break;
          case 'orders':
            include './dashboardMenuContents/orders.php';
            break;
          case 'favorites':
            include './dashboardMenuContents/favorites.php';
            break;
          case 'ticket':
            include './dashboardMenuContents/ticket.php';
            break;
          case 'addFunds':
            include './dashboardMenuContents/addFunds.php';
            break;
          case 'settings':
            include './dashboardMenuContents/settings.php';
            break;
          default:
            // Should never get here due to our whitelist above
            include './dashboardMenuContents/dashboardMainContent.php';
            break;
        }
      ?>
    </main>
  </div> <!-- end of main flex wrapper -->

  <!-- ================= Footer ================= -->
  <footer class="mt-8">
    <?php 
      include './dashboardContent/footer.php';
    ?>
  </footer>

  <!-- ================= JavaScript for Interactions ================= -->
  <script>
    // MOBILE: Toggle sidebar + mobile-nav when hamburger is clicked
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar       = document.getElementById('sidebar');
    const mobileNav     = document.getElementById('mobile-nav');
    mobileMenuBtn.addEventListener('click', () => {
      // sidebar.classList.toggle('hidden');
      mobileNav.classList.toggle('hidden');
    });

    // DESKTOP: Navbar dropdown toggles
    const navItems = [
      { buttonId: 'nav-instagram-btn', menuId: 'dropdown-instagram' },
      { buttonId: 'nav-twitter-btn',   menuId: 'dropdown-twitter' },
      { buttonId: 'nav-tiktok-btn',    menuId: 'dropdown-tiktok' },
      { buttonId: 'nav-others-btn',    menuId: 'dropdown-others' },
      { buttonId: 'nav-tools-btn',     menuId: 'dropdown-tools' },
    ];
    navItems.forEach(item => {
      const btn      = document.getElementById(item.buttonId);
      const dropdown = document.getElementById(item.menuId);
      dropdown.classList.add('hidden'); // start hidden

      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        // Close all other dropdowns
        navItems.forEach(i => {
          if (i.menuId !== item.menuId) {
            document.getElementById(i.menuId).classList.add('hidden');
          }
        });
        // Toggle this one
        dropdown.classList.toggle('hidden');
      });
    });

    // Clicking anywhere outside closes all open dropdowns
    document.addEventListener('click', () => {
      navItems.forEach(i => {
        document.getElementById(i.menuId).classList.add('hidden');
      });
    });

    // MOBILE: toggling each mobile submenu
    document.querySelectorAll('#mobile-nav button[data-target]').forEach(btn => {
      const subMenuId = btn.getAttribute('data-target');
      const subMenu   = document.getElementById(subMenuId);
      subMenu.classList.add('hidden');
      btn.addEventListener('click', () => {
        subMenu.classList.toggle('hidden');
      });
    });

    // SIDEBAR: collapse menu on desktop
    const toggleBtn = document.getElementById('menu-toggle');
    const menuItems = document.getElementById('menu-items');
    const arrowIcon = document.getElementById('menu-arrow');
    // Ensure sidebar menu is visible by default on ≥ md
    menuItems.classList.remove('hidden');
    toggleBtn.addEventListener('click', () => {
      menuItems.classList.toggle('hidden');
      arrowIcon.classList.toggle('rotate-180');
    });
  </script>
</body>
</html>
