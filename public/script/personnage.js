const inputs = document.querySelectorAll(".ajax");
const arrayUrl = document.URL.split('/');
const getId = arrayUrl[arrayUrl.length-1]

inputs.forEach(input => {
    input.addEventListener('change', ajax)
});


function ajax() {
    let values = {
        inventaire: document.getElementById("inventaire").value,
        po: document.getElementById("po").value,
        pv : document.getElementById("pv").value,
        pc: document.getElementById("pc").value,
        pm : document.getElementById("pm").value,
        id : getId
    }

    console.log(values);
    axios.post('/personnage/update',  values,   
     'Content-Type: multipart/form-data' )
    .then()
    .catch(error => console.error(error.response.data));
}