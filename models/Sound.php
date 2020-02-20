<?php

namespace app\models;

use Yii;
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
        return $scenarios;
    }

    public function getItemsForCreateSoundOfFile($type)
    {
        if ($type == self::TYPE_WORD) return Word::findAll(['sound_id' => null, 'status' => STATUS_ACTIVE]);
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
        // $str_arr = explode('.', $file);
        $info = new \SplFileInfo($file);
        $file_ext = $info->getExtension();
        $file_name = $info->getBasename('.'.$file_ext);
        if ($type == self::TYPE_WORD) $item = Word::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        else $item = Sentense::findOne(['engl' => $file_name, 'status' => STATUS_ACTIVE]);
        if (!$item) return;
        $this->saveFile($item, $file_name, $file_ext);
    }

    private function saveFile($item, $file_name, $ext) 
    {
        $last_id = self::find()->select('id')->orderBy('id DESC')->column()[0];
        $new_file_name = (($last_id ? $last_id : 0) + 1) . '.' . $ext;
        $sound = (new self);
        $sound->type = $this->type;
        $sound->filename = $new_file_name;
        $sound->item_id = $item->id;
        $sound->save();
        rename('temp/'.$file_name.'.'.$ext, 'sounds/'.$new_file_name);
        $item->sound_id = $sound->id;
        $item->save();
        return true;
    }
}
