<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card shadow">
                <div class="card-header">
                    New Message
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?php
                            echo $this->Form->create('Message', array('id' => 'messageForm'));
                            echo $this->Form->input('receiver', array(
                                'type' => 'select',
                                'id' => 'receiverInput',
                                'options' => $options,
                                'class' => 'form-control'
                            ));
                            echo $this->Form->input('message', array(
                                'type' => 'textarea',
                                'class' => 'form-control',
                                'id' => 'messageInput'
                            ));
                            echo $this->Form->end('Send Message');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var baseUrl = '<?php echo $this->Html->url('/'); ?>';

    $('#receiverInput').select2({
        data: JSON.parse('<?php echo $options ?>'),
        templateResult: formatResult,
        templateSelection: formatSelection,
    });

    function formatResult(result) {
        if (!result.id) {
            return result.text;
        }

        var image = `${baseUrl}profile/${result.image}`;
        var option = $('<span><img src="' + image + '" class="rounded-circle" height="40" width="40" /> ' + result.text + '</span>');

        return option;
    }

    function formatSelection(selection) {
        if (!selection.id) {
            return selection.text;
        }

        var image = `${baseUrl}profile/${selection.image}`;
        var selectedOption = $('<span><img src="' + image + '" class="rounded-circle" height="15" width="15"/> ' + selection.text + '</span>');

        return selectedOption;
    }

    $(document).ready(function () {
        $('#messageForm').submit(function (e) {
            var message = $('#messageInput').val();

            if (message.trim() === '') {
                e.preventDefault();
                displayError('Message is required');
            }
        });

        function displayError(message) {
            var errorDiv = $('<div class="alert alert-danger">' + message + '</div>');
            $('.card-body').prepend(errorDiv);

            setTimeout(function () {
                errorDiv.fadeOut('slow');
            }, 1000);
        }
    });
</script>
