<h1 class="text-center"><strong>User Profile</strong></h1>
<?php if (!empty($data)): ?>
    <?php foreach ($data as $profile): ?>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-3 row">
                    <div class="col-6 float-right p-0">
                        <?php echo $this->Html->image('/profile//' . $profile['Profile']['profile'], 
                            [
                                'alt' => 'Profile Image',
                                'class' => 'border float-right m-0',
                                'height' => '200',
                                'width' => '200',
                            ]
                        ); ?>
                    </div>
                </div>
                <div class="col-3 ">
                    <h2><?php echo h($profile['User']['name']); ?></h2>
                    <p>Email: <?php echo h($profile['User']['email']); ?></p>
                    <p>Gender: <?php echo $profile['Profile']['gender'] ? 'Male' : 'Female'; ?></p>
                    <p>Birthdate: <?php echo h(date('F d, Y', strtotime($profile['Profile']['birthdate']))); ?></p>
                    <p>Joined: <?php echo h(date('F d, Y', strtotime($profile['User']['created'])))?></p>
                    <p>Last Login: <?php echo h(date('F d, Y g:i A', strtotime($profile['User']['last_login_time'])))?></p>
                    
                </div>
            </div>
            <div class="row justify-content-center">
               <div class="col-6">
                    <p>Hubby: <br> <?php echo h($profile['Profile']['hubby']); ?></p>
               </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>No profile data found for the current user.</p>
<?php endif; ?>
