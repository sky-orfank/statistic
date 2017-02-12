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


        <?php if(!empty($statistic)): ?>
            <a href="/admin/statistic/1">Статистика по страницам</a>
            <div class="main">
                <table>
                    <thead>
                    <th>ОСЬ</th>
                    <th>Хиты</th>
                    <th>Уники по IP</th>
                    <th>Уники по cookies</th>
                    </thead>
                    <?php foreach ($statistic['platform'] as $k=>$v):?>
                    <tr>
                        <td>
                            <?=$k;?></td>
                        <td>
                            <?=$v['hit']?>
                        </td>
                        <td>
                            <?=$v['ip']?>
                        </td>
                        <td>
                            <?=$v['laravel_session']?>    
                        </td>
                    </tr>
                    <?php endforeach; ?>   
                </table>
            </div>  
            <div class="main">  
                <table>
                    <thead>
                    <th>Геолокация</th>
                    <th>Хиты</th>
                    <th>Уники по IP</th>
                    <th>Уники по cookies</th>
                    </thead>
                    <?php foreach ($statistic['geo_loc'] as $k=>$v):?>
                    <tr>
                        <td>
                            <?=$k;?></td>
                        <td>
                            <?=$v['hit']?>
                        </td>
                        <td>
                            <?=$v['ip']?>
                        </td>
                        <td>
                            <?=$v['laravel_session']?>    
                        </td>
                    </tr>
                    <?php endforeach; ?>                                    
                </table>
            </div> 
            <div class="main">
                <table>
                    <thead>
                    <th>Реферреры</th>
                    <th>Хиты</th>
                    <th>Уники по IP</th>
                    <th>Уники по cookies</th>
                    </thead>                                  
                    <?php foreach ($statistic['referrer'] as $k=>$v):?>
                    <tr>
                        <td>
                            <?=$k;?></td>
                        <td>
                            <?=$v['hit']?>
                        </td>
                        <td>
                            <?=$v['ip']?>
                        </td>
                        <td>
                            <?=$v['laravel_session']?>    
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>      
            <div class="main">               
                <table>
                    <thead>
                    <th>Браузеры</th>
                    <th>Хиты</th>
                    <th>Уники по IP</th>
                    <th>Уники по cookies</th>
                    </thead>
                    <?php foreach ($statistic['browser'] as $k=>$v):?>
                    <tr>
                        <td>
                            <?=$k;?></td>
                        <td>
                            <?=$v['hit']?>
                        </td>
                        <td>
                            <?=$v['ip']?>
                        </td>
                        <td>
                            <?=$v['laravel_session']?>    
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php else: ?>
            No statistic          
        <?php endif; ?> 

    </body>
</html>