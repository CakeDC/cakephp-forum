<?php
declare(strict_types=1);

/**
 * Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2017, Cake Development Corporation (https://www.cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

namespace CakeDC\Forum\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Query;

/**
 * VisibleOnly behavior
 */
class VisibleOnlyBehavior extends Behavior
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'field' => 'is_visible',
    ];

    /**
     * beforeFind callback
     *
     * @param \Cake\Event\Event $event Event
     * @param \Cake\ORM\Query $query Query
     * @param \ArrayObject $options Options
     * @param bool $primary Primary
     */
    public function beforeFind(EventInterface $event, Query $query, ArrayObject $options, $primary)
    {
        $query->where([$this->getTable()->aliasField($this->getConfig('field')) => true]);
    }
}
