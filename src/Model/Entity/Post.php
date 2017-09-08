<?php
/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\Forum\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Hash;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $category_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $message
 * @property int $replies_count
 * @property int $reports_count
 * @property int $likes_count
 * @property bool $is_sticky
 * @property bool $is_locked
 * @property bool $is_visible
 * @property \Cake\I18n\FrozenTime $last_reply_created
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \CakeDC\Forum\Model\Entity\Category $category
 * @property \CakeDC\Forum\Model\Entity\Thread $thread
 * @property \Cake\ORM\Entity $user
 * @property \CakeDC\Forum\Model\Entity\Reply[] $replies
 * @property \CakeDC\Forum\Model\Entity\Reply $last_reply
 * @property \CakeDC\Forum\Model\Entity\Report[] $reports
 * @property \CakeDC\Forum\Model\Entity\Like[] $likes
 * @property \CakeDC\Forum\Model\Entity\Report $user_report
 * @property \CakeDC\Forum\Model\Entity\Like $user_like
 */
class Post extends Entity
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
    protected $_accessible = [
        '*' => false,
    ];

    /**
     * Get title
     */
    protected function _getTitle()
    {
        if ($this->parent_id) {
            return Hash::get($this->_properties, 'thread.title');
        }

        return Hash::get($this->_properties, 'title');
    }

    /**
     * Get slug
     */
    protected function _getSlug()
    {
        if ($this->parent_id) {
            return Hash::get($this->_properties, 'thread.slug');
        }

        return Hash::get($this->_properties, 'slug');
    }
}
