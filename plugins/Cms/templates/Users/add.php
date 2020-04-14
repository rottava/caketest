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
                <legend><?= __('Novo Usuário') ?></legend>
                <?php
					echo $this->Form->control('name', ['label' => 'Nome']);
                    echo $this->Form->control('email', ['label' => 'E-Mail']);
                    echo $this->Form->control('password', ['label' => 'Senha']);
                    echo $this->Form->control('level', ['label' => 'Admin']);
                    
                ?>
            </fieldset>
            <?= $this->Form->button(__('Salvar')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
