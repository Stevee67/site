<?php
    mb_internal_encoding("UTF-8");
    require_once "lib/database_class.php";
    require_once "lib/frontpagecontent_class.php";
    require_once "lib/sectioncontent_class.php";
    require_once "lib/articlecontent_class.php";
    require_once "lib/regcontent_class.php";
    require_once "lib/messagecontent_class.php";
    require_once "lib/recov_class.php";
    require_once "lib/searchcontent_class.php";
    require_once "lib/notfoundcontent_class.php";
    require_once "lib/pollcontent_class.php";
    require_once "lib/changepasscontent_class.php";
    require_once "lib/changemenucontent_class.php";
    require_once "lib/editmenucontent_class.php";
    require_once "lib/deletemenucontent_class.php";
    require_once "lib/createmenucontent_class.php";
    require_once "lib/changesectioncontent_class.php";
    require_once "lib/editsectioncontent_class.php";
    require_once "lib/createsectioncontent_class.php";
    require_once "lib/changearticlecontent_class.php";
    require_once "lib/editarticlecontent_class.php";
    require_once "lib/createarticlecontent_class.php";
    require_once "lib/changecommentcontent_class.php";

    $db = new DataBase();
    $view = $_GET["view"];
    switch ($view){
        case "":
            $content = new FrontPageContent($db);
            break;
        case "section":
            $content = new SectionContent($db);
            break;
        case "changesections":
            $content = new ChangeSectionContent($db);
            break;
        case "editsection":
            $content = new EditSectionContent($db);
            break;
        case "createsections":
            $content = new CreateSectionContent($db);
            break;
        case "article":
            $content = new ArticleContent($db);
            break;
        case "changearticle":
            $content = new ChangeArticleContent($db);
            break;
        case "editarticle":
            $content = new EditArticleContent($db);
            break;
        case "createarticle":
            $content = new CreateArticleContent($db);
            break;
        case "changecomm":
            $content = new ChangeCommentContent($db);
            break;
        case "deletemenu":
            $content = new DeleteMenuContent($db);
            break;
        case "editmenu":
            $content = new EditMenuContent($db);
            break;
        case "changemenu":
            $content = new ChangeMenuContent($db);
            break;
        case "addnewitem":
            $content = new CreateMenuContent($db);
            break;
        case "changepass":
            $content = new ChangePassContent($db);
            break;
        case "reg":
            $content = new RegContent($db);
            break;
        case "message":
            $content = new MessageContent($db);
            break;
        case "search":
            $content = new SearchContent($db);
            break;
        case "poll":
            $content = new PollContent($db);
            break;
        case "notfound":
            $content = new NotFoundContent($db);
            break;
        default: $content = new NotFoundContent($db);
    }


    echo $content->getContent();

?>