<div class="md:max-w-screen   px-4 sm:px-6 lg:px-8 flex items-center justify-between  h-16">
      <!-- Left Side: Logo and (mobile) hamburger -->
      <div class="flex items-center gap-48 ">
        <!-- Logo (always visible) -->
        <img src="../assets/images/logo.png" alt="SmartStore Logo" class="h-8  w-auto" />
        <!-- Hamburger for Mobile (visible < md) -->
        <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-orange-500 focus:outline-none cursor-pointer">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
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