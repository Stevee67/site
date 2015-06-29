<?php
require_once "modules_class.php";

class SearchContent extends Modules{
    private $words;

    public function __construct($db){
        parent:: __construct($db);

        $this->words = $this->data["words"];
    }

    protected function getTitle()
    {
        return "Результати пошуку: ".$this->words;
    }

    protected function getMetaDesc()
    {
        return $this->words;
    }

    protected function getMetaKey()
    {
        return mb_strtolower($this->words);
    }

    protected function getMiddle()
    {
        $results = $this->article->searchArticles($this->words);
        if($results === false) return $this->getTemplate("search_notfound");
        for($i = 0;$i < count($results);$i++){
            $sr["link"] = $this->config->address."?view=article&amp;id=".$results[$i]["id"];
            $sr["title"] = $results[$i]["title"];
            $id = $results[$i]["id"];
            $full_text = $this->article->getFullText($id);
            //$pos = $this->article->getSearchText($full_text, $this->words, $id);
            $sr["full_text"] = $this->article->getSearchText($full_text, $this->words, $id);//getFullText($id);
            //var_dump($this->article->getIntroText($id));
            $text .= $this->getReplaceTemplate($sr, "search_item");

        }
        $new_sr["search_items"] = $text;
        return $this->getReplaceTemplate($new_sr, "search_result");
    }

}


?>