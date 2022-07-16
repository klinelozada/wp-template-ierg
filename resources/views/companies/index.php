<?php // resources/views/blog/single.php
  $this->layout('main');
?>

    <form>
        <div class="mb-3">
            <input type="input" class="form-control" placeholder="Search...">
        </div>
    </form>

  <?php foreach($companies as $company): ?>
    <div class="card mt-3">
        <div class="card-body">
            <div class="company">
                <div class="logo"></div>
                <div class="info">
                    <h5 class="card-title"><?php echo $company->post_title ?></h5>

                    <?php $locations = tr_field('locations', $company->ID); ?>

                    <?php if(is_array($locations)): ?>
                        <?php $location = array_values($locations)[0]; ?>

                        <h6 class="card-subtitle mb-2 text-muted">
                          <?php
                            echo $location['address']['address1'];
                            echo ($location['address']['address2'] ? ', ' . $location['address']['address2'] : '');
                            echo ($location['address']['city'] ? ', ' . $location['address']['city'] : '');
                            echo ($location['address']['state'] ? ', ' . $location['address']['state'] : '');
                            ?>
                        </h6>

                        <div class="phone mt-1"><i class="_mi _before dashicons dashicons-phone"></i> <?php echo $location['phone'] ?></div>
                        <div class="email mt-1"><i class="_mi _before dashicons dashicons-email"></i> <?php echo $location['email'] ?></div>
                    <?php endif; ?>

                    <a href="/companies/<?php echo $company->ID ?>" class="btn btn-light stretched-link mt-2">More info</a>

                </div>
            </div>
        </div>
    </div>




  <?php endforeach; ?>