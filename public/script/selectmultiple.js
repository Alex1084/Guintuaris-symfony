/* options = document.querySelectorAll('select[multiple="multiple"] option');
console.log(options);

options.forEach(option => {
    option.addEventListener('click', e => {
        e.preventDefault();
    })
}); */

const select = document.querySelector('select[multiple="multiple"]');

select.addEventListener("click", updateSelected);

function updateSelected(e) {
    const opts = select.getElementsByTagName('option');
    let t;
    if (e) {
        e.preventDefault();
        t = e.target;
    }
    else if (window.event) {
        window.event.returnValue = false;
        t = window.event.srcElement;
    }
        if (t.className == 'selected') t.className = '';
    else t.className = 'selected';
    opts.forEach(option => {
        if (option.className == 'selected') option = true;
        else option.selected = false;
    });
}