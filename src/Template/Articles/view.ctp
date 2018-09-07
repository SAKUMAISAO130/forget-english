<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */

?>
<div class="articles view large-9 medium-8 columns content">
    <h3><?= __($config_name['title']['word']) ?>｜<?= h($article->title) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __($config_name['title']['word']) ?></th>
            <td><?= h($article->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __($config_name['title']['trans']) ?></th>
            <td><?= h($article->translate) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __($config_name['title']['sentence']) ?></th>
            <td><?= h($article->sentence) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __($config_name['title']['cre_time']) ?></th>
            <td><?= h($article->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __($config_name['title']['modi_time']) ?></th>
            <td><?= h($article->modified) ?></td>
        </tr>
    </table>
    <h4><?= __($config_name['title']['memo']) ?></h4>
    <?php
    if ($article->body) {
        echo $this->Text->autoParagraph(h($article->body));
    }else {
        echo '登録されているメモはありません';
    }
    ?>


    <?php
    /*
     * タグ表示
     */
    if (!empty($article->tags)):
    ?>
    <div class="related">
        <h4><?= __('Related Tags') ?></h4>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Title') ?></th>
                <th scope="col"><?= __('Created') ?></th>
                <th scope="col"><?= __('Modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($article->tags as $tags): ?>
            <tr>
                <td><?= h($tags->id) ?></td>
                <td><?= h($tags->title) ?></td>
                <td><?= h($tags->created) ?></td>
                <td><?= h($tags->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__($config_name['action']['view']), ['controller' => 'Tags', 'action' => 'view', $tags->id]) ?>
                    <?= $this->Html->link(__($config_name['action']['edit']), ['controller' => 'Tags', 'action' => 'edit', $tags->id]) ?>
                    <?= $this->Form->postLink(__($config_name['action']['delete']), ['controller' => 'Tags', 'action' => 'delete', $tags->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tags->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <?php endif; ?>
</div>
