<?php
class ContactController extends Controller {
    public function index() {
        $data['title'] = "Liên hệ với BK88";
        $data['currentPage'] = 'contact';
        $infoModel = $this->model('ContactInfoModel');
        $data['contactFields'] = $infoModel->getActive();
        $this->view('public/contact/index', $data);
    }

    public function submit() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $customer_name  = htmlspecialchars($_POST['customer_name'] ?? '');
            $customer_email = htmlspecialchars($_POST['customer_email'] ?? '');
            $subject        = htmlspecialchars($_POST['subject'] ?? '');
            $message        = htmlspecialchars($_POST['message'] ?? '');

            if (empty($customer_name) || empty($customer_email) || empty($message)) {
                die("Vui lòng điền đầy đủ thông tin bắt buộc!"); 
            }

            $model = $this->model('ContactModel');
            if ($model->saveContact($customer_name, $customer_email, $subject, $message)) {
                header("Location: " . BASE_URL . "contact?status=success");
            }
        }
    }
}