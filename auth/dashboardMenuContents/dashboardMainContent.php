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