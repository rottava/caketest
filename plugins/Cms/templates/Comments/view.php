<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="comments view content">
			<?= $this->Html->link(__('Apagar'), ['action' => 'delete', $comment->id], ['class' => 'button float-right', 'confirm' => __('Deseja apagar # {0}?', $comment->id)]) ?>
			<?= $this->Html->link(__('Editar'), ['action' => 'edit', $comment->id], ['class' => 'button float-left']) ?>
            <table>
                <tr>
                    <th><?= __('Artigo') ?></th>
                    <td><u><?= $comment->has('article') ? $this->Html->link($comment->article->title, ['controller' => 'Articles', 'action' => 'view', $comment->article->id]) : '' ?></u></td>
                </tr>
                <tr>
                    <th><?= __('Usuário') ?></th>
                    <td><u><?= $comment->has('user') ? $this->Html->link($comment->user->name, ['controller' => 'Users', 'action' => 'view', $comment->user->id]) : 'Anônimo
					' ?></u></td>
                </tr>
                <tr>
                    <th><?= __('Texto') ?></th>
                    <td><?= h($comment->content) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($comment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Publicado') ?></th>
                    <td><?= $this->Number->format($comment->published) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= h($comment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ultima modificaçao') ?></th>
                    <td><?= h($comment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
