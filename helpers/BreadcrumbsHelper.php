<?

namespace app\helpers;

use yii\helpers\Url;

class BreadcrumbsHelper 
{
	public static function category($cat, $last_link = true)
	{
		if ($cat && !$cat->parent) $arr[] = ['label' => $cat->name];
		else if ($cat && !$last_link) $arr[] = ['label' => $cat->name];
		else if ($cat) $arr[] = ['label' => $cat->name, 'url' => Url::to(['/categories', 'parent_id' => $cat->id])];
		if (isset($cat->parent)) $arr[] = self::createLinkCategory($cat, $action);
		if (isset($cat->parent->parent)) $arr[] = self::createLinkCategory($cat->parent, $action);
		if (isset($cat->parent->parent->parent)) $arr[] = self::createLinkCategory($cat->parent->parent, $action);
		$arr[] = ['label' => 'Категории', 'url' => '/categories'];
		return array_reverse($arr);
	}

	public static function createLinkCategory($cat) 
	{
		$arr['label'] = $cat->parent->name;
		$arr['url'] = Url::to(['/categories', 'parent_id' => $cat->parent->id]);
		return $arr;
	}

	public static function text($text_id)
	{
		$arr[] = ['label' => 'Текст', 'url' => Url::to(['/text/view', 'id' => $text_id])];
		$arr[] = ['label' => 'Абзацы', 'url' => Url::to(['/sub-text/text', 'text_id' => $text_id])];
		$arr[] = ['label' => 'Предложения', 'url' => Url::to(['/string/text', 'text_id' => $text_id])];
		$arr[] = ['label' => 'Фразы', 'url' => Url::to(['/substring/text', 'text_id' => $text_id])];
		$arr[] = ['label' => 'Слова', 'url' => Url::to(['/word-text', 'text_id' => $text_id])];
		return $arr;
	}

}