<div class="form-group">
    <label for="name">Name</label>
    <input type="text" class="form-control" name="name" value="<?= $user['name']; ?>">
</div>
<div class="form-group">
    <label for="email">Email</label>
    <input type="text" class="form-control" name="email" value="<?= $user['email']; ?>">
</div>
<div class="form-group">
    <label for="mobile_number">Mobile Number</label>
    <input type="text" class="form-control" name="mobile_number" value="<?= $user['mobile_number']; ?>">
</div>
<div class="form-group">
    <label for="gender">Gender</label>
    <input type="radio" name="gender" value="Male" <?= strtolower($user['gender']) == 'male'? 'checked' : ''; ?>> Male
    <input type="radio" name="gender" value="Female" <?= strtolower($user['gender']) == 'female'? 'checked' : ''; ?>> Female
</div>
<div class="form-group">
    <label for="dob">Date of Birth</label>
    <input type="date" class="form-control" name="dob" value="<?= $user['dob']; ?>">
</div>
<div class="form-group">
    <label for="age">Age</label>
    <select class="form-control" name="age">
        <?php for ($i = 20; $i <= 100; $i++){ ?>
            <option value="<?php echo $i; ?>" <?php $user['age'] == $i? 'selected' : ''; ?>><?php echo $i; ?></option>
        <?php } ?>
    </select>
</div>
<div class="form-group">
    <label for="address">Addresses</label>
    <div id="addresses">
    <?php foreach ($addresses as $index => $address){ ?>
        <div class="address">
            <input type="text" class="form-control" name="addresses[<?php echo $index; ?>][address]" value="<?php echo $address['address']; ?>" placeholder="Address">
            <input type="text" class="form-control" name="addresses[<?php echo $index; ?>][city]" value="<?php echo $address['city']; ?>" placeholder="City">
            <input type="text" class="form-control" name="addresses[<?php echo $index; ?>][state]" value="<?php echo $address['state']; ?>" placeholder="State">
            <input type="text" class="form-control" name="addresses[<?php echo $index; ?>][pincode]" value="<?php echo $address['pincode']; ?>" placeholder="Pincode">
        </div>
    <?php } ?>
    </div>
    <button type="button" id="addAddress" class="btn btn-secondary">Add Address</button>
</div>

<script>
    var addressIndex = <?php echo count($addresses); ?>;

    $('#addAddress').click(function() {
        $('#addresses').append('<div class="address">' +
            '<input type="text" class="form-control" name="addresses[' + addressIndex + '][address]" placeholder="Address">' +
            '<input type="text" class="form-control" name="addresses[' + addressIndex + '][city]" placeholder="City">' +
            '<input type="text" class="form-control" name="addresses[' + addressIndex + '][state]" placeholder="State">' +
            '<input type="text" class="form-control" name="addresses[' + addressIndex + '][pincode]" placeholder="Pincode">' +
        '</div>');
        addressIndex++;
    });
</script>
