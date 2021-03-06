<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhalnin
 * Date: 09.06.12
 * Time: 22:00
 * To change this template use File | Settings | File Templates.
 */
 
// Выставляем уровень обработки ошибок
error_reporting(E_ALL & ~E_NOTICE);
// Устанавливаем соединение с базой данных
require_once("config.php");
// Подключаем классы
require_once("../../config/class.config.dmn.php");
// Подключаем блок авторизации
require_once("../utils/security_mod.php");
// Подключаем блок отображения текста в окне браузера
require_once("../utils/utils.print_page.php");
// Постраничная навигация
require_once("../utils/utils.pager.php");
// Формирование WHERE-условий
require_once("utils.where.php");
// Выполнение запроса
require_once("utils.query_result.php");

// Данные переменные определяют название страницы и подсказку
$title = 'Понедельный отчет';
try
{
    // Заголовок страницы
    require_once("../utils/topcounter.php");

    // Постраничная навигация
    if(empty($_GET['page'])) $page = 1;
    else $page = $_GET['page'];

    // Извлекаем количество страниц
    $query = "SELECT COUNT(DISTINCT putdate_begin)
                FROM $tbl_arch_time_week";
    $total = query_result($query);

    $page_link = 3;
    $first = ($page - 1)*$pnumber;

    // Выводим ссылки на другие страницы
    pager($page,
          $total,
          $pnumber,
          $page_link,
          "");
    echo "<br><br>";

    // Извлекаем данные для текущей страницы
    $query = "SELECT UNIX_TIMESTAMP(putdate_begin) AS putdate_begin,
                    UNIX_TIMESTAMP(putdate_end) AS putdate_end
               FROM $tbl_arch_time_week
               GROUP BY putdate_begin
               ORDER BY putdate_begin DESC
               LIMIT $first, $pnumber";
    $arh = mysql_query($query);
    if(!$arh)
    {
        throw new ExceptionMySQL(mysql_error(),
                                $query,
                                "Ошибка извлечения недельной статистики");
    }
    if(mysql_num_rows($arh))
    {
        echo "<table class=table border=0 width=100% cellpadding=0 cellspacing=0>
                <tr class=header align=center>
                    <td align=center width=50%>Дата</td>
                    <td align=center width=50%>Ссылка</td>
                </tr> ";
        while($hits = mysql_fetch_array($arh))
        {
            // Формируем дату
           $date_table = date("d.m",$hits['putdate_begin'])." - ".date("d.m",$hits['putdate_end']);
            echo "<tr>
                     <td align=center>$date_table</td>
                     <td align=center><a href=$_SERVER[PHP_SELF]?date=$hits[putdate_begin]>смотреть</a></td>
                   </tr>";
        }
        echo "</table><br><br>";
    }

    // Если параметр $_GET['date'] не пуст, запрашиваем IP-адрес
    // за неделю
    if(!empty($_GET['date']))
    {
        $_GET['date'] = intval($_GET['date']);
        $query = "SELECT * FROM $tbl_arch_time_week
                    WHERE putdate_begin LIKE '".date("Y-m-d",$_GET['date'])."%'";
        $ipt = mysql_query($query);
        if(!$ipt)
        {
            throw new ExceptionMySQL(mysql_error(),
                                     $query,
                                     "Ошибка извлечения недельной статистики");
        }
        if(mysql_num_rows($ipt))
        {
            echo "<table class=table
                         width=100%
                         border=0
                         cellpadding=0
                         cellspacing=0>
                     <tr class=header align=center>
                        <td width=150>Время</td>
                        <td width=150>Число обращений</td>
                        <td>Гистограмма</td>
                     </tr>";
            $arch_time = mysql_fetch_array($ipt);
            unset($arch_time['id_time'], $arch_time['putdate']);
            $total = array_sum($arch_time);


            echo "<tr>
                    <td>1 минута</td>
                    <td>".$arch_time['visit1']."</td>
                    <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit1']/$total)."% height=6</td>
                 </tr>\r\n";
            echo "<tr>
                    <td>2 минуты</td>
                    <td>".$arch_time['visit2']."</td>
                    <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit2']/$total)."% height=6</td>
                 </tr>\r\n";
            echo "<tr>
                    <td>3 минуты</td>
                    <td>".$arch_time['visit3']."</td>
                    <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit3']/$total)."% height=6</td>
                 </tr>\r\n";
            echo "<tr>
                    <td>4 минуты</td>
                    <td>".$arch_time['visit4']."</td>
                    <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit4']/$total)."% height=6</td>
                 </tr>\r\n";
            for($i = 5; $i < 11; $i++)
            {
                echo "<tr>
                    <td>$i минут</td>
                    <td>".$arch_time['visit'.$i]."</td>
                    <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.$i]/$total)."% height=6</td>
                 </tr>\r\n";
            }
            for($i = 10; $i < 60; $i = $i + 10)
            {
                echo "<tr>
                    <td>от ".$i." до ".($i+10)." минут</td>
                    <td>".$arch_time['visit'.($i+10)]."</td>
                    <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.($i+10)]/$total)."% height=6</td>
                 </tr>\r\n";
            }
            for($i = 1; $i < 24; $i++)
            {
                echo "<tr>
                        <td>от ".$i." до ".($i+1)." часов</td>
                        <td>".$arch_time['visit'.($i+1).'h']."</td>
                        <td><img src=images/parm.gif border=0 width=".(100*$arch_time['visit'.($i+1).'h']/$total)."% height=6</td>
                     </tr>\r\n";
            }
        }
        echo "</table>";
    }

    // Завершение страницы
    require_once("../utils/bottomcounter.php");
}
catch(ExceptionMySQL $exc)
{
    require("../utils/exception_mysql.php");
}
catch(ExceptionMember $exc)
{
    require("../utils/exception_member.php");
}
catch(ExceptionObject $exc)
{
    require("../utils/exception_object.php");
}
?>
