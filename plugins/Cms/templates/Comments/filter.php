<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment[]|\Cake\Collection\CollectionInterface $comments
 */
?>
<div class="comments index content">
    <h3><?= $this->Html->link('Comentários', ['controller' => 'Comments', 'action' => 'index']) ?></h3>
	<p>	<?= $this->Html->link('Aprovados', ['controller' => 'Comments', 'action' => 'filter', 1]) ?>
			<?= __(' || ') ?>
		<?= $this->Html->link('Reprovados', ['controller' => 'Comments', 'action' => 'filter', 2]) ?>
			<?= __(' || ') ?>
		<?= $this->Html->link('Pendentes', ['controller' => 'Comments', 'action' => 'filter', 0]) ?>
	</p>
	
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id', ['label' => 'ID']) ?></th>
                    <th><?= $this->Paginator->sort('article_id', ['label' => 'Artigo']) ?></th>
                    <th><?= $this->Paginator->sort('user_id', ['label' => 'Usuário']) ?></th>
                    <th><?= $this->Paginator->sort('content', ['label' => 'Texto']) ?></th>
                    <th><?= $this->Paginator->sort('created', ['label' => 'Criado']) ?></th>
					<th><?= __('Publicado') ?></th>
					<th class="actions"><?= __('Controle') ?></th>
                    <th class="actions"><?= __('Comandos') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?= $this->Number->format($comment->id) ?></td>
                    <td><u><?= $comment->has('article') ? $this->Html->link($comment->article->title, ['controller' => 'Articles', 'action' => 'view', $comment->article->id]) : '' ?></u></td>
                    <?php if($comment->has('user')) : ?>
						<td><u><?= $this->Html->link($comment->user->name, ['controller' => 'Users', 'action' => 'view', $comment->user_id]) ?></u></td>
					<?php else : ?>
						<td><?= __('Anônimo') ?></td>
					<?php endif; ?>
					<td><?= h($comment->content) ?></td>
                    <?php if ($comment->published == 0) : ?>
						<td><?= __('Pendente') ?></td>
					<?php elseif ($comment->published == 1) : ?>
						<td><?= __('Aprovado') ?></td>
					<?php else : ?>
						<td><?= __('Reprovado') ?></td>
					<?php endif; ?>
                    <td><?= h($comment->created) ?></td>
					<td class="actions">
						<?php if ($comment->published <> 1) : ?>
							<?= $this->Html->link(__('Aprovar'), ['action' => 'edit', $comment->id]) ?>
						<?php endif; ?>
						<?php if ($comment->published == 0 || $comment->published == 1) : ?>
							<?= $this->Html->link(__('Reprovar'), ['action' => 'view', $comment->id]) ?>
						<?php endif; ?>
                    </td>
                    <td class="actions">
                        <?= $this->Html->link(__('Ver'), ['action' => 'view', $comment->id]) ?>
						<?= $this->Html->link(__('Editar'), ['action' => 'edit', $comment->id]) ?>
                        <?= $this->Form->postLink(__('Apagar'), ['action' => 'delete', $comment->id], ['confirm' => __('Deseja apagar # {0}?', $comment->id)]) ?>
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
