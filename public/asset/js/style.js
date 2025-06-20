document.addEventListener('DOMContentLoaded', function() {
    const darkMode = localStorage.getItem('dark') === 'true';

    // Set initial state based on localStorage
    if (darkMode) {
        document.documentElement.classList.add('dark');
        document.getElementById('dark-icon').style.display = 'inline';
        document.getElementById('light-icon').style.display = 'none';
    } else {
        document.documentElement.classList.remove('dark');
        document.getElementById('dark-icon').style.display = 'none';
        document.getElementById('light-icon').style.display = 'inline';
    }
});

// Function to toggle dark mode
function toggleDarkMode() {
    const isDarkMode = document.documentElement.classList.contains('dark');
    const darkMode = !isDarkMode;

    // Set dark mode state in localStorage
    localStorage.setItem('dark', darkMode);

    // Toggle the dark mode class on the <html> element
    if (darkMode) {
        document.documentElement.classList.add('dark');
        document.getElementById('dark-icon').style.display = 'inline';
        document.getElementById('light-icon').style.display = 'none';
    } else {
        document.documentElement.classList.remove('dark');
        document.getElementById('dark-icon').style.display = 'none';
        document.getElementById('light-icon').style.display = 'inline';
    }
}

 /* Function to apply dark mode */
window.applyDarkModeToDataTable = function() {
    const isDarkMode = document.documentElement.classList.contains('dark');

    document.querySelectorAll(".nextbyte-table tbody tr").forEach(row => {
        if (isDarkMode) {
            row.classList.add("dark:bg-gray-900", "text-white");
            row.classList.remove("bg-white", "text-black");
        } else {
            row.classList.add("bg-white", "text-black");
            row.classList.remove("dark:bg-gray-900", "text-white");
        }
    });
}


/* Detect theme changes dynamically */
const observer = new MutationObserver(() => {
    applyDarkModeToDataTable(); // Apply dark mode changes immediately
});

/*Observe changes in the <html> class list */
observer.observe(document.documentElement, { attributes: true, attributeFilter: ["class"] });

/* Apply dark mode on table redraw */
document.addEventListener("DOMContentLoaded", function () {
    applyDarkModeToDataTable();
});
/* END OF DARK AND RIGHt MODE */



/* COLLAPSE PAGE OF IN SIDEBAR */
document.querySelectorAll('.Collapse-relative > button').forEach(button => {
    button.addEventListener('click', () => {
        const collapseContent = button.nextElementSibling;  // Get the sibling element (collapse content)
        collapseContent.classList.toggle('hidden');  // Toggle visibility of the collapse content
    });
});

// User dropdown (for user info with avatar)
document.getElementById('dropdownButton').addEventListener('click', function() {
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownMenu.classList.toggle('hidden');
    dropdownMenu.classList.toggle('opacity-0');
});
/*END OF COLLAPSE PAGE */


/* TOGGLE MODALS */
window.openModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) {
        console.error(`Modal with ID '${modalId}' not found.`);
        return;
    }
    modal.classList.remove('hidden');
};

window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
    }
};

/* END OF MODALS */


/* SELECT-2 */
document.addEventListener("DOMContentLoaded", function () {
    if (typeof $ !== "undefined") {
        $('#select2-example').select2({
            width: '100%',
            theme: 'classic'
        });
        function applyDarkModeStyles() {
            $('.select2-selection').addClass('p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white');
            $('.select2-dropdown, .select2-results').addClass('dark:bg-gray-900 dark:text-white');
            $('.select2-container').addClass('dark:border-gray-600');
        }

        applyDarkModeStyles();
        $(document).on('select2:open', function () {
            applyDarkModeStyles();
        });
    } else {
        console.error("jQuery is not loaded. Please include jQuery before this script.");
    }
});


document.addEventListener("DOMContentLoaded", function () {
    if (typeof $ !== "undefined") {
        $('.nextbyte-select2').select2({
            width: '100%',
            theme: 'classic'
        });
        function applyDarkModeStyles() {
            $('.select2-selection').addClass('p-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-300 dark:bg-gray-800 dark:border-gray-600 dark:text-white');
            $('.select2-dropdown, .select2-results').addClass('dark:bg-gray-900 dark:text-white');
            $('.select2-container').addClass('dark:border-gray-600');
        }

        applyDarkModeStyles();
        $(document).on('select2:open', function () {
            applyDarkModeStyles();
        });
    } else {
        console.error("jQuery is not loaded. Please include jQuery before this script.");
    }
});
/* END OF SELECT2 */

