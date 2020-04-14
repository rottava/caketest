<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>
<div class="articles index content">
	<div class="table-responsive">
		<?php if ($this->request->getAttribute('identity') <> null) : ?>
			<?= $this->Html->link(__('Criar artigo'), ['action' => 'add'], ['class' => 'button float-left']) ?>
			<?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'button float-right']) ?>
			<?= $this->Html->link(__('Conta'), ['controller' => 'Users', 'action' => 'view', $this->request->getAttribute('identity')->getIdentifier()] , ['class' => 'button float-right']) ?>

		<?php else : ?>
			<?= $this->Html->link(__('Entrar'), ['controller' => 'Users', 'action' => 'login'], ['class' => 'button float-left']) ?>
		<?php endif; ?>
	</div>
</div>
	
<div class="articles index content">
    <h3><?= __('Artigos') ?></h3>
	<?= $this->Form->create($search, ['type' => 'get']) ?>
    <fieldset>
		<?php echo $this->Form->control('title', ['label' => '']); ?>
    </fieldset>
    <?= $this->Form->button(__('Pesquisar')) ?>
    <?= $this->Form->end() ?>
			
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('title', ['label' => 'Título']) ?></th>
                    <th><?= $this->Paginator->sort('user_id', ['label' => 'Redator']) ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Data']) ?></th>
                    <th><?= $this->Paginator->sort('views', ['label' => 'Visualizaçoes']) ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
					<td><u><?= $this->Html->link($article->title, ['action' => 'view', $article->addr]) ?></u></td>
                    <td><u><?= $article->has('user') ? $this->Html->link($article->user->name, ['controller' => 'Users', 'action' => 'view', $article->user->id]) : 'Anônimo' ?></u></td>
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
