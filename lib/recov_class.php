<?php
require_once "modules_class.php";

class RecContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);

    }

    protected function getTitle()
    {
        return "Відновлення паролю";
    }

    protected function getMetaDesc()
    {
        return "Відновлення паролю користувача.";
    }

    protected function getMetaKey()
    {
        return "відновлення пароль, відновлення користувача пароль";
    }

    protected function getMiddle()
    {
        $sr["message"] = $this->getMessage();
        $sr["recovery_hash"] = $this->user->getHashOnGet($_GET["hash"]);
        return $this->getReplaceTemplate($sr, "form_recov");
    }

}


?>
