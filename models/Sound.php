<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use app\modules\string\models\{FullString, Substring};
use app\modules\word\models\{Word};

/**
 * This is the model class for table "sound".
 *
 * @property int $id
 * @property int $type
 * @property int $item_id
 * @property string $filename
 * @property int|null $status
 */
class Sound extends \app\models\ModelApp
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sounds';
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
        if ($type == TYPE_WORD) return Word::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
        if ($type == TYPE_SUBSTRING) return Substring::findAll(['sound_id' => null, 'text_id' => $text_id, 'status' => STATUS_ACTIVE]);
        return FullString::findAll(['sound_id' => null, 'text_id' => $text_id, 'status' => STATUS_ACTIVE]);
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
        $item = self::getStringItem($type, $file_name);
        if (!$item) return;
        self::saveFile($item, $file_name, $file_ext, $type);
    }

    private static function getStringItem($type, $string)
    {
        if ($type == TYPE_WORD) return Word::findOne(['engl' => $string, 'status' => STATUS_ACTIVE]);
        if ($type == TYPE_STRING) return FullString::find()->where(['like', 'engl', $string])->andWhere(['status' => STATUS_ACTIVE])->one();
        return Substring::find()->where(['like', 'engl', $string])->andWhere(['status' => STATUS_ACTIVE])->one();
    }

    private static function saveFile($item, $file_name, $ext, $type) 
    {
        $sound = self::create($type, $ext, $item->id);
        $item->sound_id = $sound->id;
        rename('temp/'.$file_name.'.'.$ext, 'sounds/'.$sound->filename);
        return $item->save(false);
    }

    public static function create($type, $ext, $item_id)
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
        do {
            $name = uniqid();
            $filename = $name . '.' . $ext;
            $file = '/web/sounds/' . $filename;
        } while (file_exists($file));
        return $filename;
    }
}
