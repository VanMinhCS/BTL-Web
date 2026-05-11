<?php
class InfoController extends Controller {
    public function index() {
        $model = $this->model('HomeInfoModel');
        $productModel = $this->model('ProductModel');

        $editQuoteId = isset($_GET['quote_id']) ? (int)$_GET['quote_id'] : 0;
        $editReasonId = isset($_GET['reason_id']) ? (int)$_GET['reason_id'] : 0;
        $editProductId = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

        $data['sections'] = $model->getSections();
        $data['quotes'] = $model->getQuotes();
        $data['reasons'] = $model->getReasons();
        $data['featuredProducts'] = $model->getFeaturedProducts();
        $data['products'] = $productModel->getAllProducts();

        $data['editQuote'] = $editQuoteId > 0 ? $model->getQuoteById($editQuoteId) : null;
        $data['editReason'] = $editReasonId > 0 ? $model->getReasonById($editReasonId) : null;
        $data['editProduct'] = $editProductId > 0 ? $model->getFeaturedProductById($editProductId) : null;
        $data['siteLogo'] = $model->getSetting('site_logo');

        $data['title'] = 'Quản lý thông tin Trang chủ';
        $data['pageTitle'] = 'Thiết lập thông tin trang Home';
        $data['pageDesc'] = 'Quản lý thông tin trên trang Home';
        $data['currentPage'] = 'home_info';
        $data['pageJs'] = ['assets/js/admin/info.js'];
        $this->view('admin/info/index', $data);
    }

    public function contact() {
        $model = $this->model('ContactInfoModel');
        $editId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $editField = $editId > 0 ? $model->getById($editId) : null;

        $data['fields'] = $model->getAll();
        $data['editField'] = $editField;
        $data['title'] = 'Quản lý thông tin Liên hệ';
        $data['pageTitle'] = 'Thiết lập thông tin liên hệ ở trang Contact';
        $data['pageDesc'] = 'Quản lý thông tin trên trang Contact';
        $data['formAction'] = BASE_URL . 'admin/info/saveContact';
        $data['editBaseUrl'] = BASE_URL . 'admin/info/contact';
        $data['deleteBaseUrl'] = BASE_URL . 'admin/info/deleteContact';
        $data['cancelUrl'] = BASE_URL . 'admin/info/contact';
        $data['currentPage'] = 'contact_info';
        $data['pageJs'] = ['assets/js/admin/info.js'];
        $this->view('admin/info/contact', $data);
    }

    public function saveHome() {
        $this->saveSection();
    }

    public function saveContact() {
        $this->saveInfo('ContactInfoModel', BASE_URL . 'admin/info/contact');
    }

    public function deleteHome() {
        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function saveSection() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/info');
            exit;
        }

