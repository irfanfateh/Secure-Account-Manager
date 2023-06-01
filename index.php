<?php
require_once('logic.php');
if (isset($_POST['add'])) {
        $msg = add($_POST);
} else if (isset($_POST['find'])) {
    $accounts = find($_POST);
    if (array_key_exists('error', $accounts)) {
        $findMsg = $accounts['error'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts Vault</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script>
        window.onload = function() {
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }
        };
    </script>
</head>

<body>
    <div class="container">
        <h1 class="text-center mt-3">Accounts Vault</h1>
        <div class="row">
            <div class="col-lg-4 mt-3 border p-4">
                <form method="POST" action="" id="addForm">
                    <?php if (isset($msg)) { ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Hey!</strong> <?php echo $msg; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php } ?>
                    <div class="mb-3">
                        <label for="master" class="form-label">Master Password</label>
                        <input type="password" class="form-control" name="master_pass" id="master" required>
                    </div>
                    <div class="mb-3">
                        <label for="platform" class="form-label">Platform</label>
                        <input type="text" class="form-control" name="platform" id="platform" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="text" class="form-control" name="password" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" id="okBtn" name="add" value="add">OK</button>
                </form>
            </div>

            <div class="col-lg-8 mt-3">
                <?php if (isset($findMsg)) { ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Hey!</strong> <?php echo $findMsg; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <form action="" method="POST" class="d-md-flex">

                    <div class="mb-3 mx-2">
                        <label for="f_master" class="form-label">Master Password</label>
                        <input type="password" class="form-control" name="master_pass" id="f_master" required>
                    </div>
                    <div class="mb-3 mx-2">
                        <label for="f_platform" class="form-label">Platform</label>
                        <input type="text" name="platform" class="form-control" id="f_platform" required>
                    </div>
                    <div class="mt-md-4">
                        <button type="submit" class="btn btn-primary mt-2" name="find" value="find">Find</button>
                    </div>
                </form>
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Platform</th>
                                <th scope="col">Username</th>
                                <th scope="col">Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $logs = [];
                            if (isset($accounts)) {
                                if (!array_key_exists('error', $accounts)) {
                                    foreach ($accounts as $key => $account) { ?>
                                        <tr class="dataRow">
                                            <td class="pt-3"><?php echo $_POST['platform']; ?></td>
                                            <td class="pt-3"><?php echo $account['username']; ?></td>
                                            <td class="pt-3"><?php echo $account['password']; ?></td>
                                            <td class="pt-3"><button class="btn btn-warning edit" data-bs-whatever='<?php echo $key; ?>'>Update</button></td>
                                        </tr>
                            <?php }
                                }
                            }
                            ?>

                            <!-- Add more rows if needed -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        // Get all elements with the specified class name
        var elements = document.getElementsByClassName('edit');

        // Iterate over the elements
        for (var i = 0; i < elements.length; i++) {
            // Add event listener to each element
            elements[i].addEventListener('click', function(event) {
                var addForm = document.getElementById('addForm');
                // Fetch the existing values from the table row
                var tableRow = event.target.closest('.dataRow');
                var tableCells = tableRow.querySelectorAll('td');
                // Assign the values from table cells to the corresponding input fields
                document.getElementById('okBtn').value = event.target.getAttribute('data-bs-whatever');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'platform');
                hiddenInput.setAttribute('value', tableCells[1].value);

                // Append the hidden input field to the form
                addForm.appendChild(hiddenInput);

                var inputs = addForm.querySelectorAll('input');
                inputs[1].disabled = true;
                assignValuesToInputs(tableCells, inputs);
            });
        }

        function assignValuesToInputs(tableCells, inputs) {
            for (var i = 0; i < tableCells.length; i++) {
                var value = tableCells[i].textContent.trim();
                //there we are adding 1 because we want to skip master password field
                if (i + 1 == tableCells.length) {
                    inputs[inputs.length - 1].value = inputs[1].value;
                } else {
                    inputs[i + 1].value = value;
                }
            }

        }
    </script>
</body>

</html>