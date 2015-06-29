<?php
require_once "modules_class.php";

class ChangePollContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування опитувань";
    }

    protected function getMetaDesc()
    {
        return "редагування опитувань";
    }

    protected function getMetaKey()
    {
        return "редагування опитувань, опитування редагувати";
    }
    protected function getMiddle()
    {
        if($_SESSION["login"] !== $this->user->getLoginOnId("1")) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $poll = $this->poll->getAll();
        for($i=0; $i < count($poll); $i++){
            $sr["title"] = $poll[$i]["title"];
            $sr["id"] = $poll[$i]["id"];
            $sr["polls"] .= $this->getReplaceTemplate($sr, "poll_itemedit");
        }
        return $this->getReplaceTemplate($sr, "form_changepoll");

    }

}
?>