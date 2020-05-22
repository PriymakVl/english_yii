<?php

namespace app\modules\word\models;

use Yii;
use app\models\Sound;
use app\modules\word\models\Word;
use app\modules\string\models\{FullString, Substring};

class BaseWord extends \app\models\ModelApp
{

    public $file_ru;
    public $file_engl;

}
