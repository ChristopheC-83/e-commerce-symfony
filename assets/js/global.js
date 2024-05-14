feather.replace();

console.log("coucou")

document.querySelectorAll('.alert').forEach(alert => {
    setTimeout(() => {
        alert.remove();
    }, 3000);
})