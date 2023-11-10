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
            <div class="card mb-1">
                <div class="card-body">
                    <strong><?php echo $this->Html->link($value['Receiver']['name'], ['controller' => 'Conversations', 'action' => 'view', $value['Message']['id']]) ?></strong><br>
                    <i class="text-right"><?php echo date('F d, Y h:i A', strtotime($value['Receiver']['created'])) ?></i>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>