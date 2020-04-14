<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="users view content">
			<?php if($user->id === $uid) : ?>
				<?= $this->Html->link(__('Editar'), ['action' => 'edit', $user->id], ['class' => 'button float-left']) ?>
			<?php endif; ?>
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
                            <th><?= __('Publicado') ?></th>
                            <th><?= __('Criado') ?></th>
                            <th><?= __('Visualizado') ?></th>
                        </tr>
                        <?php foreach ($user->articles as $article) : ?>
                        <tr>
                            <td><u><?= $this->Html->link($article->title, ['controller' => 'Articles', 'action' => 'view', $article->addr]) ?></u></td>
                            <td><?= $article->published ? __('Sim') : __('Nao'); ?></td>
                            <td><?= h($article->created) ?></td>
                            <td><?= h($article->views) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
