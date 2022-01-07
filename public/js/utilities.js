inputLimit = (idInput,limite) => {
    input = document.getElementById(idInput)
    input.addEventListener('input',function(){
        if (this.value.length > limite) {
            this.value = this.value.slice(0,limite); 
        }    
    })
    
}

inputLimit('telefono',8)
inputLimit('prefijo',2)