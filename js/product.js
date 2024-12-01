document.addEventListener('DOMContentLoaded', function () {
    const mainImage = document.getElementById('mainImage');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const priceSelected = document.getElementById('price-selected');
    const buttons = document.querySelectorAll('.variants button');
    const increaseButton = document.getElementById('increase');
    const decreaseButton = document.getElementById('decrease');
    const quantitySpan = document.getElementById('quantity');
    const fullscreenContainer = document.getElementById('fullscreenContainer');
    const fullscreenImage = document.getElementById('fullscreenImage');
    const showMoreButton = document.getElementById('show-more');
    const hideMoreButton = document.getElementById('hide-more');

    let currentQuantity = 1;

    // Function to update the displayed price
    function updatePrice() {
        const selectedButton = document.querySelector('.variants .selected');
        const basePrice = parseFloat(selectedButton.getAttribute('price'));
        const totalPrice = basePrice * currentQuantity;
        priceSelected.textContent = `$${totalPrice.toFixed(2)}`;
    }

    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function () {
            thumbnails.forEach(img => img.classList.remove('selected'));
            this.classList.add('selected');
            mainImage.src = this.src;
            updatePrice(); // Call updatePrice to reflect any necessary changes
        });
    });

    // Set default price based on the initially selected button
    updatePrice();

    // Button functionality
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            buttons.forEach(btn => btn.classList.remove('selected'));
            this.classList.add('selected');

            // Reset quantity to 1 when a new variant is selected
            currentQuantity = 1;
            quantitySpan.textContent = currentQuantity;

            updatePrice();
        });
    });

    // Increase quantity
    increaseButton.addEventListener('click', function () {
        if (currentQuantity < 99) {
            currentQuantity++;
            quantitySpan.textContent = currentQuantity;
            updatePrice();
        }
    });

    // Decrease quantity
    decreaseButton.addEventListener('click', function () {
        if (currentQuantity > 1) {
            currentQuantity--;
            quantitySpan.textContent = currentQuantity;
            updatePrice();
        }
    });

    // Enlarge image to full screen on click
    mainImage.addEventListener('click', function () {
        fullscreenImage.src = this.src;
        fullscreenContainer.style.display = 'flex';
    });

    fullscreenContainer.addEventListener('click', function () {
        closeFullscreen();
    });

    // Close fullscreen on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeFullscreen();
        }
    });

    // Show more functionality with animation
    showMoreButton.addEventListener('click', function () {
        const hiddenThumbnails = document.querySelectorAll('.thumbnail.hidden');
        hiddenThumbnails.forEach((thumbnail, index) => {
            setTimeout(() => {
                thumbnail.classList.remove('hidden');
                thumbnail.classList.add('show');
            }, index * 50); // delay each thumbnail reveal by 500ms
        });
        setTimeout(() => {
            showMoreButton.style.display = 'none'; // Hide the show more button
            hideMoreButton.style.display = 'block'; // Show the hide button
        }, hiddenThumbnails.length * 50); // Show the hide button after all thumbnails are revealed
    });

    // Hide more functionality with animation
    hideMoreButton.addEventListener('click', function () {
        const visibleThumbnails = document.querySelectorAll('.thumbnail.show');
        visibleThumbnails.forEach((thumbnail, index) => {
            setTimeout(() => {
                thumbnail.classList.remove('show');
                thumbnail.classList.add('hidden');
            }, index * 50); // delay each thumbnail hide by 500ms
        });
        setTimeout(() => {
            hideMoreButton.style.display = 'none'; // Hide the hide button
            showMoreButton.style.display = 'block'; // Show the show more button
        }, visibleThumbnails.length * 50); // Show the show more button after all thumbnails are hidden
    });
});

function closeFullscreen() {
    const fullscreenContainer = document.getElementById('fullscreenContainer');
    fullscreenContainer.style.display = 'none';
}
