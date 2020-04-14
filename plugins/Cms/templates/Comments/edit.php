<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="comments form content">
            <?= $this->Form->create($comment) ?>
            <fieldset>
                <legend><?= __('Editar Comentário') ?></legend>
                <?php
                    echo $this->Form->control('content', ['label' => 'Texto']);
					$valid = ['0' => 'Pendente', '1' => 'Aprovado', '2' => 'Reprovado'];
					echo $this->Form->select('published', $valid, ['default' => '0']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Salvar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
