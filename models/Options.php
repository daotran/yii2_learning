<?php

namespace app\models;

use Yii;
use yii\base\model;

/**
 * Option model is the model that process everything about a product.
 */
class Options extends Model
{

    public static function tableName()
    {
        return 'options';
    }

    /**
     * get one option
     */

    public static function getConfig($name='')
    {
        if(!empty($name)){
            
            $returnValue = Yii::$app->cache->get('options_name_'.$name);
            if(empty($returnValue)){
                $arrValue = Yii::$app->db->createCommand('SELECT * FROM '.self::tableName().' WHERE name="'.$name.'"')->queryOne();
                if(empty($arrValue)){
                    return false;
                }else{
                    $returnValue = $arrValue['value'];
                    Yii::$app->cache->set('options_name_'.$name,$returnValue);
                }
            }
            return $returnValue;
        }
        return false;
    }

    public static function setConfig($name='', $value='')
    {
        $getValue = Yii::$app->db->createCommand('SELECT * FROM '.self::tableName().' WHERE name = "'. $name .'"')->queryOne();
        if($getValue) { //existed => update data
            Yii::$app->db->createCommand('UPDATE '.self::tableName().' SET value = "'. $value .'" WHERE name = "'. $name .'"')->execute();
        } else { // doesn't exist, create new row
            Yii::$app->db->createCommand('INSERT INTO '.self::tableName().' (name,value) VALUES("'.$name.'","'.$value.'")')->execute();
        }        
    }
}