<?php

namespace app\components;

use app\models\Users;
use yii\base\Component;

/**
 * Mailer.
 *
 */
class Mailer extends Component
{
    /** @var string */
    public $viewPath = '@app/views/mail';

    /** @var string|array Default: `\Yii::$app->params['adminEmail']` OR `no-reply@example.com` */
    public $sender;

    /** @var string */
    public $welcomeSubject = "Welcome to Yii2 Learning Project";

    /** @var string */
    public $changePasswordSubject = 'Password Change Request';

    /** @var string */
    public $reconfirmationSubject;

    /** @var string */
    public $recoverySubject;

    /**
     * Sends an email to a user with credentials and confirmation link.
     *
     * @param  User  $user
     * @param  Token $token
     * @return bool
     */
    public function sendWelcomeMessage(Users $user)
    {
        $params = array(
            'user' => $user,
            //'reply_email' => ['testing.tlc@enclave.vn'=>'The Luxury Closet Test']
            'reply_email' => ['dao.tran@enclave.vn'=>'Yii2 Learning Test']
        );
        return $this->sendMessage($user->email,
            $this->welcomeSubject,
            'welcome',
            $params
         );
    }

    /**
     * Sends an email to a user with confirmation link.
     *
     * @param  User  $user
     * @param  Token $token
     * @return bool
     */
    // public function sendConfirmationMessage(User $user, Token $token)
    public function sendResetPasswordLink(Users $user)
    {
        $params = array(
            'user' => $user,
            'reply_email' => ['testing.tlc@enclave.vn'=>'Yii2 Learning Test']
        );
        return $this->sendMessage($user->email,
            $this->changePasswordSubject,
            'reset_password',
            $params
        );
    }

    /**
     * Sends an email to a user with reconfirmation link.
     *
     * @param  User  $user
     * @param  Token $token
     * @return bool
     */
    // public function sendReconfirmationMessage(User $user, Token $token)
    // {
    //     if ($token->type == Token::TYPE_CONFIRM_NEW_EMAIL) {
    //         $email = $user->unconfirmed_email;
    //     } else {
    //         $email = $user->email;
    //     }
    //     return $this->sendMessage($email,
    //         $this->reconfirmationSubject,
    //         'reconfirmation',
    //         ['user' => $user, 'token' => $token]
    //     );
    // }

    /**
     * Sends an email to a user with recovery link.
     *
     * @param  User  $user
     * @param  Token $token
     * @return bool
     */
    // public function sendRecoveryMessage(User $user, Token $token)
    // {
    //     return $this->sendMessage($user->email,
    //         $this->recoverySubject,
    //         'recovery',
    //         ['user' => $user, 'token' => $token]
    //     );
    // }

    /**
     * @param  string $to
     * @param  string $subject
     * @param  string $view
     * @param  array  $params
     * @return bool
     */
    protected function sendMessage($to, $subject, $view, $params = [])
    {
        $mailer = \Yii::$app->mailer;
        $mailer->viewPath = $this->viewPath;
        $mailer->getView()->theme = \Yii::$app->view->theme;

        if ($this->sender === null) {
            $this->sender = isset(\Yii::$app->params['adminEmail']) ? \Yii::$app->params['adminEmail'] : 'no-reply@example.com';
        }
        if(!empty($params['reply_email'])){
            $this->sender = $params['reply_email'];
        }

        // return $mailer->compose(['html' => $view, 'text' => 'text/' . $view], $params)
        return $mailer->compose($view, $params)
            ->setTo($to)
            ->setFrom($this->sender)
            ->setSubject($subject)
            ->send();
    }

    public function sendMail($to, $subject, $view, $params =[]){
        self::sendMessage($to, $subject, $view, $params);
    }
}