@extends('layouts.frontend.app')
@section('title', 'Report New Incident')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('frontend.incident.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-8">
                            <h3 class="text-lg font-medium mb-4">Incident Details</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="title" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                    <select name="type" id="type" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select incident type</option>
                                        @foreach($incidentTypes as $type)
                                            <option value="{{ $type->name }}"> {{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="occurred_at" class="block text-sm font-medium text-gray-700">Date &
                                        Time Occurred</label>
                                    <input type="datetime-local" name="occurred_at" id="occurred_at" required
                                           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>

                                <!-- Location -->
                                <div>
                                    <label for="location"
                                           class="block text-sm font-medium text-gray-700">Location</label>
                                    <select name="location" id="location" required
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select location of incident</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->name }}"> {{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="is_anonymous" id="is_anonymous" value="1"
                                           class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                    <label for="is_anonymous" class="ml-2 block text-sm text-gray-700">
                                        Report anonymously
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4">
                                <label for="description"
                                       class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea name="description" id="description" rows="4" required
                                          class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                            </div>
                        </div>

                        <!-- Victims -->
                        <div class="mb-8" id="victims-section">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Victim(s) Information</h3>
                                <button type="button" id="add-victim"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Add Another Victim
                                </button>
                            </div>

                            <div class="victim-form space-y-4">
                                <!-- First victim (always present) -->
                                <div class="victim border border-gray-200 p-4 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Name -->
                                        <div>
                                            <label for="victims[0][name]"
                                                   class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" name="victims[0][name]" id="victims[0][name]"
                                                   class="victim-name mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>

                                        <!-- Gender -->
                                        <div>
                                            <label for="victims[0][gender]"
                                                   class="block text-sm font-medium text-gray-700">Gender</label>
                                            <select name="victims[0][gender]" id="victims[0][gender]" required
                                                    class="select-gender mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">Select gender</option>
                                                @foreach($genders as $gender)
                                                    <option value="{{ $gender->name }}"> {{ $gender->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div>
                                            <label for="victims[0][age]"
                                                   class="block text-sm font-medium text-gray-700">Age</label>
                                            <input type="number" name="victims[0][age]" id="victims[0][age]" min="0"
                                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>

                                        <!-- Vulnerability -->
                                        <div>
                                            <label for="victims[0][vulnerability]"
                                                   class="block text-sm font-medium text-gray-700">Vulnerability</label>
                                            <select name="victims[0][vulnerability]" id="victims[0][vulnerability]"
                                                    class="select-vulnerability mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                                <option value="">Select if applicable</option>
                                                @foreach($vulnerabilities as $vulnerability)
                                                    <option value="{{ $vulnerability->name }}"> {{ $vulnerability->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Contact Number -->
                                        <div>
                                            <label for="victims[0][contact_number]"
                                                   class="block text-sm font-medium text-gray-700">Contact
                                                Number</label>
                                            <input type="text" name="victims[0][contact_number]"
                                                   id="victims[0][contact_number]"
                                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>

                                        <!-- Contact Email -->
                                        <div>
                                            <label for="victims[0][contact_email]"
                                                   class="block text-sm font-medium text-gray-700">Contact Email</label>
                                            <input type="email" name="victims[0][contact_email]"
                                                   id="victims[0][contact_email]"
                                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="mt-4">
                                        <label for="victims[0][address]"
                                               class="block text-sm font-medium text-gray-700">Address</label>
                                        <textarea name="victims[0][address]" id="victims[0][address]" rows="2"
                                                  class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Perpetrators -->
                        <div class="mb-8" id="perpetrators-section">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Perpetrator(s) Information</h3>
                                <button type="button" id="add-perpetrator"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Add Another Perpetrator
                                </button>
                            </div>

                            <div class="perpetrator-form space-y-4">
                                <!-- Perpetrator form will be added here via JavaScript -->
                            </div>
                        </div>

                        <!-- Evidence -->
                        <div class="mb-8" id="evidence-section">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium">Evidence</h3>
                                <button type="button" id="add-evidence"
                                        class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Add More Evidence
                                </button>
                            </div>

                            <div class="evidence-form space-y-4">
                                <div class="evidence border border-gray-200 p-4 rounded-lg">
                                    <div class="grid grid-cols-1 gap-6">
                                        <!-- File -->
                                        <div>
                                            <label for="evidence[0][file]"
                                                   class="block text-sm font-medium text-gray-700">File</label>
                                            <input type="file" name="evidence[0][file]" id="evidence[0][file]"
                                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        </div>

                                        <!-- Description -->
                                        <div>
                                            <label for="evidence[0][description]"
                                                   class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="evidence[0][description]" id="evidence[0][description]"
                                                      rows="2"
                                                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Add victim
        document.getElementById('add-victim').addEventListener('click', function () {
            const victimForm = document.querySelector('.victim-form');
            const victimCount = document.querySelectorAll('.victim').length;

            const newVictim = document.createElement('div');
            newVictim.className = 'victim border border-gray-200 p-4 rounded-lg mt-4';
            newVictim.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-md font-medium">Victim #${victimCount + 1}</h4>
                    <button type="button" class="remove-victim text-red-600 hover:text-red-800 text-sm">Remove</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="victims[${victimCount}][name]" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="victims[${victimCount}][name]" id="victims[${victimCount}][name]"
                            class="victim-name mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="victims[${victimCount}][gender]" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="victims[${victimCount}][gender]" id="victims[${victimCount}][gender]" required
                            class="select-gender mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Select gender</option>
                             @foreach($genders as $gender)
            <option value="{{ $gender->name }}"> {{ $gender->name }}</option>
                            @endforeach
            </select>
        </div>

        <!-- Age -->
        <div>
            <label for="victims[${victimCount}][age]" class="block text-sm font-medium text-gray-700">Age</label>
                        <input type="number" name="victims[${victimCount}][age]" id="victims[${victimCount}][age]" min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Vulnerability -->
                    <div>
                        <label for="victims[${victimCount}][vulnerability]" class="block text-sm font-medium text-gray-700">Vulnerability</label>
                        <select name="victims[${victimCount}][vulnerability]" id="victims[${victimCount}][vulnerability]"
                            class="select-vulnerability mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Select if applicable</option>
                             @foreach($vulnerabilities as $vulnerability)
            <option value="{{ $vulnerability->name }}"> {{ $vulnerability->name }}</option>
                            @endforeach
            </select>
        </div>

        <!-- Contact Number -->
        <div>
            <label for="victims[${victimCount}][contact_number]" class="block text-sm font-medium text-gray-700">Contact Number</label>
                        <input type="text" name="victims[${victimCount}][contact_number]" id="victims[${victimCount}][contact_number]"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Contact Email -->
                    <div>
                        <label for="victims[${victimCount}][contact_email]" class="block text-sm font-medium text-gray-700">Contact Email</label>
                        <input type="email" name="victims[${victimCount}][contact_email]" id="victims[${victimCount}][contact_email]"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Address -->
                <div class="mt-4">
                    <label for="victims[${victimCount}][address]" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea name="victims[${victimCount}][address]" id="victims[${victimCount}][address]" rows="2"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                </div>
            `;

            victimForm.appendChild(newVictim);

            // Add event listener to remove button
            newVictim.querySelector('.remove-victim').addEventListener('click', function () {
                victimForm.removeChild(newVictim);
            });
        });

        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = 'Submitting...';

            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw err;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        // Handle success (though ideally you should always redirect)
                        alert('Incident created successfully!');
                        window.location.reload();
                    }
                })
                .catch(error => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Submit Report';

                    let errorMessage = 'An error occurred';
                    if (error.errors) {
                        errorMessage = Object.values(error.errors).join('\n');
                    } else if (error.message) {
                        errorMessage = error.message;
                    }

                    alert(errorMessage);
                });
        });

        // Add perpetrator
        document.getElementById('add-perpetrator').addEventListener('click', function () {
            const perpetratorForm = document.querySelector('.perpetrator-form');
            const perpetratorCount = document.querySelectorAll('.perpetrator').length;

            const newPerpetrator = document.createElement('div');
            newPerpetrator.className = 'perpetrator border border-gray-200 p-4 rounded-lg';
            newPerpetrator.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-md font-medium">Perpetrator #${perpetratorCount + 1}</h4>
                    <button type="button" class="remove-perpetrator text-red-600 hover:text-red-800 text-sm">Remove</button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="perpetrators[${perpetratorCount}][name]" class="block text-sm font-medium text-gray-700">Name (if known)</label>
                        <input type="text" name="perpetrators[${perpetratorCount}][name]" id="perpetrators[${perpetratorCount}][name]"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Gender -->
                    <div>
                        <label for="perpetrators[${perpetratorCount}][gender]" class="block text-sm font-medium text-gray-700">Gender</label>
                        <select name="perpetrators[${perpetratorCount}][gender]" id="perpetrators[${perpetratorCount}][gender]" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">Select gender</option>
                            @foreach($genders as $gender)
            <option value="{{ $gender->name }}"> {{ $gender->name }}</option>
                            @endforeach
            </select>
        </div>

        <!-- Age -->
        <div>
            <label for="perpetrators[${perpetratorCount}][age]" class="block text-sm font-medium text-gray-700">Approximate Age</label>
                        <input type="number" name="perpetrators[${perpetratorCount}][age]" id="perpetrators[${perpetratorCount}][age]" min="0"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Relationship -->
                    <div>
                        <label for="perpetrators[${perpetratorCount}][relationship_to_victim]" class="block text-sm font-medium text-gray-700">Relationship to Victim</label>
                        <input type="text" name="perpetrators[${perpetratorCount}][relationship_to_victim]" id="perpetrators[${perpetratorCount}][relationship_to_victim]"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-4">
                    <label for="perpetrators[${perpetratorCount}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="perpetrators[${perpetratorCount}][description]" id="perpetrators[${perpetratorCount}][description]" rows="2"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                </div>
            `;

            perpetratorForm.appendChild(newPerpetrator);

            // Add event listener to remove button
            newPerpetrator.querySelector('.remove-perpetrator').addEventListener('click', function () {
                perpetratorForm.removeChild(newPerpetrator);
            });
        });

        // Add evidence
        document.getElementById('add-evidence').addEventListener('click', function () {
            const evidenceForm = document.querySelector('.evidence-form');
            const evidenceCount = document.querySelectorAll('.evidence').length;

            const newEvidence = document.createElement('div');
            newEvidence.className = 'evidence border border-gray-200 p-4 rounded-lg mt-4';
            newEvidence.innerHTML = `
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-md font-medium">Evidence #${evidenceCount + 1}</h4>
                    <button type="button" class="remove-evidence text-red-600 hover:text-red-800 text-sm">Remove</button>
                </div>
                <div class="grid grid-cols-1 gap-6">
                    <!-- File -->
                    <div>
                        <label for="evidence[${evidenceCount}][file]" class="block text-sm font-medium text-gray-700">File</label>
                        <input type="file" name="evidence[${evidenceCount}][file]" id="evidence[${evidenceCount}][file]"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="evidence[${evidenceCount}][description]" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="evidence[${evidenceCount}][description]" id="evidence[${evidenceCount}][description]" rows="2"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    </div>
                </div>
            `;

            evidenceForm.appendChild(newEvidence);

            // Add event listener to remove button
            newEvidence.querySelector('.remove-evidence').addEventListener('click', function () {
                evidenceForm.removeChild(newEvidence);
            });
        });

        // Toggle victim name requirement based on anonymous checkbox
        document.getElementById('is_anonymous').addEventListener('change', function () {
            const victimNames = document.querySelectorAll('.victim-name');
            victimNames.forEach(nameInput => {
                if (this.checked) {
                    nameInput.removeAttribute('required');
                } else {
                    nameInput.setAttribute('required', 'required');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            $('#type').select2({
                placeholder: 'Select incident type',
                allowClear: true,
                width: '100%'
            });

            $('#location').select2({
                placeholder: 'Select incident of location',
                allowClear: true,
                width: '100%'
            });

            $('.select-gender').select2({
                placeholder: 'Select gender',
                allowClear: true,
                width: '100%'
            });

            $('.select-vulnerability').select2({
                placeholder: 'Select if applicable',
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endsection
