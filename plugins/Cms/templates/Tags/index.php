<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag[]|\Cake\Collection\CollectionInterface $tags
 */
?>
<div class="articles index content">
	<div class="table-responsive">
		<?= $this->Html->link(__('Artigos'), ['controller' => 'Articles', 'action' => 'index'], ['class' => 'button float-left']) ?>
		<?= $this->Html->link(__('Usuários'), ['controller' => 'Users', 'action' => 'index'], ['class' => 'button float-left']) ?>
		<?= $this->Html->link(__('Comentários'), ['controller' => 'Comments', 'action' => 'index'], ['class' => 'button float-left']) ?>
		
		<?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'button float-right']) ?>
		<?= $this->Html->link(__('Exportar'), ['action' => 'export'], ['class' => 'button float-right']) ?>
	</div>
</div>
<div class="tags index content">
    <h3><?= __('Tags') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                    <th><?= $this->Paginator->sort('title', ['label' => 'Tag']) ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Criado']) ?></th>
					<th><?= __('Artigos') ?></th>
                    <th class="actions"><?= __('Comandos') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tags as $tag): ?>
                <tr>
                    <td><?= $this->Number->format($tag->id) ?></td>
					<td><?= h($tag->title) ?></td>
                    <td><?= h($tag->created) ?></td>
					<td><?= h(count($tag->articles)) ?></td>
                    <td class="actions">
						<?= $this->Html->link(__('Ver'), ['action' => 'view', $tag->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $tag->id]) ?>
                        <?= $this->Form->postLink(__('Apagar'), ['action' => 'delete', $tag->id], ['confirm' => __('Deseja apagar # {0}?', $tag->id)]) ?>
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
