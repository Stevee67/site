<?php
require_once "modules_class.php";

class ChangeMenuContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
    }

    protected function getTitle()
    {
        return "Редагування меню";
    }

    protected function getMetaDesc()
    {
        return "редагування меню";
    }

    protected function getMetaKey()
    {
        return "редагування меню, змінити меню";
    }
    protected function getMiddle()
    {
        if($_SESSION["login"] !== $this->user->getLoginOnId("1")) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $menu = $this->menu->getAll();
        for($i=0; $i < count($menu); $i++){
            $sr["title"] = $menu[$i]["title"];
            $sr["id"] = $menu[$i]["id"];
            $sr["menu"] .= $this->getReplaceTemplate($sr, "menu_itemchange");
        }
        return $this->getReplaceTemplate($sr, "form_changemenu");
    }

}


?>
