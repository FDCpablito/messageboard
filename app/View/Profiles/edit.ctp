<div class="container">
    <div class="row justify-content-center">
        <div class="col-10">

            <?php if (!$ifHasProfile): ?>
                <div class="alert alert-info shadow" role="alert">
                    Welcome aboard! 🚀 Congratulations on your first login! 🎉 
                    To unlock the full potential of our platform, let's make your experience even 
                    better by completing your profile setup. Your journey to discovering all 
                    the incredible features begins now. Thank you for choosing us! 🌟
                </div>
            <?php endif;?>

            <div class="card shadow">
                <div class="card-header">
                    Edit Profile / Account Details
                </div>
                <div class="card-body">
                    <?php if(isset($profileData)) :?>
                        <?php echo $this->Form->create('Profile', [
                            'type' => 'file',
                        ]); ?>
                        <div class="row justify-content-center">
                            <div class="col-6 p-1">
                               <div class="row justify-content-center" >
                                    <?php 
                                        echo $this->Html->image('/profile//'.$profileData['Profile']['profile'], [
                                            'alt' => 'Image',
                                            'height' => '200',
                                            'width' => '200',
                                            'id'=> 'imagePreview',
                                            'class' => 'rounded-circle shadow'
                                        ]);
                                    ?>
                               </div>
                                <div class="row justify-content-center">
                                    <?php 
                                        echo $this->Html->link(
                                            'Account Settings',
                                            ['controller' => 'Users', 'action' => 'edit'],
                                            ['class' => 'btn btn-primary']
                                        );
                                    ?>
                                </div>
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
                                        'class' => 'class btn btn-primary',
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
                                <div class="row justify-content-center">
                                    <?php 
                                        echo $this->Html->image('https://t4.ftcdn.net/jpg/02/29/75/83/240_F_229758328_7x8jwCwjtBMmC6rgFzLFhZoEpLobB6L8.jpg', [
                                            'alt' => 'Image',
                                            'height' => '200',
                                            'width' => '200',
                                            'id'=> 'imagePreview',
                                            'class' => 'rounded-circle shadow'
                                        ]);
                                    ?>
                                </div>
                                <div class="row justify-content-center">
                                    <?php
                                        echo $this->Html->link(
                                            'Edit User',
                                            ['controller' => 'Users', 'action' => 'edit'], // Replace $userId with the actual user ID
                                            ['class' => 'btn btn-primary']
                                        );
                                    ?>
                                </div>
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
                                        'class' => 'class btn btn-primary',
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