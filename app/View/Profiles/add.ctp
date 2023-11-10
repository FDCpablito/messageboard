<div class="" id="profile-preview">
    <!-- <input type="file" id="imageInput"> -->
    <img src="" id="imagePreview" alt="Image Preview" height="200" width="200">
</div>
<?php
    echo $this->Form->create('Profile', ['type' => 'file']);
    echo $this->Form->input('image', [
        'type' => 'file',
        'id' => 'imageInput'
    ]);
    echo $this->Form->input('name', [
        'value' => $current_user['name']
    ]);
    echo $this->Form->input('birthdate', [
        'type' => 'date'
    ]);
    echo $this->Form->input('gender', [
        'type' => 'radio',
        'options' => [
            '0' => 'Male',
            '1' => 'Female',
        ]
    ]);
    echo $this->Form->input('hubby', [
        'type' => 'textarea'
    ]);
    
    echo $this->Form->end('Update');
?>
    
<script>
    $(document).ready(function() {
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