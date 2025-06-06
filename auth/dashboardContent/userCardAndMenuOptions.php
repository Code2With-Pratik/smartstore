 <aside id="sidebar" class="  md:flex w-full  rounded-2xl pb-10 md:w-64 bg-white shadow-lg flex-shrink-0 flex flex-col h-full">
      <!-- User Card Background Layers -->
      <div class="relative h-64">
        
        <div class="absolute top-6 left-24 md:left-4 w-52 h-72 md:h-72 bg-orange-200 rounded-xl"></div>
        <div class="absolute top-8 left-28 md:left-6 w-56 h-72 md:h-72  bg-orange-500 rounded-xl overflow-hidden">
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
        class="md:mt-20 mt-16 px-6 py-3 flex items-center justify-between text-gray-700 font-medium cursor-pointer hover:bg-gray-100 transition"
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
            <a href="?page=dashboard" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'dashboard') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5  <?php if ($page === 'dashboard') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h18v18H3V3z" />
              </svg>
              <span>Dashboard</span>
            </a>
          </li>
          <li>
            <a  href="?page=orders" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'orders') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5 <?php if ($page === 'orders') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 13l4 4L19 7" />
              </svg>
              <span>Orders</span>
            </a>
          </li>
          <li>
            <a href="?page=favorites" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'favorites') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5 <?php if ($page === 'favorites') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5.121 19.121L12 12.243l6.879 6.878M12 5v7.243" />
              </svg>
              <span>Favorites</span>
            </a>
          </li>
          <li>
            <a  href="?page=ticket" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'ticket') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5 <?php if ($page === 'ticket') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 14l6-6m0 0l-6 6m6-6V3m0 18v-5" />
              </svg>
              <span>Ticket</span>
            </a>
          </li>
          <li>
            <a href="?page=reference" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'reference') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5 <?php if ($page === 'reference') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 12h8M8 16h8M8 8h8" />
              </svg>
              <span>Reference</span>
            </a>
          </li>
          <li>
            <a href="?page=addFunds" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'addFunds') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5 <?php if ($page === 'addFunds') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 10h3l3 10h8l3-10h3M5 10V6h14v4" />
              </svg>
              <span>Add Funds</span>
            </a>
          </li>
          <li>
            <a href="?page=settings" class="flex items-center gap-3 text-gray-700 py-2 px-2 rounded-md hover:bg-gray-100 transition cursor-pointer  <?php if ($page === 'settings') echo 'bg-gray-100 text-orange-500 font-semibold'; else echo 'text-gray-700'; ?>">
              <svg class="w-5 h-5 <?php if ($page === 'settings') echo 'text-orange-500'; else echo 'text-gray-500'; ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83" />
              </svg>
              <span>Settings</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>