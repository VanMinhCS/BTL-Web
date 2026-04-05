<?php
class ContactController extends Controller {
    public function index() {
        $data['title'] = "Liên hệ với BK88";
        $this->view('public/contact/index', $data);
    }
}