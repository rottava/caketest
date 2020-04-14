<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="tags view content">
			<?= $this->Html->link(__('Apagar'), ['action' => 'delete', $tag->id], ['class' => 'button float-right', 'confirm' => __('Deseja apagar # {0}?', $tag->id)]) ?>
			<?= $this->Html->link(__('Editar'), ['action' => 'edit', $tag->id], ['class' => 'button float-left']) ?>
            <table>
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= h($tag->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($tag->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= h($tag->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Última modificaçao') ?></th>
                    <td><?= h($tag->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Artigos') ?></h4>
                <?php if (!empty($tag->articles)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Título') ?></th>
                            <th><?= __('Redator') ?></th>
                        </tr>
                        <?php foreach ($tag->articles as $article) : ?>
                        <tr>
                            <td><u><?= $this->Html->link($article->title, ['controller' => 'Articles', 'action' => 'view', $article->id]) ?></u></td>
							<td><u><?= $this->Html->link($article->user->name, ['controller' => 'Users', 'action' => 'view', $article->user_id]) ?></u></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
