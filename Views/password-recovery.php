<div class="container py-5 px-5">
    <div class="row">
        <div class="col"></div>
        <div class="col-lg-5 col-xl border rounded-5 border-3 overflow-hidden theme-bg-sec theme-text theme-border p-0">
            <div class="px-3 pt-1 border-bottom border-3 theme-border">
                <h3 class="theme-text">Password Recovery</h3>
            </div>
            <div id="secondRecoveryMsg" class="d-none">
                <div class="px-3 pt-3 border-bottom border-3 theme-border">
                    <p id="theMsg" class="theme-text"></p>
                </div>
                <div class="px-3 pt-3 border-bottom border-3 theme-border">
                    <p id="expMsg" class="theme-text"> </p>
                </div>
            </div>
            <form id="recoveryForm" method="post" novalidate>
                <div class="px-3 pt-3 border-bottom border-3 theme-border">
                    <div class="form-floating has-validation mb-3">
                        <input type="text" name="email" id="email" required class="form-control" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" value="<?=$_POST['email']?>">
                        <label for="email" class="">Email Address: </label>
                        <div class="invalid-feedback">Invalid Email Address!!</div>
                    </div>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center flex-row-reverse">
                    <button class="btn btn-primary" type="submit">Send Recovery Email</button>
                </div>
            </form>
            <form id="confirmRecoveryForm" method="post" class="d-none" novalidate>
                <div class="px-3 pt-3 border-bottom border-3 theme-border">
                    <div class="form-floating has-validation mb-3">
                        <input type="text" name="confCode" id="confCode" required class="form-control" maxlength="6" pattern="[0-9]{6}">
                        <label for="confCode" class="">Confirmation Code: </label>
                        <div class="invalid-feedback">Invalid Confirmation Code!!</div>
                    </div>
                </div>
                <div class="p-3 d-flex justify-content-between align-items-center flex-row-reverse">
                    <button class="btn btn-primary" type="submit">Recover Account</button>
                    <button type="button" onclick="resetRecovery()" class="btn btn-link p-0">Try again?</button>   
                </div>
            </form>
        </div>
        <div class="col"></div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/local/recovery/isRecovering').then(response => response.json()).then(data => {
            if (data['isRecovering']) {
                secondPhase();
                if (document.getElementById("expMsg").innerHTML == "The Recovery token has expired") {
                    resetRecovery()
                }
            }
        });
    });

    function setValidity() {
        var validity;

        fetch('/api/local/recovery/validity').then(response => response.json()).then(data => {
            validity = new Date(data['valid']).getTime();
        });

        var x = setInterval(function() {
            var distance = validity - new Date().getTime();

            if (distance < 0) {
                clearInterval(x);
                document.getElementById("expMsg").innerHTML = "The Recovery token has expired";
            } else {
                document.getElementById("expMsg").innerHTML = 'Token Expires in <span id=expTime></span>'
                document.getElementById("expTime").innerHTML = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)) + ":" + String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2,'0') + "";
                
            }
        }, 1000);
    }


    function secondPhase() {
        document.getElementById("recoveryForm").classList.add('d-none');
        document.getElementById("confirmRecoveryForm").classList.remove('d-none');
        document.getElementById("secondRecoveryMsg").classList.remove('d-none');

        fetch('/api/local/recovery/username').then(response => response.json()).then(data => {
            if (data['ok']) {
                document.getElementById("theMsg").innerHTML = "Hi " + data['username'] + "! After the confirmation code, You will receive the new passowrd on your email.";
            }
        });

        // '/?showWarning=If the email address is correct, You should recieve a Confirmation Code'

        setValidity();
    }


// ""

    function resetRecovery() {
        fetch('/api/local/recovery/reset').then(response => response.json()).then(data => {
            if (data['ok']) {
                document.getElementById("email").value = "";
                document.getElementById("recoveryForm").classList.remove('d-none');
                document.getElementById("confirmRecoveryForm").classList.add('d-none');
                document.getElementById("secondRecoveryMsg").classList.add('d-none');
            }
        });
    }

    var recoveryForm = document.getElementById("recoveryForm");

    recoveryForm.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (recoveryForm.checkValidity()) {
            var data = new FormData(recoveryForm);
            fetch('/api/local/recovery/recover', {
                method: 'POST',
                body: data
            }).then(response => response.json()).then(data => {
                if (data['ok']) {
                    secondPhase()
                }
            });
        }
        recoveryForm.classList.add('was-validated');
    });

    var confirmRecoveryForm = document.getElementById("confirmRecoveryForm");

    confirmRecoveryForm.addEventListener('submit', function(event) {
        event.preventDefault();
        event.stopPropagation();

        if (confirmRecoveryForm.checkValidity()) {
            var data = new FormData(confirmRecoveryForm);
            fetch('/api/local/recovery/confirm', {
                method: 'POST',
                body: data
            }).then(response => {
                if (response.status == 200) {
                    return response.json()
                } else {
                    // some error
                }
            }).then(data => {
                if (data['ok']) {
                    window.location.href = "/?showSuccess=" + data['message'];
                }
            });
        }
        confirmRecoveryForm.classList.add('was-validated');
    });
</script>