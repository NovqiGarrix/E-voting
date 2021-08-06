<?php
require_once APPPATH . "libraries/domPDF/vendor/autoload.php";

use Dompdf\Dompdf;

class Pdf extends Dompdf {
    public $filename;

    public function __construct()
    {
        parent::__construct();
        $this->filename = 'laporan.pdf';
    }

    protected function ci()
    {
        return get_instance();
    }

    public function loadView($view, $data = []) {
        $html = $this->ci()->load->view($view, $data, TRUE);
        $this->load_html($html);

        $this->render();

        $this->stream($this->filename, ['Attachment' => FALSE]);
    }
}