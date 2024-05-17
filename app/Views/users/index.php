<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <style>
        .error {color: red;}
    </style>
</head>
<body>
    <div class="container">
         <?php if (session()->has('errors')){ ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach (session('errors') as $error){ ?>
                        <li><?php echo $error; ?></li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
        <h1>User Management</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">Add User</button>
        <form action="<?php echo site_url('users/search'); ?>" method="post">
            <input type="text" name="search" placeholder="Search" class="form-control">
            <button type="submit" class="btn btn-secondary">Search</button>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Age</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user){ ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['email']; ?></td>
                    <td><?php echo $user['mobile_number']; ?></td>
                    <td><?php echo $user['gender']; ?></td>
                    <td><?php echo $user['dob']; ?></td>
                    <td><?php echo $user['age']; ?></td>
                    <td>
                        <button class="btn btn-warning editUser" data-id="<?php echo $user['id_user']; ?>">Edit</button>
                        <button class="btn btn-danger deleteUser" data-id="<?php echo $user['id_user']; ?>">Delete</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <?= $pager->links() ?>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="addUserForm" method="POST" action="<?php echo site_url('users/create'); ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <label for="mobile_number">Mobile Number</label>
                            <input type="text" class="form-control" name="mobile_number">
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <input type="radio" name="gender" value="Male"> Male
                            <input type="radio" name="gender" value="Female"> Female
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" name="dob">
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <select class="form-control" name="age">
                                <?php for ($i = 20; $i <= 100; $i++): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Addresses</label>
                            <div id="addresses">
                                <div class="address">
                                    <input type="text" class="form-control" name="addresses[0][address]" placeholder="Address">
                                    <input type="text" class="form-control" name="addresses[0][city]" placeholder="City">
                                    <input type="text" class="form-control" name="addresses[0][state]" placeholder="State">
                                    <input type="text" class="form-control" name="addresses[0][pincode]" placeholder="Pincode">
                                </div>
                            </div>
                            <button type="button" id="addAddress" class="btn btn-secondary">Add Address</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="editUserForm" method="POST" action="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- The form fields will be populated via jQuery -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Yes</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var addressIndex = 1;

            $('#addAddress').click(function() {
                $('#addresses').append('<div class="address">' +
                    '<input type="text" class="form-control" name="addresses[' + addressIndex + '][address]" placeholder="Address">' +
                    '<input type="text" class="form-control" name="addresses[' + addressIndex + '][city]" placeholder="City">' +
                    '<input type="text" class="form-control" name="addresses[' + addressIndex + '][state]" placeholder="State">' +
                    '<input type="text" class="form-control" name="addresses[' + addressIndex + '][pincode]" placeholder="Pincode">' +
                '</div>');
                addressIndex++;
            });

            // Handle Edit button click
            $('.editUser').click(function() {
                var userId = $(this).data('id');
                $.ajax({
                    url: '<?php echo site_url('users/edit/'); ?>' + userId,
                    method: 'GET',
                    success: function(response) {
                        $('#editUserForm .modal-body').html(response);
                        $('#editUserForm').attr('action', '<?php echo site_url('users/edit/'); ?>' + userId);
                        $('#editUserModal').modal('show');
                    }
                });
            });

            // Handle Delete button click
            $('.deleteUser').click(function() {
                var userId = $(this).data('id');
                $('#confirmDelete').data('id', userId);
                $('#deleteUserModal').modal('show');
            });

            // Confirm Delete
            $('#confirmDelete').click(function() {
                var userId = $(this).data('id');
                window.location.href = '<?php echo site_url('users/delete/'); ?>' + userId;
            });

            // jQuery validation
            $('#addUserForm').validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    mobile_number: {
                        required: true,
                        maxlength: 10
                    },
                    gender: "required",
                    dob: "required",
                    age: {
                        required: true,
                        number: true,
                        min: 20,
                        max: 100
                    }
                }
            });

            $('#editUserForm').validate({
                rules: {
                    name: "required",
                    email: {
                        required: true,
                        email: true
                    },
                    mobile_number: {
                        required: true,
                        maxlength: 10
                    },
                    gender: "required",
                    dob: "required",
                    age: {
                        required: true,
                        number: true,
                        min: 20,
                        max: 100
                    }
                }
            });
        });
    </script>
</body>
</html>
