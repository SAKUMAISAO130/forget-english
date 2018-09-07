<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<div class="articles form large-9 medium-8 columns content">
    <?= $this->Form->create($article) ?>
    <fieldset>
        <legend><?= __($config_name['action']['edit']) ?></legend>
        <?php
        echo $this->Form->control('title',['label' => $config_name['title']['word']]);
        echo $this->Form->control('translate',['label' => $config_name['title']['trans']]);
        echo $this->Form->control('sentence',['label' => $config_name['title']['sentence']]);
        echo $this->Form->control('body',['label' => $config_name['title']['memo']]);
        ?>
    </fieldset>
    <?= $this->Form->button(__($config_name['action']['register'])) ?>
    <?= $this->Form->end() ?>
</div>
