<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="articles index content">
	<div class="table-responsive">
		<?= $this->Html->link(__('Artigos'), ['controller' => 'Articles', 'action' => 'index'], ['class' => 'button float-left']) ?>
		<?= $this->Html->link(__('Comentários'), ['controller' => 'Comments', 'action' => 'index'], ['class' => 'button float-left']) ?>
		<?= $this->Html->link(__('Tags'), ['controller' => 'Tags', 'action' => 'index'] , ['class' => 'button float-left']) ?>
		
		<?= $this->Html->link(__('Sair'), ['controller' => 'Users', 'action' => 'logout'], ['class' => 'button float-right']) ?>
		<?= $this->Html->link(__('Exportar'), ['action' => 'export'], ['class' => 'button float-right']) ?>
		<?= $this->Html->link(__('Criar'), ['action' => 'add'], ['class' => 'button float-right']) ?>
	</div>
</div>

<div class="users index content">
    <h3><?= __('Usuários') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
					<th><?= $this->Paginator->sort('name', ['label' => 'Nome']) ?></th>
                    <th><?= $this->Paginator->sort('email', ['label' => 'E-Mail']) ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Criado']) ?></th>
					<th><?= $this->Paginator->sort('level', ['label' => 'Admin']) ?></th>
                    <th class="actions"><?= __('Comandos') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $this->Number->format($user->id) ?></td>
					<td><?= h($user->name) ?></td>
                    <td><?= h($user->email) ?></td>
					<td><?= h($user->created) ?></td>
                    <td><?= $user->level ? __('Sim') : __('Nao'); ?></td>
                    <td class="actions">
						<?= $this->Html->link(__('Ver'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Apagar'), ['action' => 'delete', $user->id], ['confirm' => __('Deseja apagar # {0}?', $user->id)]) ?>
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
