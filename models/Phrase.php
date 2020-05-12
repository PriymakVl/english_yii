<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use app\models\Sound;

/**
 * This is the model class for table "phrase".
 *
 * @property int $id
 * @property string|null $engl
 * @property string|null $ru
 * @property int|null $id_text
 * @property int|null $id_sentense
 * @property int|null $status
 */
class Phrase extends \yii\db\ActiveRecord
{

    const STATE_NOT_LEANED = 0;
    const STATE_LEANED = 1;
    const STATE_ALL = 2;
    const DELIMITER_PUNCTUATION_MARKS = 1;
    const DELIMITER_LINE_BREAK = 2;
    const SCENARIO_FILES = 'files';

    public $soundfile;
    public $file_ru;
    public $file_engl;
    public $delimeter; //delimeter sentensis in upload files

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'phrase';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_text', 'id_sentense', 'status', 'delimeter'], 'integer'],
            [['engl', 'ru'], 'string', 'max' => 255],
            [['engl', 'ru'], 'filter', 'filter' => 'trim'],
            [['file_ru', 'file_engl'], 'file', 'skipOnEmpty' => false, 'extensions' => 'txt'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_FILES] = ['delimeter', 'id_text'];
        $scenarios[static::SCENARIO_FILES] = ['delimeter', 'file_ru', 'file_engl', 'id_text'];
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
            'id_text' => 'Id Text',
            'id_sentense' => 'Id Sentense',
            'status' => 'Status',
            'delimeter' => 'Разделители между фразами',
        ];
    }

    public function updatePhrase()
    {
        if ($this->validate()) $this->soundfile = UploadedFile::getInstance($this, 'soundfile');
        if ($this->soundfile) {
            $sound = Sound::create(Sound::TYPE_PHRASE, $this->soundfile->baseName, $this->soundfile->extension, $this->id);
            $this->sound_id = $sound->id;
            $this->soundfile->saveAs('sounds/' . $sound->filename);
        }
        return $this->save();
    }

    public function getSound()
    {
        return $this->hasOne(Sound::className(), ['id' => 'sound_id']);
    }

    public static function createSoundsString($state, $id_text = false)
    {
        $where = ['status' => STATUS_ACTIVE];
        $where = ($state == self::STATE_ALL) ?  $where : array_merge($where, ['state' => $state]);
        $where = $id_text ? array_merge($where, ['id_text' => $id_text]) : $where;
        $phrases = self::findAll($where);
        if (!$phrases) return false;
        $phrases_str = '';
        foreach ($phrases as $phrase) {
            if (!$phrase->sound_id) continue;
            $phrases_str .= $phrase->sound->filename.':'.$phrase->engl.':'.$phrase->ru.':'.$phrase->id.';';
        }
        return $phrases_str;
    }

    public function addFromFiles()
    {
        if (!$this->validate()) throw new NotFoundHttpException('Validate not');
        $phrases['ru'] = $this->getFromFile($this->file_ru->tempName);
        $phrases['engl'] = $this->getFromFile($this->file_engl->tempName);
        for ($i = 0; $i < count($phrases['engl']); $i++) {
            $phrase = self::findOne(['engl' => $phrases['engl'][$i], 'id_text' => $this->id_text]);
            if ($phrase) continue;
            $this->add($phrases['engl'][$i], $phrases['ru'][$i], $this->id_text);
        }
    }

    private function getFromFile($filename)
    {
        if ($this->delimeter == self::DELIMITER_PUNCTUATION_MARKS) throw new NotFoundHttpException('деление по знакам препинания не реализовано');
        return file($filename);
        // array_walk($phrases, str_replace('', ''', subject))
    }

    private function add($engl, $ru, $id_text)
    {
        $obj = new self;
        $obj->engl = htmlspecialchars($engl);
        $ru = mb_convert_encoding($ru, "utf-8", "windows-1251");
        $obj->ru = htmlspecialchars($ru);
        $obj->id_text = $id_text;
        $obj->save(false);
    }

}
