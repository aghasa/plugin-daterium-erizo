document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.daterium-brand-family');
    const menuItems = document.querySelectorAll('.daterium-brand-menu-list-title a');

    function updateMenu() {
        let currentSection = null;

        sections.forEach(section => {
            const rect = section.getBoundingClientRect();
            if (rect.top <= 50 && rect.bottom >= 50) {
                currentSection = section;
            }
        });

        if (currentSection) {
            const currentSectionId = currentSection.id;
            menuItems.forEach(menuItem => {
                const href = menuItem.getAttribute('href').substring(1);
                if (href === currentSectionId) {
                    const menuText = menuItem.getAttribute('data-original-text');
                    menuItem.innerHTML = `&#x27F6; ${menuText}`;
                    menuItem.classList.add('daterium-brand-menu-list-active');
                } else {
                    const originalText = menuItem.getAttribute('data-original-text');
                    menuItem.innerHTML = `&#8213; ${originalText}`;
                    menuItem.classList.remove('daterium-brand-menu-list-active');
                }
            });
        }
    }

    document.addEventListener('scroll', updateMenu);
    updateMenu();
});



document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.daterium-brand-toggle');

    buttons.forEach(button => {
        button.addEventListener('click', function(event) {
            const id = button.getAttribute('subfamily-id');
            const buttonIcon = document.querySelector(`#${id} .daterium-brand-toggle-button`);
            const content = document.querySelector(`#${id} .daterium-lista-categorias-container`);
            const contentParent = content.parentElement;

            if (content.classList.contains('daterium-lista-collapsed')) {
                content.classList.remove('daterium-lista-collapsed');
                buttonIcon.textContent = '-';
            } else {
                content.classList.add('daterium-lista-collapsed');
                buttonIcon.textContent = '+';
            }
            
            // Prevent the click event from bubbling up to the title
            event.stopPropagation();
        });
    });

    function checkScreenWidth() {
        const contents = document.querySelectorAll('.daterium-lista-categorias-container');
        const buttons = document.querySelectorAll('.daterium-brand-toggle-button');
        if (window.innerWidth <= 920) {
            contents.forEach(content => {
                content.classList.add('daterium-lista-collapsed');
            });
            buttons.forEach(button => button.textContent = '+');
        } else {
            contents.forEach(content => {
                content.classList.remove('daterium-lista-collapsed');
            });
            buttons.forEach(button => button.textContent = '-');
        }
    }

    window.addEventListener('resize', checkScreenWidth);
    checkScreenWidth();
});

