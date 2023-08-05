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
namespace CakeDC\Forum\Model\Behavior;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Query\SelectQuery;

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
    protected array $_defaultConfig = [
        'field' => 'is_visible',
    ];

    /**
     * beforeFind callback
     *
     * @param \Cake\Event\Event $event Event
     * @param \Cake\ORM\Query\SelectQuery $query Query
     * @param \ArrayObject $options Options
     * @param bool $primary Primary
     * @return void
     */
    public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options, bool $primary): void
    {
        $query->where([
            $this->table()->aliasField($this->getConfig('field')) => true,
        ]);
    }
}
