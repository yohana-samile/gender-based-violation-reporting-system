
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div>
            <h4 class="text-xl font-bold text-center text-gray-800">{{ __('Login') }}</h4>
        </div>

        <div class="text-center">
            <x-loader></x-loader>
        </div>

        <form method="POST" id="login" action="{{ route('log_me_in') }}" class="form bg-white w-full">
            @csrf

            <div class="inputForm mt-5 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 32 32" height="20"><g data-name="Layer 3" id="Layer_3"><path d="m30.853 13.87a15 15 0 0 0 -29.729 4.082 15.1 15.1 0 0 0 12.876 12.918 15.6 15.6 0 0 0 2.016.13 14.85 14.85 0 0 0 7.715-2.145 1 1 0 1 0 -1.031-1.711 13.007 13.007 0 1 1 5.458-6.529 2.149 2.149 0 0 1 -4.158-.759v-10.856a1 1 0 0 0 -2 0v1.726a8 8 0 1 0 .2 10.325 4.135 4.135 0 0 0 7.83.274 15.2 15.2 0 0 0 .823-7.455zm-14.853 8.13a6 6 0 1 1 6-6 6.006 6.006 0 0 1 -6 6z"></path></g></svg>
                <input placeholder="Enter your Email"  name="email" class="input bg-white" type="text" required autofocus autocomplete="username" />
            </div>

            <div class="inputForm mt-5 mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="-64 0 512 512" height="20"><path d="m336 512h-288c-26.453125 0-48-21.523438-48-48v-224c0-26.476562 21.546875-48 48-48h288c26.453125 0 48 21.523438 48 48v224c0 26.476562-21.546875 48-48 48zm-288-288c-8.8125 0-16 7.167969-16 16v224c0 8.832031 7.1875 16 16 16h288c8.8125 0 16-7.167969 16-16v-224c0-8.832031-7.1875-16-16-16zm0 0"></path><path d="m304 224c-8.832031 0-16-7.167969-16-16v-80c0-52.929688-43.070312-96-96-96s-96 43.070312-96 96v80c0 8.832031-7.167969 16-16 16s-16-7.167969-16-16v-80c0-70.59375 57.40625-128 128-128s128 57.40625 128 128v80c0 8.832031-7.167969 16-16 16zm0 0"></path></svg>
                <input placeholder="Enter your Password" class="input bg-white" type="password"  id="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="flex-row">
                <div>
                    <input type="radio" id="remember_me" name="remember_me">
                    <label for="remember_me">{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <x-button id="loginButton" onsubmit="login(event)"> {{__('Sign In')}}</x-button>
            <div class="flex items-center justify-end mt-4">
                <p class="p">{{__("Dont have account? registered ")}}<span class="span"><a href="{{ route('register')}}">{{__(' Sign Up')}}</a></span>
            </div>
        </form>
    </x-authentication-card>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        jQuery(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function handleLoginResponse(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: "success",
                        title: response.message,
                    }).then(() => {
                        window.location.href = response.url_destination;
                    });
                }
                else if (response.status === 'error') {
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
                }
                else {
                    Swal.fire({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        icon: "error",
                        title: 'Failed to log in. Please try again.',
                    });
                }
            }

            $("#login").submit(function (event) {
                event.preventDefault();
                $("#loader").removeClass("hidden");

                const formData = $(this).serialize();
                const loginButton = $('#loginButton').prop('disabled', true);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        handleLoginResponse(response);
                    },
                    error: function (xhr) {
                        let errorMessage = xhr.responseJSON?.message || "An error occurred. Please try again.";
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
                        loginButton.prop('disabled', false);
                    },
                });
            });
        });
    </script>
</x-guest-layout>
