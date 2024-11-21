<div class="container py-5">
    <div class="row">
        <div class="col"></div>
        <div class="col-lg-5 col-xl">
            <h3 class="theme-text">Setup</h3>
            <form method="post" class="needs-validation" novalidate>
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
                <input type="hidden" name="setupUser">
                <input class="btn btn-primary" type="submit" value="Create First Account" id="sbm-bt">
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>