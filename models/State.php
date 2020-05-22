<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "states".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $type
 * @property int|null $value
 */
class State extends \app\models\ModelApp
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'value'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'value' => 'Value',
        ];
    }

    public static function set($item)
    {
        $type = self::getType($item);
        //$item_id = ($item->getClassName() == 'WordText') ? $item->word->id : $item->id;
        $params = ['user_id' => Yii::$app->user->id, 'type' => $type, 'item_id' => $item->id];
        $state = State::findOne($params); 
        if (!$state) $state = self::add($item);
        else if ($state->value == STATE_LEARNED) $state->value = STATE_NOT_LEARNED;
        else $state->value = STATE_LEARNED;
        if (!$state->save(false)) throw new NotFoundHttpException('error set state item class State');
    }

    public static function get($item)
    {
        $type = State::getType($item);
        $params = ['user_id' => Yii::$app->user->id, 'type' => $type, 'item_id' => $item->id];
        $state = State::findOne($params);
        if (!$state) $state = self::add($item);
        return $state->value;
    }

    public static function add($item)
    {
        $state = new self;
        $state->user_id = Yii::$app->user->id;
        $state->value = STATE_NOT_LEARNED;
        $state->type = self::getType($item);
        $state->item_id = $item->id;
        if (!$state->save(false)) throw new NotFoundHttpException('error add state item class State');
        return $state;
    }

    private static  function getType($obj)
    {
        $classname = $obj->getClassName();
        if ($classname == 'Word') return TYPE_WORD;
        else if ($classname == 'FullString') return TYPE_STRING;
        else if ($classname == 'SubString') return TYPE_SUBSTRING;
        throw new NotFoundHttpException('error get type state item class State');
    }




    //для перехода но новый движок 
    //add values state from tables into table state 
    public static function addValue() 
    {
        $words = \app\modules\word\models\Word::findAll(['status' => STATUS_ACTIVE]);
        foreach ($words as $word) {
            $state = new self;
            $state->user_id = Yii::$app->user->id;
            $state->value = $word->state;
            $state->type = self::getType($word);
            $state->item_id = $word->id;
            $state->save(false);
        }
        debug();
    }
}
