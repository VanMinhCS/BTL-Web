<?php
class ContactController extends Controller {
    
    public function index() {
        $model = $this->model('ContactModel');
        // $contacts = $model->getAll();
        $data['contacts'] = $model->getAll();
        $data['title']    = "Quản lý liên hệ";
        $data['currentPage'] = 'contact'; // Để nháy sáng menu
        $this->view('admin/contacts/index', $data);
    }

    public function read() {
        // Lấy ID từ Query String (?id=...) thay vì từ tham số hàm
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            $model = $this->model('ContactModel');
            $model->markAsRead($id);
        }

        // Quay trở lại danh sách sau khi xử lý
        header("Location: " . BASE_URL . "admin/contact");
        exit;
    }
}