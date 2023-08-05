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
 *
 * @var \Cake\View\View $this
 * @var \CakeDC\Forum\Model\Entity\Report $report
 */
?>
<?= $this->Form->create($report) ?>
    <?= $this->Form->control('message', ['label' => __('Report')]) ?>
    <?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