/* BACK TO TOP BUTTON */
document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.getElementById("backToTopBtn");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) {
            backToTopButton.style.display = "block";
        } else {
            backToTopButton.style.display = "none";
        }
    });
});

window.scrollToTop = function () {
    window.scrollTo({ top: 0, behavior: "smooth" });
}
/* END OF BACK TO TOP BUTTON */

window.sendAjaxRequest = function (url, formData, fieldType) {
    $("#loader").removeClass("hidden");

    $.ajax({
        url: url,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        headers: { "X-CSRF-TOKEN": formData.get("_token") },
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
}

document.addEventListener("DOMContentLoaded", function () {
    fetch(domainUrl)
        .then(response => response.json())
        .then(responseData => {
            let domains = responseData.data;
            let select = document.querySelector(".select_domain");

            select.innerHTML = `<option selected hidden disabled>Choose a domain</option>`;

            domains.forEach(domain => {
                let option = document.createElement("option");
                option.value = domain.id;
                option.textContent = domain.name;
                select.appendChild(option);
            });
        })
        .catch(error => console.error("Error fetching domains:", error));
});


// Ensure the function is globally available
window.generateStrongPassword = function (length = 12) {
    const chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+";
    let password = "";
    for (let i = 0; i < length; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    return password;
}

// Event delegation for generating password
document.addEventListener("click", function (event) {
    if (event.target.closest(".generate_password")) {
        const newPassword = generateStrongPassword();
        document.getElementById("new_password").value = newPassword;
        document.getElementById("password_confirmation").value = newPassword;
    }
});

// Event delegation for toggling password visibility
document.addEventListener("click", function (event) {
    const viewPasswordBtn = event.target.closest(".view_password");
    if (viewPasswordBtn) {
        const passwordField = document.getElementById("new_password");
        const confirmPasswordField = document.getElementById("password_confirmation");
        const type = passwordField.type === "password" ? "text" : "password";

        passwordField.type = type;
        confirmPasswordField.type = type;

        const icon = viewPasswordBtn.querySelector("i");
        if (icon) {
            icon.classList.toggle("fa-eye");
            icon.classList.toggle("fa-eye-slash");
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-user-btn").forEach(button => {
        button.addEventListener("click", function () {
            const deleteRoute = this.dataset.route;
            deleteUser(deleteRoute);
        });
    });
});

window.deleteUser = function (route) {
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
            fetch(route, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: data.status === 200 ? "success" : "error",
                        title: data.message,
                    }).then(() => {
                        console.log(data.url_destination);
                        console.log(data.status);
                        if (data.status === 200 && data.url_destination) {
                            window.location.href = data.url_destination;
                        }
                    });
                })
                .catch(() => {
                    Swal.fire("Error!", "Failed to connect to the server.", "error");
                });
        }
    });
};

window.pleaseWaitSubmitButton = function (buttonId, labelId, message, mode) { //todo delete this function
    const $button = $('#' + buttonId);
    const $label = $('#' + labelId);

    if (mode === 1) {
        $button.prop('disabled', true).text(message + '...');
        $label.text(message + '...');
    } else if (mode === 2) {
        $button.on('click', function () {
            $(this).prop('disabled', true).text(message + '...');
            $label.text(message + '...');
        });
    }
};


document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.pleaseWaitSubmitButton');

    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            await handleDomainTokenUpdate(this);
        });
    }

    async function handleDomainTokenUpdate(form) {
        const formData = new FormData(form);
        const url = form.action;
        const submitButton = form.querySelector('button[type="submit"]');

        try {
            // Set loading state
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            submitButton.disabled = true;

            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Failed to update token');
            }

            showToast('success', data.message);

            // Refresh only on success
            setTimeout(() => window.location.reload(), 1500);
        } catch (error) {
            showToast('error', error.message || "Failed to update token");
        } finally {
            // Reset button state
            submitButton.innerHTML = '<i class="fas fa-save"></i> Save';
            submitButton.disabled = false;
        }
    }

    function showToast(icon, message) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        Toast.fire({
            icon: icon,
            title: message
        });
    }
});
