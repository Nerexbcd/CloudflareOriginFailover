<div class="offcanvas offcanvas-end theme-bg-sec" tabindex="-1" id="sidemenu" aria-labelledby="sidemenuLabel" style="width: 240px;">
  <div class="offcanvas-header pb-0 pt-2">
    <h4 class="offcanvas-title theme-text" id="sidemenuLabel">Menu</h4>
    <a href="#" data-bs-dismiss="offcanvas" class="text-decoration-none mx-1"><h3 class="theme-text mt-2"><?= $icons->getIcon('x') ?></i></h3></a>
  </div>
  <style>
    .dropdown-toggle { outline: 0; }
  </style>
  <div class="offcanvas-body theme-text pt-0 d-flex flex-column flex-shrink-0">
    <hr>
      <ul class="nav nav-pills flex-column mb-auto">
        <?php if ($_SESSION['userData']['role'] == "admin") { ?>
          <li class="nav-item">
            <a href="/admin" class="nav-link"><h4 class="theme-text"><span class="align-text-top me-2"><?= $icons->getIcon('layout') ?></span>Dashboard</h4></a> 
          </li>
        <?php }?>
        <li class="nav-item">
          <a href="/" class="nav-link"><h4 class="theme-text"><span class="align-text-top me-2"><?= $icons->getIcon('grid') ?></span>ShowCase</h4></a>
        </li>
        <?php if ($_SESSION['userData']['role'] == "admin") { ?>
        <li class="nav-item">
          <a href="/assets/new" class="nav-link"><h4 class="theme-text"><span class="align-text-top me-2"><?=$icons->getIcon('plus-circle') ?></span>New Asset</h4></a>
        </li>
        <li class="nav-item">
          <a href="/assets" class="nav-link"><h4 class="theme-text"><span class="align-text-top me-2"><?=$icons->getIcon('package') ?></span>Assets</h4></a>
        </li>
        <li class="nav-item">
          <a href="/upload" class="nav-link"><h4 class="theme-text"><span class="align-text-top me-2"><?=$icons->getIcon('upload') ?></span>Upload</h4></a>
        </li>
        <?php }?>
      </ul>
    <hr>
    <div class="dropdown">
      <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle theme-text" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="me-2 rounded-circle border theme-border border-2"><?= $icons->getIcon('user') ?></span>
        <strong class="theme-text"><?=$_SESSION['userData']['username']?></strong>
      </a>
      <ul class="dropdown-menu theme-bg text-small shadow">
        <li><button class="dropdown-item theme-text" onclick="ownPassChange()">Change Password</button></li>
        <li><button class="dropdown-item theme-text" onclick="ownPersonalChange()">Change Personal Info</button></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item theme-text" href="#" data-bs-toggle="modal" data-bs-target="#logoutmodal">Sign out</a></li>
      </ul>
    </div> 
  </div>
</div>



