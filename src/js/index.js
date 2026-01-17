document.addEventListener('DOMContentLoaded', () => {
    const imgsContainer = document.getElementById('imgs-container');
    const nextBtn = document.getElementById('next-btn');
    const lastBtn = document.getElementById('last-btn');
    const images = imgsContainer.children;
    let imageWidth = images[0].clientWidth;
    let currentIndex = 0;

    nextBtn.addEventListener('click', () => {
        currentIndex++;
        if (currentIndex >= images.length) {
            currentIndex = 0; // Revenir à la première image
        }
        imgsContainer.scrollTo({
            left: currentIndex * imageWidth,
            behavior: 'smooth'
        });
        changerPointActive(currentIndex);
    });

    lastBtn.addEventListener('click', () => {
        currentIndex--;
        if (currentIndex < 0) {
            currentIndex = images.length - 1; // Revenir à la dernière image
        }
        imgsContainer.scrollTo({
            left: currentIndex * imageWidth,
            behavior: 'smooth'
        });
        changerPointActive(currentIndex);
    });

    function changerPointActive(index){
        console.log(index);
        
        const pointActive = document.querySelector('.point.active');
        pointActive.classList.remove('active');

        const newPointActive = document.querySelectorAll('.point')[index];
        newPointActive.classList.add('active');
        
    }
});