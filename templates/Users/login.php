<!-- in /templates/Users/login.php -->
<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Login</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Para continuar, entre com seu email e senha') ?></legend>
        <?= $this->Form->control('email', ['label' => 'Email', 'required' => true]) ?>
        <?= $this->Form->control('password', ['label' => 'Senha', 'required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Entrar')); ?>
    <?= $this->Form->end() ?>
</div>