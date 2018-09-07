<!--
新規追加
-->

<div class="container main-contents">
    <div class="card bg-light">
      <div class="card-body">
            <div class="articles index large-9 medium-8 columns content">
                <?= $this->Form->create($articles_add,['url' => ['action' => 'add'], 'class' => 'form-inline']) ?>
	            <i class="fa fa-plus-circle fa-2x" aria-hidden="true"style="color: #666;"></i>
	            <span class='font-weight-bold title-font'>単語帳へ<?= __($config_name['action']['add']) ?></span>
                <fieldset>
                    <div class="form-group mb-2 ml-2">
                        <?=$this->Form->control('title', [
                            'label' => false,
                            'class' => 'form-control',
                            'maxlength' => '100',
                            'placeholder' => '単語・熟語を入力',
                        ]);
                        ?>
                    </div>
                </fieldset>
                <?= $this->Form->button(__($config_name['action']['new']), ['class' => 'btn btn-pinky mb-2 ml-2 btn-sm']) ?>
                <?= $this->Form->end() ?>
            </div>
      </div>
    </div>
</div>

<!--
今日登録した英語数
-->

<div class="container main-contents">
<div class="row">
    <div class="col">
        <div class="card">
          <div class="card-header">
                    <i class="fa fa-line-chart fa-2x" aria-hidden="true"style="color: #666;"></i><span class='font-weight-bold title-font'>単語帳への登録数</span>
          </div>
          <div class="card-body">
              <div id="chartContainer2" style="height: 200px; width: 100%;"></div>
          </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
              <div class="card-header">
                    <i class="fa fa-line-chart fa-2x" aria-hidden="true"style="color: #666;"></i><span class='font-weight-bold title-font'>何回も調べちゃっている単語ランキング</span>
          </div>
            <div class="card-body">
                <div id="chartContainer" style="height: 200px; max-width: 100%; margin: 0px auto;"></div>
            </div>
        </div>
    </div>
</div>
</div>

