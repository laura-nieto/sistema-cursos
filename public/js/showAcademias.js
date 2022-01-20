let rol = document.getElementById('role'),
    academias = document.getElementById('academies');

rol.addEventListener('change',()=>{
    if (rol.value != 1 && rol.value != 2) { //SI ROL ES SUPERADMIN, ADMIN
        if (academias.classList.contains('d-none')) {
            academias.classList.toggle('d-none')
        }
    } else if ((rol.value == 1 || rol.value == 2) && !academias.classList.contains('d-none')) {
        academias.classList.toggle('d-none');
    }
})