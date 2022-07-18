<?php // resources/views/blog/single.php
  $this->layout('main');
?>

    <form>
        <div class="mb-3">
            <input type="input" class="form-control" placeholder="Search...">
        </div>
    </form>


  <?php foreach($members as $member):?>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">
                <a href="/members/<?php echo $member->ID ?>" class="stretched-link">
                    <?php echo get_user_meta($member->ID, 'first_name', true ) . ' ' . get_user_meta($member->ID, 'last_name', true ) ?>
                </a>
            </h5>

            <h6 class="card-subtitle text-muted mb-0">
                <?php
                  $companyID = tr_user_field("company", $member->ID);
                  $company = new \App\Models\Company();
                  $company->findById($companyID);
                  echo $company->post_title;
                ?>
            </h6>

              <?php if(get_user_meta($member->ID, 'phone', true )): ?>
                  <div class="phone mt-1"><i class="_mi _before dashicons dashicons-phone"></i> <?php echo get_user_meta($member->ID, 'phone', true ) ?></div>
              <?php endif; ?>
              <?php if(get_user_meta($member->ID, 'email', true )): ?>
                  <div class="email mt-1"><i class="_mi _before dashicons dashicons-email"></i> <?php echo get_user_meta($member->ID, 'email', true ) ?></div>
              <?php endif; ?>

        </div>
    </div>
  <?php endforeach; ?>