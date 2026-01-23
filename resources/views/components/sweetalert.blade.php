@if (session()->has('swal_type'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: @json(session('swal_type')),
                title: @json(session('swal_title')),
                text: @json(session('swal_text')),
                confirmButtonColor: '#ffbf0f'
            });
        });
    </script>
@endif