<!--
一覧
-->
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>
<div class="container main-contents">
<div class="articles index large-9 medium-8 columns content">
    <!--
    検索BOX
    -->
    <div class="inline-area">
        <?=$this->Form->create('Article', ['type' => 'get', 'class' => 'form-inline'])?>
        <div class="form-group mb-2">
		    <h3><i class="fa fa-book fa-1x" aria-hidden="true"></i><?= __($config_name['page']['main_contens']) ?></h3>
            <?= $this->Form->hidden('type',  ['value' => 'search']) ?>
            <?=$this->Form->control('keyword', [
                'label' => false,
                'class' => 'form-control ml-2 ',
                'maxlength' => '100',
                'placeholder' => '登録単語検索(英語)',
                'value' => isset($keyword) ? $keyword : '',

            ]);
            ?>
        </div>
        <?=$this->Form->button('検索', ['class' => 'btn btn-pinky mb-2 ml-2 btn-sm'])?>
        <?=$this->Html->link('検索条件をクリア',['controller' => 'Articles', 'action' => 'index'],['class' => 'btn btn-pinky mb-2 ml-2 btn-sm'])?>
        <?=$this->Form->end()?>
    </div>
    <!--
    テーブル
    -->
    <div class="paginator">
        <div class="float-right">
            <p><?= $this->Paginator->counter(['format' => __(' {{page}}/{{pages}}ページ , {{current}}/{{count}}件')]) ?></p>
        </div>
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('最初')) ?>
            <?= $this->Paginator->prev('< ' . __('前へ')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次へ') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
    </div>
    <table cellpadding="0" cellspacing="0" class="table table-bordered">
        <thead>
            <tr class="table-secondary">
                <th scope="col"><i class="fa fa-desktop fa-2x" aria-hidden="true"></i> <?= $this->Paginator->sort('id',$config_name['title']['id']) ?> <i class="fa fa-sort" aria-hidden="true"></i></th>
                <th scope="col"><i class="fa fa-address-card fa-2x" aria-hidden="true"></i> <?= $this->Paginator->sort('user_id',$config_name['title']['user_id']) ?> <i class="fa fa-sort" aria-hidden="true"></i></th>
                <th scope="col"><i class="fa fa-jpy fa-2x" aria-hidden="true"></i> <?= __($config_name['title']['word']) ?></th>
                <th scope="col"><i class="fa fa-usd fa-2x" aria-hidden="true"></i> <?= __($config_name['title']['trans']) ?></th>
                <th scope="col"><i class="fa fa-usd fa-2x" aria-hidden="true"></i> <?= __($config_name['title']['sentence']) ?></th>
                <th scope="col"><i class="fa fa-share-square-o fa-2x" aria-hidden="true"></i> <?= __($config_name['title']['dictionary']) ?></th>
                <th scope="col"><i class="fa fa-clock-o fa-2x" aria-hidden="true"></i> <?= $this->Paginator->sort('created',$config_name['title']['cre_time']) ?> <i class="fa fa-sort" aria-hidden="true"></i></th>
                <th scope="col" class="actions"><i class="fa fa-cog fa-2x" aria-hidden="true"></i> <?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $this->Number->format($article->id) ?></td>
                <td><?= $article->has('user') ? $this->Html->link($article->user->id, ['controller' => 'Users', 'action' => 'view', $article->user->id]) : '' ?></td>
                <td><?= h($article->title) ?></td>
                <td><?= h($article->translate) ?></td>
                <td><?= h($article->sentence) ?></td>
                <td>
                <button type="button" class="btn btn-pinky btn-sm"><a href="https://translate.google.co.jp/?hl=ja#en/ja/<?= h($article->title) ?>" target="_blank">G翻訳</a></button>
                <button type="button" class="btn btn-pinky btn-sm"><a href="https://ja.wikipedia.org/wiki/<?= h($article->translate) ?>" target="_blank">Wiki</a></button>
                </td>
                <td><?= h($article->created) ?></td>
                <td class="actions">
                    <button type="button" class="btn btn-pinky btn-sm"><?= $this->Html->link(__($config_name['action']['view'] . '・' . $config_name['action']['edit']), ['action' => 'edit', $article->id]) ?></button>
                    <button type="button" class="btn btn-pinky btn-sm"><?= $this->Form->postLink(__($config_name['action']['delete']), ['action' => 'delete', $article->id], ['confirm' => __('削除してもよろしいですか？ # {0}?', $article->id)]) ?></button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('最初')) ?>
            <?= $this->Paginator->prev('< ' . __('前へ')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('次へ') . ' >') ?>
            <?= $this->Paginator->last(__('最後') . ' >>') ?>
        </ul>
    </div>

</div>
</div>

<!--
グラフ
-->
<?= $this->Html->script('canvasjs.min.js') ?>
<script type="text/javascript">
window.onload = function () {

/*
 * 何回調べているか集計
 */
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2", // "light1", "light2", "dark1", "dark2"
	title: {
		text: ""
	},
	axisY: {
		title: "(調べた回数)",
		suffix: "回",
		includeZero: false
	},
	axisX: {
		title: "（単語・熟語など）"
	},
	data: [{
		type: "column",
		yValueFormatString: "#,##0#\"回も調べています。\"",
		dataPoints: [
			<?php
			foreach ($result_count as $k => $v) {
			    echo '{ label: "' . $v['title'] . '", y: ' . $v['duplicate_count'] . ' },';
			    /**
			     * 10位まではあるだけ表示
			     */
			    if ($k === 9 ) {
			        break;
			    }
			}
			?>

		]
	}]
});
chart.render();
/*
 * 日別単語登録集計
 */
var chart_liner = new CanvasJS.Chart("chartContainer2", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: ""
	},
	axisY:{
		includeZero: false
	},
	data: [{
		type: "line",
		yValueFormatString: "この日は#,##0#\"個登録できました。\"",
		dataPoints: [
			<?php
			foreach ($result_count_week as $l => $w) {
			    echo '{ label:"' . $w['c_col'] . '", y: ' . $w['count'] . ' },';
			    }
			?>
		]
	}]
});
chart_liner.render();
}
</script>
