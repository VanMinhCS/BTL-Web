<?php
class HomeInfoModel extends Model {
    public function __construct() {
        parent::__construct();
        $this->createTablesIfNotExists();
        $this->seedDefaults();
    }

    private function createTablesIfNotExists() {
        $this->db->exec("CREATE TABLE IF NOT EXISTS home_sections (
            id INT AUTO_INCREMENT PRIMARY KEY,
            section_key VARCHAR(50) NOT NULL UNIQUE,
            title VARCHAR(255) DEFAULT NULL,
            subtitle TEXT DEFAULT NULL,
            is_active TINYINT(1) DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $this->db->exec("CREATE TABLE IF NOT EXISTS home_quotes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            quote_text TEXT NOT NULL,
            author VARCHAR(255) DEFAULT NULL,
            image VARCHAR(255) DEFAULT NULL,
            sort_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $this->db->exec("CREATE TABLE IF NOT EXISTS home_reasons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT DEFAULT NULL,
            sort_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

        $this->db->exec("CREATE TABLE IF NOT EXISTS home_featured_products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            item_id INT NOT NULL,
            sort_order INT DEFAULT 0,
            is_active TINYINT(1) DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uniq_home_featured_item (item_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
    }

    private function seedDefaults() {
        $count = (int)$this->db->query("SELECT COUNT(*) FROM home_sections")->fetchColumn();
        if ($count === 0) {
            $stmt = $this->db->prepare("INSERT INTO home_sections (section_key, title, subtitle, is_active) VALUES (?, ?, ?, 1)");
            $stmt->execute(['quote', 'Quote', null]);
            $stmt->execute(['reason', 'Tại sao lại chọn chúng tôi?', 'Những giá trị cốt lõi mà BK88 mang lại cho bạn.']);
            $stmt->execute(['product', 'Một số sản phẩm tiêu biểu', 'Tham khảo một số giáo trình tiêu biểu của chúng tôi']);
        }

        $quoteCount = (int)$this->db->query("SELECT COUNT(*) FROM home_quotes")->fetchColumn();
        if ($quoteCount === 0) {
            $stmt = $this->db->prepare("INSERT INTO home_quotes (quote_text, author, image, sort_order, is_active) VALUES (?, ?, ?, ?, 1)");
            $stmt->execute(['Sách là nguồn tri thức vô tận.', '- Nguyễn Văn Minh - Co-founder của BK88', 'avt/nvm.png', 1]);
            $stmt->execute(['Đầu tư vào kiến thức là khoản đầu tư lãi nhất.', '- Hồ Ngọc Anh Tuấn - Co-founder của BK88', 'avt/HNAT.png', 2]);
            $stmt->execute(['Kiến thức dẫn lối con người.', '- Nông Văn Trung - Co-founder của BK88', 'avt/Trung Nông.png', 3]);
            $stmt->execute(['Kiến thức là kết tinh của tạo hóa.', '- Phan Huy Trung - Co-founder của BK88', 'avt/Trung Phan.png', 4]);
        }

        $reasonCount = (int)$this->db->query("SELECT COUNT(*) FROM home_reasons")->fetchColumn();
        if ($reasonCount === 0) {
            $stmt = $this->db->prepare("INSERT INTO home_reasons (title, description, sort_order, is_active) VALUES (?, ?, ?, 1)");
            $stmt->execute(['Giáo trình chất lượng', 'Cung cấp các bộ giáo trình được biên soạn và kiểm duyệt kỹ lưỡng bởi các chuyên gia hàng đầu trong ngành.', 1]);
            $stmt->execute(['Cập nhật liên tục', 'Nội dung luôn được làm mới để bắt kịp xu hướng và kiến thức mới nhất, đảm bảo tính ứng dụng cao.', 2]);
            $stmt->execute(['Hỗ trợ 24/7', 'Đội ngũ hỗ trợ chuyên nghiệp luôn sẵn sàng giải đáp mọi thắc mắc của bạn mọi lúc, mọi nơi.', 3]);
            $stmt->execute(['Giá cả hợp lý', 'Mang lại giá trị kiến thức vượt trội với mức chi phí cạnh tranh nhất trên thị trường.', 4]);
        }

        $featuredCount = (int)$this->db->query("SELECT COUNT(*) FROM home_featured_products")->fetchColumn();
        if ($featuredCount === 0) {
            $items = $this->db->query("SELECT item_id FROM items ORDER BY item_id ASC LIMIT 5")->fetchAll(PDO::FETCH_COLUMN);
            $stmt = $this->db->prepare("INSERT IGNORE INTO home_featured_products (item_id, sort_order, is_active) VALUES (?, ?, 1)");
            foreach ($items as $index => $itemId) {
                $stmt->execute([(int)$itemId, $index + 1]);
            }
        }
    }

    public function getSections() {
        $stmt = $this->db->query("SELECT * FROM home_sections ORDER BY FIELD(section_key, 'quote', 'reason', 'product'), id ASC");
        $sections = [];
        foreach ($stmt->fetchAll() as $section) {
            $sections[$section['section_key']] = $section;
        }
        return $sections;
    }

    public function getSection($sectionKey) {
        $stmt = $this->db->prepare("SELECT * FROM home_sections WHERE section_key = ?");
        $stmt->execute([$sectionKey]);
        return $stmt->fetch();
    }

    public function saveSection($sectionKey, $title, $subtitle, $isActive) {
        $stmt = $this->db->prepare("INSERT INTO home_sections (section_key, title, subtitle, is_active)
            VALUES (:section_key, :title, :subtitle, :is_active)
            ON DUPLICATE KEY UPDATE title = VALUES(title), subtitle = VALUES(subtitle), is_active = VALUES(is_active)");
        return $stmt->execute([
            ':section_key' => $sectionKey,
            ':title' => $title,
            ':subtitle' => $subtitle,
            ':is_active' => (int)$isActive,
        ]);
    }

    public function clearSection($sectionKey) {
        $this->saveSection($sectionKey, '', '', 0);

        if ($sectionKey === 'quote') {
            return $this->db->exec("DELETE FROM home_quotes");
        }
        if ($sectionKey === 'reason') {
            return $this->db->exec("DELETE FROM home_reasons");
        }
        if ($sectionKey === 'product') {
            return $this->db->exec("DELETE FROM home_featured_products");
        }

        return false;
    }

    public function getQuotes($activeOnly = false) {
        $sql = "SELECT * FROM home_quotes";
        if ($activeOnly) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getQuoteById($id) {
        $stmt = $this->db->prepare("SELECT * FROM home_quotes WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function saveQuote($id, $quoteText, $author, $image, $sortOrder, $isActive) {
        if ((int)$id > 0) {
            $sql = "UPDATE home_quotes
                    SET quote_text = :quote_text, author = :author, sort_order = :sort_order, is_active = :is_active";
            $params = [
                ':id' => (int)$id,
                ':quote_text' => $quoteText,
                ':author' => $author,
                ':sort_order' => (int)$sortOrder,
                ':is_active' => (int)$isActive,
            ];

            if ($image !== '') {
                $sql .= ", image = :image";
                $params[':image'] = $image;
            }

            $sql .= " WHERE id = :id";
            return $this->db->prepare($sql)->execute($params);
        }

        $stmt = $this->db->prepare("INSERT INTO home_quotes (quote_text, author, image, sort_order, is_active)
            VALUES (:quote_text, :author, :image, :sort_order, :is_active)");
        return $stmt->execute([
            ':quote_text' => $quoteText,
            ':author' => $author,
            ':image' => $image,
            ':sort_order' => (int)$sortOrder,
            ':is_active' => (int)$isActive,
        ]);
    }

    public function deleteQuote($id) {
        $stmt = $this->db->prepare("DELETE FROM home_quotes WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }

    public function getReasons($activeOnly = false) {
        $sql = "SELECT * FROM home_reasons";
        if ($activeOnly) {
            $sql .= " WHERE is_active = 1";
        }
        $sql .= " ORDER BY sort_order ASC, id ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getReasonById($id) {
        $stmt = $this->db->prepare("SELECT * FROM home_reasons WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function saveReason($id, $title, $description, $sortOrder, $isActive) {
        if ((int)$id > 0) {
            $stmt = $this->db->prepare("UPDATE home_reasons
                SET title = :title, description = :description, sort_order = :sort_order, is_active = :is_active
                WHERE id = :id");
            return $stmt->execute([
                ':id' => (int)$id,
                ':title' => $title,
                ':description' => $description,
                ':sort_order' => (int)$sortOrder,
                ':is_active' => (int)$isActive,
            ]);
        }

        $stmt = $this->db->prepare("INSERT INTO home_reasons (title, description, sort_order, is_active)
            VALUES (:title, :description, :sort_order, :is_active)");
        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':sort_order' => (int)$sortOrder,
            ':is_active' => (int)$isActive,
        ]);
    }

    public function deleteReason($id) {
        $stmt = $this->db->prepare("DELETE FROM home_reasons WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }

    public function getFeaturedProducts($activeOnly = false) {
        $sql = "SELECT hfp.*, i.item_name, i.item_image, i.item_stock, i.price
                FROM home_featured_products hfp
                JOIN items i ON i.item_id = hfp.item_id";
        if ($activeOnly) {
            $sql .= " WHERE hfp.is_active = 1";
        }
        $sql .= " ORDER BY hfp.sort_order ASC, hfp.id ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getFeaturedProductById($id) {
        $stmt = $this->db->prepare("SELECT * FROM home_featured_products WHERE id = ?");
        $stmt->execute([(int)$id]);
        return $stmt->fetch();
    }

    public function saveFeaturedProduct($id, $itemId, $sortOrder, $isActive) {
        if ((int)$id > 0) {
            $stmt = $this->db->prepare("UPDATE home_featured_products
                SET item_id = :item_id, sort_order = :sort_order, is_active = :is_active
                WHERE id = :id");
            return $stmt->execute([
                ':id' => (int)$id,
                ':item_id' => (int)$itemId,
                ':sort_order' => (int)$sortOrder,
                ':is_active' => (int)$isActive,
            ]);
        }

        $stmt = $this->db->prepare("INSERT INTO home_featured_products (item_id, sort_order, is_active)
            VALUES (:item_id, :sort_order, :is_active)
            ON DUPLICATE KEY UPDATE sort_order = VALUES(sort_order), is_active = VALUES(is_active)");
        return $stmt->execute([
            ':item_id' => (int)$itemId,
            ':sort_order' => (int)$sortOrder,
            ':is_active' => (int)$isActive,
        ]);
    }

    public function deleteFeaturedProduct($id) {
        $stmt = $this->db->prepare("DELETE FROM home_featured_products WHERE id = ?");
        return $stmt->execute([(int)$id]);
    }

    // Legacy helpers kept for older admin/contact-style screens.
    public function getAll() {
        return $this->getQuotes(false);
    }

    public function getActive() {
        return $this->getQuotes(true);
    }

    public function getById($id) {
        return $this->getQuoteById($id);
    }
}
?>
