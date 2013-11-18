<h2>Add A New Wic Center</h2>

<?php echo validation_errors(); ?>

<?php echo form_open('wic/new_clinic') ?>

	<label for="Agency">Agency</label>
	<input type="input" name="Agency" /><br />

        <label for="Address1">Address1</label>
        <input type="input" name="Address1" /><br />

        <label for="Address2">Address2</label>
        <input type="input" name="Address2" /><br />

        <label for="POBox">POBox</label>
        <input type="input" name="POBox" /><br />

        <label for="City">City</label>
        <input type="input" name="City" /><br />

        <label for="State">State</label>
        <input type="input" name="State" /><br />

        <label for="ZipCode">ZipCode</label>
        <input type="input" name="ZipCode" /><br />

        <label for="Phone">Phone</label>
        <input type="input" name="Phone" /><br />

        <label for="Link">Link</label>
        <input type="input" name="Link" /><br />
	
	<input type="submit" name="submit" value="Add New Center" />

</form>
