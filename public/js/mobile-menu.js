// Mobile Menu Drag Functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenu = document.querySelector('.mobile-horizontal-menu');
    const dragHandle = document.getElementById('mobileMenuDragHandle');
    const menuContainer = document.getElementById('mobileMenuContainer');

    if (!mobileMenu || !dragHandle || !menuContainer) return;

    let isDragging = false;
    let startY = 0;
    let currentY = 0;
    let menuHeight = mobileMenu.offsetHeight;
    let isMenuVisible = true;

    // Touch events for mobile drag
    dragHandle.addEventListener('touchstart', function(e) {
        isDragging = true;
        startY = e.touches[0].clientY;
        dragHandle.style.cursor = 'grabbing';
        mobileMenu.style.transition = 'none';
    });

    document.addEventListener('touchmove', function(e) {
        if (!isDragging) return;

        currentY = e.touches[0].clientY;
        const deltaY = currentY - startY;

        if (deltaY > 0) { // Dragging down
            const newHeight = Math.max(0, menuHeight - deltaY);
            mobileMenu.style.transform = `translateY(${menuHeight - newHeight}px)`;
        }
    });

    document.addEventListener('touchend', function(e) {
        if (!isDragging) return;

        isDragging = false;
        dragHandle.style.cursor = 'grab';
        mobileMenu.style.transition = 'transform 0.3s ease';

        const deltaY = currentY - startY;

        if (deltaY > 50) { // Hide menu if dragged down more than 50px
            mobileMenu.style.transform = `translateY(${menuHeight}px)`;
            isMenuVisible = false;

            // Auto-show after 3 seconds
            setTimeout(() => {
                if (!isMenuVisible) {
                    mobileMenu.style.transform = 'translateY(0)';
                    isMenuVisible = true;
                }
            }, 3000);
        } else {
            // Snap back to visible position
            mobileMenu.style.transform = 'translateY(0)';
            isMenuVisible = true;
        }
    });

    // Mouse events for desktop testing
    dragHandle.addEventListener('mousedown', function(e) {
        isDragging = true;
        startY = e.clientY;
        dragHandle.style.cursor = 'grabbing';
        mobileMenu.style.transition = 'none';
        e.preventDefault();
    });

    document.addEventListener('mousemove', function(e) {
        if (!isDragging) return;

        currentY = e.clientY;
        const deltaY = currentY - startY;

        if (deltaY > 0) {
            const newHeight = Math.max(0, menuHeight - deltaY);
            mobileMenu.style.transform = `translateY(${menuHeight - newHeight}px)`;
        }
    });

    document.addEventListener('mouseup', function(e) {
        if (!isDragging) return;

        isDragging = false;
        dragHandle.style.cursor = 'grab';
        mobileMenu.style.transition = 'transform 0.3s ease';

        const deltaY = currentY - startY;

        if (deltaY > 50) {
            mobileMenu.style.transform = `translateY(${menuHeight}px)`;
            isMenuVisible = false;

            setTimeout(() => {
                if (!isMenuVisible) {
                    mobileMenu.style.transform = 'translateY(0)';
                    isMenuVisible = true;
                }
            }, 3000);
        } else {
            mobileMenu.style.transform = 'translateY(0)';
            isMenuVisible = true;
        }
    });

    // Horizontal scrolling with momentum
    let scrollVelocity = 0;
    let lastScrollTime = 0;
    let scrollAnimation = null;

    menuContainer.addEventListener('touchstart', function(e) {
        if (scrollAnimation) {
            cancelAnimationFrame(scrollAnimation);
            scrollAnimation = null;
        }
        scrollVelocity = 0;
        lastScrollTime = Date.now();
    });

    menuContainer.addEventListener('touchmove', function(e) {
        const currentTime = Date.now();
        const deltaTime = currentTime - lastScrollTime;

        if (deltaTime > 0) {
            scrollVelocity = (e.touches[0].clientX - (menuContainer.lastTouchX || e.touches[0].clientX)) / deltaTime;
        }

        menuContainer.lastTouchX = e.touches[0].clientX;
        lastScrollTime = currentTime;
    });

    menuContainer.addEventListener('touchend', function(e) {
        // Apply momentum scrolling
        if (Math.abs(scrollVelocity) > 0.1) {
            const momentum = function() {
                menuContainer.scrollLeft += scrollVelocity * 16;
                scrollVelocity *= 0.95; // Friction

                if (Math.abs(scrollVelocity) > 0.01) {
                    scrollAnimation = requestAnimationFrame(momentum);
                } else {
                    scrollAnimation = null;
                }
            };
            momentum();
        }
    });
});