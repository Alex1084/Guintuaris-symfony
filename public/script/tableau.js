const tableau = document.querySelector(".tableau");
const rowHead = tableau.querySelectorAll("thead th.sortable");
const rowsBody = tableau.querySelectorAll("tbody tr");
const tbody = tableau.querySelector("tbody")
rowHead.forEach(element => {
    element.addEventListener("click", (e) => {
        sort(siblingIndex(element));
    })
});

document.querySelector(".default-sort").addEventListener("click", () => {
    for (const row of rowsBody) {
        tbody.append(row);
    }
})

function siblingIndex(node) {
    let count = 0;

    while (node = node.previousElementSibling) {
        count++;
    }

    return count;
}

function sort(columnIndex) {
    console.log(rowsBody);
    let columnClass = tableau.querySelector("thead th:nth-child(" + (columnIndex + 1) + ")").classList;
    let columnType = "";
    if (columnClass.contains("number")) {
        columnType = "number";
    }
    else if (columnClass.contains("date")) {
        columnType = "date";
    }
    else if (columnClass.contains("text")){
        columnType = "text";
    }

    let sel = "td:nth-child(" + (columnIndex + 1) + ")";
    let values = [];
    let val = "";
    for (i = 0; i < rowsBody.length; i++) {
        val = rowsBody[i].querySelector(sel);
        values.push([val.outerText, rowsBody[i]])
    }
    switch (columnType) {
        case "number":
            values.sort(sortNumberVal);
            break;
        case "date" :
            values.sort(sortDateVal);
            break
        case "text" :
            values.sort(sortTextVal);
            break
        default:
            values.sort(sortTextVal);
            break;
    }
/*     values.forEach(element => {
        console.log(element[0].outerText);
    }); */
    
    // tbody.innerHTML = ""
    for (var idx = 0; idx < values.length; idx++) {
        console.log(values[idx][1]);
        tbody.append(values[idx][1]);
    }
}
/**
 * Compare two 'value objects' numerically
 */
 function sortNumberVal(a, b) {
    return a[0] - b[0];
}

/**
 * Compare two 'value objects' as dates
 */
function sortDateVal(a, b) {
    let dateA = Date.parse(a[0]),
        dateB = Date.parse(b[0]);

    return dateA - dateB;
}

/**
 * Compare two 'value objects' as simple text; case-insensitive
 */
function sortTextVal(a, b) {
    let textA = (a[0] + "").toUpperCase();
    let textB = (b[0] + "").toUpperCase();
    if (textA < textB) return -1;
    if (textA > textB) return 1;
    return 0;
}