<?php
require_once "modules_class.php";

class EditMenuContent extends Modules{

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
        if(!$this->isAdmin()) return $this->config->address;
        $sr["message"] = $this->getMessage();
        $id = $_GET["id"];
        $menu = $this->menu->getFieldMenu($id);
        if(!$menu) return false;
        $sr["title"] = $menu;
        $sr["id"] = $id;
        $sr["menu"] = $this->getReplaceTemplate($sr, "menu_itemedit");
        return $this->getReplaceTemplate($sr, "form_itemedit");
    }

}
?>
