<?php
class TicketModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Check if a ticket already exists for the same user and order
    public function ticketExists($userId, $orderId) {
        $stmt = $this->conn->prepare("SELECT id FROM support_tickets WHERE user_id = ? AND order_id = ?");
        $stmt->bind_param("ii", $userId, $orderId);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // Create a new support ticket
    public function createTicket($userId, $orderId, $title, $description) {
        if ($this->ticketExists($userId, $orderId)) {
            return false; // prevent duplicate ticket for the same order
        }

        $stmt = $this->conn->prepare("INSERT INTO support_tickets (user_id, order_id, title, description) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $userId, $orderId, $title, $description);
        return $stmt->execute();
    }

    // Get all tickets created by a user
    public function getTicketsByUser($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM support_tickets WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        return $stmt->get_result();
    }
}
?>
