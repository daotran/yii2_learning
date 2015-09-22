<?php 

namespace app\components;

use Yii;
use yii\web\Request;
use yii\web\Controller;
use yii\web\Session;
use app\models\Options;
use yii\base\Component;

class GlobalComponent extends Component {

    public function init() {
      //dump(Yii::$app->request->pathInfo);
      if(substr(Yii::$app->request->pathInfo,-1)=='/'){
        Yii::$app->urlManager->suffix = '/';
      }else{
        Yii::$app->urlManager->suffix = null;
      }
  
      Yii::$app->params['upload_url'] = Options::getConfig('upload_url');
      $timeZone = Options::getConfig('time_zone');
      if(!empty($timeZone)){
        Yii::$app->timeZone = $timeZone;
      }
      parent::init();
	}
}
