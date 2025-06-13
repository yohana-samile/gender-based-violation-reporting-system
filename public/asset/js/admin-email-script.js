let adminEmailsTable;
document.addEventListener("DOMContentLoaded", function () {
    let tableElement = document.querySelector("#admin_emails");
    if (!tableElement  || tableElement.classList.contains("dataTable")) {
        console.warn("DataTable is already initialized or element not found.");
        return;
    }

    adminEmailsTable = new DataTable(tableElement, {
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        pageLength: 10,
        language: {
            info: "",
            infoFiltered: "(filtered from _MAX_ total entries)",
            lengthMenu: "Show _MENU_ entries"
        },
        ajax: adminEmailUrl,

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "email" },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `
                       <button class="text-red-500 dark:text-red-400 delete-entry"
                            data-email-id="${row.id}"
                            data-admin-uid="${row.adminUid}">
                            <i class="fa fa-trash"></i> Remove email
                        </button>
                    `;
                }
            }
        ],
        pagingType: "full_numbers",
        drawCallback: function (settings) {
            applyDarkModeToDataTable();
            let info = settings.oInstance.api().page.info();
            let entriesCount = document.querySelector(".entriesCount");
            if (entriesCount) {
                entriesCount.textContent = `Showing ${info.start + 1} to ${info.end} of ${info.recordsDisplay} entries`;
            }
        }
    });

    // Remove
    tableElement.addEventListener("click", function (event) {
        if (event.target.closest(".delete-entry")) {
            let emailId = event.target.closest(".delete-entry").dataset.emailId;
            let adminUid = event.target.closest(".delete-entry").dataset.adminUid;

            deleteEmail(emailId, adminUid);
        }
    });
    applyDarkModeToDataTable();
});

function deleteEmail(emailId, adminUid) {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, remove it!"
    }).then((result) => {
        if (result.isConfirmed) {
            let requestUrl = removeAdminEmailUrl.replace(':emailId', emailId).replace(':adminUid', adminUid);
            fetch(requestUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then((response) => response.json())
                .then((data) => {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: data.status === 200 ? "success" : "error",
                        title: data.message,
                    }).then(() => {
                        if (data.status === 200) {
                            adminEmailsTable.ajax.reload();
                        }
                    });
                })
                .catch(() => {
                    Swal.fire("Error!", "Failed to connect to the server.", "error");
                });
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    fetch(emailUrl)
        .then(response => response.json())
        .then(responseData => {
            let emails = responseData.data;
            let select = document.querySelector(".select_email");

            select.innerHTML = `<option selected hidden disabled>Choose a email</option>`;

            emails.forEach(email => {
                let option = document.createElement("option");
                option.value = email.id;
                option.textContent = email.email;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error fetching emails:", error));
});
