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

/**
 * Thread Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $category_id
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string $message
 * @property int $reports_count
 * @property bool $is_sticky
 * @property bool $is_locked
 * @property \Cake\I18n\FrozenTime $last_reply_created
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \CakeDC\Forum\Model\Entity\Category $category
 * @property \Cake\ORM\Entity $user
 * @property \CakeDC\Forum\Model\Entity\Thread $thread
 * @property \CakeDC\Forum\Model\Entity\Report[] $reports
 * @property \CakeDC\Forum\Model\Entity\Like[] $likes
 */
class Reply extends Entity
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
        'message' => true,
    ];
}
