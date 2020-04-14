<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Editar usuário') ?></legend>
                <?php
					echo $this->Form->control('name', ['label' => 'Nome']);
                    echo $this->Form->control('email', ['label' => 'E-Mail']);
                    echo $this->Form->control('password', ['label' => 'Senha']);
                    
                ?>
            </fieldset>
            <?= $this->Form->button(__('Salvar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
