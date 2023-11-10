<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    New Message
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <?php
                            echo $this->Form->create('Message');
                            echo $this->Form->input('receiver', array(
                                'type' => 'select',
                                'id' => 'recieverInput',
                                'options' => $options,
                                'class' => 'form-control'
                            ));
                            echo $this->Form->input('message', array(
                                'type' => 'textarea',
                                'class' => 'form-control'
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
    $(document).ready(function() {
        $('#recieverInput').select2();
    });
</script>