<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title p-0">
                        Account Credentials
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-6 p-1">
                            <h6 class="">Current Credentials</h6>
                            <div class="rounded p-1">
                                <p>Name: <strong><?php echo $user['User']['name'] ?></strong></p>
                                <p>Email: <strong><?php echo $user['User']['email'] ?></strong></p>
                            </div>
                            <div class="border-top p-1">
                                <p><i class="fas fa-info-circle mr-2 text-warning"></i>For security reasons. Your password will not be displayed here.</p>
                            </div>
                        </div>
                        <div class="col-6 p-1">
                            <?php
                                echo $this->Form->create('User');
                                echo $this->Form->input('name', array(
                                    'class' => 'form-control'
                                ));
                                echo $this->Form->input('email', array(
                                    'class' => 'form-control'
                                ));
                                echo $this->Form->input('password', array('type' => 'password', 'class' => 'form-control'));
                                echo $this->Form->input('password_confirm', array('type' => 'password', 'label' => 'Confirm Password', 'class' => 'form-control'));
                                echo $this->Form->end('Update');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>