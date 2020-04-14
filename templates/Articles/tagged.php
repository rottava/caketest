<!-- In templates/Articles/tags.php -->
<?php if(isset($tag)) : ?>
<div class="articles tag content">
    <h3><?= __('Artigos com a tag: ') ?><?= h($tag) ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title', ['label' => 'Título']) ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Data']) ?></th>
                    <th><?= $this->Paginator->sort('views', ['label' => 'Visualizaçoes']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
					<td><u><?= $this->Html->link($article->title, ['action' => 'view', $article->addr]) ?></u></td>
                    <td><?= h($article->created) ?></td>
                    <td><?= $this->Number->format($article->views) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('primeiro')) ?>
            <?= $this->Paginator->prev('< ' . __('anterior')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('próximo') . ' >') ?>
            <?= $this->Paginator->last(__('último') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} de {{count}}')) ?></p>
    </div>
</div>
<?php else : ?>
	<div class="articles notag content">
		<h3><?= __('Nenhuma tag selecionada :(') ?></h3>
	</div>
<?php endif; ?>