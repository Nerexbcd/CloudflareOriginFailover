<div class="py-5">
    <div id="scrollableArea" class="container overflow-hidden overflow-y-scroll" data-simplebar>
        <div class="border rounded-5 border-3 overflow-hidden theme-bg-sec theme-text theme-border">
            <div class="px-3 pt-1 border-bottom border-3 theme-border">
                <h3 class="theme-text">Admin Dashboard</h3>
            </div>
            <div class="px-3 pt-1 border-3 border-bottom theme-border d-flex justify-content-between">
                <h4 class="theme-text">User Management</h4>
                <a onclick="userAdd()" class="theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Add User"><?= $icons->getIcon('user-plus') ?></a>
            </div>
            <div class="overflow-y-auto px-0 border-3 border-bottom theme-border" style="max-height: 250px;" data-simplebar>
                <table id="userTable" class="table table-bordered mb-0 theme-border">
                    <thead>
                        <tr class="d-flex">
                            <th scope="col" class="col-4 col-md-2 text-center theme-bg-sec theme-text">Username</th>
                            <th scope="col" class="d-none d-md-block col-4 text-center theme-bg-sec theme-text">Email</th>
                            <th scope="col" class="col-3 col-md-2 text-center theme-bg-sec theme-text">Role</th>
                            <th scope="col" class="col-5 col-md-4 text-center theme-bg-sec theme-text">Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Added via API -->
                    </tbody>
                </table>
            </div>
            <div class="px-3 pt-1 border-3 border-bottom theme-border">
                <h4 class="theme-text">Asset Log</h4>
            </div>
            <div class="overflow-y-auto px-0 border-3 border-bottom theme-border" style="max-height: 250px;" data-simplebar>
                <table class="table table-bordered mb-0 theme-border">
                    <thead>
                        <tr class="d-flex">
                            <th scope="col" class="col-3 col-md-2 text-center theme-bg-sec theme-text">Id</th>
                            <th scope="col" class="col-5 col-md-4 text-center theme-bg-sec theme-text">Name</th>
                            <th scope="col" class="d-none d-md-block col-4 text-center theme-bg-sec theme-text">Author</th>
                            <th scope="col" class="col-4 col-md-2 text-center theme-bg-sec theme-text">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach (listAssets() as $asset) {
                                echo '<tr class="d-flex">';
                                echo '<th scope="row" class="col-3 col-md-2 theme-text theme-bg-sec text-center"><a href="/assets/show/?assetId=' . convertAssetToHuman($asset['category'],$asset['id']) . '">' . convertAssetToHuman($asset['category'],$asset['id']) . '</a></th>';
                                echo '<td class="col-5 col-md-4 theme-text theme-bg-sec">' . $asset['name'] . '</td>';
                                echo '<td class="d-none d-md-block col-4 theme-text theme-bg-sec">' . $asset['author'] . '</td>';
                                echo '<td class="col-4 col-md-2 theme-text theme-bg-sec">' . $asset['createdAt'] . '</td>';
                                echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="userDelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userDelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content theme-bg">
            <div class="modal-header">
                <h1 class="modal-title fs-5 theme-text" id="userDelModalLabel">Delete User</h1>
            </div>
            <form method="post" id="userDelForm">
                <input type="hidden" name="userId" id="delUserId">
                <div class="modal-body theme-text">
                    <div id="deleteUsername" class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="changeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content theme-bg">
            <div class="modal-header">
                <h1 class="modal-title fs-5 theme-text" id="changeModalLabel"></h1>
            </div>
            <form id="changeForm" method="post" novalidate>
                <input type="hidden" name="mode" id="mode">
                <input type="hidden" name="userId" id="userId">
                <div class="modal-body theme-text">
                    <div id="error" class="alert alert-danger d-none" role="alert"></div>
                    <!-- User Add || Personal Data Change -->
                    <div id="first" class="modal-section d-none">
                        <div class="form-floating has-validation mb-3">
                            <input type="text" name="username" id="username" required maxlength="25" class="form-control">
                            <label for="username" class="">Username: </label>
                            <div class="invalid-feedback">Invalid Username!!</div>
                        </div>
                        <div class="form-floating has-validation mb-3">
                            <input type="text" name="email" id="email" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" maxlength="100" class="form-control">
                            <label for="email" class="">Email: </label>
                            <div class="invalid-feedback">Invalid Email!!</div>
                        </div>
                    </div>
                    <!-- User Add || Role Change -->
                    <div id="second" class="modal-section d-none">
                    
                        <div class="form-floating mb-3">
                            <select name="role" id="role" class="form-control">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                            <label for="role">Role:</label>
                        </div>  
                    </div>  
                    <!-- User Add || Pass Change -->
                    <div id="third" class="modal-section d-none">
                        <div class="form-floating has-validation mb-3">
                            <input type="password" name="password" id="password" required class="form-control">
                            <label for="password" class="">Password: </label>
                            <div class="invalid-feedback">You must write Your Password!!</div>
                        </div>
                        <div class="form-floating has-validation mb-3">
                            <input type="password" name="passwordconf" id="passwordconf" required class="form-control">
                            <label for="passwordconf" class="">Repeat Password: </label>
                            <div class="invalid-feedback">You must write Your Password Confirmation!!</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="changeModalSubmit">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
loadUsers()

var changeModal = new bootstrap.Modal("#changeModal");
var userDelModal = new bootstrap.Modal("#userDelModal");

function loadUsers() {
    fetch("/api/users")
    .then(response => response.json())
    .then(data => {
        var table = document.querySelector("#userTable tbody");
        table.innerHTML = "";
        data['users'].forEach(user => {
            table.innerHTML += 
            '<tr class="d-flex">' +
                '<th scope="row" class="col-4 col-md-2 theme-text theme-bg-sec">' + user["username"] + '</th>' +
                '<td class="d-none d-md-block col-4 theme-text theme-bg-sec">' + user["email"] + '</td>' +
                '<td class="col-3 col-md-2 theme-text theme-bg-sec">' + user["role"] + '</td>' +
                '<td class="col-5 col-md-4 d-flex justify-content-evenly theme-bg-sec">' +
                    '<a onclick="personalChange(' + user['id'] + ')" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Change Username or Email"><?=$icons->getIcon('user') ?></a>' +
                    '<a onclick="passChange(' + user['id'] + ')" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Change Password"><?=$icons->getIcon('terminal') ?></a>' +
                    '<a onclick="roleChange(' + user['id'] + ')" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Change Role"><?=$icons->getIcon('shield') ?></a>' +
                    '<a onclick="userDel(' + user['id'] + ')" class="text-decoration-none theme-text" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete User"><?=$icons->getIcon('trash-2') ?></a>' +
                '</td>' +
            '</tr>';

        });
    });
}

function userAdd() {
    resetModal()
    document.getElementById("first").classList.remove("d-none");
    document.getElementById("second").classList.remove("d-none");
    document.getElementById("third").classList.remove("d-none");
    document.getElementById("changeModalLabel").innerHTML = "Adding User";
    document.getElementById("changeModalSubmit").innerHTML = "Create";
    document.getElementById("username").disabled = false;
    document.getElementById("email").disabled = false;
    document.getElementById("role").disabled = false;
    document.getElementById("password").disabled = false;
    document.getElementById("passwordconf").disabled = false;
    document.getElementById("mode").value = "userAdd";
    document.getElementById("userId").disabled = true;
    changeModal.show();
}

function personalChange(id) {
    resetModal()
    document.getElementById("first").classList.remove("d-none");
    document.getElementById("changeModalLabel").innerHTML = "Changing User Personal Info";
    document.getElementById("username").disabled = false;
    document.getElementById("email").disabled = false;
    loadModal(id);
    document.getElementById("mode").value = "personalChange";
    changeModal.show();
}

function passChange(id) {
    resetModal()
    document.getElementById("third").classList.remove("d-none");
    document.getElementById("changeModalLabel").innerHTML = "Changing User Password";
    document.getElementById("password").disabled = false;
    document.getElementById("passwordconf").disabled = false;
    loadModal(id);
    document.getElementById("mode").value = "passChange";
    changeModal.show();
}

function roleChange(id) {
    
    resetModal()
    document.getElementById("second").classList.remove("d-none");
    document.getElementById("changeModalLabel").innerHTML = "Changing User Role";
    document.getElementById("role").disabled = false;
    loadModal(id);
    document.getElementById("mode").value = "roleChange";
    changeModal.show();
}

function userDel(id) {
    fetch("/api/users/" + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById("deleteUsername").innerHTML = 'Are You sure You want to delete the account: ' + data["username"];
        });

    document.getElementById("delUserId").value = id;
    userDelModal.show();
}

