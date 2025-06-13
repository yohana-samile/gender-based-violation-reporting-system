let table;
document.addEventListener("DOMContentLoaded", function () {
    if (window.currentRoute !== "frontend.user" && window.currentRoute !== "backend.user") {
        return;
    }

    let tableElement = document.querySelector("#whm-customers");
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
        ajax: whmCustomer,

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `
                    <a href="javascript:void(0)" class="btn btn-link d-block" onclick="openCustomerDetailModal(${meta.row})">
                        <i class="fas fa-ellipsis-v"></i>
                    </a> ${meta.row + 1}
                `;
                }
            },
            {
                data: "name",
                render: function (data, type, row) {
                    if (!data) return '';
                    return data.split(' ')
                        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
                        .join(' ');
                }
            }
            ,
            { data: "email" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    if (data === true || data === 1) {
                        return `<div class="bg-green-100 text-green-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">
                                Active
                              </div>`;
                    } else {
                        return `<div class="bg-red-100 text-red-800 text-sm font-semibold px-2 py-1 rounded-lg text-center">
                            Inactive
                          </div>`;
                    }
                }
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    let isSmallScreen = window.innerWidth < 768;
                    if (isSmallScreen) {
                        return `
                        <a href="javascript:void(0)" class="btn btn-link d-block" onclick="openCustomerDetailModal(${meta.row})">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                    `;
                    }
                    return `
                        <div class="flex items-center space-x-2">
                            <button class="text-blue-500 dark:text-blue-400" onclick="openCustomerDetailModal(${meta.row})">
                                 <i class="fas fa-eye"></i> Preview
                            </button>x
                            <a href="javascript:void(0)" class="text-green-500 dark:text-green-400 update-customer-button" data-uid="${row.uid}" data-row="${meta.row}">
                                <i class="fas fa-eye"></i> Update
                            </a>
                            <button class="text-red-500 dark:text-red-400 delete-customer" data-uid="${row.uid}">
                                <i class="fas fa-trash-restore-alt"></i> Delete
                            </button>
                        </div>
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

    applyDarkModeToDataTable();

    window.openCustomerDetailModal = function (rowIndex) {
        if (!table) {
            console.error("DataTable instance is not initialized.");
            return;
        }
        let rowData = table.row(rowIndex).data();
        if (!rowData) {
            console.error("Row data not found.");
            return;
        }

        let status = rowData.is_active;
        if (status === true) {
            status = `<div class="bg-indigo-500 text-white text-sm font-semibold px-2 py-1 rounded-lg text-center">
                Active
          </div>`;
        } else {
            status = `<div class="bg-orange-500 text-white text-sm font-semibold px-2 py-1 rounded-lg text-center">
                Inactive
          </div>`;
        }

        document.querySelector("#customer-details").innerHTML = `
            <div class="data-row"><span class="data-label">email :</span> <span class="data-value">${rowData.email}</span></div>
            <div class="data-row"><span class="data-label">Customer Name :</span> <span class="data-value">${rowData.name}</span></div>
            <div class="data-row"><span class="data-label">Is Active? :</span> <span class="data-value">${status}</span></div>
        `;

        document.querySelector("#customer-action-buttons").innerHTML = `
            <div class="flex items-center justify-between">
                <button class="text-blue-500 text-xs flex items-center" onclick="openCustomerDetailModal(${rowIndex})">
                    <i class="fas fa-eye mr-1"></i> Preview
                </button>
                <a href="javascript:void(0)" class="text-green-500 text-xs flex items-center ml-2 update-customer-button" data-uid="${rowData.uid}" data-row="${rowIndex}">
                    <i class="fas fa-edit mr-1"></i> update
                </a>
                <button class="text-red-500 text-xs flex items-center ml-2 delete-customer-modal" data-uid="${rowData.uid}">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
            </div>
        `;

        document.getElementById("customerDetailsModal").classList.remove("hidden");
    }

    //edit
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("update-customer-button")) {
            let rowData = table.row(event.target.dataset.row).data();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            // Inject modal content
            document.getElementById("edit_customer_modal").innerHTML = getModalTemplate(rowData, csrfToken);

            // Show modal
            const modal = document.getElementById("updateCustomerDetails");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }
    });

    // delete
    tableElement.addEventListener("click", function (event) {
        if (event.target.closest(".delete-customer")) {
            let customerUid = event.target.closest(".delete-customer").dataset.uid;
            deleteCustomer(customerUid);
        }
    });
});

/* DELETE customer ACCOUNT */
function deleteCustomer(uid) {
    Swal.fire({
        title: "Are you sure?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(deleteCustomerRoute.replace(':uid', uid), {
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



function getModalTemplate(rowData, csrfToken) {
    let field = null;
    return `
        <h2 class="text-center font-bold">Update <span class="bg-indigo-500 text-white text-sm font-semibold px-2 py-1 rounded-lg">${rowData.name}</span> Details</h2>
        <form class="update-form mt-4 mb-3" method="POST" data-field="${field}">
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="uid" value="${rowData.uid}">
            <div class="mb-4">
                <label for="cname" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Customer Name
                </label>
                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                    <input id="cname" type="text" name="name" placeholder="name" value="${rowData.name}" class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="cemail" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                    Customer Email
                </label>
                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                    <input id="cemail" type="email" name="email" placeholder="Email" value="${rowData.email}" class="w-full bg-transparent focus:outline-none dark:text-gray-200" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="cis_active" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Active Status</label>
                <div class="flex items-center mt-1">
                    <input id="cis_active" type="checkbox" name="is_active" class="mr-2" ${rowData.is_active ? 'checked' : '' }>
                    <span class="dark:text-gray-300">Is Active?</span>
                </div>
            </div>
             <button type="submit" class="w-full bg-indigo-500 text-white py-2 rounded-lg hover:bg-indigo-600">
                Save Changes
            </button>
        </form>
    `;
}

document.addEventListener("submit", function (e) {
    if (e.target.classList.contains("update-form")) {
        e.preventDefault();

        const form = e.target;
        let url = editCustomerRoute.replace(':uid', form.uid.value);
        if (!form.uid.value){
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: "error",
                title: "Fail To Identify User",
            });
        }
        const formData = new FormData(form);
        const fieldType = form.dataset.field;

        if (formData){
            sendAjaxRequest(url, formData, fieldType);
        }
    }
});

/* TOGGLE MODALS */

document.addEventListener("click", function (event) {
    if (event.target.classList.contains("delete-customer-modal")) {
        let customerUid = event.target.dataset.uid;
        document.querySelector(`.delete-customer[data-uid="${customerUid}"]`).click();
    }
});
