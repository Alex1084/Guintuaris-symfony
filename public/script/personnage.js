const inputs = document.querySelectorAll(".ajax");
const arrayUrl = document.URL.split('/');
const getId = arrayUrl[arrayUrl.length-1]

inputs.forEach(input => {
    input.addEventListener('change', ajax)
});

document.getElementById("po").addEventListener("keydown", e => {
    re = new RegExp("[0-9]")
    if (!re.test(e.key)) {
        e.preventDefault();
    }
})


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
    .then(
        Swal.fire({
            position: 'top-end',
            // icon: 'success',
            title: "Modification enregistré",
            showConfirmButton: false,
            timer: 1500,
            // backdrop : false,  
            background : 'url(../../img/toast.png)',
            customClass : {
                popup : "toast-custom",
                title : "swal-comfirm"
            },  
            toast : true
          })
    )
    .catch(error => console.error(error.response.data));
}