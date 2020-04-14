<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

/**
 * Article Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string $addr
 * @property string|null $body
 * @property bool|null $published
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property int|null $views
 *
 * @property \App\Model\Entity\Tag[] $tags
 * @property \App\Model\Entity\Comment[] $comments
 * @property \App\Model\Entity\User $user
 */
class Article extends Entity {
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'title' => true,
        'addr' => true,
        'body' => true,
        'published' => true,
        'created' => true,
        'modified' => true,
        'views' => true,
        'tags' => true,
		'pics' => true,
        'comments' => true,
        'user' => true,
		'tag_string' => true,
		'pic' => true,
    ];
	
	protected function _getTagString() {
		if (isset($this->_fields['tag_string'])) {
			return $this->_fields['tag_string'];
		}
		if (empty($this->tags)) {
			return '';
		}
		$tags = new Collection($this->tags);
		$str = $tags->reduce(function ($string, $tag) {
			return $string . $tag->title . ', ';
		}, '');
		return trim($str, ', ');
	}
}
