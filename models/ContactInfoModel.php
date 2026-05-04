<?php
class ContactInfoModel extends Model {
    public function __construct() {
        parent::__construct();
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists() {
        $sql = "CREATE TABLE IF NOT EXISTS contact_info_fields (
            id INT AUTO_INCREMENT PRIMARY KEY,
            label VARCHAR(255) NOT NULL,
            value TEXT NOT NULL,
            icon VARCHAR(50) DEFAULT NULL,
            sort_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

        $this->db->exec($sql);
    }

    public function getAll() {
        $sql = "SELECT * FROM contact_info_fields ORDER BY sort_order ASC, id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getActive() {
        $sql = "SELECT * FROM contact_info_fields WHERE is_active = 1 ORDER BY sort_order ASC, id ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $sql = "SELECT * FROM contact_info_fields WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function insert($label, $value, $icon, $sortOrder, $isActive) {
        $sql = "INSERT INTO contact_info_fields (label, value, icon, sort_order, is_active)
                VALUES (:label, :value, :icon, :sort_order, :is_active)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':label' => $label,
            ':value' => $value,
            ':icon' => $icon,
            ':sort_order' => (int)$sortOrder,
            ':is_active' => (int)$isActive,
        ]);
    }

    public function update($id, $label, $value, $icon, $sortOrder, $isActive) {
        $sql = "UPDATE contact_info_fields
                SET label = :label,
                    value = :value,
                    icon = :icon,
                    sort_order = :sort_order,
                    is_active = :is_active
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => (int)$id,
            ':label' => $label,
            ':value' => $value,
            ':icon' => $icon,
            ':sort_order' => (int)$sortOrder,
            ':is_active' => (int)$isActive,
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM contact_info_fields WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([(int)$id]);
    }
}
