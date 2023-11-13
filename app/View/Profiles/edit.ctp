<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card shadow">
                <div class="card-header bg-white">
                    Edit Profile / Account Details
                </div>
                <div class="card-body">
                    <?php if(isset($profileData)) :?>
                        <?php echo $this->Form->create('Profile', [
                            'type' => 'file',
                        ]); ?>
                        <div class="row justify-content-center">
                            <div class="col-6 p-1">
                                <?php 
                                    echo $this->Html->image('/profile//'.$profileData['Profile']['profile'], [
                                        'alt' => 'Image',
                                        'height' => '200',
                                        'width' => '200',
                                        'id'=> 'imagePreview',
                                        'class' => 'border'
                                    ]);

                                    //* these are from the user table
                                    echo $this->Form->input('name', [
                                        'value' => $profileData['User']['name'],
                                        'required' => true,
                                        'class' => 'form-control'
                                    ]);

                                    echo $this->Form->input('email', [
                                        'value' => $profileData['User']['email'],
                                        'required' => true,
                                        'class' => 'form-control'
                                    ]);

                                    echo $this->Form->input('new password', [
                                        'required' => true,
                                        'class' => 'form-control',
                                        'type' => 'password'
                                    ]);

                                    echo $this->Form->input('confirm password', [
                                        'required' => true,
                                        'class' => 'form-control',
                                        'type' => 'password'
                                    ]);
                                ?>
                            </div>
                            <div class="col-6 p-1">
                                <?php 
                                    echo $this->Form->input('profile', [
                                        'type' => 'file',
                                        'id' => 'imageInput',
                                        'accepts' => '.jpg, .jpeg, .gif, .png',
                                        'class' => 'form-control'
                                    ]);

                                    
                                    echo $this->Form->input('birthdate', [
                                        'type' => 'text',
                                        'id' => 'datepicker',
                                        'value' => $profileData['Profile']['birthdate'],
                                        'class' => 'form-control'
                                    ]);
                                    echo $this->Form->input('gender', [
                                        'type' => 'radio',
                                        'options' => [
                                            '0' => 'Male',
                                            '1' => 'Female',
                                        ],
                                        'default' => $profileData['Profile']['gender'],
                                        'class' => 'form-control'
                                    ]);
                                    
                                    echo $this->Form->input('hubby', [
                                        'type' => 'textarea',
                                        'value' => $profileData['Profile']['hubby'],
                                        'class' => 'form-control'
                                    ]);
                                    echo $this->Form->end('Update');
                                ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <?php echo $this->Form->create('Profile', [
                            'type' => 'file',
                        ]); ?>
                        <div class="row justify-content-center">
                            <div class="col-6 p-1">
                                <?php 
                                    echo $this->Html->image('https://t4.ftcdn.net/jpg/02/29/75/83/240_F_229758328_7x8jwCwjtBMmC6rgFzLFhZoEpLobB6L8.jpg', [
                                        'alt' => 'Image',
                                        'height' => '200',
                                        'width' => '200',
                                        'id'=> 'imagePreview',
                                        'class' => 'border'
                                    ]);

                                    //* these are from the user table
                                    echo $this->Form->input('name', [
                                        'value' => (isset($profileData['Users']['name'])) ? $profileData['Users']['name'] : $current_user['name'],
                                        'required' => true,
                                        'class' => 'form-control'
                                    ]);

                                    echo $this->Form->input('email', [
                                        'value' => (isset($profileData['Users']['email'])) ? $profileData['Users']['email'] : $current_user['email'],
                                        'required' => true,
                                        'class' => 'form-control'
                                    ]);

                                    echo $this->Form->input('new password', [
                                        'required' => true,
                                        'class' => 'form-control',
                                        'type' => 'password'
                                    ]);

                                    echo $this->Form->input('confirm password', [
                                        'required' => true,
                                        'class' => 'form-control',
                                        'type' => 'password'
                                    ]);
                                ?>
                            </div>
                            <div class="col-6 p-1">
                                <?php 
                                    echo $this->Form->input('profile', [
                                        'type' => 'file',
                                        'id' => 'imageInput',
                                        'accepts' => '.jpg, .jpeg, .gif, .png',
                                        'class' => 'form-control'
                                    ]);

                                    
                                    echo $this->Form->input('birthdate', [
                                        'type' => 'text',
                                        'id' => 'datepicker',
                                        'class' => 'form-control'
                                    ]);
                                    echo $this->Form->input('gender', [
                                        'type' => 'radio',
                                        'options' => [
                                            '0' => 'Male',
                                            '1' => 'Female',
                                        ],
                                        'class' => 'form-control'
                                    ]);
                                    
                                    echo $this->Form->input('hubby', [
                                        'type' => 'textarea',
                                        'class' => 'form-control'
                                    ]);
                                    echo $this->Form->end('Update');
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#datepicker").datepicker({
            changeMonth: true, // Allow changing months
            changeYear: true, // Allow changing years
            yearRange: '1900:2050' // Limit the year range
        });
        $('#imageInput').change(function() {
            var file = this.files[0];
            var imagePreview = $('#imagePreview');
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.attr('src', e.target.result);
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.attr('src', ''); // Clear the image preview
            }
        });
    });
</script>