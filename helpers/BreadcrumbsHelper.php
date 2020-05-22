<?

namespace app\helpers;

use yii\helpers\Url;

class BreadcrumbsHelper 
{
	public static function create($model, $last_item = true, $action = 'index')
	{
		if ($last_item) $arr[] = $model->name;
		if (isset($model->parent)) $arr[] = self::createLink($model, $action);
		if (isset($model->parent->parent)) $arr[] = self::createLink($model->parent, $action);
		if (isset($model->parent->parent->parent)) $arr[] = self::createLink($model->parent->parent, $action);
		return array_reverse($arr);
	}

	public static function createLink($obj, $action) 
	{
		$path = self::createPathLink($obj, $action);
		$arr['label'] = $obj->parent->name;
		$arr['url'] = Url::to([$path, 'parent_id' => $obj->parent->id]);
		return $arr;
	}

	private static function createPathLink($obj, $action) {
		$controller = strtolower($obj->getClassName());
		return $controller . '/' . $action;
	}
}