const inputs = document.querySelectorAll(".ajax");
const arrayUrl = document.URL.split('/');
const getId = arrayUrl[arrayUrl.length-1]

inputs.forEach(input => {
    input.addEventListener('change', ajax)
});

document.getElementById("po").addEventListener("keydown", e => {
    keys = ["ArrowLeft", "ArrowRight", "Backspace", "End", "Home", "-", "Enter"]
    re = new RegExp("[0-9]")
    if (!re.test(e.key)) {
        if (!keys.includes(e.key)) {
            // console.log(e.key);
            e.preventDefault();
        }
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
    axios.post('/personnage/modifier-statut',  values,   
     'Content-Type: multipart/form-data' )
    .then( response => {
        Swal.fire({
            position: 'top-end',
            title: "Modification enregistré",
            showConfirmButton: false,
            timer: 1500,
            background : 'url(../../img/toast.png)',
            customClass : {
                popup : "toast-custom",
                title : "swal-comfirm"
            },  
            toast : true
        })
    })
    .catch(error => {
        Swal.fire({
            position: 'top-end',
            title: "Une erreur c'est produite veuillez réessayer plus tard",
            showConfirmButton: false,
            timer: 1500,
            background : 'url(../../img/toast.png)',
            customClass : {
                popup : "toast-custom",
                title : "swal-cancel"
            },  
            toast : true
        })
    });
}