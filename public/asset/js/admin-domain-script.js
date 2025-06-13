document.addEventListener("DOMContentLoaded", function () {
    let tableElement = document.querySelector("#whm-admin-domains");
    if (!tableElement || tableElement.classList.contains("dataTable")) {
        console.warn("DataTable is already initialized or element not found.");
        return;
    }

    let table = new DataTable(tableElement, {
        processing: false,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        pageLength: 10,
        language: {
            info: "",
            infoFiltered: "(filtered from _MAX_ total entries)",
            lengthMenu: "Show _MENU_ entries"
        },
        ajax: adminDomainUrl,

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: "name" },
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `
                       <button class="text-red-500 dark:text-red-400 delete-entry"
                            data-domain-id="${row.id}"
                            data-admin-uid="${row.adminUid}">
                            <i class="fa fa-trash"></i> Remove Domain
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
            let domainId = event.target.closest(".delete-entry").dataset.domainId;
            let adminUid = event.target.closest(".delete-entry").dataset.adminUid;

            deleteDomain(domainId, adminUid);
        }
    });
    applyDarkModeToDataTable();
});

function deleteDomain(domainId, adminUid) {
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
            let requestUrl = removeAdminDomainUrl.replace(':domainId', domainId).replace(':adminUid', adminUid);
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
                    if (data.status === 200) window.location.reload();
                });
            })
            .catch(() => {
                Swal.fire("Error!", "Failed to connect to the server.", "error");
            });
        }
    });
}

function copyToClipboard() {
    const input = document.getElementById("whm_api_token");
    navigator.clipboard.writeText(input.value).then(() => {
        alert("Token copied to clipboard!");
    }).catch(err => {
        console.error('Failed to copy token: ', err);
    });
}
