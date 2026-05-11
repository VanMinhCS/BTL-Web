<?php
class ContactModel extends Model {
    public function __construct() {
        parent::__construct(); 
        
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS contacts (
            contact_id INT AUTO_INCREMENT PRIMARY KEY,
            customer_name VARCHAR(255) NOT NULL,
            customer_email VARCHAR(255) NOT NULL,
            subject VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            status TINYINT(1) DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
        
        $this->db->exec($sql);
    }
    public function saveContact($customer_name, $customer_email, $subject, $message) {
        $sql = "INSERT INTO contacts (customer_name, customer_email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$customer_name, $customer_email, $subject, $message]);
    }

    public function getAll() {
        $sql = "SELECT * FROM contacts ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getPaginated($limit, $offset, $statusFilter = 'all', $sortOrder = 'newest') {
        $where = '';
        if ($statusFilter === 'unread') {
            $where = 'WHERE status = 0';
        } elseif ($statusFilter === 'read') {
            $where = 'WHERE status = 1';
        }

        $order = ($sortOrder === 'oldest') ? 'ASC' : 'DESC';
        $sql = "SELECT * FROM contacts $where ORDER BY created_at $order LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countAll($statusFilter = 'all') {
        $where = '';
        if ($statusFilter === 'unread') {
            $where = 'WHERE status = 0';
        } elseif ($statusFilter === 'read') {
            $where = 'WHERE status = 1';
        }

        $stmt = $this->db->query("SELECT COUNT(*) AS total FROM contacts $where");
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }

    public function getById($id) {
        $sql = "SELECT * FROM contacts WHERE contact_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function markAsRead($id) {
        $sql = "UPDATE contacts SET status = 1 WHERE contact_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function deleteById($id) {
        $sql = "DELETE FROM contacts WHERE contact_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$id]);
    }

    public function deleteByIds($ids) {
        if (!is_array($ids)) {
            return false;
        }

        $ids = array_values(array_filter(array_map('intval', $ids), function ($id) {
            return $id > 0;
        }));

        if (count($ids) === 0) {
            return false;
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "DELETE FROM contacts WHERE contact_id IN ($placeholders)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($ids);
    }

    public function search($keyword, $limit, $offset, $sortOrder = 'newest') {
        $order = ($sortOrder === 'oldest') ? 'ASC' : 'DESC';
        $like = '%' . $keyword . '%';
        $sql = "SELECT * FROM contacts 
                WHERE customer_name LIKE :kw1 
                OR customer_email LIKE :kw2 
                OR subject LIKE :kw3 
                OR message LIKE :kw4
                ORDER BY created_at $order
                LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':kw1', $like);
        $stmt->bindValue(':kw2', $like);
        $stmt->bindValue(':kw3', $like);
        $stmt->bindValue(':kw4', $like);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countSearch($keyword) {
        $like = '%' . $keyword . '%';
        $sql = "SELECT COUNT(*) AS total FROM contacts 
                WHERE customer_name LIKE ? 
                OR customer_email LIKE ? 
                OR subject LIKE ? 
                OR message LIKE ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$like, $like, $like, $like]);
        $row = $stmt->fetch();
        return (int)($row['total'] ?? 0);
    }
}

