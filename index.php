<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

</head>

<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h4>Students</h4>
                            </div>
                            <div class="col-6 text-end">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                                    Add Student
                                </button>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">
                        <table class="table table-bordered m-0" id="table">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Name</th>
                                    <th>Duration</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody id="tbody">
                                <tr>
                                    <td>1</td>
                                    <td>ali</td>
                                    <td>ali@gmail.com</td>
                                    <td>Date</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                            Edit
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="alert alert-danger m-0 d-none" id="alert-msg"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php require_once('./partials/modals.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

    <script>
        const addFormElement = document.querySelector("#add-form");

        addFormElement.addEventListener("submit", function(e) {
            e.preventDefault();

            const addAlertElement = document.querySelector("#add-alert");
            const addNameElement = document.querySelector("#add-name");
            const addEmailElement = document.querySelector("#add-email");

            let addNameValue = addNameElement.value;
            let addEmailValue = addEmailElement.value;

            addNameElement.classList.remove('is-invalid');
            addEmailElement.classList.remove('is-invalid');
            addAlertElement.innerHTML = "";

            if (addNameValue == "") {
                addNameElement.classList.add('is-invalid');
                addAlertElement.innerHTML = alertMaker('danger', 'Enter the name!');
            } else if (addEmailValue == "") {
                addEmailElement.classList.add('is-invalid');
                addAlertElement.innerHTML = alertMaker('danger', 'Enter the email!');
            } else {
                const data = {
                    name: addNameValue,
                    email: addEmailValue,
                    submit: 1,
                }

                fetch('./add-student.php', {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {
                            'Content-Type': 'application.json'
                        }
                    })
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(result) {
                        if (result.errorName) {
                            addNameElement.classList.add('is-invalid');
                            addAlertElement.innerHTML = alertMaker('danger', result.errorName);
                        } else if (result.errorEmail) {
                            addEmailElement.classList.add('is-invalid');
                            addAlertElement.innerHTML = alertMaker('danger', result.errorEmail);
                        } else if (result.failure) {
                            addAlertElement.innerHTML = alertMaker('danger', result.failure);
                        } else if (result.success) {
                            addAlertElement.innerHTML = alertMaker('success', result.success);
                        } else {
                            addAlertElement.innerHTML = alertMaker('danger', 'Something went wrong!');
                        }
                    })
            }
        });

        function alertMaker(cls, msg) {
            return `<div class="alert alert-${cls} alert-dismissible fade show" role="alert">${msg}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>`;
        }
    </script>

</body>

</html>