addDays = (day = null,date = '', startTime , endTime = '', nameInstructor = '') => {
    let containerBox = document.getElementById("CourseDaysDiv")
    const count = (day === null)?((containerBox.childElementCount)/6)+1: day

    let oneDivElement = document.createElement("div")
    oneDivElement.setAttribute("class","col-3 ")

    let twoDivElement = document.createElement("div")
    twoDivElement.setAttribute("class","col-3 ")

    let threeDivElement = document.createElement("div")
    threeDivElement.setAttribute("class","col-3 ")

    let fourDivElement = document.createElement("div")
    fourDivElement.setAttribute("class","col-3 p-0 d-flex align-items-center justify-content-center")

    let fifthDivElement = document.createElement("div")
    fifthDivElement.setAttribute("class","col-3 p-0 mt-2 mb-4 d-flex align-items-center justify-content-center")

    let sixthDivElement = document.createElement("div")
    sixthDivElement.setAttribute("class","col-9 mt-2 mb-4")
    
    const fechaActual = new Date()
    let minDate
    let year = fechaActual.getFullYear()
    let month = fechaActual.getMonth()+1
    let days = fechaActual.getUTCDate()

    if (month < 10) {
        month = "0"+month
    }
    if (days < 10) {
        days = "0"+days
    }
    
    minDate = year+"-"+month+"-"+days

    let inputDate = document.createElement("input")
    inputDate.setAttribute("type","date")
    inputDate.setAttribute("name",`dia${count}`)
    inputDate.setAttribute("id",`dia${count}CrearDia`)
    inputDate.setAttribute("required","")
    inputDate.setAttribute("class","w-100 form-control")
    inputDate.setAttribute("value", date)
    inputDate.setAttribute("min",minDate)

    let inputStartTime = document.createElement("input")
    inputStartTime.setAttribute("type","time")
    inputStartTime.setAttribute("class","w-100 form-control")
    inputStartTime.setAttribute("name",`hora${count}Inicio`)
    inputStartTime.setAttribute("id",`hora${count}InicioCrearDia`)
    inputStartTime.setAttribute("step","900")
    inputStartTime.setAttribute("value",startTime)
    inputStartTime.setAttribute("required","")

    let inputEndTime = document.createElement("input")
    inputEndTime.setAttribute("type","time")
    inputEndTime.setAttribute("class","w-100 form-control")
    inputEndTime.setAttribute("name",`hora${count}Fin`)
    inputEndTime.setAttribute("id",`hora${count}FinCrearDia`)
    inputEndTime.setAttribute("step","900")
    inputEndTime.setAttribute("value",endTime)
    inputEndTime.setAttribute("required","")

    let labelDia = document.createElement("label")
    labelDia.innerText = `Dia ${count}`
    labelDia.setAttribute("for",`dia${count}`)
    labelDia.setAttribute("class","m-0")

    let labelInstructor = document.createElement("label")
    labelInstructor.innerText = "Nombre del Instructor"
    labelInstructor.setAttribute("for",`nombreInstructor${count}`)
    labelInstructor.setAttribute("class","m-0")

    let inputInstructor = document.createElement("input")
    inputInstructor.setAttribute("name",`nombreInstructor${count}`)
    inputInstructor.setAttribute("id",`nombreInstructor${count}CrearDia`)
    inputInstructor.setAttribute("class","form-control")
    inputInstructor.setAttribute("value",nameInstructor)
    inputInstructor.setAttribute("required","")


    let numberTheDays = document.getElementById('numberTheDays')
    numberTheDays.setAttribute("value",count)

    oneDivElement.appendChild(inputEndTime)
    twoDivElement.appendChild(inputStartTime)
    threeDivElement.appendChild(inputDate)
    fourDivElement.appendChild(labelDia)
    fifthDivElement.appendChild(labelInstructor)
    sixthDivElement.appendChild(inputInstructor)

    containerBox.appendChild(fourDivElement)
    containerBox.appendChild(threeDivElement)
    containerBox.appendChild(twoDivElement)
    containerBox.appendChild(oneDivElement)

    containerBox.appendChild(fifthDivElement)
    containerBox.appendChild(sixthDivElement)
    
}
removeDays = () => {
    let containerBox = document.getElementById("CourseDaysDiv")
    const count = ((containerBox.childElementCount)/6)    
    let numberTheDays = document.getElementById('numberTheDays')

    if (count > 1) {
        numberTheDays.setAttribute("value",count-1)

        containerBox.removeChild(containerBox.lastChild)
        containerBox.removeChild(containerBox.lastChild)
        containerBox.removeChild(containerBox.lastChild)
        containerBox.removeChild(containerBox.lastChild)
        containerBox.removeChild(containerBox.lastChild)
        containerBox.removeChild(containerBox.lastChild)
    }
}
loadOldData = (oldData) => {
    if (typeof(oldData._token) === 'undefined') {
        oldData.forEach((day,index) => {
            addDays(index+1,day['hour_range_string'].split(" ")[0].split('"')[1],day['hour_range_string'].split(" ")[1].split('"')[0],day['hour_range_string'].split(" ")[2].split('"')[0],day['name_instructor'])
        });
    }else if (typeof(oldData._token) === 'string') {
        for (let i = 1; i <= oldData.numberTheDays; i++) {
            addDays(i,oldData[`dia${i}`],oldData[`hora${i}Inicio`],oldData[`hora${i}Fin`],oldData[`nombreInstructor${i}`])
        }
    }
}

loadOldData(oldData)