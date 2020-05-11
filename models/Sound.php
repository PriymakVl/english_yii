<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\Word;
use app\models\Sentense;
use app\models\Phrase;

/**
 * This is the model class for table "sound".
 *
 * @property int $id
 * @property int $type
 * @property int $item_id
 * @property string $filename
 * @property int|null $status
 */
class Sound extends \yii\db\ActiveRecord
{

    // const SCENARIO_FILE = 'file';
    const SCENARIO_CREATE = 'create';
    const TYPE_WORD = 1;
    const TYPE_SENTENSE = 2;
    const TYPE_PHRASE = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sound';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'item_id', 'status'], 'integer'],
            [['filename'], 'string', 'max' => 100],
            [['filename'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'item_id' => 'Item ID',
            'filename' => 'Filename',
            'status' => 'Status',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        // $scenarios[static::SCENARIO_FILE] = ['type'];
        $scenarios[static::SCENARIO_CREATE] = ['type', 'filename', 'item_id'];
        return $scenarios;
    }

    public static function getItemsForCreateSoundOfFile($type, $text_id)
    {
        if ($type == self::TYPE_WORD) return Word::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
        if ($type == self::TYPE_PHRASE) return Phrase::findAll(['sound_id' => null, 'id_text' => $text_id, 'status' => STATUS_ACTIVE]);
        return Sentense::findAll(['sound_id' => null, 'id_text' => $text_id, 'status' => STATUS_ACTIVE]);
    }

    public static function addList($type)
    {
        $files = scandir('temp');
        for ($i = 2; $i < count($files); $i++) {
            self::add($files[$i], $type);
        }   
    }

    public static function add($file, $type)
    {
        $info = new \SplFileInfo($file);
        $file_ext = $info->getExtension();
        $file_name = $info->getBasename('.'.$file_ext);
        if ($type == self::TYPE_WORD) $item = Word::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        else if ($type == self::TYPE_SENTENSE) $item = Sentense::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        else $item = Phrase::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        if (!$item) return;
        self::saveFile($item, $file_name, $file_ext, $type);
    }

    private static function saveFile($item, $file_name, $ext, $type) 
    {
        $sound = self::create($type, $file_name, $ext, $item->id);
        $item->sound_id = $sound->id;
        rename('temp/'.$file_name.'.'.$ext, 'sounds/'.$sound->filename);
        return $item->save(false);
    }

    public static function create($type, $file_name, $ext, $item_id)
    {
        $sound = self::findOne(['item_id' => $item_id, 'type' => $type, 'status' => STATUS_ACTIVE]);
        if (!$sound) $sound = (new self);
        $sound->type = $type;
        $sound->filename = self::getSoundName($ext);
        $sound->item_id = $item_id;
        if (!$sound->save(false)) throw new NotFoundHttpException('ошибка при сохранении звука в базу');
        return $sound;
    }

    private static function getSoundName($ext)
    {
        $last_id = self::find()->select('id')->orderBy('id DESC')->column()[0];
        return (($last_id ? $last_id : 0) + 1) . '.' . $ext;
    }
}
