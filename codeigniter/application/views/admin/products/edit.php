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
          <a href="#">Update</a>
        </li>
      </ul>
      
      <div class="page-header">
        <h2>
          Updating <?php
          if ($this->uri->segment(2) == 'products') {echo 'Clinic';}
          else {echo "Food List";}
            ?>
        </h2>
      </div>

 
      <?php
      //flash messages
      if($this->session->flashdata('flash_message')){
        if($this->session->flashdata('flash_message') == 'updated')
        {
          echo '<div class="alert alert-success">';
            echo '<a class="close" data-dismiss="alert">×</a>';
            echo '<strong>Well done!</strong> product updated with success.';
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

      echo form_open('admin/products/update/'.$this->uri->segment(4).'', $attributes);
      ?>
        <fieldset>
            <div class="control-group">
            <label for="inputError" class="control-label">Agency</label>
            <div class="controls">
              <input type="text" id="" name="Agency" value="<?php echo $product[0]['Agency']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="control-group">
            <label for="inputError" class="control-label">Address1</label>
            <div class="controls">
              <input type="text" id="" name="Address1" value="<?php echo $product[0]['Address1']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>  
          <div>
             <div class="control-group">
            <label for="inputError" class="control-label">Address2</label>
            <div class="controls">
              <input type="text" id="" name="Address2" value="<?php echo $product[0]['Address2']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
            <div class="control-group">
            <label for="inputError" class="control-label">PO_Box</label>
            <div class="controls">
              <input type="text" id="" name="PO_Box" value="<?php echo $product[0]['PO_Box']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
            <div class="control-group">
            <label for="inputError" class="control-label">City</label>
            <div class="controls">
              <input type="text" id="" name="City" value="<?php echo $product[0]['City']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
            <div class="control-group">
            <label for="inputError" class="control-label">State</label>
            <div class="controls">
              <input type="text" id="" name="State" value="<?php echo $product[0]['State']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
            <div class="control-group">
            <label for="inputError" class="control-label">Zip Code</label>
            <div class="controls">
              <input type="text" id="" name="Zip_Code" value="<?php echo $product[0]['Zip_Code']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
            <div class="control-group">
            <label for="inputError" class="control-label">Phone Number</label>
            <div class="controls">
              <input type="text" id="" name="Phone" value="<?php echo $product[0]['Phone']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
            <div class="control-group">
            <label for="inputError" class="control-label">Latitude</label>
            <div class="controls">
              <input type="text" id="" name="Latitude" value="<?php echo $product[0]['Latitude']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div>
          <div class="control-group">
            <label for="inputError" class="control-label">Longitude</label>
            <div class="controls">
              <input type="text" id="" name="Longitude" value="<?php echo $product[0]['Longitude']; ?>" >
              <!--<span class="help-inline">Woohoo!</span>-->
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" type="submit">Save changes</button>
            <button class="btn" type="reset">Reset</button>
          </div>
        </fieldset>

      <?php echo form_close(); ?>

    </div>
     