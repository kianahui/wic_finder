    <div class="container top">
      
      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li>
          <a href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>">
            <?php
          if ($this->uri->segment(2) == 'products') {echo 'Clinics';}
          else {echo "Food Lists";}
            ?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <a href="#">New</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Adding <?php
          if ($this->uri->segment(2) == 'products') {echo 'Clinic';}
          else {echo "Food List";}
            ?>
        </h2>
      </div>
 
      <?php
      //flash messages
      if(isset($flash_message)){
        if($flash_message == TRUE)
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> new product created with success.';
          echo '</div>';       
        }else{
          echo '<div class="alert alert-error">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Oh snap!</strong> change a few things up and try submitting again.';
          echo '</div>';          
        }
      }
      ?>
      
      <?php
      //form data
      $attributes = array('class' => 'form-horizontal', 'id' => '');

      //form validation
      echo validation_errors();
      
      echo form_open('admin/products/add', $attributes);
      ?>
        <fieldset>
          <div class="control-group">
            <label for="inputError" class="control-label">Agency</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Address1</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>  
             <div class="control-group">
            <label for="inputError" class="control-label">Address2</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
            <div class="control-group">
            <label for="inputError" class="control-label">PO_Box</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
            <div class="control-group">
            <label for="inputError" class="control-label">City</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
            <div class="control-group">
            <label for="inputError" class="control-label">State</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            <div class="control-group">
            <label for="inputError" class="control-label">Zip Code</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Phone Number</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
            <div class="control-group">
            <label for="inputError" class="control-label">Latitude</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Longitude</label>
            <div class="controls">
              <input type="text" id="" name="description" value="<?php echo set_value('description'); ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          </div>
          </div>
          </div>
            </div>
          </div>
          </div>
          </div>
          </div>       
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Cancel</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     