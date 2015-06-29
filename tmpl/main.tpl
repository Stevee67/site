<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html">
    <meta name="description" content="%meta_desc%">
    <meta name="keywords" content="%meta_key%">
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <title>%title%</title>
</head>
<body>
<div id="content">
    <div id="header">
        <h2>PHP</h2>
    </div>
</div>
<hr />
<div id="main_content">
    <div id="left">
        <h2>Меню</h2>
        <ul>%menu%</ul>
        %auth_user%
    </div>
    <div id="right">
        <form name="search" action="%address%" method="get">
            <p>
                Пошук:<input type="text" name="words">
            </p>
            <p>
                <input type="hidden" name="view" value="search">
                <input type="submit" name="search" value="Пошук">
            </p>
        </form>
        <h2>Реклама</h2>
        %banners%
        <div class="poll">
            %poll%
        </div>
    </div>
    <div id="center">
        %top%
        %middle%
        %bottom%

    </div>
    <div class="clear"></div>
    <hr />
    <div id="footer">
        <p>Всі права захищенні &copy; 2015</p>
    </div>
</div>
</body>
</html>