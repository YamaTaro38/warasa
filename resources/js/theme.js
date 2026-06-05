// Theme Manager with better contrast
class ThemeManager {
    constructor() {
        this.theme = localStorage.getItem('theme') || 'light';
        this.init();
    }
    
    init() {
        if (this.theme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        this.updateButton();
        this.updateContrast();
    }
    
    toggle() {
        if (this.theme === 'light') {
            this.theme = 'dark';
            document.documentElement.classList.add('dark');
        } else {
            this.theme = 'light';
            document.documentElement.classList.remove('dark');
        }
        localStorage.setItem('theme', this.theme);
        this.updateButton();
        this.updateContrast();
    }
    
    updateButton() {
        const buttons = document.querySelectorAll('.theme-toggle-btn');
        buttons.forEach(btn => {
            if (btn) {
                if (this.theme === 'dark') {
                    btn.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    btn.innerHTML = '<i class="fas fa-moon"></i>';
                }
            }
        });
    }
    
    updateContrast() {
        // Update glassmorphism cards for better contrast
        const glassCards = document.querySelectorAll('.glass-card');
        glassCards.forEach(card => {
            if (this.theme === 'dark') {
                card.classList.add('glass-card-dark');
            } else {
                card.classList.remove('glass-card-dark');
            }
        });
    }
}

// Initialize
const themeManager = new ThemeManager();
window.themeManager = themeManager;
window.toggleTheme = () => themeManager.toggle();