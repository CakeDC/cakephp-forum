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
 * ForumCategory Entity
 *
 * @property int $id
 * @property int $parent_id
 * @property int $last_post_id
 * @property int $lft
 * @property int $rght
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $threads_count
 * @property int $replies_count
 * @property bool $is_visible
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \CakeDC\Forum\Model\Entity\Category $parent_category
 * @property \CakeDC\Forum\Model\Entity\Category[] $sub_categories
 * @property \CakeDC\Forum\Model\Entity\Category[] $children
 * @property \CakeDC\Forum\Model\Entity\Post[] $posts
 * @property \CakeDC\Forum\Model\Entity\Moderator[] $moderators
 * @property \CakeDC\Forum\Model\Entity\Post $last_post
 */
class Category extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
