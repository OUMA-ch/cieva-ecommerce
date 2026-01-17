document.querySelectorAll('.form-container .input-container').forEach(container => {
    const input = container.querySelector('input:not([type="file"])');
    if (input) {
        input.addEventListener('focus', () => {
            container.classList.add('input-focus');
        });
        input.addEventListener('blur', () => {
            container.classList.remove('input-focus');
        });
    }
});
