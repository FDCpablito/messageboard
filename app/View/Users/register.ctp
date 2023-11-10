<div class="row justify-content-center">
    <div class="col-5">
        <div class="card shadow">
            <div class="card-header">
                Register
            </div>
            <div class="card-body">
                <?php
                    echo $this->Form->create('User');
                    echo $this->Form->input('name');
                    echo $this->Form->input('email');
                    echo $this->Form->input('password');
                    echo $this->Form->error('password');
                    echo $this->Form->input('password_confirm', array('type' => 'password'));
                    echo $this->Form->error('password_confirm');
                    echo $this->Form->end('Register');
                ?>
            </div>
        </div>
    </div>
</div>