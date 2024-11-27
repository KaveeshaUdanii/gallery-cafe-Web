// Function to open the table form modal
function openTableModal() {
    document.getElementById("table-form-modal").style.display = "block";
}

// Function to close the table form modal
function closeTableModal() {
    document.getElementById("table-form-modal").style.display = "none";
}

// Function to view tables
function viewTables() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'ManageTables.php?action=view', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const tables = JSON.parse(xhr.responseText);
            const tableBody = document.getElementById('tables-table-body');
            tableBody.innerHTML = ''; // Clear existing rows

            tables.forEach(table => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${table.TID}</td>
                    <td>${table.Capacity}</td>
                    <td>${table.Location}</td>
                    <td>${table.Availability ? 'Available' : 'Not Available'}</td>
                    <td>
                        <button class="btn btn-secondary" onclick="editTable(${table.TID})">Edit</button>
                        <button  class="btn btn-secondary" onclick="deleteTable(${table.TID})">Delete</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }
    };
    xhr.send();
}

// Function to edit table
function editTable(tid) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'ManageTables.php?action=edit&tid=' + tid, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const table = JSON.parse(xhr.responseText);
            document.getElementById('tid').value = table.TID;
            document.getElementById('capacity').value = table.Capacity;
            document.getElementById('location').value = table.Location;
            document.getElementById('availability').value = table.Availability ? '1' : '0';
            document.getElementById('form-title').innerText = 'Edit Table';
            openTableModal();
        }
    };
    xhr.send();
}

// Function to delete table
function deleteTable(tid) {
    if (confirm('Are you sure you want to delete this table?')) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'ManageTables.php?action=delete&tid=' + tid, true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('localhost says: Table deleted successfully.');
                viewTables(); // Refresh the table list
            }
        };
        xhr.send();
    }
}