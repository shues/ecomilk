function recount_order() {
    var pole = event.currentTarget;
    var row = pole.parentElement.parentElement;
    var kvo = pole.value;
    var price = row.cells[3].textContent;
    row.cells[4].children[0].value = Math.round((kvo * price) * 100) / 100;

    var table = row.parentElement;
    var sum = 0;
    for (var i = 1; i < table.rows.length; i++) {
        sum += Number(table.rows[i].cells[4].children[0].value);
    }
    document.getElementById('itog').value = Math.round((sum) * 100) / 100;
}