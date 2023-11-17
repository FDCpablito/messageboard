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
    var intervalId;
    $(document).ready(function() {
        var baseUrl = '<?php echo $this->Html->url('/'); ?>';
        // Set interval only if it's not already set
        if (!intervalId) {
            intervalId = setInterval(fetchMessages, 2000);
        }
    });

    /**
     * TODO: submit / send the message
     */
        $(document).on('click', '#submit-btn', function() {
            var formData = $('#conversation-form').serializeArray();
            formData.push({ name: 'messageId', value: $(this).data('messageid') });
            formData.push({ name: 'receiverId', value: $(this).data('receiverid') });
            $.ajax({
                type: 'POST',
                url: $('#conversation-form').attr('action'),
                data: formData,
                success: function(response) {
                    $('#message-input').val(' ');
                    console.log(response);

                    // This will fetch the response
                    fetchMessages();
                },
                error: function(error) {
                    // Handle the error response
                    console.error(error);
                }
            });
        });

    /**
     * TODO: this will fetch the conversation
     */
        let numberConvo = 10; // * holds the limit or the number message to fetch
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
                         * TODO: create the message holders
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
                        // TODO: end
                        /**
                         * TODO: Creating chat box
                         */
                            const chatBox = $('<div>', {
                                'class': `${(userId == element.Conversation.sender_id) ? 'bg-info' : 'bg-secondary'} shadow text-white p-2 rounded col-12`
                            });
                            const senderHolder = $('<div>', {
                                'class': `form-group d-flex justify-content-${(userId == element.Conversation.sender_id) ? 'end' : 'begin'} align-items-center`,
                            });

                            const senderProfile = $('<img>', {
                                'src': baseUrl + `profile/${element.Profile.profile}`,
                                'class': 'rounded-circle',
                                'alt': 'Profile Image',
                                'height': '30',
                                'width': '30',
                                'id': 'visit-profile',
                                'data-id': `${element.Sender.id}`
                            });

                            senderHolder.append(senderProfile);

                            // TODO: Creating the show more message feature
                            const messageText = element.Conversation.message;

                            // Only show "Show More" button if the message exceeds 30 characters
                            const showMoreButton = (messageText.length > 30) ? $('<button>', {
                                'text': 'Show More',
                                'class': 'btn btn-link',
                                'click': function() {
                                    messagePreview.toggle();
                                    messageFull.toggle();
                                    showMoreButton.text(messagePreview.is(':visible') ? 'Show More' : 'Show Less');

                                    if (messagePreview.is(':visible')) {
                                        intervalId = setInterval(fetchMessages, 2000);
                                    } else {
                                        clearInterval(intervalId);
                                    }
                                }
                            }) : null;

                            const messagePreview = $('<span>').text(messageText.substring(0, 30));
                            const messageFull = $('<span>').text(messageText).hide();
                            const messageElement = $('<p>').append(messagePreview).append(messageFull).append(showMoreButton);

                            const timeHolder = $('<p>', {
                                'text': element.Conversation.created,
                                'class': 'text-right mr-4'
                            });

                            chatBox.append(senderHolder);
                            chatBox.append(messageElement);
                            chatBox.append(timeHolder);
                        // TODO: end
                        // TODO: conversation placement
                            if (userId == element.Conversation.sender_id) {
                                rightColumn.append(chatBox)
                            } else {
                                leftColumn.append(chatBox)
                            }
                        // TODO: end 
                        messageBox.append(newRow);
                    });
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }

    /**
     * TODO: fetch more message
     */
        $(document).on('click', '#more-conversation', function(e) {
            e.preventDefault();
            numberConvo += numberConvo;
            fetchMessages();
        });

    /**
     * TODO: visit profile of message sender
     */
        $(document).on('click', '#visit-profile', function(e) {
            e.preventDefault();
            var baseUrl = '<?php echo $this->Html->url('/'); ?>';
            window.location.href = baseUrl + 'Profiles/userProfile/'+ $(this).data('id') ;
        });
</script>
