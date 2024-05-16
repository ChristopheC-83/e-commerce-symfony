feather.replace();

document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.remove();
    }, 3000);
})