document.addEventListener("DOMContentLoaded", function () {
    if (window.currentRoute !== "frontend.email.managers" && window.currentRoute !== "backend.email.managers") {
        return;
    }

    let tableElement = document.querySelector("#whm-email-accounts");
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
        ajax: whmEmailAccounts,

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `
                        <a href="javascript:void(0)" class="btn btn-link d-block" onclick="openEmailDetailModal(${meta.row})">
                            <i class="fas fa-ellipsis-v"></i>
                        </a> ${meta.row + 1}
                    `;
                }
            },
            { data: "email" },
            { data: "domain" },
            {
                data: "diskusedpercent",
                render: function (data, type, row) {
                    let countUsage = row.diskused ?? 0;
                    let totalQuota = row.txtdiskquota ?? 0;
                    let progress = row.diskusedpercent ?? 0;

                    return `
                        <div class="bg-gray-200 rounded-full h-5 w-full relative">
                            <div class="bg-blue-500 rounded-full h-5 transition-all duration-500"
                                 style="width: ${progress}%;"></div>
                        </div>
                        <div class="text-center mt-1">${countUsage} MB / ${totalQuota} MB (${progress}%)</div>
                    `;
                }
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    let isSmallScreen = window.innerWidth < 768;
                    if (isSmallScreen) {
                        return `
                            <a href="javascript:void(0)" class="btn btn-link d-block" onclick="openEmailDetailModal(${meta.row})">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                        `;
                    }
                    return `
                        <div class="flex items-center space-x-2">
                            <button class="text-blue-500 dark:text-blue-400" onclick="openEmailDetailModal(${meta.row})">
                               <i class="fas fa-eye"></i> preview
                            </button>
                            <a href="https://webmail.${data.domain}" target="_blank" class="text-orange-500 text-xs">
                                <i class="fas fa-arrow-alt-circle-right"></i> login
                            </a>
                            <a href="javascript:void(0)" class="text-green-500 dark:text-green-400 update-email-button" data-uid="${data.uid}" data-row="${meta.row}">
                                <i class="fas fa-edit"></i> update
                            </a>
                            <button class="text-red-500 dark:text-red-400 delete-email" data-uid="${data.uid}">
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

    /* DELETE EMAIL ACCOUNT */
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-email")) {
            let emailUid = event.target.dataset.uid;

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
                    fetch(deleteEmailRoute.replace(':uid', emailUid), {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire("Deleted!", "The email has been deleted.", "success");
                            table.ajax.reload();
                        } else {
                            Swal.fire("Error!", "There was an issue deleting the email.", "error");
                        }
                    })
                    .catch(() => {
                        Swal.fire("Error!", "Failed to connect to the server.", "error");
                    });
                }
            });
        }
    });

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("update-email-button")) {
            let rowData = table.row(event.target.dataset.row).data();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            if (!isNaN(rowData.txtdiskquota)) {
                rowData.txtdiskquota = parseInt(rowData.txtdiskquota, 10);
            }

            // Inject modal content
            document.getElementById("edit_email_modal").innerHTML = getModalTemplate(rowData, csrfToken);

            // Show modal
            const modal = document.getElementById("updateEmailDetails");
            modal.classList.remove("hidden");
            modal.classList.add("flex");
        }
    });

    function getModalTemplate(rowData, csrfToken) {
        return `
            <h2 class="text-center font-bold">
                Update
                <span class="bg-indigo-500 text-white text-sm font-semibold px-2 py-1 rounded-lg">
                    ${rowData.email}
                </span>
                Details
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 w-full mt-4 mb-3">
                ${getFormSection("Quota", "quota", rowData.uid, rowData.txtdiskquota, csrfToken)}
                ${getFormSection("Email Password", "password", rowData.uid, "", csrfToken)}
            </div>
        `;
    }

    function getFormSection(title, field, uid, value, csrfToken) {
        let inputField =
            field === "quota"
                ? `<input id="quota" type="text" name="quota" placeholder="Enter Quota"
                  class="w-full bg-transparent focus:outline-none dark:text-gray-200" value="${value}">`
                :`
                <div class="grid grid-flow-col grid-rows-4 gap-4 w-full">
                    <div class="mb-4">
                        <label for="new_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            New Password
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="new_password" type="password" name="password" placeholder="Enter New Password"
                                class="w-full bg-transparent focus:outline-none dark:text-gray-200" minlength="8" required>
                            <span class="generate_password bg-red-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer">
                                <i class="fa fa-key"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Confirm Password
                        </label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Confirm Password"
                                class="w-full bg-transparent focus:outline-none dark:text-gray-200" minlength="8" required>
                            <span class="view_password bg-gray-500 text-white px-2 py-1 rounded-r-md text-xs cursor-pointer">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                    </div>
                </div>
            `;

        return `
            <div class="col-span-12 md:col-span-6">
                <div class="text-center"><x-loader /></div>
                <form class="update-form mt-4 mb-3" method="POST" data-field="${field}">
                    <input type="hidden" name="_token" value="${csrfToken}">
                    <input type="hidden" name="uid" value="${uid}">
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">${title}</label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                            ${inputField}
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-${field === "quota" ? "indigo" : "red"}-500 text-white py-2 rounded-lg hover:bg-indigo-600">
                        Update ${title}
                    </button>
                </form>
            </div>
        `;
    }

    document.addEventListener("submit", function (e) {
        if (e.target.classList.contains("update-form")) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const fieldType = form.dataset.field;

            if (fieldType === "password") {
                const password = formData.get("password");
                function checkPasswordStrength(password) {
                    // Require at least 12 characters, including uppercase, lowercase, number, and special character
                    const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{12,}$/;
                    return strongPasswordRegex.test(password);
                }

                if (!checkPasswordStrength(password)) {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: "error",
                        title: "Password is too weak! Use at least 12 characters with uppercase, lowercase, number, and special character.",
                    });
                    e.preventDefault();
                    return;
                }
                sendAjaxRequest(editEmailRoute, formData, fieldType);
            }
            if (fieldType === "quota") {
                let quotaValue = formData.get("quota").trim();
                if (!/^\d+$/.test(quotaValue) && quotaValue.toLowerCase() !== "unlimited") {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: "error",
                        title: "Quota must be a positive integer or 'unlimited'.",
                    });
                    return;
                }
                sendAjaxRequest(editEmailRoute, formData, fieldType);
            }
        }
    });


    /* TOGGLE MODALS */
    window.openEmailDetailModal = function (rowIndex) {
        let rowData = table.row(rowIndex).data();
        if (!rowData) {
            console.error("Row data not found.");
            return;
        }

        let countUsage = rowData.diskused ?? 0;
        let totalQuota = rowData.txtdiskquota ?? 0;
        let progress = rowData.diskusedpercent ?? 0;

        let diskUsage = `
            <div class="bg-gray-200 rounded-full h-5 w-full relative">
                <div class="bg-blue-500 rounded-full h-5 transition-all duration-500"
                        style="width: ${progress}%;"></div>
            </div>
            <div class="text-center mt-1">${countUsage} MB / ${totalQuota} MB (${progress}%)</div>
        `;

        document.querySelector("#email-details").innerHTML = `
            <div class="data-row"><span class="data-label">email :</span> <span class="data-value">${rowData.email}</span></div>
            <div class="data-row"><span class="data-label">domain :</span> <span class="data-value">${rowData.domain}</span></div>
            <div class="data-row"><span class="data-label">usage / quota :</span> <span class="data-value">${diskUsage}</span></div>
        `;

        document.querySelector("#action-buttons").innerHTML = `
            <button class="text-blue-500 text-xs flex items-center" onclick="previewAction(${rowIndex})">
                <i class="fas fa-eye mr-1"></i> Preview
            </button>
            <a href="https://webmail.${rowData.domain}" target="_blank" class="text-orange-500 text-xs flex items-center ml-2">
                <i class="fas fa-lock mr-1"></i> login
            </a>
             <a href="javascript:void(0)" class="text-green-500 dark:text-green-400 update-email-button" data-uid="${rowData.uid}" data-row="${rowIndex}">
                <i class="fas fa-edit mr-1"></i> update
            </a>
             <button class="text-red-500 text-xs flex items-center ml-2 delete-email-modal" data-uid="${rowData.uid}">
                <i class="fas fa-trash mr-1"></i> Delete
            </button>
        `;

        document.getElementById("emailDetailsModal").classList.remove("hidden");
    };

    window.closeEmailDetailModal = function () {
        document.getElementById("emailDetailsModal").classList.add("hidden");
    };

    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-email-modal")) {
            let emailUid = event.target.dataset.uid;
            document.querySelector(`.delete-email[data-uid="${emailUid}"]`).click();
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const domainSelect = document.querySelector("select[name='domain']");
    const emailUsername = document.getElementById("email_username");
    const emailDomain = document.getElementById("email_domain");
    const passwordField = document.getElementById("password");
    const form = document.getElementById("addEmailEmailAccount");

    function updateEmailField() {
        const selectedDomain = domainSelect.options[domainSelect.selectedIndex].text.trim();
        emailDomain.textContent = "@" + selectedDomain;

        // Ensure the input only contains the username (remove '@' if typed)
        emailUsername.addEventListener("input", function () {
            emailUsername.value = emailUsername.value.split('@')[0].trim();
        });
    }

    function checkPasswordStrength(password) {
        // Require at least 12 characters, including uppercase, lowercase, number, and special character
        const strongPasswordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?])[A-Za-z\d!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]{12,}$/;
        return strongPasswordRegex.test(password);
    }

    // Trigger update when domain is changed
    domainSelect.addEventListener("change", updateEmailField);

    // Ensure full email is properly formed before submitting
    form.addEventListener("submit", function (e) {
        let username = emailUsername.value.trim();
        let selectedDomain = domainSelect.options[domainSelect.selectedIndex].text.trim();
        let password = passwordField.value.trim();

        console.log("password ", password);
        if (!username) {
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: "error",
                title: "Please enter an email username before submitting.",
            });
            e.preventDefault();
            return;
        }
        if (!checkPasswordStrength(password)) {
            Swal.fire({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                icon: "error",
                title: "Password is too weak! Use at least 12 characters with uppercase, lowercase, number, and special character.",
            });
            e.preventDefault();
            return;
        }

        document.getElementById("full_email").value = username + "@" + selectedDomain;
        e.preventDefault();
        $('#loader').removeClass('hidden');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: response.status === 200 ? "success" : "error",
                    title: response.message,
                }).then(() => {
                    if (response.status === 200) window.location.reload();
                });
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.message || "An error occurred while processing your request.";
                Swal.fire({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    icon: "error",
                    title: errorMessage,
                });
            },
            complete: function () {
                $("#loader").addClass("hidden");
            },
        });
    });

    // Initialize with the current domain (if selected)
    updateEmailField();
});


//password generation
document.getElementById("generate_password").addEventListener("click", function() {
    function generateStrongPassword(length = 12) {
        const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+";
        let password = "";
        for (let i = 0; i < length; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        return password;
    }

    const newPassword = generateStrongPassword(16);
    document.getElementById("password").value = newPassword;
    document.getElementById("password_confirmation").value = newPassword;
});

document.querySelector(".view_password").addEventListener("click", function() {
    const passwordInput = document.getElementById("password_confirmation");
    passwordInput.type = passwordInput.type === "password" ? "text" : "password";
});

document.getElementById('addEmail').addEventListener('click', function () {
    closeModal('addEmail');
});
