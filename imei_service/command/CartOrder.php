<?php
/**
 * Created by PhpStorm.
 * User: zhalnin
 * Date: 12/07/14
 * Time: 17:50
 */

namespace imei_service\command;
error_reporting( E_ALL & ~E_NOTICE );
session_start();

require_once( "imei_service/command/Command.php" );
require_once( "imei_service/domain/CartOrder.php" );
require_once( "imei_service/view/utils/utils.checkEmail.php" );
require_once( "imei_service/base/Registry.php" );


class CartOrder extends Command {

    function doExecute( \imei_service\controller\Request $request ) {
//        echo "<tt><pre>".print_r( $_POST, true )."</pre></tt>";

        $pdo = \imei_service\base\DBRegistry::getDB();
//        Добавляем в system_cart_orders
        $firstname          = 'anonymous';
        $lastname           = 'anonymous';
        $email              = $request->getProperty( 'email' );
        $country            = 'anonymous';
        $address            = 'anonymous';
        $city               = 'anonymous';
        $zip_code           = 'anonymous';
        $state              = 'anonymous';
        $status             = 'anonymous';
        $amount             = $request->getProperty( 'subtotal' );
        $paypal_trans_id    = 'anonymous';
        $created_at         = date('Y-m-d H:i:s');
        $data               = $request->getProperty( 'data' );

        if( $request->getProperty( 'submitted') !== 'yes' ) { // если форма не отправлена
            return self::statuses( 'CMD_INSUFFICIENT_DATA' );
        }
        if( empty( $email ) ) {
            $request->addFeedback( 'Заполните поле "Email"' );
            return self::statuses( 'CMD_INSUFFICIENT_DATA' );
        }
        if( checkEmail( $email ) == false ) {
            $request->addFeedback( 'Введите корректный адрес "Email"' );
            return self::statuses( 'CMD_INSUFFICIENT_DATA' );
        }
        if( empty( $data ) ) {
            $request->addFeedback( 'Заполните поле "Данных"' );
            return self::statuses( 'CMD_INSUFFICIENT_DATA' );
        }

        $cartOrder = new \imei_service\domain\CartOrder( null,
                                                        $firstname,
                                                        $lastname,
                                                        $email,
                                                        $country,
                                                        $address,
                                                        $city,
                                                        $zip_code,
                                                        $state,
                                                        $status,
                                                        $amount,
                                                        $paypal_trans_id,
                                                        $created_at,
                                                        $data );
        $ob = $request->setObject( 'cartObject', $cartOrder );




            $order_id = $cartOrder->getId();
//        $id = $pdo->lastInsertId();
        echo "<tt><pre>".print_r( $order_id, true )."</pre></tt>";

    //        Добавляем в system_cart_items

            foreach( $_POST as $key => $val ) {
                if( preg_match('|amount_(.*)|', $key, $match ) ) {
                    $count = $match[1];
                }
            }

            for( $i=1; $i <= $count; $i++ ) {

                $item_name      = $_POST['item_name_'.$i];
                $item_number    = $_POST['item_number_'.$i];
                $amount         = $_POST['amount_'.$i];
                $quantity       = $_POST['quantity_'.$i];

    //            new \imei_service\domain\CartOrder( null, $item_number, )

            }

    //        echo "<tt><pre>".print_r( $res, true )."</pre></tt>";

            // после успешного добавления заказа и предметов закакза удаляем сессию
            session_unset();
            session_destroy();
//            return self::statuses( 'CMD_OK' );
        }

}

?>