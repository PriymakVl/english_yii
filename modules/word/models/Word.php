<?php

namespace app\modules\word\models;

use Yii;
use yii\helpers\Html;
use app\models\Sound;
use app\modules\string\models\{FullString, Substring};

/**
 * This is the model class for table "word".
 *
 * @property int $id
 * @property string $engl
 * @property string $ru
 * @property int|null $status
 */
class Word extends \app\modules\word\models\BaseWord
{
    // const SCENARIO_STATE = 'state';
    // const SCENARIO_DELETE = 'delete';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'words';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['engl', 'ru'], 'required'],
            [['status'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['engl'], 'unique'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // $scenarios[static::SCENARIO_STATE] = ['state'];
        // $scenarios[static::SCENARIO_DELETE] = ['status'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'engl' => 'Engl',
            'ru' => 'Ru',
            'status' => 'Status',
            'saund' => 'Saund'
        ];
    }

    public static function getSoundsString($state)
    {
        if ($state == STATE_ALL) $words = self::findAll(['status' => STATUS_ACTIVE]);
        else {
            $ids = State::find()->select('item_id')->where(['state' => $state, 'status' => STATUS_ACTIVE, 'user_id' => Yii::$app->user->id, 'type' => TYPE_WORD])->asArray()->all();
            $words = self::findAll($ids);
        }
        return self::createSoundsString($words);
    }

    public function getStrings()
    {
        return FullString::find()->where(['status' => STATUS_ACTIVE])->andWhere(['like', 'engl', $this->engl])->all();
    }

    public function getSubstrings()
    {
        return Substring::find()->where(['status' => STATUS_ACTIVE])->andWhere(['like', 'engl', $this->engl])->all();
    }

    public static function getIdByName($engl, $ru)
    {
        $engl = self::prepareAdd($engl);
        $ru = self::prepareAdd($ru, false);
        $word = self::findOne(['engl' => $engl]);
        if (!$word) $word = self::add($engl, $ru);
        if ($word->status == STATUS_INACTIVE) return false;
        return $word->id;
    }

    private static function add($engl, $ru) 
    {
        $word = new self;
        $word->engl = $engl; 
        $word->ru = $ru;
        $word->status = STATUS_ACTIVE;
        if (!$word->save(false)) throw new NotFoundHttpException('error add class Word.');
        return $word;
    }

    private static function prepareAdd($word, $flag_engl = true)
    {
        $word = strtolower(trim($word));
        if (!$flag_engl) $word = mb_convert_encoding($word, "utf-8", "windows-1251");
        return htmlspecialchars($word);
    }

    public function templateLinkState()
    {
        $params = ['/word/set-state', 'id' => $this->id];
        $style['class'] = ($this->state == STATE_NOT_LEARNED) ? 'text-danger' : 'text-success';
        $name = ($this->state == STATE_NOT_LEARNED) ? 'не выучено' : 'выучено';
        return Html::a($name, $params, $style);
    }
}
