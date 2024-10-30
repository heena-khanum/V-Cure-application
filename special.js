document.addEventListener("DOMContentLoaded", () => {
    const doctorCards = document.querySelectorAll('.doctor-card');
    const bodyContent = document.querySelector('body');

    doctorCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            // Add blur effect to the body content
            bodyContent.classList.add('blur-background');

            // Clone and expand the card
            const expandedCard = card.cloneNode(true);
            expandedCard.classList.add('expanded-card');
            expandedCard.style.position = 'fixed';
            expandedCard.style.top = '50%';
            expandedCard.style.left = '50%';
            expandedCard.style.transform = 'translate(-50%, -50%)';
            expandedCard.style.zIndex = '1000';

            // Append to body
            document.body.appendChild(expandedCard);

            // Close card on mouse leave
            expandedCard.addEventListener('mouseleave', () => {
                expandedCard.classList.add('fade-out'); // Smooth exit
                setTimeout(() => {
                    expandedCard.remove();
                    bodyContent.classList.remove('blur-background');
                }, 300);
            });
        });
    });
});
