<div class="container">
    <div class="text-right">
        
    </div>
    
    <div class="row justify-content-center">
        <div class="col-5 p-4">
            <?php 
                // TODO: new message button
                echo $this->Html->link(
                '<i class="fas fa-plus"></i> New Message',
                array('controller' => 'Messages', 'action' => 'add'),
                array('class' => 'btn btn-primary mb-4', 'escape' => false)
            ); ?>

            <?php foreach ($messages as $key => $value) :?>
                <div class="card shadow mb-1" id="messageBox-<?php echo $value['Message']['id']; ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong><?php echo $this->Html->link($value['Receiver']['name'], ['controller' => 'Conversations', 'action' => 'view', $value['Message']['id']]) ?></strong>
                            <div>
                                <i class="text-right"><?php echo date('F d, Y h:i A', strtotime($value['Receiver']['created'])) ?></i>
                                <a class="ml-2 trash-icon" data-id="<?php echo $value['Message']['id']; ?>" id="delete-converstation">
                                    <i class="fas fa-trash text-danger"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '#delete-converstation', function(e) {
        e.preventDefault();
        var messageId = $(this).data('id');
        var objectToFade = $(`#messageBox-${messageId}`);
    
        objectToFade.fadeOut('slow', function() {
            $.ajax({
                type: 'POST', 
                url: '/messageboard/Messages/delete/' + messageId,
                data: {
                },
                success: function(response) {
                    console.log(response);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>