const inputs = document.querySelectorAll(".ajax");
const arrayUrl = document.URL.split('/');
const getId = arrayUrl[arrayUrl.length-1]

inputs.forEach(input => {
    input.addEventListener('change', ajax)
});

if ( document.getElementById("po") !== null)
{    
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
}


function ajax() {
    const formData = new FormData();
    if ( document.getElementById("inventaire") !== null)
        formData.append('inventaire', document.getElementById("inventaire").value);
    if ( document.getElementById("po") !== null)
        formData.append('po', document.getElementById("po").value);

    formData.append('pv', document.getElementById("pv").value);
    formData.append('pc', document.getElementById("pc").value);
    formData.append('pm', document.getElementById("pm").value);
    formData.append('id', getId);

    let requestOptions = { 
        method: 'POST',
        body: formData,
    };

    fetch('/personnage/modifier-statut', requestOptions)
    .then(response => response.json())
    .then(data => {
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
            title: "Une erreur s'est produite veuillez réessayer plus tard.",
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