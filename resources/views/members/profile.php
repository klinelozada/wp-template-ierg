<?php // resources/views/blog/single.php
  $this->layout('main');
  $current_user = wp_get_current_user();
?>

<form>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">First Name</label>
        <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $current_user->first_name ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Last Name</label>
        <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $current_user->last_name ?>">
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Phone</label>
        <input type="input" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo tr_user_field("phone"); ?>">
    </div>
    <div class="mb-3">
      <label for="exampleInputEmail1" class="form-label">Email address</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="<?php echo $current_user->user_email ?>">
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Address</label>
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo tr_user_field("address"); ?></textarea>
    </div>

    <p>Notify me when news is posted to the following categories:</p>
      <?php
      $cats = get_categories();
      foreach($cats as $cat){
  //        var_dump($cat);
        echo '<div class="mb-3 form-check">';
        echo '<input type="checkbox" class="form-check-input"><label class="form-check-label" for="exampleCheck1">' . $cat->name.'</label>';
        echo '</div>';
      }
      ?>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>



<?php
//  $form = tr_form();
//
//
//  echo $form->open();
//  echo $form->text('Number');
//  echo $form->text('Price');
//  echo $form->submit('Update Seat');
//  echo $form->close(); ?>