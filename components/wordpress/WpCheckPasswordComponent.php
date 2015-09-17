<?php
namespace app\components\wordpress;

use \yii\base\Component;

use app\components\wordpress\WpPasswordHashComponent;

class WpCheckPasswordComponent extends Component {
    function wp_check_password($password, $hash, $user_id = '') {
        $wp_hasher = new WpPasswordHashComponent();
        $wp_hasher->PasswordHash(8, true);
        $check = $wp_hasher->CheckPassword($password, $hash); //check if password true
 
        return $check;
    }
}