<!DOCTYPE html>
<html>
<head>
    <title>Akses Ditolak</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<script>
Swal.fire({
    icon: 'error',
    title: 'Akses Ditolak',
    text: 'Anda tidak memiliki hak akses untuk fitur ini.',
    confirmButtonColor: '#ef4444'
}).then(() => {
    window.location.href = '/dashboard';
});
</script>

</body>
</html>