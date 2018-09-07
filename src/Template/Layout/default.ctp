<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Configure;

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= Configure::read('site_title') ?><?php echo  $this->fetch('title') ? '｜' . $this->fetch('title') : ''; ?>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>

    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('reset') ?>
    <?= $this->Html->css('font-awesome.min') ?>
    <?= $this->Html->css('bootstrap.min') ?>
    <?= $this->Html->css('system_custom') ?>


    <?php
//     $this->fetch('meta');
//     $this->fetch('css');
//     $this->fetch('script');
    ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
  <h1><a class="navbar-brand" href="./">　<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> <?= Configure::read('site_title') ?></a></h1>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
          <?= $this->Html->link(__($config_name['action']['index']), ['controller' => 'Articles', 'action' => 'index', '_full' => true]) ?>
      </li>
    </ul>
  </div>
</nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer class="text-center">
    <p>&copy; <?= Configure::read('site_title') ?></p>
    </footer>


    <?= $this->Html->script('jquery-3.3.1.min') ?>
    <?= $this->Html->script('bootstrap.min') ?>
</body>
</html>
