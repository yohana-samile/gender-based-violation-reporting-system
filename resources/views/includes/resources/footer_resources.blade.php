

        @if(session('error'))
            <script>
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: @json(session('error')),
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                });
            </script>
        @endif
        <script src="{{ asset('asset/js/packages/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('asset/js/packages/jquery.dataTables.min.js') }}"></script>
        <!-- Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('asset/js/style.js') }}" defer></script>
        @livewireScripts
        @stack('after-scripts')
    </body>
</html>
