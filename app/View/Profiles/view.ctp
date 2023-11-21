<?php if (!empty($data)): ?>
    <?php foreach ($data as $profile): ?>
      <div class="row justify-content-center">
        <div class="card col-5 shadow">
            <div class="card-header">
                <h5 class="card-title">
                    User Profile
                </h5>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-6 row">
                        <div class="col-6 row justify-content-center">
                            <div class="col-8">
                                <?php echo $this->Html->image('/profile//' . $profile['Profile']['profile'], 
                                    [
                                        'alt' => 'Profile Image',
                                        'class' => 'rounded-circle border shadow',
                                        'height' => '200',
                                        'width' => '200',
                                    ]
                                ); ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 ">
                        <h2><?php echo h($profile['User']['name']); ?></h2>
                        <p><strong>Email:</strong> <?php echo h($profile['User']['email']); ?></p>
                        <p><strong>Gender:</strong> <?php echo ($profile['Profile']['gender'] == 0) ? 'Male' : 'Female'; ?></p>
                        <p><strong>Birthdate:</strong> <?php echo h(date('F d, Y', strtotime($profile['Profile']['birthdate']))); ?></p>
                        <p><strong>Joined:</strong> <?php echo h(date('F d, Y', strtotime($profile['User']['created'])))?></p>
                        <p><strong>Last Login:</strong> <?php echo h(date('F d, Y g:i A', strtotime($profile['User']['last_login_time'])))?></p>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12">
                            <p><strong>Hubby:</strong> <br> <?php echo h($profile['Profile']['hubby']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center"><strong>No profile data found for the current user.</strong></p>
<?php endif; ?>
