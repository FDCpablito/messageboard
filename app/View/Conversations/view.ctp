<div class="container">
    <div class="row justify-content-center">
        <div class="col-8 mb-2">
            <?php
                echo $this->Form->create('Conversation', [
                    'id' => 'conversation-form',
                    'url' => ['controller' => 'Conversations', 'action' => 'add'],
                ]);
                echo $this->Form->input('message', [
                    'class' => 'form-control',
                    'id' => 'message-input'
                ]);
                echo $this->Form->button('Send Message', [
                    'type' => 'button', 
                    'id' => 'submit-btn',
                    'class' => 'btn btn-success',
                    'data-messageId' => $messageId,
                    'data-receiverId' => $receiverId
                ]);
                echo $this->Form->end();
            ?>

            <div class="mt-4" id="message-box" 
                data-user-id="<?php echo $current_user['id']; ?>"
                data-message-id= "<?php echo $messageId; ?>"
            >
                
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                Loading ...
            </div>
            <div class="row justify-content-center">
                <a href="#" class="btn text-primary" id="more-conversation">
                    Show More
                </a>
            </div>
        </div>        
    </div>

</div>

<script>
    $(document).ready(function() {
        setInterval(fetchMessages, 2000);
        $('#submit-btn').click(function() {
            fetchMessages();
            var formData = $('#conversation-form').serializeArray();
            formData.push({ name: 'messageId', value: $(this).data('messageid') });
            formData.push({ name: 'receiverId', value: $(this).data('receiverid') });
            $.ajax({
                type: 'POST',
                url: $('#conversation-form').attr('action'),
                data: formData,
                success: function(response) {
                    $('#message-input').val(' ');
                    // Handle the success response
                    console.log(response);
                },
                error: function(error) {
                    // Handle the error response
                    console.error(error);
                }
            });
            
        });

        let numberConvo = 10;
        function fetchMessages() {
            var baseUrl = '<?php echo $this->Html->url('/'); ?>';
            var messageId = $('#message-box').data('message-id');
            $.ajax({
                type: 'GET',
                url: baseUrl + 'messageboard/Conversations/fetch/' + messageId + '/' + numberConvo,
                dataType: 'json',
                success: function(response) {
                    const messageBox = $('#message-box');
                    messageBox.html('');
                    const userId = messageBox.data('user-id');

                    

                    // TODO: Display the conversation
                    response.forEach((element, index) => {
                        const newRow = $('<div>', {
                            'class': 'row col-12 justify-content-center p-1 mb-2',
                        });

                        /**
                         * TODO: Relocate the message to left or right
                         * ? right will hold the messages for current logged in user
                         * ? left will hold the messages from the receiver user
                         */
                            const leftColumn = $('<div>');
                            const rightColumn = $('<div>');

                            if (userId == element.Conversation.sender_id) {
                                leftColumn.addClass('col-2 p-1');
                                rightColumn.addClass('col-10 p-1');
                            } else {
                                leftColumn.addClass('col-10 p-1');
                                rightColumn.addClass('col-2 p-1');
                            }

                            newRow.append(leftColumn);
                            newRow.append(rightColumn);

                        // Creating chat box
                        const chatBox = $('<div>', {
                            'class': `${ (userId == element.Conversation.sender_id) ? 'bg-info' : 'bg-secondary' } shadow text-white p-2 rounded col-12`
                        });
                        const senderHolder = $('<div>', {
                            'class': `form-group d-flex justify-content-${ (userId == element.Conversation.sender_id) ? 'end' : 'begin' } align-items-center`,
                        });
                        const senderProfile = $('<img>', {
                            'src': baseUrl + `profile/${element.Profile.profile}`,
                            'class': 'rounded-circle',
                            'alt': 'Profile Image',
                            'height': '25',
                            'width': '25'
                        });

                        senderHolder.append(senderProfile);
                        const messageElement = $('<p>', {
                            'text': element.Conversation.message
                        });
                        const timeHolder = $('<p>', {
                            'text': element.Conversation.created,
                            'class': 'text-right mr-4'
                        });

                        chatBox.append(senderHolder);
                        chatBox.append(messageElement);
                        chatBox.append(timeHolder);

                        // * conversation placement
                        if (userId == element.Conversation.sender_id) {
                            rightColumn.append(chatBox)
                        } else {
                            leftColumn.append(chatBox)
                        }

                        // end 
                        messageBox.append(newRow);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

        $('#more-conversation').click(function (e) {
            e.preventDefault();
            numberConvo += numberConvo;
        });
    });
</script>
