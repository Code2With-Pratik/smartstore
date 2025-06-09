<?php
session_start();
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../models/TicketModel.php';


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId = $_SESSION['user_id'] ?? 1;
    $orderId = $_POST['order_id'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    $ticketModel = new TicketModel($conn);
    $success = $ticketModel->createTicket($userId, $orderId, $title, $description);

    if ($success) {
    $_SESSION['message'] = "🎫 Ticket created successfully and marked as pending.";
} else {
    $_SESSION['message'] = "⚠️ A ticket for this order already exists. Please check your ticket list.";
}

  header("Location: ../dashboard.php?page=ticket");
    exit();
}
?>