        $sectionKey = trim($_POST['section_key'] ?? '');
        $title = trim($_POST['title'] ?? '');
        $subtitle = trim($_POST['subtitle'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($sectionKey === '') {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Thiếu thông tin section.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info');
            exit;
        }

        $model = $this->model('HomeInfoModel');
        $model->saveSection($sectionKey, $title, $subtitle, $isActive);
        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'data' => ['sections' => $model->getSections()],
                'message' => 'Đã lưu thiết lập.'
            ]);
        }
        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function saveQuote() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/info');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $quoteText = trim($_POST['quote_text'] ?? '');
        $author = trim($_POST['author'] ?? '');
        $image = '';
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($quoteText === '') {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Vui lòng nhập nội dung trích dẫn.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=missing');
            exit;
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                if ($this->isAjax()) {
                    $this->jsonResponse(['success' => false, 'message' => 'Tải ảnh lên thất bại.'], 400);
                }
                header('Location: ' . BASE_URL . 'admin/info?error=upload');
                exit;
            }

            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $originalName = $_FILES['image']['name'] ?? '';
            $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            if (!in_array($extension, $allowed, true)) {
                if ($this->isAjax()) {
                    $this->jsonResponse(['success' => false, 'message' => 'Ảnh không hợp lệ.'], 400);
                }
                header('Location: ' . BASE_URL . 'admin/info?error=invalid_image');
                exit;
            }

            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $baseName);
            if ($baseName === '') {
                $baseName = 'quote';
            }

            $imageName = time() . '_' . $baseName . '.' . $extension;
            $targetDir = __DIR__ . '/../../public/assets/img/info/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
            $targetFile = $targetDir . $imageName;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                if ($this->isAjax()) {
                    $this->jsonResponse(['success' => false, 'message' => 'Tải ảnh lên thất bại.'], 400);
                }
                header('Location: ' . BASE_URL . 'admin/info?error=upload');
                exit;
            }

            $image = 'info/' . $imageName;
        }

        $model = $this->model('HomeInfoModel');
        $model->saveQuote($id, $quoteText, $author, $image, $sortOrder, $isActive);
        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'data' => ['quotes' => $model->getQuotes()],
                'message' => 'Đã lưu trích dẫn.'
            ]);
        }
        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function saveLogo() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/info');
            exit;
        }

        if (!isset($_FILES['logo']) || $_FILES['logo']['error'] === UPLOAD_ERR_NO_FILE) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Vui lòng chọn ảnh logo.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=missing');
            exit;
        }

        if ($_FILES['logo']['error'] !== UPLOAD_ERR_OK) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Tải ảnh lên thất bại.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=upload');
            exit;
        }

        $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $originalName = $_FILES['logo']['name'] ?? '';
        $extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
        if (!in_array($extension, $allowed, true)) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Ảnh không hợp lệ.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=invalid_image');
            exit;
        }

        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $baseName);
        if ($baseName === '') {
            $baseName = 'logo';
        }

        $imageName = time() . '_' . $baseName . '.' . $extension;
        $targetDir = __DIR__ . '/../../public/assets/img/logo/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $targetFile = $targetDir . $imageName;

        if (!move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Tải ảnh lên thất bại.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=upload');
            exit;
        }

        $relativePath = 'logo/' . $imageName;
        $model = $this->model('HomeInfoModel');
        $model->setSetting('site_logo', $relativePath);

        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'data' => ['siteLogo' => $relativePath],
                'message' => 'Đã cập nhật logo.'
            ]);
        }

        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function deleteQuote() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $model = $this->model('HomeInfoModel');
            $model->deleteQuote($id);
            if ($this->isAjax()) {
                $this->jsonResponse([
                    'success' => true,
                    'data' => ['quotes' => $model->getQuotes()],
                    'message' => 'Đã xóa trích dẫn.'
                ]);
            }
        }

        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function saveReason() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/info');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($title === '') {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Vui lòng nhập tiêu đề lý do.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=missing');
            exit;
        }

        $model = $this->model('HomeInfoModel');
        $model->saveReason($id, $title, $description, $sortOrder, $isActive);
        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'data' => ['reasons' => $model->getReasons()],
                'message' => 'Đã lưu lý do.'
            ]);
        }
        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function deleteReason() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $model = $this->model('HomeInfoModel');
            $model->deleteReason($id);
            if ($this->isAjax()) {
                $this->jsonResponse([
                    'success' => true,
                    'data' => ['reasons' => $model->getReasons()],
                    'message' => 'Đã xóa lý do.'
                ]);
            }
        }

        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function saveProduct() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . 'admin/info');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);
        $itemId = (int)($_POST['item_id'] ?? 0);
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($itemId <= 0) {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Vui lòng chọn sản phẩm.'], 400);
            }
            header('Location: ' . BASE_URL . 'admin/info?error=missing');
            exit;
        }

        $model = $this->model('HomeInfoModel');
        $model->saveFeaturedProduct($id, $itemId, $sortOrder, $isActive);
        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'data' => ['featuredProducts' => $model->getFeaturedProducts()],
                'message' => 'Đã lưu sản phẩm tiêu biểu.'
            ]);
        }
        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function deleteProduct() {
        $id = (int)($_GET['id'] ?? 0);
        if ($id > 0) {
            $model = $this->model('HomeInfoModel');
            $model->deleteFeaturedProduct($id);
            if ($this->isAjax()) {
                $this->jsonResponse([
                    'success' => true,
                    'data' => ['featuredProducts' => $model->getFeaturedProducts()],
                    'message' => 'Đã xóa sản phẩm khỏi danh sách.'
                ]);
            }
        }

        header('Location: ' . BASE_URL . 'admin/info');
        exit;
    }

    public function deleteContact() {
        $this->deleteInfo('ContactInfoModel', BASE_URL . 'admin/info/contact');
    }

    private function saveInfo($modelName, $redirectUrl) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . $redirectUrl);
            exit;
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        $label = trim($_POST['label'] ?? '');
        $value = trim($_POST['value'] ?? '');
        $icon = trim($_POST['icon'] ?? '');
        $sortOrder = (int)($_POST['sort_order'] ?? 0);
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if ($label === '' || $value === '') {
            if ($this->isAjax()) {
                $this->jsonResponse(['success' => false, 'message' => 'Vui lòng nhập đầy đủ thông tin.'], 400);
            }
            header("Location: " . $redirectUrl . "?error=missing");
            exit;
        }

        $model = $this->model($modelName);
        if ($id > 0) {
            $model->update($id, $label, $value, $icon, $sortOrder, $isActive);
        } else {
            $model->insert($label, $value, $icon, $sortOrder, $isActive);
        }

        if ($this->isAjax()) {
            $this->jsonResponse([
                'success' => true,
                'data' => ['fields' => $model->getAll()],
                'message' => 'Đã lưu thông tin.'
            ]);
        }

        header("Location: " . $redirectUrl);
        exit;
    }

    private function deleteInfo($modelName, $redirectUrl) {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id > 0) {
            $model = $this->model($modelName);
            $model->delete($id);
            if ($this->isAjax()) {
                $this->jsonResponse([
                    'success' => true,
                    'data' => ['fields' => $model->getAll()],
                    'message' => 'Đã xóa thông tin.'
                ]);
            }
        }

        header("Location: " . $redirectUrl);
        exit;
    }

    private function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    private function jsonResponse($payload, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($payload);
        exit;
    }
}
