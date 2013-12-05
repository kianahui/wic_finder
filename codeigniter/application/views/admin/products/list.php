    <div class="container top">

      <ul class="breadcrumb">
        <li>
          <a href="<?php echo site_url("admin"); ?>">
            <?php echo ucfirst($this->uri->segment(1));?>
          </a> 
          <span class="divider">/</span>
        </li>
        <li class="active">
          <?php
          if ($this->uri->segment(2) == 'products') {echo 'Clinics';}
          else {echo "Food Lists";}
            ?>

        </li>
      </ul>

      <div class="page-header users-header">
        <h2>
          <?php
          if ($this->uri->segment(2) == 'products') {echo 'Clinics';}
          else {echo "Food Lists";}
            ?>
          <a  href="<?php echo site_url("admin").'/'.$this->uri->segment(2); ?>/add" class="btn btn-success">Add a new</a>
        </h2>
      </div>
      
      <div class="row">
        <div class="span12 columns">
          <div class="well">
           
            <?php
           
            $attributes = array('class' => 'form-inline reset-margin', 'id' => 'myform');
           
            //save the columns names in a array that we will use as filter         
            $options_products = array();    
            foreach ($products as $array) {
              foreach ($array as $key => $value) {
                $options_products[$key] = $key;
              }
              break;
            }

            echo form_open('admin/products', $attributes);
     
              echo form_label('Search:', 'search_string');
              echo form_input('search_string', $search_string_selected, 'style="width: 170px;
height: 26px;"');

              echo form_label('Order by:', 'order');
              echo form_dropdown('order', $options_products, $order, 'class="span2"');

              $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary', 'value' => 'Go');

              $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
              echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="span1"');

              echo form_submit($data_submit);

            echo form_close();
            ?>

          </div>

          <table class="table table-striped table-bordered table-condensed">
            <thead>
              <tr>
                <th class="header">#</th>
                <th class="yellow header headerSortDown">Agency</th>
                <th class="red header">Address1</th>
                <th class="red header">Address2</th>
                <th class="red header">PO_Box</th>
                <th class="red header">City</th>
                <th class="red header">State</th>
                <th class="red header">Zip_Code</th>
                <th class="red header">Latitude</th>
                <th class="red header">Longitude</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($products as $row)
              {
                echo '<tr>';
                echo '<td>'.$row['id'].'</td>';
                echo '<td>'.$row['Agency'].'</td>';
                echo '<td>'.$row['Address1'].'</td>';
                echo '<td>'.$row['Address2'].'</td>';
                echo '<td>'.$row['PO_Box'].'</td>';
                echo '<td>'.$row['City'].'</td>';
                echo '<td>'.$row['State'].'</td>';
                echo '<td>'.$row['Zip_Code'].'</td>';
                echo '<td>'.$row['Latitude'].'</td>';
                echo '<td>'.$row['Longitude'].'</td>';
                echo '<td class="crud-actions">
                  <a href="'.site_url("admin").'/products/update/'.$row['id'].'" class="btn btn-info">view & edit</a>  
                  <a href="'.site_url("admin").'/products/delete/'.$row['id'].'" class="btn btn-danger">delete</a>
                </td>';
                echo '</tr>';
              }
              ?>      
            </tbody>
          </table>

          <?php echo '<div class="pagination">'.$this->pagination->create_links().'</div>'; ?>

      </div>
    </div>