<div class="row justify-content-center">
    <div class="col-5">
        <div class="card shadow">
            <div class="card-header">
                Register
            </div>
            <div class="card-body">
                <?php
                    echo $this->Form->create('User', array('id' => 'registerForm'));
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
<script>
    $(document).ready(function () {
        $("#UserRegisterForm").validate({
            rules: {
                'data[User][name]': {
                    required: true
                },
                'data[User][email]': {
                    required: true,
                    email: true
                },
                'data[User][password]': {
                    required: true,
                    minlength: 8
                },
                'data[User][password_confirm]': {
                    required: true,
                    equalTo: '#UserPassword'
                }
            },
            messages: {
                'data[User][name]': {
                    required: 'Please enter your name'
                },
                'data[User][email]': {
                    required: 'Please enter a valid email address',
                    email: 'Please enter a valid email address'
                },
                'data[User][password]': {
                    required: 'Password is required',
                    minlength: 'Password must be at least 8 characters long'
                },
                'data[User][password_confirm]': {
                    required: 'Please confirm your password',
                    equalTo: 'Passwords do not match'
                }
            }
        });
    });
</script>
