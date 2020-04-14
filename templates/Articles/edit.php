<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article $article
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="articles form content">
            <?= $this->Form->create($article) ?>
            <fieldset>
                <legend><?= __('Editar artigo') ?></legend>
                <?php
                    echo $this->Form->control('title', ['label' => 'Título']);
                    echo $this->Form->control('body', ['label' => 'Texto']);
                    echo $this->Form->control('published', ['label' => 'Publicado']);
                    echo $this->Form->control('tag_string', ['label' => 'Tags', 'type' => 'text']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Salvar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
