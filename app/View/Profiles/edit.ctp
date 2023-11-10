<div class="container">
    <div class="row justify-content-center">
        <div class="col-5">
            <?php
                if (isset($profileData)) {
                    echo $this->Form->create('Profile', ['type' => 'file']);
                    echo $this->Html->image('/profile//'.$profileData['Profile']['profile'], [
                        'alt' => 'Image',
                        'height' => '200',
                        'width' => '200',
                        'id'=> 'imagePreview'
                    ]);
                
                    echo $this->Form->input('profile', [
                        'type' => 'file',
                        'id' => 'imageInput',
                        'accepts' => '.jpg, .jpeg, .gif, .png'
                    ]);
                    echo $this->Form->input('name', [
                        'value' => $current_user['name'],
                        // 'required' => true
                    ]);
                    echo $this->Form->input('birthdate', [
                        'type' => 'text',
                        'id' => 'datepicker',
                        'value' => $profileData['Profile']['birthdate']
                    ]);
                    echo $this->Form->input('gender', [
                        'type' => 'radio',
                        'options' => [
                            '0' => 'Male',
                            '1' => 'Female',
                        ],
                        'default' => $profileData['Profile']['gender']
                    ]);
                    echo $this->Form->input('hubby', [
                        'type' => 'textarea',
                        'value' => $profileData['Profile']['hubby']
                    ]);
                    echo $this->Form->end('Update');

                } else {
                    echo $this->Form->create('Profile', ['type' => 'file']);
                    echo $this->Html->image('https://t4.ftcdn.net/jpg/02/29/75/83/240_F_229758328_7x8jwCwjtBMmC6rgFzLFhZoEpLobB6L8.jpg', [
                        'alt' => 'Image',
                        'height' => '200',
                        'width' => '200',
                        'id' => 'imagePreview'
                    ]);

                    echo $this->Form->input('profile', [
                        'type' => 'file',
                        'id' => 'imageInput',
                        'accepts' => '.jpg, .jpeg, .gif, .png'
                    ]);
                    echo $this->Form->input('name', [
                        'value' => $current_user['name']
                    ]);
                    echo $this->Form->input('birthdate', [
                        'type' => 'text',
                        'id' => 'datepicker',
                    ]);
                    echo $this->Form->input('gender', [
                        'type' => 'radio',
                        'options' => [
                            '0' => 'Male',
                            '1' => 'Female',
                        ],
                    ]);
                    echo $this->Form->input('hubby', [
                        'type' => 'textarea',
                    ]);
                    echo $this->Form->end('Update');
                }
            ?>  
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