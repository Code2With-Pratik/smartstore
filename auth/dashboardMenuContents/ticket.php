<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/TicketModel.php';

$userId = $_SESSION['user_id'] ?? 1;
$ticketModel = new TicketModel($conn);
$tickets = $ticketModel->getTicketsByUser($userId);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Support Ticket</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .primary-color {
      color: #f97316; /* orange-500 */
    }
    .primary-bg {
      background-color: #f97316;
    }
    .primary-bg-hover:hover {
      background-color: #ea580c;
    }
  </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<!-- Create Ticket Form -->
<div class="bg-white p-8 rounded-xl shadow-lg max-w-2xl mx-auto mt-6 border border-gray-200">
  <h1 class="text-3xl font-bold text-black mb-2">Create Support Ticket</h1>
  <p class="text-gray-500 mb-6">Having trouble with an order? Submit a support ticket below.</p>

  <?php if (isset($_SESSION['message'])): ?>
  <div x-data="{ show: true }" x-show="show" class="flex justify-between items-start bg-green-100 text-green-800 px-4 py-3 rounded my-4 shadow-md relative">
    <div class="flex-1 pr-6">
      <?= $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
    <button @click="show = false" class="text-green-800 hover:text-red-500 text-xl font-bold px-2 focus:outline-none">
      ×
    </button>
  </div>
<?php endif; ?>


  <form action="controllers/TicketController.php" method="POST" class="space-y-5">
    <div>
      <label class="block text-gray-800 font-medium">Select Order</label>
      <select name="order_id" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400" required>
        <option value="">-- Select Order --</option>
        <option value="101">Order #101 - 500 Likes Instagram</option>
        <option value="102">Order #102 - 200 followers Instagram</option>
        <option value="103">Order #103 - 1000 likes Instagram</option>
      </select>
    </div>

    <div>
      <label class="block text-gray-800 font-medium">Ticket Title</label>
      <input type="text" name="title" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400" required />
    </div>

    <div>
      <label class="block text-gray-800 font-medium">Description</label>
      <textarea name="description" rows="4" class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-orange-400" required></textarea>
    </div>

    <button type="submit" class="primary-bg primary-bg-hover text-white font-semibold px-6 py-2 rounded shadow hover:shadow-md transition duration-150">
      Create Ticket
    </button>
  </form>
</div>

<!-- Existing Tickets Table -->
<div class="bg-white p-8 rounded-xl shadow-lg max-w-5xl mx-auto mt-10 border border-gray-200">
  <h2 class="text-2xl font-bold text-black mb-4">My Tickets</h2>

  <div class="overflow-x-auto">
    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
      <thead>
        <tr class="bg-orange-500 text-white text-left">
          <th class="p-3">Ticket ID</th>
          <th class="p-3">Order ID</th>
          <th class="p-3">Title</th>
          <th class="p-3">Status</th>
          <th class="p-3">Created At</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($tickets->num_rows > 0): ?>
          <?php while ($ticket = $tickets->fetch_assoc()): ?>
            <tr class="border-t hover:bg-gray-50">
              <td class="p-3 text-gray-700">#<?= $ticket['id'] ?></td>
              <td class="p-3 text-gray-700">#<?= $ticket['order_id'] ?></td>
              <td class="p-3 text-gray-800"><?= htmlspecialchars($ticket['title']) ?></td>
              <td class="p-3 capitalize font-medium 
    <?php
      switch ($ticket['status']) {
        case 'resolved':
          echo 'text-green-600';
          break;
        case 'pending':
          echo 'text-yellow-500';
          break;
        case 'in_process':
          echo 'text-orange-500';
          break;
        case 'failed':
          echo 'text-red-600';
          break;
        default:
          echo 'text-blue-600'; // fallback
      }
    ?>">
  <?= str_replace('_', ' ', $ticket['status']) ?>
</td>

              <td class="p-3 text-gray-600"><?= $ticket['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" class="p-4 text-center text-gray-500">You haven't created any tickets yet.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