<div class="modal fade" id="logoutmodal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="logoutmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content theme-bg">
            <div class="modal-header">
                <h1 class="modal-title fs-5 theme-text" id="logoutmodalLabel">Are You sure You want to logout?</h1>
            </div>
            <div class="modal-body theme-text">You will need to login again if You want to access the assets!!</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button onclick="logout()" class="btn btn-primary" name="logout">Understood</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ownChangeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ownChangeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content theme-bg">
            <div class="modal-header">
                <h1 class="modal-title fs-5 theme-text" id="ownChangeModalLabel"></h1>
            </div>
            <form id="ownChangeForm" method="post" novalidate>
                <div class="modal-body theme-text">
                  <div id="ownError" class="alert alert-danger" role="alert"></div>
                    <input type="hidden" name="ownMode" id="ownMode">
                    <!-- Change Own Personal Info -->
                    <div id="ownFirst" class="d-none ownModal-section">
                      <div class="mb-3">Changing Your Info to:</div> 
                      <div class="form-floating has-validation mb-3">
                          <input type="text" name="username" id="ownUsername" required maxlength="25" class="form-control" value="<?=$_SESSION['userData']['username']?>">
                          <label for="username" class="">Username: </label>
                          <div class="invalid-feedback">Invalid Username!!</div>
                      </div>
                      <div class="form-floating has-validation mb-3">
                          <input type="text" name="email" id="ownEmail" required pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" maxlength="100" class="form-control" value="<?=$_SESSION['userData']['email']?>">
                          <label for="email" class="">Email: </label>
                          <div class="invalid-feedback">Invalid Email!!</div>
                      </div>
                    </div>
                    <!-- Change Own Password -->
                    <div id="ownSecond" class="d-none ownModal-section">
                      <div class="mb-3">Changing Your password to:</div> 
                      <div class="form-floating has-validation mb-3">
                          <input type="password" name="password" id="ownPassword" required class="form-control">
                          <label for="password" class="">Password: </label>
                          <div class="invalid-feedback">You must write Your Password!!</div>
                      </div>
                      <div class="form-floating has-validation mb-3">
                          <input type="password" name="passwordconf" id="ownPasswordconf" required class="form-control">
                          <label for="passwordconf" class="">Repeat Password: </label>
                          <div class="invalid-feedback">You must write Your Password Confirmation!!</div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Change</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  var ownChangeModal = new bootstrap.Modal("#ownChangeModal");

function logout() {
        fetch("/api/local/logout", {
                method: "POST"
            })
            .then(response => response.json())
            .then(data => {
                if (data["ok"] == true) {
                    window.location.href = "/?showSuccess=" + data['message'];
                } else {
                    window.location.href = "/?showError=" + data['message'];
                }
            });
    }

function ownPersonalChange() {
        resetOwnModal()
        document.getElementById("ownFirst").classList.remove("d-none");
        document.getElementById("ownChangeModalLabel").innerHTML = "Changing own Personal Info";
        document.getElementById("ownUsername").disabled = false;
        document.getElementById("ownEmail").disabled = false;
        document.getElementById("ownMode").value = "personalChange";
        ownChangeModal.show();
    }

    function ownPassChange() {
        resetOwnModal()
        document.getElementById("ownSecond").classList.remove("d-none");
        document.getElementById("ownChangeModalLabel").innerHTML = "Changing own Password";
        document.getElementById("ownPassword").disabled = false;
        document.getElementById("ownPasswordconf").disabled = false;
        document.getElementById("ownMode").value = "passChange";
        ownChangeModal.show();
    }

    document.getElementById("ownChangeForm").addEventListener("submit", function (event) {
        event.preventDefault();
        event.stopPropagation();
        var form = document.getElementById("ownChangeForm");
        form.classList.add('was-validated');
        if (form.checkValidity()) {
            var formData = new FormData(form);
            var command = "";
            switch (formData.get("ownMode")) {
                case "personalChange":
                    command = "<?=$_SESSION['userData']['id']?>" + "/changePersonalInfo";
                    break;
                case "passChange":
                    command = "<?=$_SESSION['userData']['id']?>" + "/changePassword";
                    break;
            }

            fetch("/api/users/" + command, {
                        method: "POST",
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        
                        if (data["ok"] == true) {
                            ownChangeModal.hide();
                            fetch("/api/local/refresh", {})
                        } else {
                            document.getElementById("ownError").innerHTML = data["message"];
                            document.getElementById("ownError").classList.remove("d-none");
                        }
                    });
        }
        
    });

    function resetOwnModal(){
        document.getElementById("ownUsername").disabled = true;
        document.getElementById("ownEmail").disabled = true;
        document.getElementById("ownPassword").disabled = true;
        document.getElementById("ownPasswordconf").disabled = true;
        document.getElementById("ownError").classList.add("d-none");
        document.getElementById("ownMode").value = "";
        var sections = document.getElementsByClassName("ownModal-section");
        for (var i = 0; i < sections.length; i++) {
            if (!sections[i].classList.contains("d-none")) {
                sections[i].classList.add("d-none");
            }
        }
    }
</script>