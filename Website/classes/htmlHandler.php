<?php
include_once("htmlComplete.php");
class htmlHandler {
    public function homepage(): void {
        $htmlComplete = new htmlComplete("html/homepage.html");
        $htmlComplete->getPage();
    }
    public function download(): void {
        $htmlComplete = new htmlComplete("html/download.html");
        $htmlComplete->getPage();
    }
    public function impressum(): void {
        $htmlComplete = new htmlComplete("html/terms/impressum.html");
        $htmlComplete->getPage();
    }
    public function datenschutzerklärung(): void {
        //$htmlComplete = new htmlComplete("html/terms/dataProtection.html");
        //$htmlComplete->getPage();
        include_once("html/terms/dataProtection.html");
    }
    public function register(): void {
        $htmlComplete = new htmlComplete("html/register.html");
        $htmlComplete->getPage();
    }
    public function nav(): void {
        include_once("html/moduls/nav.php");
    }
    public function footer(): void {
        include_once("html/moduls/footer.html");
    }
}
?>