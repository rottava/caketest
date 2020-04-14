<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="users view content">
			<?= $this->Html->link(__('Apagar'), ['action' => 'delete', $user->id], ['class' => 'button float-right', 'confirm' => __('Deseja apagar # {0}?', $user->id)]) ?>
			<?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'button float-left']) ?>
            <table>
				<tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($user->id) ?></td>
                </tr>
				<tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($user->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('E-Mail') ?></th>
                    <td><?= h($user->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= h($user->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Última modificaçao') ?></th>
                    <td><?= h($user->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Admin') ?></th>
                    <td><?= $user->level ? __('Sim') : __('Nao'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Artigos:') ?></h4>
                <?php if (!empty($user->articles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Título') ?></th>
                            <th><?= $this->Paginator->sort('published', ['label' => 'Publicado']) ?></th>
                            <th><?= $this->Paginator->sort('created', ['label' => 'Criado']) ?></th>
                            <th><?= $this->Paginator->sort('views', ['label' => 'Visualizado']) ?></th>
							<th class="actions"><?= __('Comandos') ?></th>
                        </tr>
                        <?php foreach ($user->articles as $article) : ?>
                        <tr>
							<td><?= h($article->title) ?></td>
                            <td><?= $article->published ? __('Sim') : __('Nao'); ?></td>
                            <td><?= h($article->created) ?></td>
                            <td><?= h($article->views) ?></td>
							<td class="actions">
								<?= $this->Html->link(__('Ver'), ['controller' => 'Articles', 'action' => 'view', $article->id]) ?>
								<?= $this->Html->link(__('Editar'), ['controller' => 'Articles', 'action' => 'edit', $article->id]) ?>
								<?= $this->Form->postLink(__('Apagar'), ['controller' => 'Articles', 'action' => 'delete', $article->id], ['confirm' => __('Deseja apagar # {0}?', $article->id)]) ?>
							</td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
