

const search = document.querySelector('.input-group input'),
table_rows = document.querySelectorAll('tbody tr'),
table_headings = document.querySelectorAll('thead th');

// 1. Searching for specific data of HTML table
search.addEventListener('input', searchTable);

function searchTable() {
table_rows.forEach((row, i) => {
    let table_data = row.textContent.toLowerCase(),
        search_data = search.value.toLowerCase();

    row.classList.toggle('hide', table_data.indexOf(search_data) < 0);
    row.style.setProperty('--delay', i / 25 + 's');
})

document.querySelectorAll('tbody tr:not(.hide)').forEach((visible_row, i) => {
    visible_row.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
});
}

// 2. Sorting | Ordering data of HTML table

table_headings.forEach((head, i) => {
let sort_asc = true;
head.onclick = () => {
    table_headings.forEach(head => head.classList.remove('active'));
    head.classList.add('active');

    document.querySelectorAll('td').forEach(td => td.classList.remove('active'));
    table_rows.forEach(row => {
        row.querySelectorAll('td')[i].classList.add('active');
    })

    head.classList.toggle('asc', sort_asc);
    sort_asc = head.classList.contains('asc') ? false : true;

    sortTable(i, sort_asc);
}
})


function sortTable(column, sort_asc) {
[...table_rows].sort((a, b) => {
    let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
        second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

    return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
})
    .map(sorted_row => document.querySelector('tbody').appendChild(sorted_row));
}

// 3. Converting HTML table to PDF

const pdf_btn = document.querySelector('#toPDF');
const customers_table = document.querySelector('#customers_table');

const toPDF = function (customers_table) {
const html_code = `
<link rel="stylesheet" href="css/users.css" />

<table id="customers_table">${customers_table.innerHTML}</table>
`;

const new_window = window.open();
new_window.document.write(html_code);

setTimeout(() => {
    new_window.print();
    new_window.close();
}, 400);
}

pdf_btn.onclick = () => {
toPDF(customers_table);
}

// 4. Converting HTML table to JSON

const json_btn = document.querySelector('#toJSON');

const toJSON = function (table) {
let table_data = [],
    t_head = [],

    t_headings = table.querySelectorAll('th'),
    t_rows = table.querySelectorAll('tbody tr');

for (let t_heading of t_headings) {
    let actual_head = t_heading.textContent.trim().split(' ');

    t_head.push(actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase());
}

t_rows.forEach(row => {
    const row_object = {},
        t_cells = row.querySelectorAll('td');

    t_cells.forEach((t_cell, cell_index) => {
        const img = t_cell.querySelector('img');
        if (img) {
            row_object['customer image'] = decodeURIComponent(img.src);
        }
        row_object[t_head[cell_index]] = t_cell.textContent.trim();
    })
    table_data.push(row_object);
})

return JSON.stringify(table_data, null, 4);
}

json_btn.onclick = () => {
const json = toJSON(customers_table);
downloadFile(json, 'json')
}


    const csv_btn = document.querySelector('#toCSV');
const excel_btn = document.querySelector('#toEXCEL');

const toCSV = function(table) {
const t_heads = table.querySelectorAll('th');
const headings = [...t_heads].map(head => {
let actual_head = head.textContent.trim().split(' ');
return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
}).join(',') + ',image name';

const tbody_rows = table.querySelectorAll('tbody tr');
const table_data = [...tbody_rows].map(row => {
const cells = row.querySelectorAll('td');
const data_without_img = [...cells].map(cell => cell.textContent.replace(/,/g, ".").trim()).join(',');
return data_without_img;
}).join('\n');

return headings + '\n' + table_data;
};

const toExcel = function(table) {
const excelRows = [];

const t_heads = table.querySelectorAll('th');
const headings = [...t_heads].map(head => {
let actual_head = head.textContent.trim().split(' ');
return actual_head.splice(0, actual_head.length - 1).join(' ').toLowerCase();
});
excelRows.push(headings);

const tbody_rows = table.querySelectorAll('tbody tr');
[...tbody_rows].forEach(row => {
const cells = row.querySelectorAll('td');
const rowData = [...cells].map(cell => cell.textContent.trim());
excelRows.push(rowData);
});

const workbook = XLSX.utils.book_new();
const worksheet = XLSX.utils.aoa_to_sheet(excelRows);
XLSX.utils.book_append_sheet(workbook, worksheet, 'Sheet 1');

const excelFile = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });
return excelFile;
};

csv_btn.onclick = () => {
const csv = toCSV(customers_table);
downloadFile(csv, 'csv', 'customer_orders.csv');
};

excel_btn.onclick = () => {
const excel = toExcel(customers_table);
downloadFile(excel, 'excel', 'customer_orders.xlsx');
};

const downloadFile = function(data, fileType, fileName = '') {
const blob = new Blob([data], { type: fileType });
const url = URL.createObjectURL(blob);

const a = document.createElement('a');
a.href = url;
a.download = fileName;
document.body.appendChild(a);
a.click();
document.body.removeChild(a);
URL.revokeObjectURL(url);
};