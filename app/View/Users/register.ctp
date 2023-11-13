<div class="row justify-content-center">
    <div class="col-5">
        <div class="card shadow">
            <div class="card-header">
                Register
            </div>
            <div class="card-body">
                <?php
                    echo $this->Form->create('User');
                    echo $this->Form->input('name', array(
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('email', array(
                        'class' => 'form-control'
                    ));
                    echo $this->Form->input('password', array(
                        'class' => 'form-control'
                    ));
                    echo $this->Form->error('password');
                    echo $this->Form->input('password_confirm', array(
                        'type' => 'password',
                        'class' => 'form-control'
                    ));
                    echo $this->Form->error('password_confirm');
                    echo $this->Form->end('Register');
                ?>
            </div>
        </div>
    </div>
</div>