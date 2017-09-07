<?php
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Utility\Hash;

Plugin::load('Muffin/Slug');
Plugin::load('Muffin/Orderly');

$defaults = include('defaults.php');
$config = Hash::merge($defaults, (array)Configure::read('Forum'));
Configure::write('Forum', $config);
