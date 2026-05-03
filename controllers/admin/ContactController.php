<?php
class ContactController extends Controller {
    
    public function index() {
        $model = $this->model('ContactModel');

        $statusFilter = $_GET['status'] ?? 'all';
        $sortOrder    = $_GET['sort']   ?? 'newest';
        $keyword      = trim($_GET['q'] ?? '');  // ← thêm

        $allowedStatus = ['all', 'unread', 'read'];
        if (!in_array($statusFilter, $allowedStatus, true)) $statusFilter = 'all';

        $allowedSort = ['newest', 'oldest'];
        if (!in_array($sortOrder, $allowedSort, true)) $sortOrder = 'newest';

        $page  = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit = 10;

        // Nếu có keyword thì dùng search, không thì dùng bình thường
        if ($keyword !== '') {
            $total    = $model->countSearch($keyword);
            $totalPages = (int)ceil($total / $limit);
            if ($totalPages > 0 && $page > $totalPages) $page = $totalPages;
            $offset   = ($page - 1) * $limit;
            $contacts = $model->search($keyword, $limit, $offset, $sortOrder);
        } else {
            $total    = $model->countAll($statusFilter);
            $totalPages = (int)ceil($total / $limit);
            if ($totalPages > 0 && $page > $totalPages) $page = $totalPages;
            $offset   = ($page - 1) * $limit;
            $contacts = $model->getPaginated($limit, $offset, $statusFilter, $sortOrder);
        }

        $data['contacts']   = $contacts;
        $data['keyword']    = $keyword;  // ← truyền keyword sang view
        $data['pagination'] = [
            'page'       => $page,
            'totalPages' => $totalPages,
            'total'      => $total,
        ];
        $data['filters'] = [
            'status' => $statusFilter,
            'sort'   => $sortOrder,
        ];
        $data['title']       = "Quản lý liên hệ";
        $data['currentPage'] = 'contact';
        $data['pageCss']     = ['assets/css/admin/contacts.css'];
        $data['pageJs']      = ['assets/js/admin/contacts.js'];
        $this->view('admin/contacts/index', $data);
    }

    public function read() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $statusFilter = $_GET['status'] ?? 'all';
        $sortOrder = $_GET['sort'] ?? 'newest';
        $isAjax = (isset($_GET['ajax']) && $_GET['ajax'] === '1')
            || (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
                && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');

        if ($id > 0) {
            $model = $this->model('ContactModel');
            $model->markAsRead($id);
        }

        if ($isAjax) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                'success' => $id > 0,
                'id' => $id,
            ]);
            exit;
        }

        header("Location: " . BASE_URL . "admin/contact?page=" . $page . "&status=" . urlencode($statusFilter) . "&sort=" . urlencode($sortOrder));
        exit;
    }

    public function detail() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $statusFilter = $_GET['status'] ?? 'all';
        $sortOrder = $_GET['sort'] ?? 'newest';

        $model = $this->model('ContactModel');
        $contact = $id > 0 ? $model->getById($id) : null;

        if (!$contact) {
            header("Location: " . BASE_URL . "admin/contact?page=" . $page . "&status=" . urlencode($statusFilter) . "&sort=" . urlencode($sortOrder));
            exit;
        }

        if ((int)($contact['status'] ?? 0) === 0) {
            $model->markAsRead($id);
            $contact['status'] = 1;
        }

        $data['contact'] = $contact;
        $data['page'] = $page;
        $data['filters'] = [
            'status' => $statusFilter,
            'sort' => $sortOrder,
        ];
        $data['title'] = "Chi tiết liên hệ";
        $data['currentPage'] = 'contact';
        $this->view('admin/contacts/detail', $data);
    }

    public function delete() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $statusFilter = $_GET['status'] ?? 'all';
        $sortOrder = $_GET['sort'] ?? 'newest';

        if ($id > 0) {
            $model = $this->model('ContactModel');
            $model->deleteById($id);
        }

        header("Location: " . BASE_URL . "admin/contact?page=" . $page . "&status=" . urlencode($statusFilter) . "&sort=" . urlencode($sortOrder));
        exit;
    }

    public function bulkDelete() {
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $statusFilter = $_GET['status'] ?? 'all';
        $sortOrder = $_GET['sort'] ?? 'newest';
        $ids = $_POST['ids'] ?? [];

        if (!empty($ids) && is_array($ids)) {
            $model = $this->model('ContactModel');
            $model->deleteByIds($ids);
        }

        header("Location: " . BASE_URL . "admin/contact?page=" . $page . "&status=" . urlencode($statusFilter) . "&sort=" . urlencode($sortOrder));
        exit;
    }

}

