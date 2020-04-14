<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="articles view content">
			<?= $this->Html->link(__('Apagar'), ['action' => 'delete', $article->id], ['class' => 'button float-right', 'confirm' => __('Deseja apagar # {0}?', $article->id)]) ?>
			<?= $this->Html->link(__('Editar'), ['action' => 'edit', $article->id], ['class' => 'button float-left']) ?>
            <table>
				<tr>
                    <th><?= __('Título') ?></th>
                    <td><?= h($article->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Usuário') ?></th>
                    <td><u><?= $article->has('user') ? $this->Html->link($article->user->name, ['controller' => 'Users', 'action' => 'view', $article->user->id]) : 'Anônimo' ?></u></td>
                </tr>
                <tr>
                    <th><?= __('Link') ?></th>
                    <td><?= h($article->addr) ?></td>
                </tr>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($article->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Visualizado') ?></th>
                    <td><?= $this->Number->format($article->views) ?></td>
                </tr>
                <tr>
                    <th><?= __('Criado em') ?></th>
                    <td><?= h($article->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Última modificaçao') ?></th>
                    <td><?= h($article->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Publicado') ?></th>
                    <td><?= $article->published ? __('Sim') : __('Nao'); ?></td>
                </tr>
				<tr>
                    <th><?= __('Tags') ?></th>
                    <td>
					<?php foreach ($article->tags as $tag) : ?>
						<u><?= $this->Html->link($tag->title, ['controller' => 'Tags', 'action' => 'view', $tag->id]) ?></u>
						<?php if($tag <> end($article->tags)) : ?>
							<?= h(', ') ?>
						<?php endif; ?>
					<?php endforeach; ?>
					</td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Texto') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($article->body)); ?>
                </blockquote>
            </div>
			
			<h4><?= __('Imagem') ?></h4>
			<?php foreach ($article->pics as $pic) : ?>
				<?= h($this->Html->image($pic->path)) ?>
			<?php endforeach; ?>
			
            <div class="related">
                <h4><?= __('Commentários') ?></h4>
				<?= $this->Html->link(__('Criar Comentário'), ['controller' => 'Comments', 'action' => 'add', $article->id], ['class' => 'button float-left']) ?>
                <?php if (!empty($article->comments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Usuário') ?></th>
                            <th><?= __('Texto') ?></th>
                            <th><?= $this->Paginator->sort('published', ['label' => 'Publicado']) ?></th>
                            <th><?= $this->Paginator->sort('created', ['label' => 'Criado']) ?></th>
							<th class="actions"><?= __('Comandos') ?></th>
                        </tr>
                        <?php foreach ($article->comments as $comment) : ?>
                        <tr>
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
								<?= $this->Html->link(__('Ver'), ['controller' => 'Comments', 'action' => 'view', $comment->id]) ?>
								<?= $this->Html->link(__('Editar'), ['controller' => 'Comments', 'action' => 'edit', $comment->id]) ?>
								<?= $this->Form->postLink(__('Apagar'), ['controller' => 'Comments', 'action' => 'delete', $comment->id], ['confirm' => __('Deseja apagar # {0}?', $comment->id)]) ?>
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
