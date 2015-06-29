<?php
require_once "modules_class.php";

class NotFoundContent extends Modules{

    public function __construct($db){
        parent:: __construct($db);
        header("HTTP/1.0 404 Not Found");
    }

    protected function getTitle()
    {
        return "Сторінку не знайдено - 404";
    }

    protected function getMetaDesc()
    {
        return "Даної сторінки не існує!";
    }

    protected function getMetaKey()
    {
        return "сторінку не знайдено, сторінка не існує, 404";
    }

    protected function getMiddle()
    {
        return $this->getTemplate("notfound");
    }

}


?>