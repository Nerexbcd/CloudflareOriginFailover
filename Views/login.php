<div class="container py-5 px-5">
    <div class="row">
        <div class="col"></div>
        <div class="col-lg-5 col-xl border rounded-5 border-3 overflow-hidden theme-bg-sec theme-text theme-border p-0">
            <div class="px-3 pt-1 border-bottom border-3 theme-border">
                <h3 class="theme-text">Login</h3>
            </div>
            <div class="px-3 pt-3 border-bottom border-3 theme-border">
                <form id="loginForm" method="post" novalidate>
                    <div class="form-floating has-validation mb-3">
                        <input type="text" name="input" id="email" required class="form-control">
                        <label for="input">Email or Username: </label>
                        <div class="invalid-feedback">You must write Your Email!!</div>
                    </div>
                    <div class="form-floating has-validation mb-3">
                        <input type="password" name="password" id="password" required class="form-control">
                        <label for="password">Password: </label>
                        <div class="invalid-feedback">You must write Your Password!!</div>
                    </div>
            </div>
            <div class="p-3 d-flex justify-content-between align-items-center">
                    <input class="btn btn-primary" type="submit" name="login" id="sbm-bt" value="Login">
                    <a href="/password-recovery">Forgot Password?</a>
                </form>
            </div>
        </div>
        <div class="col"></div>
    </div>
</div>


<script>

    var loginForm = document.getElementById("loginForm");
    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        event.stopPropagation();
        loginForm.classList.add('was-validated');
        if (loginForm.checkValidity()) {
            var formData = new FormData(loginForm);

            fetch("/api/local/login", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                
                if (data["ok"] == true) {
                    window.location.href = "/?showSuccess=" + data['message'];
                } else {
                    document.getElementById("showErrorText").innerHTML = data['message'];
                    document.getElementById("showError").classList.remove("d-none");
                }
            });
        }
        
    });
</script>