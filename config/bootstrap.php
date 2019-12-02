<?php
use Cake\Core\Configure;
use Cake\Utility\Hash;

$defaults = include('defaults.php');
$config = Hash::merge($defaults, (array)Configure::read('Forum'));
Configure::write('Forum', $config);
