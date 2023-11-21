<?php 
    $counter = 0;
?>
<div class="container">
    <div class="row justify-content-center">
        <?php if($ifHasProfile == true) :?>
            <div class="col-8 p-4">
                <?php 
                    // TODO: new message button
                    echo $this->Html->link(
                    '<i class="fas fa-plus"></i> New Message',
                    array('controller' => 'Messages', 'action' => 'add'),
                    array('class' => 'btn btn-primary mb-4', 'escape' => false)
                ); ?>

                <?php if (!empty($messages)) : ?>
                    <div class="justify-content-center p-2" id="sent-box">
                        <?php foreach ($messages as $key => $value) :?>
                            <!-- <?php $counter = $key; ?> -->
                            <div class="card shadow mb-1" id="messageBox-<?php echo $value['Message']['id']; ?>">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong><?php echo $this->Html->link($value['Receiver']['name'], ['controller' => 'Conversations', 'action' => 'view', $value['Message']['id']]) ?></strong>
                                        <div>
                                            <i class="text-right"><?php echo date('Y/m/d H:i:s A', strtotime($value['Receiver']['created'])) ?></i>
                                            <a class="ml-2 btn" data-id="<?php echo $value['Message']['id']; ?>" id="delete-conversation">
                                                <i class="fas fa-trash text-danger" ></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if($counter >= 2) :?>
                            <a href="#" id="show-more" class="btn text-center text-primary col-12">Show More</a>
                        <?php endif; ?>
                    </div>
                <?php else :?>
                    <h5 class="text-center">You don't have any sent box.</h5>
                <?php endif ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info shadow col-8" role="alert">
                To maximize your interaction on our platform, please take a moment to set up your <?php echo $this->Html->link('Profile', array('controller' => 'profiles', 'action' => 'edit')); ?> . 
                This step is essential for enabling message sending capabilities. 
                We're excited to have you fully engaged, and appreciate your prompt attention to this matter! 🌐💬
            </div>
        <?php endif ;?>
    </div>
</div>

<script>
    $(document).on('click', '#delete-conversation', function(e) {
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

    $(document).on('click', '#show-more', function(e) {
        e.preventDefault();
        fetchMessages();
    });

    
    let limit = 5;
    function fetchMessages() {
        var baseUrl = '<?php echo $this->Html->url('/'); ?>';
        var userId = '<?php echo $current_user['id']; ?>';
        $.ajax({
            type: 'GET',
            url: baseUrl + 'Messages/fetchSentBox/' + userId + '/' + limit,
            dataType: 'json',
            success: function(response) {
                const sentBox = $('#sent-box');
                sentBox.html(' ');
                
                response.forEach((element , index) => {
                    const card = $('<div>', {
                        'class' : 'card shadow mb-1',
                        'id' : 'messageBox-' + element.Message.id
                    });
                    const cardBody = $('<div>', {
                        'class' : 'card-body'
                    });

                    const content = $('<div>', {
                        'class' : 'd-flex justify-content-between align-items-center'
                    });

                    const strong = $('<strong>');

                    const name = $('<a>', {
                        'class' : 'font-weight-bold text-primary',
                        'text' : element.Receiver.name,
                        'href' : '/messageboard/Conversations/view/' + element.Message.id
                    });
                    strong.append(name);
                    // $.datepicker.parseDate("yy-mm-dd", ajaxResponseDate)
                    const date = $('<i>', {
                        'text' : element.Message.created,
                        'class' : 'text-right mr-2 text-primary'
                    });

                    const deleteIcon = $('<i>', {
                        'class' : 'fas fa-trash text-danger'
                    });
                    const deleteButton = $('<a>', {
                        'class' : 'ml-2 trash-icon btn' ,
                        'id' : 'delete-conversation',
                        'data-id' : element.Message.id
                    });
                    deleteButton.append(deleteIcon);

                    const dateAndDeleteBtn = $('<div>');
                    dateAndDeleteBtn.append(strong);
                    dateAndDeleteBtn.append(date);
                    dateAndDeleteBtn.append(deleteButton);

                    content.append(strong);
                    content.append(dateAndDeleteBtn);
                    cardBody.append(content);
                    card.append(cardBody);

                    sentBox.append(card);
                });
                const showMoreBtn = $('<a>', {
                    'id' : 'show-more',
                    'class' : 'btn text-center text-primary col-12',
                    'text' : 'Show more',
                    'href' : '#'
                });

                if (limit >= 4) {
                    sentBox.append(showMoreBtn);
                }
                limit += 10;
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
</script>