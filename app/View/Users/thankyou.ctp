<div class="row justify-content-center text-center">
    <div class="col-5">
        <h2 class="text-center font-weight-heavy">Thank you for registering</h2>
        <?php
            echo $this->Html->link('Back to homepage', ['controller' => 'Users', 'action' => 'login'], ['class' => 'btn btn-primary']);
        ?>
    </div>
</div>
