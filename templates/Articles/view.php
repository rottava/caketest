<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="articles view content">
            <h3><?= h($article->title) ?></h3>
			<p><?= h('Escrito por: ') ?><u><i><?= $this->Html->link($article->user->name, ['controller' => 'Users', 'action' => 'view', $article->user->id]) ?></i></u></p>
			<p><?= h('Em: ') ?> <?= h($article->created) ?></p>
            <div class="text">
                <blockquote>
                    <?= $this->Text->autoParagraph(h($article->body)); ?>
                </blockquote>
            </div>
			
			<h4><?= __('Imagem') ?></h4>
			<?php foreach ($article->pics as $pic) : ?>
				<?= h($this->Html->image($pic->path)) ?>
			<?php endforeach; ?>
			
			<p><?= h('Tags: ') ?>
			<?php foreach ($article->tags as $tag) : ?>
				<u><?= $this->Html->link($tag->title, ['action' => 'tagged', $tag->title]) ?></u>
				<?php if($tag <> end($article->tags)) : ?>
					<?= h(', ') ?>
				<?php endif; ?>
			<?php endforeach; ?>
			
			</p>
			
            <div class="related">
				<?= $this->Html->link(__('Criar comentário'), ['action' => 'comment', $article->addr], ['class' => 'button float-right']) ?>
                <h4><?= __('Commentários') ?></h4>
                <?php if (!empty($article->comments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Usuário') ?></th>
                            <th><?= __('Comentário') ?></th>
                            <th><?= __('Data') ?></th>
                        </tr>
                        <?php foreach ($article->comments as $comment) : ?>
                        <tr>
							<td><u><?= $comment->has('user') ? $this->Html->link($comment->user->name, ['controller' => 'Users', 'action' => 'view', $comment->user_id]) : 'Anônimo' ?></u></td>
                            <td><?= h($comment->content) ?></td>
                            <td><?= h($comment->created) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
