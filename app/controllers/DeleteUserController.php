<?php
class DeleteUserController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function deleteUser() {
        if (isset($_GET['id'])) {
            $userId = (int) $_GET['id'];

            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
            if ($stmt->execute([$userId])) {
                header("Location: /myphpproject/index.php?page=user_management&message=User deleted successfully");
                exit();
            } else {
                echo "Failed to delete user.";
            }
        } else {
            echo "No user ID specified.";
        }
    }
}
?>
