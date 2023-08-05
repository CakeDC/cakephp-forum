<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2023, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
namespace CakeDC\Forum\Model\Entity;

use Cake\ORM\Entity;

/**
 * Thread Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $category_id
 * @property int $user_id
 * @property int $last_reply_id
 * @property string $title
 * @property string $slug
 * @property string $message
 * @property int $replies_count
 * @property int $reports_count
 * @property bool $is_sticky
 * @property bool $is_locked
 * @property bool $is_visible
 * @property bool $is_reported
 * @property \Cake\I18n\FrozenTime $last_reply_created
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \CakeDC\Forum\Model\Entity\Category $category
 * @property \Cake\ORM\Entity $user
 * @property \CakeDC\Forum\Model\Entity\Reply[] $replies
 * @property \CakeDC\Forum\Model\Entity\Reply|null $reported_reply
 * @property \CakeDC\Forum\Model\Entity\Reply|null $last_reply
 * @property \CakeDC\Forum\Model\Entity\Report[] $reports
 * @property \CakeDC\Forum\Model\Entity\Like[] $likes
 */
class Thread extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        '*' => false,
        'category_id' => true,
        'title' => true,
        'slug' => true,
        'message' => true,
        'is_sticky' => true,
        'is_locked' => true,
        'is_visible' => true,
    ];

    /**
     * is_reported getter
     *
     * @return bool
     */
    protected function _getIsReported(): bool
    {
        return $this->reported_reply || $this->reports_count;
    }
}