function loadModal(id) {
    document.getElementById("userId").value = id;
    fetch("/api/users/" + id)
        .then(response => response.json())
        .then(data => {
            document.getElementById("username").value = data["username"];
            document.getElementById("email").value = data["email"];
            document.getElementById("role").value = data["role"];
        });
}

function resetModal(){
    document.getElementById("username").disabled = true;
    document.getElementById("email").disabled = true;
    document.getElementById("role").disabled = true;
    document.getElementById("password").disabled = true;
    document.getElementById("passwordconf").disabled = true;
    document.getElementById("error").classList.add("d-none");
    document.getElementById("userId").disabled = false;
    document.getElementById("username").value = "";
    document.getElementById("email").value = "";
    document.getElementById("role").value = "user";
    document.getElementById("password").value = "";
    document.getElementById("passwordconf").value = "";
    document.getElementById("mode").value = "";
    var sections = document.getElementsByClassName("modal-section");
    for (var i = 0; i < sections.length; i++) {
        if (!sections[i].classList.contains("d-none")) {
            sections[i].classList.add("d-none");
        }
    }
}

var changeForm = document.getElementById("changeForm");

changeForm.addEventListener("submit", function (event) {
    event.preventDefault();
    event.stopPropagation();
    changeForm.classList.add('was-validated');
    if (changeForm.checkValidity()) {
        var formData = new FormData(changeForm);
        var command = "";
        switch (formData.get("mode")) {
            case "userAdd":
                command = "add";
                break;
            case "personalChange":
                command = formData.get("userId") + "/changePersonalInfo";
                break;
            case "passChange":
                command = formData.get("userId") + "/changePassword";
                break;
            case "roleChange":
                command = formData.get("userId") + "/changeRole";
                break;
        }

        fetch("/api/users/" + command, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            
            if (data["ok"] == true) {
                loadUsers();
                changeModal.hide();
            } else {
                document.getElementById("error").innerHTML = data["message"];
                document.getElementById("error").classList.remove("d-none");
            }
        });
    }
    
});

var userDelForm = document.getElementById("userDelForm");

userDelForm.addEventListener("submit", function (event) {
    event.preventDefault();
    event.stopPropagation();
    var formData = new FormData(userDelForm);

    fetch("/api/users/" + formData.get("userId") + "/delete", {
        method: "POST",
    })
    .then(response => response.json())
    .then(data => {  
        if (data["ok"] == true) {
            loadUsers();
            userDelModal.hide();
        }
    });
    
});
</script>