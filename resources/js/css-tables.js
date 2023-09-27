document.addEventListener('click', function(e) {
    let spoiler;
    if (spoiler = e.target.closest(".row-spoiler")) {
        spoiler.classList.toggle('active');
    }
})
