import "./styles/reserved.css"
import "./styles/user-list.css"

// EXPORT TABLE DATA
const searchAll = document.querySelector('#table-content .input-group input');
const searchArchive = document.querySelector('#archive-content .input-group input');
const tableRowsAll = document.querySelectorAll('#table-content tbody tr');
const tableRowsArchive = document.querySelectorAll('#archive-content tbody tr');

// 1. Searching for specific data in the "All" table
searchAll.addEventListener('input', searchTableAll);

// 2. Searching for specific data in the "Archived" table
searchArchive.addEventListener('input', searchTableArchive);

function searchTableAll() {
  tableRowsAll.forEach((row, i) => {
    let tableData = row.textContent.toLowerCase();
    let searchData = searchAll.value.toLowerCase();
    row.classList.toggle('hide', tableData.indexOf(searchData) < 0);
    row.style.setProperty('--delay', i / 25 + 's');
  });

  // Additional code specific to the "All" table if needed
  document.querySelectorAll('#table-content tbody tr:not(.hide)').forEach((visibleRow, i) => {
    visibleRow.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
  });
}

function searchTableArchive() {
  tableRowsArchive.forEach((row, i) => {
    let tableData = row.textContent.toLowerCase();
    let searchData = searchArchive.value.toLowerCase();
    row.classList.toggle('hide', tableData.indexOf(searchData) < 0);
    row.style.setProperty('--delay', i / 25 + 's');
  });

  // Additional code specific to the "Archived" table if needed
  document.querySelectorAll('#archive-content tbody tr:not(.hide)').forEach((visibleRow, i) => {
    visibleRow.style.backgroundColor = (i % 2 == 0) ? 'transparent' : '#0000000b';
  });
}


// 2. Sorting | Ordering data of HTML table

function setupTableSorting(tableId) {
 const tableHeadings = document.querySelectorAll(`#${tableId} th`);
 const tableRows = document.querySelectorAll(`#${tableId} tbody tr`);

 tableHeadings.forEach((head, i) => {
     let sort_asc = true;
     head.onclick = () => {
         tableHeadings.forEach(head => head.classList.remove('active'));
         head.classList.add('active');

         document.querySelectorAll(`#${tableId} td`).forEach(td => td.classList.remove('active'));
         tableRows.forEach(row => {
             row.querySelectorAll('td')[i].classList.add('active');
         })

         head.classList.toggle('asc', sort_asc);
         sort_asc = head.classList.contains('asc') ? false : true;

         sortTable(tableRows, i, sort_asc);
     }
 });

 function sortTable(rows, column, sort_asc) {
     [...rows].sort((a, b) => {
         let first_row = a.querySelectorAll('td')[column].textContent.toLowerCase(),
             second_row = b.querySelectorAll('td')[column].textContent.toLowerCase();

         return sort_asc ? (first_row < second_row ? 1 : -1) : (first_row < second_row ? -1 : 1);
     })
         .map(sorted_row => document.querySelector(`#${tableId} tbody`).appendChild(sorted_row));
 }
}

// Call the function to set up sorting for the "All" table
setupTableSorting('reservation_table');

// Call the function again to set up sorting for the "Archived" table
setupTableSorting('archivedReservation_table');




// 3. Converting HTML table to PDF

// Export button for the "All" tab
const pdf_btn = document.querySelector('#toPDF');
const customers_table = document.querySelector('#reservation_table');

// Export button for the "Archived" tab
const pdf_btn_archive = document.querySelector('#toPDFArchive');
const archived_customers_table = document.querySelector('#archivedReservation_table');

const toPDF = function (table) {
    const html_code = `
    <link rel="stylesheet" href="css/reserved.css" />
    
    <table id="customers_table">${table.innerHTML}</table>
    `;
    
    const new_window = window.open();
    new_window.document.write(html_code);
    
    setTimeout(() => {
        new_window.print();
        new_window.close();
    }, 400);
}

// Event listener for the "All" tab export button
pdf_btn.onclick = () => {
    toPDF(customers_table);
}

// Event listener for the "Archived" tab export button
pdf_btn_archive.onclick = () => {
    toPDF(archived_customers_table);
}




// 4. Converting HTML table to JSON

// JSON export button for the "All" tab
const json_btn = document.querySelector('#toJSON');

// JSON export button for the "Archived" tab
const json_btn_archive = document.querySelector('#toJSONArchive');

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
                row_object['picture'] = decodeURIComponent(img.src);
            }
            row_object[t_head[cell_index]] = t_cell.textContent.trim();
        });
        table_data.push(row_object);
    });
    
    return JSON.stringify(table_data, null, 4);
}

// Event listener for the "All" tab JSON export button
json_btn.onclick = () => {
    const json = toJSON(customers_table);
    downloadFile(json, 'json');
}

// Event listener for the "Archived" tab JSON export button
json_btn_archive.onclick = () => {
    const json = toJSON(archived_customers_table);
    downloadFile(json, 'json_archive');
}


// 5. Converting HTML table to CSV and Excel

// CSV export button for the "All" tab
const csv_btn = document.querySelector('#toCSV');

// Excel export button for the "All" tab
const excel_btn = document.querySelector('#toEXCEL');

// CSV export button for the "Archived" tab
const csv_btn_archive = document.querySelector('#toCSVArchive');

// Excel export button for the "Archived" tab
const excel_btn_archive = document.querySelector('#toEXCELArchive');

const toCSV = function (table) {
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

const toExcel = function (table) {
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
 downloadFile(csv, 'csv', 'reservation_table.csv');
};

excel_btn.onclick = () => {
 const excel = toExcel(customers_table);
 downloadFile(excel, 'excel', 'reservation_table.xlsx');
};

csv_btn_archive.onclick = () => {
    const csv = toCSV(archived_customers_table);
    downloadFile(csv, 'csv', 'archived_reservation_table.csv');
};

excel_btn_archive.onclick = () => {
    const excel = toExcel(archived_customers_table);
    downloadFile(excel, 'excel', 'archived_reservation_table.xlsx');
};






const downloadFile = function (data, fileType, fileName = '') {
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