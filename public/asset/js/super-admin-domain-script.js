document.addEventListener("DOMContentLoaded", function () {
    if (window.currentRoute !== "frontend.domain.index" && window.currentRoute !== "backend.domain") {
        return;
    }

    let tableElement = document.querySelector("#whm-domain-accounts");
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
        ajax: domains,

        columns: [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return `
                        <a href="javascript:void(0)" class="btn btn-link d-block" onclick="fetchDomainDetails('${row.name}', '${row.domain_type}')">
                            <i class="fas fa-ellipsis-v"></i>
                        </a> ${meta.row + 1}
                    `;
                }
            },
            { data: "name" },
            { data: "whm_package" },
            {
                data: "status",
                    render: function (data, type, row) {
                        return `<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                    ${data === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${data === 'active' ? 'Active' : 'Inactive'}
                    </span>`;
                }
            },
            {
                data: null,
                render: function (data, type, row, meta) {
                    let isSmallScreen = window.innerWidth < 768;
                    if (isSmallScreen) {
                        return `
                            <a href="javascript:void(0)" class="btn btn-link d-block" onclick="fetchDomainDetails('${row.name}', '${row.domain_type}')">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                        `;
                    }

                    let buttons = `
                        <button class="text-blue-500 dark:text-blue-400 text-sm" onclick="fetchDomainDetails('${row.name}', '${row.domain_type}')">
                            <i class="fa fa-eye"></i> Preview
                        </button>
                    `;

                    if (window.currentRoute === "backend.domain") {
                        buttons += `
                                <button class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm" onclick="showDomainToken('${row.name}', '${row.domain_type}')">
                                    <i class="fa fa-server mr-1"></i> Token
                                </button>

                                <button class="text-green-500 dark:text-green-400 ml-2 text-sm hidden" onclick="editAction(${meta.row})">
                                    <i class="fa fa-expand-arrows-alt"></i> Full Info
                                </button>
                            </div>
                        `;
                    }
                    return buttons;
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

    /* FETCH DOMAIN DETAILS */
    window.fetchDomainDetails = function (domainName, domainType) {
        let url = domain_full_data.replace(':domain', encodeURIComponent(domainName));
        fetch(url)
            .then(response => {
                return response.json();
            })
            .then(data => {
                if (!data) {
                    return;
                }
                let status = `
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
                        ${data.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                        ${data.status === 'active' ? 'Active' : 'Inactive'}
                    </span>`;

                document.querySelector("#domain-info").innerHTML = `
                    <div class="data-row"><span class="data-label">Domain:</span> <span class="data-value">${data.domain}</span></div>
                    <div class="data-row"><span class="data-label">Server Alias:</span> <span class="data-value">${data.serveralias}</span></div>
                    <div class="data-row"><span class="data-label">User:</span> <span class="data-value">${data.user}</span></div>
                    <div class="data-row"><span class="data-label">Type:</span> <span class="data-value">${data.type}</span></div>
                    <div class="data-row"><span class="data-label">IP Address:</span> <span class="data-value">${data.ip}</span></div>
                    <div class="data-row"><span class="data-label">Server Admin:</span> <span class="data-value">${data.serveradmin}</span></div>
                    <div class="data-row"><span class="data-label">Server Name:</span> <span class="data-value">${data.servername}</span></div>
                    <div class="data-row"><span class="data-label">Status:</span> <span class="data-value">${status}</span></div>
                `;

                document.querySelector(".action-buttons").innerHTML = `
                    <button class="text-blue-500 text-xs flex items-center" onclick="previewAction('${data.domain}')">
                        <i class="fas fa-eye mr-1"></i> Preview
                    </button>

                    ${window.currentRoute === "backend.domain" ? `
                        <button class="text-green-500 text-xs flex items-center ml-2" onclick="editAction('${data.domain}')">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </button>
                         <button class="text-blue-500 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm" onclick="showDomainToken('${domainName}', '${domainType}')">
                            <i class="fa fa-server mr-1"></i> Token
                        </button>

                        <button class="text-red-500 text-xs flex items-center ml-2" onclick="deleteAction('${data.domain}')">
                            <i class="fas fa-trash mr-1"></i> Delete
                        </button>
                    ` : ""}
                `;

                document.getElementById("domainInfo").classList.remove("hidden");
            })
            .catch(error => console.error("Error fetching domain details:", error));
    };

    /* Domain Token Functions */
    window.showDomainToken = function (domainName, domainType) {
        console.log("domainType ", domainType);

        fetch(domainTokenUrl.replace(':domain', encodeURIComponent(domainName)))
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (!data) {
                    throw new Error("No data received from server");
                }

                if (domainType === "addon"){
                    const fieldsContainer = document.getElementById("addon-domain-token-fields");
                    fieldsContainer.innerHTML = `
                            <div class="mb-4">
                                <label for="cpanel_token_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    token name
                                </label>
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                    <input id="cpanel_token_name" type="text" name="cpanel_token_name" value="${data.cpanel_token_name || ''}" placeholder="token name"
                                        class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="cpanel_user" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    cpanel user
                                </label>
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                    <input id="cpanel_user" type="text" name="cpanel_user" value="${data.cpanel_user || ''}" placeholder="cpanel user"
                                        class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="cpanel_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    cpanel password
                                </label>
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                    <input id="cpanel_password" type="text" name="cpanel_password" value="${data.cpanel_password || ''}" placeholder="cpanel password"
                                        class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="domain" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    domain
                                </label>
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                    <input id="domain" type="text" name="whm_host" value="${domainName}" placeholder="domain" class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="whm_api_token" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    cPanel Domain Token
                                </label>
                                <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                    <input id="token" type="text" name="token" value="${data.token || ''}" placeholder="cPanel Domain Token"
                                        class="w-full bg-transparent focus:outline-none dark:text-gray-200 pr-8">
                                    <button type="button" onclick="copyToClipboard('token')"
                                        class="ml-2 p-1 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none">
                                        <i class="far fa-copy"></i>
                                        <span class="sr-only">Copy to clipboard</span>
                                    </button>
                                </div>
                                <p id="token-copy-message" class="hidden text-xs text-green-600 dark:text-green-400 mt-1">Copied!</p>
                            </div>
                        `;
                    document.getElementById("domainTokenModal").classList.remove("hidden");
            }
                if (domainType === "sub" || domainType === "main") {
                    const fieldsContainer = document.getElementById("main-domain-token-fields");
                    fieldsContainer.innerHTML = `
                        <div class="mb-4">
                            <label for="cpanel_token_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                token name
                            </label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                <input id="cpanel_token_name" type="text" name="cpanel_token_name" value="${data.cpanel_token_name || ''}" placeholder="token name"
                                    class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                            </div>
                        </div>


                        <div class="mb-4">
                            <label for="cpanel_user" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                cpanel user
                            </label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                <input id="cpanel_user" type="text" name="cpanel_user" value="${data.cpanel_user || ''}" placeholder="cpanel user"
                                    class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="cpanel_password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                cpanel password
                            </label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                <input id="cpanel_password" type="text" name="cpanel_password" value="${data.cpanel_password || ''}" placeholder="cpanel password"
                                    class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="domain" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                domain
                            </label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                <input id="domain" type="text" name="whm_host" value="${domainName}" placeholder="domain" class="w-full bg-transparent focus:outline-none dark:text-gray-200">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="whm_api_token" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                cPanel Domain Token
                            </label>
                            <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg p-2 mt-1">
                                <input id="token" type="text" name="token" value="${data.token || ''}" placeholder="cPanel Domain Token"
                                    class="w-full bg-transparent focus:outline-none dark:text-gray-200 pr-8">
                                <button type="button" onclick="copyToClipboard('token')"
                                    class="ml-2 p-1 text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 focus:outline-none">
                                    <i class="far fa-copy"></i>
                                    <span class="sr-only">Copy to clipboard</span>
                                </button>
                            </div>
                            <p id="token-copy-message" class="hidden text-xs text-green-600 dark:text-green-400 mt-1">Copied!</p>
                        </div>
                    `;
                    document.getElementById("generateDomainToken").classList.remove("hidden");
                }
            })
            .catch(error => {
                console.error("Error fetching domain token:", error);
                alert("Failed to load domain token. Please try again.");
            });
    }

    /* CLOSE MODAL */
    window.closeDomainDetailModal = function () {
        document.getElementById("domainInfo").classList.add("hidden");
    };
});

function copyToClipboard(elementId) {
    const element = document.getElementById(elementId);
    const message = document.getElementById('token-copy-message');

    // Select the text
    element.select();
    element.setSelectionRange(0, 99999); // For mobile devices
    navigator.clipboard.writeText(element.value)
        .then(() => {
            message.classList.remove('hidden');
            setTimeout(() => message.classList.add('hidden'), 2000);
        })
        .catch(err => {
            console.error('Failed to copy: ', err);
        });
}
