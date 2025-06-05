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
    <div class="max-w-screen   px-4 sm:px-6 lg:px-8 flex items-center justify-between  h-16">
      <!-- Left Side: Logo and (mobile) hamburger -->
      <div class="flex items-center gap-4">
        <!-- Hamburger for Mobile (visible < md) -->
        <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
        <!-- Logo (always visible) -->
        <img src="../assets/images/logo.png" alt="SmartStore Logo" class="h-8  w-auto" />
      </div>

      <!-- Middle: (Desktop) Nav Items (hidden on mobile) -->
      <nav id="desktop-nav" class="hidden  md:flex items-center space-x-6">
        <!-- Instagram -->
        <div class="relative">
          <button id="nav-instagram-btn" class="flex items-center space-x-1 text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
            <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7.4 2H16.6C20 2 22 4 22 7.4V16.6C22 20 20 22 16.6 22H7.4C4 22 2 20 2 16.6V7.4C2 4 4 2 7.4 2Z" />
              <path d="M12 8A4 4 0 1 0 12 16A4 4 0 0 0 12 8Z" />
              <path d="M17.5 6.5A1 1 0 1 0 17.5 8.5A1 1 0 0 0 17.5 6.5Z" />
            </svg>
            <span class="font-medium">Instagram</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <!-- Instagram Dropdown (Desktop) -->
          <div id="dropdown-instagram" class="hidden absolute left-1/2 transform -translate-x-1/2 mt-2 w-screen max-w-4xl bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              <!-- Explore Follower Packages -->
              <div>
                <h4 class="text-gray-800 font-semibold mb-3">Explore Follower Packages</h4>
                <ul class="space-y-2 text-gray-700">
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Premium Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Real Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>USA Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Brazilian Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>UK Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Geo-Targeted Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Female Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Indian Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Arab Followers</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                      </svg>
                    </div>
                    <span>Channel Members</span>
                  </li>
                </ul>
              </div>

              <!-- Explore Like Packages -->
              <div>
                <h4 class="text-gray-800 font-semibold mb-3">Explore Like Packages</h4>
                <ul class="space-y-2 text-gray-700">
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114:0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>Real Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>Premium Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>USA Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>UK Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>Brazilian Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>Arab Likes</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 10a2 2 0 114 0 2 2 0 01-4 0zM8 10a4 4 0 818 0 4 4 0 01-8 0zM16 10a2 2 0 114 0 2 2 0 01-4 0z"/>
                      </svg>
                    </div>
                    <span>Monthly Likes</span>
                  </li>
                </ul>
              </div>

              <!-- Explore Viewer Packages -->
              <div>
                <h4 class="text-gray-800 font-semibold mb-3">Explore Viewer Packages</h4>
                <ul class="space-y-2 text-gray-700">
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a7 7 0 016.32 10.16l2.18 2.18a1 1 0 01-1.42 1.42l-2.18-2.18A7 7 0 1110 3z"/>
                      </svg>
                    </div>
                    <span>Views</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a7 7 0 016.32 10.16l2.18 2.18a1 1 0 01-1.42 1.42l-2.18-2.18A7 7 0 1110 3z"/>
                      </svg>
                    </div>
                    <span>Reels Views</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a7 7 0 016.32 10.16l2.18 2.18a1 1 0 01-1.42 1.42l-2.18-2.18A7 7 0 1110 3z"/>
                      </svg>
                    </div>
                    <span>Story Views</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 3a7 7 0 016.32 10.16l2.18 2.18a1 1 0 01-1.42 1.42l-2.18-2.18A7 7 0 1110 3z"/>
                      </svg>
                    </div>
                    <span>Live Views</span>
                  </li>
                </ul>
              </div>

              <!-- Other Instagram Services -->
              <div>
                <h4 class="text-gray-800 font-semibold mb-3">Other Instagram Services</h4>
                <ul class="space-y-2 text-gray-700">
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Story Comments</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Random Comments</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Emoji Comments</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Posts Saves</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Profile Visits</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Instagram Growth Services</span>
                  </li>
                  <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                    <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M7 4a3 3 0 016 0v1h2a1 1 0 011 1v2H3V6a1 1 0 011-1h2V4zM3 10h14v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6z"/>
                      </svg>
                    </div>
                    <span>Grow Your Business on Instagram</span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>

        <!-- Twitter -->
        <div class="relative">
          <button id="nav-twitter-btn" class="flex items-center space-x-1 text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
            <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
              <path d="M8 19c11 0 17-9 17-17 0-.3 0-.7 0-1A12.3 12.3 0 0027 0a12.18 12.18 0 01-3.5 1A6 6 0 0026.3-2a12.31 12.31 0 01-3.7 1.4A6.15 6.15 0 0017 0c-3.3 0-6 2.7-6 6 0 .5.1 1 .2 1.5A17.5 17.5 0 013 1.8a6 6 0 001.9 8c-.6 0-1.3-.2-1.9-.5v.1c0 2.8 2 5.1 4.7 5.6a6.21 6.21 0 01-1.6.2c-.4 0-.8 0-1.2-.1.8 2.3 3 3.9 5.7 3.9A12.3 12.3 0 010 16.5a17.34 17.34 0 009.4 2.8"/>
            </svg>
            <span class="font-medium">Twitter</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="dropdown-twitter" class="hidden absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <ul class="p-4 space-y-3 text-gray-700">
              <li class="hover:text-orange-500 cursor-pointer">Explore Tweet Packages</li>
              <li class="hover:text-orange-500 cursor-pointer">Premium Tweet Likes</li>
              <li class="hover:text-orange-500 cursor-pointer">Tweet Analytics</li>
            </ul>
          </div>
        </div>

        <!-- TikTok -->
        <div class="relative">
          <button id="nav-tiktok-btn" class="flex items-center space-x-1 text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
            <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
              <path d="M9.6 2a.4.4 0 01.4.4v7.2a3.8 3.8 0 003.8 3.8h3.8a.4.4 0 01.4.4v4.22a5.62 5.62 0 01-5.62 5.62 5.62 5.62 0 01-5.62-5.62 5.62 5.62 0 015.62-5.62 5.62 5.62 0 005.62 5.62V9.62a.4.4 0 01-.4.4h-3.8a3.8 3.8 0 01-3.8-3.8V2.4a.4.4 0 01.4-.4z"/>
            </svg>
            <span class="font-medium">TikTok</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="dropdown-tiktok" class="hidden absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <ul class="p-4 space-y-3 text-gray-700">
              <li class="hover:text-orange-500 cursor-pointer">Explore TikTok Followers</li>
              <li class="hover:text-orange-500 cursor-pointer">TikTok Likes & Views</li>
              <li class="hover:text-orange-500 cursor-pointer">TikTok Comments</li>
            </ul>
          </div>
        </div>

        <!-- Other Services -->
        <div class="relative">
          <button id="nav-others-btn" class="flex items-center space-x-1 text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
            <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM2 6a3 3 0 013-3h14a3 3 0 013 3v12a3 3 0 01-3 3H5a3 3 0 01-3-3V6z"/>
            </svg>
            <span class="font-medium">Other Services</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="dropdown-others" class="hidden absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <ul class="p-4 space-y-3 text-gray-700">
              <li class="hover:text-orange-500 cursor-pointer">YouTube Services</li>
              <li class="hover:text-orange-500 cursor-pointer">Facebook Services</li>
              <li class="hover:text-orange-500 cursor-pointer">LinkedIn Services</li>
            </ul>
          </div>
        </div>

        <!-- Free Tools -->
        <div class="relative">
          <button id="nav-tools-btn" class="flex items-center space-x-1 text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
            <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M5 4h14a1 1 0 011 1v2a1 1 0 01-1 1H5A1 1 0 014 7V5a1 1 0 011-1zm0 6h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2a1 1 0 011-1zm0 6h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2a1 1 0 011-1z"/>
            </svg>
            <span class="font-medium">Free Tools</span>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="dropdown-tools" class="hidden absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
            <ul class="p-4 space-y-3 text-gray-700">
              <li class="hover:text-orange-500 cursor-pointer">Hashtag Generator</li>
              <li class="hover:text-orange-500 cursor-pointer">Caption Ideas</li>
              <li class="hover:text-orange-500 cursor-pointer">Profile Analyzer</li>
            </ul>
          </div>
        </div>

        <!-- Cart Icon -->
        <button class="relative text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1 2m1-2l1 2m10-2l1 2m-1-2l-1 2M5 21a1 1 0 100-2 1 1 0 000 2zm14 0a1 1 0 100-2 1 1 0 000 2z" />
          </svg>
          <span class="absolute -top-1 -right-2 bg-red-500 text-white text-xs font-semibold px-1 rounded">0</span>
        </button>

        <!-- Balance Display -->
        <div class="px-3 py-1 border border-orange-500 rounded text-orange-500 font-semibold cursor-default">
          $<?php echo $balance; ?>
        </div>

        <!-- User Icon -->
        <button class="text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5.121 17.804A2 2 0 017 17h10a2 2 0 011.879 1.372l.621 2.485A2 2 0 0117.5 22h-11a2 2 0 01-1.999-1.139l.619-2.485zM15 11a3 3 0 10-6 0 3 3 0 006 0z" />
          </svg>
        </button>
      </nav>

      <!-- Mobile Nav Menu (hidden by default; appears on < md) -->
      <div id="mobile-nav" class="md:hidden hidden absolute top-16 left-0 w-full bg-white shadow-lg z-40">
        <ul class="flex flex-col divide-y divide-gray-200">
          <!-- Instagram (mobile) -->
          <li>
            <button class="w-full px-4 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-100 focus:outline-none" data-target="mobile-instagram-menu">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-pink-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M7.4 2H16.6C20 2 22 4 22 7.4V16.6C22 20 20 22 16.6 22H7.4C4 22 2 20 2 16.6V7.4C2 4 4 2 7.4 2Z" />
                  <path d="M12 8A4 4 0 1 0 12 16A4 4 0 0 0 12 8Z" />
                  <path d="M17.5 6.5A1 1 0 1 0 17.5 8.5A1 1 0 0 0 17.5 6.5Z" />
                </svg>
                <span class="font-medium">Instagram</span>
              </div>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <!-- Instagram sub-menu (mobile) -->
            <div id="mobile-instagram-menu" class="hidden bg-gray-50">
              <ul class="space-y-1 px-6 py-4 text-gray-700">
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Premium Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Real Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>USA Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Brazilian Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>UK Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Geo-Targeted Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Female Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Indian Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Arab Followers</span>
                </li>
                <li class="flex items-center gap-2 hover:text-orange-500 cursor-pointer">
                  <div class="w-6 h-6 rounded	bg-gradient-to-br from-pink-500 to-yellow-500 flex	items-center justify-center text-white">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 3a4 4 0 014 4v1H6V7a4 4 0 014-4zM4 14v1a2 2 0 002 2h8a2 2 0 002-2v-1H4z"/>
                    </svg>
                  </div>
                  <span>Channel Members</span>
                </li>
              </ul>
            </div>
          </li>

          <!-- Twitter (mobile) -->
          <li>
            <button class="w-full px-4 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-100 focus:outline-none" data-target="mobile-twitter-menu">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M8 19c11 0 17-9 17-17 0-.3 0-.7 0-1A12.3 12.3 0 0027 0a12.18 12.18 0 01-3.5 1A6 6 0 0026.3-2a12.31 12.31 0 01-3.7 1.4A6.15 6.15 0 0017 0c-3.3 0-6 2.7-6 6 0 .5.1 1 .2 1.5A17.5 17.5 0 013 1.8a6 6 0 001.9 8c-.6 0-1.3-.2-1.9-.5v.1c0 2.8 2 5.1 4.7 5.6a6.21 6.21 0 01-1.6.2c-.4 0-.8 0-1.2-.1.8 2.3 3 3.9 5.7 3.9A12.3 12.3 0 010 16.5a17.34 17.34 0 009.4 2.8"/>
                </svg>
                <span class="font-medium">Twitter</span>
              </div>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="mobile-twitter-menu" class="hidden bg-gray-50">
              <ul class="space-y-1 px-6 py-4 text-gray-700">
                <li class="hover:text-orange-500 cursor-pointer">Explore Tweet Packages</li>
                <li class="hover:text-orange-500 cursor-pointer">Premium Tweet Likes</li>
                <li class="hover:text-orange-500 cursor-pointer">Tweet Analytics</li>
              </ul>
            </div>
          </li>

          <!-- TikTok (mobile) -->
          <li>
            <button class="w-full px-4 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-100 focus:outline-none" data-target="mobile-tiktok-menu">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-black" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M9.6 2a.4.4 0 01.4.4v7.2a3.8 3.8 0 003.8 3.8h3.8a.4.4 0 01.4.4v4.22a5.62 5.62 0 01-5.62 5.62 5.62 5.62 0 01-5.62-5.62 5.62 5.62 0 015.62-5.62 5.62 5.62 0 005.62 5.62V9.62a.4.4 0 01-.4.4h-3.8a3.8 3.8 0 01-3.8-3.8V2.4a.4.4 0 01.4-.4z"/>
                </svg>
                <span class="font-medium">TikTok</span>
              </div>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="mobile-tiktok-menu" class="hidden bg-gray-50">
              <ul class="space-y-1 px-6 py-4 text-gray-700">
                <li class="hover:text-orange-500 cursor-pointer">Explore TikTok Followers</li>
                <li class="hover:text-orange-500 cursor-pointer">TikTok Likes & Views</li>
                <li class="hover:text-orange-500 cursor-pointer">TikTok Comments</li>
              </ul>
            </div>
          </li>

          <!-- Other Services (mobile) -->
          <li>
            <button class="w-full px-4 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-100 focus:outline-none" data-target="mobile-others-menu">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-purple-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M4 5h16a1 1 0 011 1v12a1 1 0 01-1 1H4a1 1 0 01-1-1V6a1 1 0 011-1zM2 6a3 3 0 013-3h14a3 3 0 013 3v12a3 3 0 01-3 3H5a3 3 0 01-3-3V6z"/>
                </svg>
                <span class="font-medium">Other Services</span>
              </div>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="mobile-others-menu" class="hidden bg-gray-50">
              <ul class="space-y-1 px-6 py-4 text-gray-700">
                <li class="hover:text-orange-500 cursor-pointer">YouTube Services</li>
                <li class="hover:text-orange-500 cursor-pointer">Facebook Services</li>
                <li class="hover:text-orange-500 cursor-pointer">LinkedIn Services</li>
              </ul>
            </div>
          </li>

          <!-- Free Tools (mobile) -->
          <li>
            <button class="w-full px-4 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-100 focus:outline-none" data-target="mobile-tools-menu">
              <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M5 4h14a1 1 0 011 1v2a1 1 0 01-1 1H5A1 1 0 014 7V5a1 1 0 011-1zm0 6h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2a1 1 0 011-1zm0 6h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1v-2a1 1 0 011-1z"/>
                </svg>
                <span class="font-medium">Free Tools</span>
              </div>
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div id="mobile-tools-menu" class="hidden bg-gray-50">
              <ul class="space-y-1 px-6 py-4 text-gray-700">
                <li class="hover:text-orange-500 cursor-pointer">Hashtag Generator</li>
                <li class="hover:text-orange-500 cursor-pointer">Caption Ideas</li>
                <li class="hover:text-orange-500 cursor-pointer">Profile Analyzer</li>
              </ul>
            </div>
          </li>

          <!-- You could also stack Cart, Balance, User here if needed -->
        </ul>
      </div>
    </div>
  </header>

  <!-- ================= Main Layout ================= -->
  <div class="flex-1 flex">
    <!-- ================= Sidebar (Desktop only) ================= -->
    <aside id="sidebar" class="hidden md:flex w-full rounded-2xl pb-10 md:w-64 bg-white shadow-lg flex-shrink-0 flex flex-col h-full">
      <!-- User Card Background Layers -->
      <div class="relative h-64">
        <div class="absolute top-4 left-4 w-52 h-48 md:h-72 bg-orange-200 rounded-xl"></div>
        <div class="absolute top-6 left-6 w-56 h-52 md:h-72  bg-orange-500 rounded-xl overflow-hidden">
          <div class="p-6 flex flex-col items-center text-white">
            <img
              src="https://plus.unsplash.com/premium_photo-1683140621573-233422bfc7f1?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
              alt="User Avatar"
              class="w-20 h-20 rounded-full mb-4 border-2 border-white"
            />
            <h2 class="text-lg font-semibold">Welcome,</h2>
            <p class="text-xl font-bold"><?php echo htmlspecialchars($_SESSION['full_name']); ?></p>
            <div class="mt-4 flex items-center gap-2">
              <span class="text-sm">Balance:</span>
              <span class="text-lg font-semibold">$<?php echo $balance; ?></span>
            </div>
            <button
              class="mt-4 bg-white text-orange-500 px-4 py-1 rounded-md font-medium hover:bg-orange-50 transition cursor-pointer"
            >
              Add Funds
            </button>
          </div>
        </div>
      </div>

      <!-- Collapseable Menu Header -->
      <div
        id="menu-toggle"
        class="md:mt-20 px-6 py-3 flex items-center justify-between text-gray-700 font-medium cursor-pointer hover:bg-gray-100 transition"
      >
        <span>Menu</span>
        <svg
          id="menu-arrow"
          class="w-5 h-5 transition-transform"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 9l-7 7-7-7" />
        </svg>
      </div>

      <!-- Menu Items (scrollable on desktop) -->
      <nav id="menu-items" class="flex-1 overflow-y-auto no-scrollbar px-6 space-y-2">
        <ul>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h18v18H3V3z" />
              </svg>
              <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
              </svg>
              <span>Orders</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 19.121L12 12.243l6.879 6.878M12 5v7.243" />
              </svg>
              <span>Favorites</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 14l6-6m0 0l-6 6m6-6V3m0 18v-5" />
              </svg>
              <span>Ticket</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 12h8M8 16h8M8 8h8" />
              </svg>
              <span>Reference</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 10h3l3 10h8l3-10h3M5 10V6h14v4" />
              </svg>
              <span>Add Funds</span>
            </a>
          </li>
          <li>
            <a href="#" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer">
              <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" />
              </svg>
              <span>Settings</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    <!-- ================= Main Content ================= -->
    <main class="flex-1 overflow-y-auto no-scrollbar p-4 sm:p-5 sm:pt-2">
      <a href="/smartstore" class="  top-6 right-6  font-semibold text-sm text-gray-500 hover:text-gray-700">&larr; Back to Site</a>
      <!-- Spend & Earn Discount Section -->
      <section class="mb-8 mt-2">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-4">
          <h3 class="text-xl font-semibold text-gray-800">Spend &amp; Earn Discount</h3>
          <span class="mt-2 md:mt-0 text-sm font-medium text-gray-600">
            Current Discount: <span class="text-orange-500">3% off</span>
          </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Level 1 Card -->
          <div class="relative bg-white p-6 rounded-lg shadow cursor-pointer hover:shadow-md transition">
            <!-- Discount Badge -->
            <div class="absolute top-4 right-4 bg-black text-white text-xs font-semibold px-2 py-1 rounded">
              2% Discount
            </div>
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-orange-100 text-orange-500 flex items-center justify-center rounded-md">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927C9.3 2.254 10.7 2.254 10.951 2.927l1.286 3.683a1 1 0 00.95.69h3.877c.969 0 1.371 1.24.588 1.81l-3.136 2.278a1 1 0 00-.364 1.118l1.286 3.683c.251.673-.553 1.23-1.127.805L10 13.347l-3.136 2.278c-.574.425-1.378-.132-1.127-.805l1.286-3.683a1 1 0 00-.364-1.118L3.523 9.11c-.783-.57-.38-1.81.588-1.81h3.877a1 1 0 00.95-.69l1.286-3.683z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-medium text-gray-800">Level 1</h4>
                <p class="text-sm text-gray-600">0 - 10,000 $ spent</p>
              </div>
            </div>
          </div>

          <!-- Level 2 Card -->
          <div class="relative bg-white p-6 rounded-lg shadow cursor-pointer hover:shadow-md transition opacity-70">
            <div class="absolute top-4 right-4 bg-gray-300 text-white text-xs font-semibold px-2 py-1 rounded">
              3% Discount
            </div>
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-gray-100 text-gray-400 flex items-center justify-center rounded-md">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927C9.3 2.254 10.7 2.254 10.951 2.927l1.286 3.683a1 1 0 00.95.69h3.877c.969 0 1.371 1.24.588 1.81l-3.136 2.278a1 1 0 00-.364 1.118l1.286 3.683c.251.673-.553 1.23-1.127.805L10 13.347l-3.136 2.278c-.574.425-1.378-.132-1.127-.805l1.286-3.683a1 1 0 00-.364-1.118L3.523 9.11c-.783-.57-.38-1.81.588-1.81h3.877a1 1 0 00.95-.69l1.286-3.683z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-medium text-gray-800">Level 2</h4>
                <p class="text-sm text-gray-600">10,000 - 50,000 $ spent</p>
              </div>
            </div>
          </div>

          <!-- Level 3 Card -->
          <div class="relative bg-white p-6 rounded-lg shadow cursor-pointer hover:shadow-md transition opacity-70">
            <div class="absolute top-4 right-4 bg-gray-300 text-white text-xs font-semibold px-2 py-1 rounded">
              5% Discount
            </div>
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-gray-100 text-gray-400 flex items-center justify-center rounded-md">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M9.049 2.927C9.3 2.254 10.7 2.254 10.951 2.927l1.286 3.683a1 1 0 00.95.69h3.877c.969 0 1.371 1.24.588 1.81l-3.136 2.278a1 1 0 00-.364 1.118l1.286 3.683c.251.673-.553 1.23-1.127.805L10 13.347l-3.136 2.278c-.574.425-1.378-.132-1.127-.805l1.286-3.683a1 1 0 00-.364-1.118L3.523 9.11c-.783-.57-.38-1.81.588-1.81h3.877a1 1 0 00.95-.69l1.286-3.683z"/>
                </svg>
              </div>
              <div>
                <h4 class="text-lg font-medium text-gray-800">Level 3</h4>
                <p class="text-sm text-gray-600">50,000+ $ spent</p>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Last 5 Orders Section -->
      <section class="mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Last 5 Orders</h3>
            <svg class="w-5 h-5 text-gray-400 cursor-pointer hover:text-gray-600 transition" fill="currentColor" viewBox="0 0 20 20">
              <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zm6 0a2 2 0 114 0 2 2 0 01-4 0zm-3 2a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
          </div>
          <p class="text-gray-600">You have no recent orders.</p>
        </div>
      </section>

      <!-- Codes for Members Section -->
      <section class="mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Codes for Members</h3>
          <div class="space-y-6">
            <!-- Code Item 1 -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b border-gray-200 pb-4">
              <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 3l2.9 6H7.1L10 3zM4 8h12l1.6 4H2.4L4 8zM2 14h16v2H2v-2z"/>
                </svg>
                <div>
                  <p class="font-medium text-gray-800">SmartStore Summer Sale!</p>
                  <p class="text-sm text-gray-600">Get 30% off with SmartStore summer sale</p>
                </div>
              </div>
              <button class="mt-3 sm:mt-0 flex items-center gap-2 bg-white border border-orange-500 text-orange-500 px-3 py-1 rounded-md hover:bg-orange-50 transition cursor-pointer">
                <span>SUMMER30</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2zM7 5h6a2 2 0 012 2v1H5V7a2 2 0 012-2z"/>
                </svg>
              </button>
            </div>

            <!-- Code Item 2 -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
              <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                  <path d="M10 3l2.9 6H7.1L10 3zM4 8h12l1.6 4H2.4L4 8zM2 14h16v2H2v-2z"/>
                </svg>
                <div>
                  <p class="font-medium text-gray-800">FATEN50</p>
                  <p class="text-sm text-gray-600">Get 50% off your next order</p>
                </div>
              </div>
              <button class="mt-3 sm:mt-0 flex items-center gap-2 bg-white border border-orange-500 text-orange-500 px-3 py-1 rounded-md hover:bg-orange-50 transition cursor-pointer">
                <span>FATEN50</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 16h8M8 12h8m-6 8h6a2 2 0 002-2v-4a2 2 0 00-2-2h-6a2 2 0 00-2 2v4a2 2 0 002 2zM7 5h6a2 2 0 012 2v1H5V7a2 2 0 012-2z"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- Fast Access Section -->
      <section class="mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
          <h3 class="text-lg font-semibold text-gray-800 mb-4">Fast Access</h3>

          <div class="space-y-6">
            <!-- Referral Banner -->
            <div class="bg-orange-500 rounded-lg p-4 flex flex-col sm:flex-row items-start sm:items-center justify-between">
              <div>
                <h4 class="text-white text-lg font-medium">Win with Referral!</h4>
                <p class="text-white text-sm">Bring customers with your referral link and earn balance.</p>
              </div>
              <button class="mt-3 sm:mt-0 bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition cursor-pointer">
                See Details
              </button>
            </div>

            <!-- Notification Toggles -->
            <div class="space-y-4">
              <!-- SMS Notification -->
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.93 9.93 0 01-4.255-.866L3 20l1.366-4.634A7.962 7.962 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                  </svg>
                  <span class="text-gray-800 font-medium">SMS Notification</span>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                  <input type="checkbox" class="sr-only peer" />
                  <div class="w-10 h-4 bg-gray-200 rounded-full peer-checked:bg-orange-500 relative transition"></div>
                  <div class="absolute left-0.5 top-0.5 w-3 h-3 bg-white rounded-full transition peer-checked:translate-x-6"></div>
                </label>
              </div>

              <!-- Mail Notification -->
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18V8H3v8z"/>
                  </svg>
                  <span class="text-gray-800 font-medium">Mail Notification</span>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                  <input type="checkbox" class="sr-only peer" />
                  <div class="w-10 h-4 bg-gray-200 rounded-full peer-checked:bg-orange-500 relative transition"></div>
                  <div class="absolute left-0.5 top-0.5 w-3 h-3 bg-white rounded-full transition peer-checked:translate-x-6"></div>
                </label>
              </div>

              <!-- On-Site Notification -->
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                  <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11a6 6 0 10-12 0v3c0 .386-.153.74-.405 1.01L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                  </svg>
                  <span class="text-gray-800 font-medium">On-Site Notification</span>
                </div>
                <label class="inline-flex items-center cursor-pointer">
                  <input type="checkbox" class="sr-only peer" />
                  <div class="w-10 h-4 bg-gray-200 rounded-full peer-checked:bg-orange-500 relative transition"></div>
                  <div class="absolute left-0.5 top-0.5 w-3 h-3 bg-white rounded-full transition peer-checked:translate-x-6"></div>
                </label>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div> <!-- end of main flex wrapper -->

  <!-- ================= Footer ================= -->
  <footer class="mt-8">
    <!-- Top Strip: “For Questions and Problems” -->
    <div class="bg-orange-500 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
        <!-- Left Text -->
        <div class="text-center sm:text-left">
          <h4 class="text-lg font-semibold">FOR QUESTIONS AND PROBLEMS</h4>
          <p class="text-sm">YOU CAN REACH US!</p>
        </div>
        <!-- Illustration (visible on ≥640px) -->
        <!-- <div class="hidden sm:block">
          <img src="https://i.ibb.co/3pZdhNj/support-character.png" alt="Support Illustration" class="h-24">
        </div> -->
        <!-- Contact Buttons -->
        <div class="flex flex-col sm:flex-row items-center gap-4">
          <!-- Email Button -->
          <a href="mailto:support@smartstore.com" class="flex items-center gap-2 bg-white text-orange-500 rounded-lg px-4 py-2 hover:bg-gray-100 transition">
            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 12H8m0 0l4-4m-4 4l4 4" />
            </svg>
            <span class="font-medium">Reach Us</span>
          </a>

          <!-- Instagram Button -->
          <a href="https://instagram.com/smartstore" target="_blank" class="flex items-center gap-2 bg-white text-orange-500 rounded-lg px-4 py-2 hover:bg-gray-100 transition">
            <svg class="w-6 h-6 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
              <path d="M7.75 2h8.5C19.097 2 21 3.903 21 6.25v8.5C21 18.097 19.097 20 16.25 20h-8.5C4.903 20 3 18.097 3 15.75v-8.5C3 3.903 4.903 2 7.75 2zm0 1.5C5.678 3.5 4.5 4.678 4.5 6.25v8.5c0 1.572 1.178 2.75 2.75 2.75h8.5c1.572 0 2.75-1.178 2.75-2.75v-8.5c0-1.572-1.178-2.75-2.75-2.75h-8.5zM12 7.25a4.75 4.75 0 110 9.5 4.75 4.75 0 010-9.5zm0 1.5a3.25 3.25 0 100 6.5 3.25 3.25 0 000-6.5zm4.75-.75a.75.75 0 110 1.5.75.75 0 010-1.5z"/>
            </svg>
            <span class="font-medium">@smartstore</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Main Footer Links -->
    <div class="bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        <!-- Logo & Description -->
        <div>
          <div class="flex items-center gap-2 mb-4">
            <img src="../assets/images/logo.png" alt="SmartStore Logo" class="h-8 w-auto">
            <span class="text-2xl font-bold">SmartStore</span>
          </div>
          <p class="text-sm text-gray-300 mb-6">
            “SmartStore serves many happy customers, from individual users to corporate companies, with 5 years of industry experience.”
          </p>
          <div class="flex items-center gap-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_2014_logo_detail.svg"
                 alt="Visa" class="h-6 opacity-80">
            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png"
                 alt="MasterCard" class="h-6 opacity-80">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/30/American_Express_logo.svg"
                 alt="American Express" class="h-6 opacity-80">
          </div>
        </div>

        <!-- SmartStore Links -->
        <div>
          <h5 class="text-lg font-semibold mb-4">SmartStore</h5>
          <ul class="space-y-2 text-gray-300">
            <li><a href="#" class="hover:text-orange-500 transition">Home</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Contact</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">About Us</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Terms of Service</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Distance Selling Agreement</a></li>
          </ul>
        </div>

        <!-- Popular Blogs -->
        <div>
          <h5 class="text-lg font-semibold mb-4">Popular Blogs</h5>
          <ul class="space-y-2 text-gray-300">
            <li><a href="#" class="hover:text-orange-500 transition">Choose the Perfect Instagram Handle</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">What is BOP on TikTok</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Is SmartStore Safe?</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">What Are TikTok Coins?</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">What Does “Slay” Mean?</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">How to Create GIFs For Instagram</a></li>
          </ul>
        </div>

        <!-- Free Services -->
        <div>
          <h5 class="text-lg font-semibold mb-4">Free Services</h5>
          <ul class="space-y-2 text-gray-300">
            <li><a href="#" class="hover:text-orange-500 transition">Free Instagram Followers</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Free Instagram Likes</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Free Instagram Views</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Free TikTok Followers</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Free TikTok Likes</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Free Twitter Followers</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Free Twitter Likes</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Instagram Photo Downloader</a></li>
            <li><a href="#" class="hover:text-orange-500 transition">Instagram Video Downloader</a></li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Bottom Copyright Bar -->
    <div class="bg-gray-800 text-gray-400 text-sm py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        © <?php echo date("Y"); ?> SmartStore. All rights reserved.
      </div>
    </div>
  </footer>

  <!-- ================= JavaScript for Interactions ================= -->
  <script>
    // MOBILE: Toggle sidebar + mobile-nav when hamburger is clicked
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const sidebar       = document.getElementById('sidebar');
    const mobileNav     = document.getElementById('mobile-nav');
    mobileMenuBtn.addEventListener('click', () => {
      sidebar.classList.toggle('hidden');
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
