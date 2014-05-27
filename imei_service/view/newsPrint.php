<?php
/**
 * Created by JetBrains PhpStorm.
 * User: zhalnin
 * Date: 5/17/13
 * Time: 2:19 PM
 * To change this template use File | Settings | File Templates.
 */

namespace imei_service\view;


error_reporting(E_ALL & ~E_NOTICE);

require_once( "imei_service/view/ViewHelper.php" );
require_once( "imei_service/view/utils/utils.printPage.php" );

$request = \imei_service\view\VH::getRequest();
$newsPrint = $request->getObject( 'newsPrint' );

//echo $request->getFeedbackString('< br/>');
//echo "<tt><pre>".print_r($newsPrint, true)."</pre></tt>";

$title = "NEWS IMEI-SEVICE";
$keywords = "udid,unlock,blacklist,carrier,iPhone,iPod,iPad,iTunes";
$description = "Официальный анлок iPhone позволит вам обновлять ваш аппарат в iTunes. Регистрация UDID в аккаунте разработчика нужен для безопасной установки iOS 7.1 бета 3. iPhone.
    Проверка iPhone по IMEI/серийному номеру даст вам самую полную информацию о вашем iPhone.
    Проверка iPhone на blacklist даст вам информацию о статусе вашего аппарата (потерян/украден/задолженность по контракту)";
require_once("templates/top.php");

?>


    <div id="header">
        <ul id="navigation" role="navigation">
            <li id="nav-home"><a  class="selected" href="index.php"><span>Главная</span></a></li>
            <li id="nav-unlock"><a href="unlock.php"><span>Официальный Анлок iPhone</span></a></li>
            <li id="nav-udid"><a href="udid.php"><span>Регистрация UDID</span></a></li>
            <li id="nav-carrier"><a href="carrier_check.php"><span>Проверка оператора по IMEI</span></a></li>
            <li id="nav-fast_check"><a href="fast_check.php"><span>Быстрая проверка</span></a></li>
            <li id="nav-blacklist"><a href="blacklist_check.php"><span>Blacklist</span></a></li>
            <li id="nav-faq"><a href="faq.php"><span>Вопросы</span></a></li>
        </ul>
    </div>
    <div id="main" class="">
    <div id="main-slogan" class="main-content">
        <div id="slogan">Быстро - Качественно - Надежно</div>
    </div>
    <!--        End of main-slogan-->

    <div id="addNav" class="">
        <a href="<?php echo $_SERVER['PHP_SELF']."?cmd=Guestbook" ?>"><div id="nav-guestbook" class="addNav-body rounded main-content"><h3 class="h3">Гостевая</h3></div></a>
        <a href="<?php echo $_SERVER['PHP_SELF']."?cmd=Contacts" ?>"><div id="nav-contact" class="addNav-body rounded main-content"><h3 class="h3">Контакты</h3></div></a>
    </div>


    <div id="news-main" class="main-content">
        <div id="" class="news-content clear-fix">
            <div id='' class="news-header">
                <h2  class="h2">Новости</h2>
            </div>
            <div class='news-container'>



<?php



// Если имеется хотя бы одна запись - выводим ее
if(!empty($newsPrint))
{

    if($newsPrint->getHidedate() != 'hide' ) {
        $pdate = date('d.m.Y H:i', strtotime($newsPrint->getPutdate()));
        $putdate =  "<span id=\"datetime\">".$pdate."</span>";
    } else {
        $putdate = "";
    }
    if($newsPrint->getUrlpict_s() != '' && $newsPrint->getHidepict() != 'hide')
    {
        $photo_print = "src='imei_service/view/{$newsPrint->getUrlpict_s()}' alt='{$newsPrint->getAlt()}'";
        $img = "<img $photo_print>";

    } else {
        $img = "";
    }
    if($newsPrint->getUrl() != '' && $newsPrint->getUrl() != '-')
    {
        $href = "href='".$newsPrint->getUrl()."'";
        $val_href = $newsPrint->getUrltext();
    }

    echo "<div class='news-all-body'>
                <div class='news-all-title'>
                    <h1 class=\"h2\">".nl2br(\imei_service\view\utils\printPage($newsPrint->getName()))."</h1>
                </div>
                <div class='news-all-image'>
                  $img
                  $putdate
                </div>
                <div class='news-all-info'>
                    <p>".nl2br(\imei_service\view\utils\printPage($newsPrint->getBody()))."</p>
                </div>
                <div class=\"gs grid4 gs-last r-align\" style=\"\" onclick=window.history.back(); >
                    <div id=\"button_back\" class=\"button rect transactional blues\" title=\"Сбросить\" type=\"button\" style=\"\">
                            <span style=\"\">
                                <span class=\"effect\"></span>
                                <span class=\"label\"> Назад </span>
                            </span>
                    </div><!-- shipping-button -->
                </div>
          </div>";

}
echo "
                    </div><!-- End of news-container -->
                 <div class=\"news-footer\"></div><!-- End of news-footer -->
            </div><!-- End of news-content -->
        </div><!-- End of news-main -->
        <div id=\"main-guestbook\"></div>";

require_once("templates/bottom.php");
?>