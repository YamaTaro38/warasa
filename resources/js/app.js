import './bootstrap';
import './theme';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Dark mode toggle function for inline usage
window.toggleTheme = function() {
    if (window.themeManager) {
        window.themeManager.toggle();
    } else {
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }
};