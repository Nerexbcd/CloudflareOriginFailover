// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    Array.from(forms).forEach(form => {
        
        form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        //Custom Validation
        if(form.classList.contains("special-validation")) {
            if(form.classList.contains("check-file-type")){CheckFileType() }
            if(form.classList.contains("check-base")) {CheckBase(form.name)}
            
        }
        form.classList.add('was-validated')
        }, false)
    })
})()