<?php // resources/views/blog/single.php
  $this->layout('main');
?>

<h1>
  <?php echo get_user_meta($member->ID, 'first_name', true ) . ' ' . get_user_meta($member->ID, 'last_name', true ) ?>
</h1>

<h3 class="card-subtitle mb-2 text-muted">
    <?php echo get_user_meta($member->ID, 'position', true ) ?>
</h3>



<div class="card mt-3">
    <div class="card-header">
        Contact Details
    </div>
    <ul class="list-group list-group-flush">
      <?php if(get_user_meta($member->ID, 'phone', true )): ?>
          <li class="list-group-item position-relative">
              <a class="stretched-link" href="tel:<?php echo get_user_meta($member->ID, 'phone', true ) ?>"><i class="_mi _before dashicons dashicons-phone"></i> <?php echo get_user_meta($member->ID, 'phone', true ) ?></a>
          </li>
      <?php endif; ?>
      <?php if(get_user_meta($member->ID, 'email', true )): ?>
          <li class="list-group-item position-relative">
              <a class="stretched-link" href="mailto:<?php echo get_user_meta($member->ID, 'email', true ) ?>"><i class="_mi _before dashicons dashicons-email"></i> <?php echo get_user_meta($member->ID, 'email', true ) ?></a>
          </li>
      <?php endif; ?>
    </ul>
</div>








<?php $locations = tr_field('locations', $company->ID); ?>

<div class="card mt-3">
  <div class="card-header">
    Company
  </div>
  <?php
    $companyID = tr_user_field("company", $member->ID);
    $company = new \App\Models\Company();
    if($companyID){
        $company->findById($companyID)->get();
    }
  ?>

  <ul class="list-group list-group-flush">

    <?php if(!empty($company) && !empty($companyID)): ?>
        <li class="list-group-item position-relative">
            <a class="stretched-link" href="/companies/<?php echo $company->ID ?>">
                <?php echo $company->post_title ?>
            </a>
        </li>
    <?php else: ?>
      <li class="list-group-item">No locations found</li>
    <?php endif; ?>
  </ul>
</div>

