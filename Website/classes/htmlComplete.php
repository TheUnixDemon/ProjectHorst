<?php
class htmlComplete {
    private $nav = "html/moduls/nav.php";
    private $filename;
    private $footer = "html/moduls/footer.html";

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function getPage(): void {
        include_once($this->nav);
        include_once($this->filename);
        include_once($this->footer);
    }
}
?>