<div class="container">
    <div class="text-right">
        
    </div>
    
    <div class="row justify-content-center">
        <div class="col-5 p-4">
            <?php if (!empty($messages)) : ?>
                <?php foreach ($messages as $key => $value) :?>
                    <div class="card mb-1">
                        <div class="card-body">
                            <strong><?php echo $this->Html->link($value['User']['name'], ['controller' => 'Conversations', 'action' => 'view', $value['Message']['id']]) ?></strong><br>
                            <i class="text-right"><?php echo date('F d, Y h:i A', strtotime($value['Receiver']['created'])) ?></i>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <h5 class="text-center">You don't have any messages</h5>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    
</script>