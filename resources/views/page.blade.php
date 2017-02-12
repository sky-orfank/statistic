<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <link rel="stylesheet" href="/css/main.css">

    <script src="http://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>

</head>
    <body>
        <div>

        <?php foreach ($pages as $item):?>
            <a href="/page/<?=$item->id?>">
                <?php if($current_page==$item->id): ?>
                    <b><?=$item->title?></b>
                <?php else: ?>
                    <?=$item->title?>            
                <?php endif; ?> 
            </a>
        <?php endforeach; ?> 
        </div>

        <?php if(!empty($page)): ?>
            <div class="text">
                <?=$page->text?>
            </div>
        <?php else: ?>
            No page          
        <?php endif; ?> 

    </body>
</html>