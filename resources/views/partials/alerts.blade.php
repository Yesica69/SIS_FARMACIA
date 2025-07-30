@php
use Illuminate\Support\Str;
@endphp

@if(session('mensaje') && !Str::contains(strtolower(session('mensaje')), ['eliminado', 'borrado', 'eliminación']))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: '{{ session('icono', 'success') }}',
            title: '{{ session('mensaje') }}',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            position: 'top-end',
            toast: true,
            background: '#f8f9fa',
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        });
    });
</script>
@endif