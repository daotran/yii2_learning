<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;

/**
 * @var dektrium\user\models\User  $user
 * @var dektrium\user\models\Token $token
 */
?>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('app', 'Hello') ?>,
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('app', 'Thank you for registering with The Luxury Closet') ?>.<br>
    <?= Yii::t('app', 'You will now receive updates about our latest arrivals, and hear from our Fashion Editor on the latest trends hitting the luxury world!') ?>.<br>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('app', 'Watch out for emails featuring our special collections and blog posts put together by our in house experts, specially for you!') ?>.<br>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <a href="<?= \yii\helpers\Url::to(['?showlogin=true'],true) ?>"><?= Yii::t('app', 'Login') ?></a>
    <?= Yii::t('app', ' to your account with your username') ?>: 
    <?= $user->email ?>.<br><br>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('app', 'Questions? Contact us on') ?>:<br>
    <a href="mailto:info@theluxurycloset.com">info@theluxurycloset.com</a><br>
    +971 800 589<br>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('app', 'We would be happy to hear from you!') ?><br><br>
</p>
<p style="font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 1.6; font-weight: normal; margin: 0 0 10px; padding: 0;">
    <?= Yii::t('app', 'Regards') ?>,<br>
    <?= Yii::t('app', 'Customer Support') ?><br>
    <?= Yii::t('app', 'The Luxury Closet') ?><br>
</p>
