<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use app\models\Word;
use app\models\Sentense;

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

    const SCENARIO_FILE = 'file';
    const SCENARIO_CREATE = 'create';
    const TYPE_WORD = 1;
    const TYPE_SENTENSE = 2;

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

        $scenarios[static::SCENARIO_FILE] = ['type'];
        $scenarios[static::SCENARIO_CREATE] = ['type', 'filename', 'item_id'];
        return $scenarios;
    }

    public function getItemsForCreateSoundOfFile($type, $text_id)
    {
        if ($type == self::TYPE_WORD) return Word::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
        if ($text_id) return Sentense::findAll(['sound_id' => null, 'id_text' => $text_id, 'status' => STATUS_ACTIVE]);
        return Sentense::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
    }

    public function addList($type)
    {
        $files = scandir('temp');
        for ($i = 2; $i < count($files); $i++) {
            $this->add($files[$i], $type);
        }   
        return $this;
    }

    public function add($file, $type)
    {
        $info = new \SplFileInfo($file);
        $file_ext = $info->getExtension();
        $file_name = $info->getBasename('.'.$file_ext);
        if ($type == self::TYPE_WORD) $item = Word::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        else $item = Sentense::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        if (!$item) return;
        $this->saveFile($item, $file_name, $file_ext, $type);
    }

    private function saveFile($item, $file_name, $ext, $type) 
    {
        $item->sound_id = self::create($type, $file_name, $ext, $item->id);
        $item->save();
        return true;
    }

    public static function create($type, $file_name, $ext, $item_id)
    {
        $sound = new self(['scenario' => self::SCENARIO_CREATE]);
        $sound->type = $type;
        $sound->filename = self::getSoundName($ext);
        $sound->item_id = $item_id;
        if (!$sound->save()) throw new NotFoundHttpException('ошибка при сохранении звука в базу');
        rename('temp/'.$file_name.'.'.$ext, 'sounds/'.$sound->filename);
        return $sound->id;
    }

    private static function getSoundName($ext)
    {
        $last_id = self::find()->select('id')->orderBy('id DESC')->column()[0];
        return (($last_id ? $last_id : 0) + 1) . '.' . $ext;
    }
}
