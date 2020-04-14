<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[]|\Cake\Collection\CollectionInterface $articles
 */
?>
<div class="articles index content">
	<div class="table-responsive">
		<?= $this->Html->link(__('Usuários'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'button float-left']) ?>
		<?= $this->Html->link(__('Comentários'), ['controller' => 'Comments', 'action' => 'index'], ['class' => 'button float-left']) ?>
		<?= $this->Html->link(__('Tags'), ['controller' => 'Tags', 'action' => 'index'] , ['class' => 'button float-left']) ?>
		
		<?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'button float-right']) ?>
		<?= $this->Html->link(__('Exportar'), ['action' => 'export'], ['class' => 'button float-right']) ?>
		<?= $this->Html->link(__('Criar'), ['action' => 'add'], ['class' => 'button float-right']) ?>
	</div>
</div>

<div class="articles index content">
    <h3><?= __('Artigos') ?></h3>
	<?= $this->Form->create($search, ['type' => 'get']) ?>
    <fieldset>
		<?php echo $this->Form->control('title', ['label' => 'Buscar']); ?>
		<?php echo $this->Form->control('published', ['label' => 'Publicado']); ?>
    </fieldset>
    <?= $this->Form->button(__('Pesquisar')) ?>
    <?= $this->Form->end() ?>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                    <th><?= $this->Paginator->sort('title', ['label' => 'Título']) ?></th>
                    <th><?= $this->Paginator->sort('user_id', ['label' => 'Usuário']) ?></th>
                    <th><?= $this->Paginator->sort('published', ['label' => 'Publicado']) ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Criado']) ?></th>
                    <th><?= $this->Paginator->sort('views', ['label' => 'Visualizaçoes']) ?></th>
                    <th class="actions"><?= __('Comandos') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?= $this->Number->format($article->id) ?></td>
                    <td><?= h($article->title) ?></td>
                    <td><u><?= $article->has('user') ? $this->Html->link($article->user->name, ['controller' => 'Users', 'action' => 'view', $article->user->id]) : 'Anônimo' ?></u></td>
                    <td><?= $article->published ? __('Sim') : __('Nao'); ?></td>
                    <td><?= h($article->created) ?></td>
                    <td><?= $this->Number->format($article->views) ?></td>
                    <td class="actions">
						<?= $this->Html->link(__('Ver'), ['action' => 'view', $article->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $article->id]) ?>
                        <?= $this->Form->postLink(__('Apagar'), ['action' => 'delete', $article->id], ['confirm' => __('Deseja apagar # {0}?', $article->id)]) ?>
                    </td>
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
