<?php
require_once "global_class.php";

class Article extends GlobalClass{

    public function __construct($db){
        parent::__construct("articles", $db);
    }
    public function editArticle($idm, $id, $section_id, $title, $intro_text, $full_text, $metadesc, $metakey, $image){
        return $this->edit($idm, array("id" => $id,"section_id"=>$section_id, "title" => $title, "intro_text" => $intro_text, "full_text"=>$full_text, "meta_desc" => $metadesc, "meta_key" => $metakey, "image"=>$image) );
    }
    public function editArticleWithoutImage($idm, $id, $section_id, $title, $intro_text, $full_text, $metadesc, $metakey){
        return $this->edit($idm, array("id" => $id,"section_id"=>$section_id, "title" => $title, "intro_text" => $intro_text, "full_text"=>$full_text, "meta_desc" => $metadesc, "meta_key" => $metakey));
    }
    public function addArticle($id, $section_id, $title, $intro_text, $full_text, $metadesc, $metakey, $image){
        return $this->add(array("id"=>$id, "section_id"=>$section_id, "title"=>$title, "intro_text"=>$intro_text, "full_text"=>$full_text, "meta_desc"=>$metadesc, "meta_key"=>$metakey, "image"=>$image, "date"=>time()));
    }
    public function getAllSortDate(){
        return $this->getAll("date", false);
    }
    public function isArticle($id){
        return $this->isExists("id", $id);
    }
    public function getAllOnSectionID($section_id){
        return $this->getAllOnField("section_id", $section_id, "date", false);
    }
    public function getSection($id){
        return $this->getFieldOnID($id, "section_id");
    }
    public function getTitle($id){
        return $this->getFieldOnID($id, "title");
    }
    public function getIntroText($id){
        return $this->getFieldOnID($id, "intro_text");
    }
    public function getFullText($id){
        return $this->getFieldOnID($id, "full_text");
    }
    public function getMetaDesc($id){
        return $this->getFieldOnID($id, "meta_desc");
    }
    public function getMetaKey($id){
        return $this->getFieldOnID($id, "meta_key");
    }
    public function getImage($id){
        return $this->getFieldOnID($id, "image");
    }
    public function getDate($id){
        return $this->getFieldOnID($id, "date");
    }

    public function setSection($id, $section){
        if(!$this->valid->validSectionID($section)) return false;
        return $this->edit($id, $section);
    }
    public function setTitle($id, $title){
        if(!$this->valid->validText($title)) return false;
        return $this->edit($id, $title);
    }
    public function setIntroText($id, $intro_text){
        return $this->edit($id, $intro_text);
    }
    public function setFullText($id, $full_text){
        return $this->edit($id, $full_text);
    }
    public function setMetaDesc($id, $meta_desc){
        if(!$this->valid->validText($meta_desc)) return false;
        return $this->edit($id, $meta_desc);
    }
    public function setMetaKey($id, $meta_key){
        if(!$this->valid->validText($meta_key)) return false;
        return $this->edit($id, $meta_key);
    }
    public function setImage($id, $image){
        if(!$this->valid->validText($image)) return false;
        return $this->edit($id, $image);
    }
    public function setDate($id, $date){
        if(!$this->valid->validTimeStamp($date)) return false;
        return $this->edit($id, $date);
    }

    public function getSearchText($full_text, $words, $id){
        $words = mb_strtolower($words);
        $words = trim($words);
        $words = quotemeta($words);
        $count = substr_count($full_text, $words);
            if ($count == 0) {
                $signs = array("." , "!", "?");
                for($i = 0;$i < count($signs); $i++) {
                    $pos = strpos($this->getFullText($id), $signs[$i], 255);
                    if($pos > 450) continue;
                    if ($pos) {
                        return substr($this->getFullText($id), 0, $pos + 1);
                    }
                }
            } elseif($count >= 1){
                $poss[] = strpos($this->getFullText($id), $words, 0);
                for($i = 0;$i < $count;$i++) {
                    $poss[] = strpos($this->getFullText($id), $words, $poss[$i]);
                }
                if($poss){
                    for($i = 0;$i < $count; $i++){
                        $posendword = strpos($this->getFullText($id), ' ' ,$poss[$i]);
                        $replword = mb_strcut($this->getFullText($id), $poss[$i], $posendword - $poss[$i]);
                        $wordsbold = "<b><i>".$replword."</i></b>";
                            if ($poss[$i] > 250) {
                                $post = strpos($this->getFullText($id), ".", $poss[$i] - 250);
                                if(!$post) $post = strpos($this->getFullText($id), "!", $poss[$i] - 250);
                                if(!$post) $post = strpos($this->getFullText($id), "?", $poss[$i] - 250);
                                $possend = strpos($this->getFullText($id), ".", $poss[$i]);
                                if(!$possend) $possend = strpos($this->getFullText($id), "!", $poss[$i]);
                                if(!$possend) $possend = strpos($this->getFullText($id), "?", $poss[$i]);
                                $text[] = str_replace($replword, $wordsbold, substr($this->getFullText($id), $post + 1, $possend - $post));
                            } elseif (($poss[$i] < 250) && ($poss[$i] > 150) ) {
                                $post = strpos($this->getFullText($id), ".", $poss[$i] - 150);
                                if(!$post) $post = strpos($this->getFullText($id), "!", $poss[$i] - 150);
                                if(!$post) $post = strpos($this->getFullText($id), "?", $poss[$i] - 150);
                                $possend = strpos($this->getFullText($id), ".", $poss[$i] + 100);
                                if(!$possend) $possend = strpos($this->getFullText($id), "!", $poss[$i]);
                                if(!$possend) $possend = strpos($this->getFullText($id), "?", $poss[$i]);
                                $text[] = str_replace($replword, $wordsbold, substr($this->getFullText($id), $post + 1, $possend - $post));

                            }elseif($poss[$i] < 150){
                                $post = 0;
                                $possend = strpos($this->getFullText($id), ".", $poss[$i] + 100);
                                if(!$possend) $possend = strpos($this->getFullText($id), "!", $poss[$i]);
                                if(!$possend) $possend = strpos($this->getFullText($id), "?", $poss[$i]);
                                $text[] = str_replace($replword, $wordsbold, substr($this->getFullText($id), $post, $possend - $post));
                            }
                    }
                }
                $_SESSION["countw"] = 0;
                    for ($j = 0; $j < count($text); $j++) {
                        if(count($text) == 1) {
                            return $text[$j];
                        }
                        $countw = substr_count($text[$j], $words);
                        if ($_SESSION["countw"] < $countw) {
                            if(count($text) - 1){
                                $max = $text[$j];
                            }
                            $_SESSION["countw"] = $countw;

                        } else $max = $text[$j-1];
                    }
                return $max;
                //return $text;
            }
            else return false;

    }

    public function searchArticles($words){
        return $this->search($words, array("title", "full_text"));
    }
}

?>