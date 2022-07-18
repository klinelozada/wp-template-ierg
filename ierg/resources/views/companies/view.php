<?php // resources/views/blog/single.php
  $this->layout('main');
?>

<h1><?php echo $company->post_title ?></h1>

<?php $locations = tr_field('locations', $company->ID); ?>

<div class="card mt-3">
  <div class="card-header">
    Locations
  </div>
  <ul class="list-group list-group-flush">
    <?php if(is_array($locations)): ?>
      <?php foreach ( $locations as $location ): ?>
        <li class="list-group-item">
          <div class="card-body">

            <?php $location = array_values($locations)[0]; ?>

            <h5 class="card-title"><?php echo $location['location_name'] ?></h5>

            <h6 class="card-subtitle mb-2 text-muted">
              <?php
                echo $location['address']['address1'];
                echo ($location['address']['address2'] ? ', ' . $location['address']['address2'] : '');
                echo ($location['address']['city'] ? ', ' . $location['address']['city'] : '');
                echo ($location['address']['state'] ? ', ' . $location['address']['state'] : '');
              ?>
            </h6>
            <?php if($location['phone']): ?>
                <div class="phone mt-1"><i class="_mi _before dashicons dashicons-phone"></i> <?php echo $location['phone'] ?></div>
            <?php endif; ?>
            <?php if($location['phone']): ?>
                <div class="email mt-1"><i class="_mi _before dashicons dashicons-email"></i> <?php echo $location['email'] ?></div>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    <?php else: ?>
      <li class="list-group-item">No locations found</li>
    <?php endif; ?>
  </ul>
</div>



<?php
  $members = new WP_User_Query(
    array(
      'meta_key' => 'company',
      'meta_value' => $company->ID
    )
  );
?>

<div class="card mt-3">
  <div class="card-header">
    Members
  </div>
  <ul class="list-group list-group-flush">
    <?php
      if ( ! empty( $members->get_results() ) ) {
        foreach ( $members->get_results() as $user ) {
          echo '<li class="list-group-item position-relative"><a class="stretched-link" href="/members/' .$user->ID. '">' . $user->first_name . ' ' . $user->last_name . '</a></li>';
        }
      } else {
        echo '<li class="list-group-item">No users found</li>';
      }
    ?>
  </ul>
</div>


