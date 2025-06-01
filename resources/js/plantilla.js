const sidebar = document.getElementById('sidebar');
const navbar = document.getElementById('navbar');
const toggleBtn = document.getElementById('toggleSidebar');
const toggleIcon = document.getElementById('toggleIcon');
const gearIcon = document.getElementById('gearIcon');
const settingsPanel = document.getElementById('colorSettings');
const darkToggle = document.getElementById('darkModeToggle');
const fullscreenToggle = document.getElementById('fullscreenToggle');
const body = document.body;

toggleBtn.onclick = () => {
  sidebar.classList.toggle('collapsed');
  toggleIcon.classList.toggle('bi-list');
  toggleIcon.classList.toggle('bi-x');
};

gearIcon.onclick = () => {
  settingsPanel.style.display = settingsPanel.style.display === 'none' ? 'block' : 'none';
};

darkToggle.onclick = () => {
  body.classList.toggle('dark-mode');
  darkToggle.classList.toggle('bi-moon');
  darkToggle.classList.toggle('bi-sun');
  localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
};

fullscreenToggle.onclick = () => {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().then(() => {
      fullscreenToggle.classList.remove('bi-arrows-fullscreen');
      fullscreenToggle.classList.add('bi-fullscreen-exit');
    }).catch(console.error);
  } else {
    document.exitFullscreen().then(() => {
      fullscreenToggle.classList.remove('bi-fullscreen-exit');
      fullscreenToggle.classList.add('bi-arrows-fullscreen');
    }).catch(console.error);
  }
};

window.setGradient = function (target, color1, color2) {
  const el = target === 'sidebar' ? sidebar : navbar;
  const direction = target === 'sidebar' ? 'to bottom' : 'to right';
  el.style.background = `linear-gradient(${direction}, ${color1}, ${color2})`;
  const contrast = window.isLightColor(color2) ? '#000' : '#fff';
  el.style.color = contrast;
  el.querySelectorAll('span, i, h4, .nav-link').forEach(e => e.style.color = contrast);
  localStorage.setItem(`${target}Gradient`, `${color1},${color2}`);
};

window.isLightColor = function (hex) {
  const rgb = parseInt(hex.replace('#', ''), 16);
  const r = (rgb >> 16) & 0xff, g = (rgb >> 8) & 0xff, b = rgb & 0xff;
  const brightness = 0.299 * r + 0.587 * g + 0.114 * b;
  return brightness > 186;
};

window.restoreDefault = function (target) {
  const defaults = {
    sidebar: ['#0d6efd', '#6ea8fe'],
    navbar: ['#ffffff', '#f8f9fa']
  };
  localStorage.removeItem(`${target}Gradient`);
  window.setGradient(target, ...defaults[target]);
};

window.applyInitialContrast = function () {
  const sidebarGradient = localStorage.getItem('sidebarGradient');
  const navbarGradient = localStorage.getItem('navbarGradient');
  const dark = localStorage.getItem('darkMode') === 'true';

  if (sidebarGradient) window.setGradient('sidebar', ...sidebarGradient.split(','));
  else window.restoreDefault('sidebar');

  if (navbarGradient) window.setGradient('navbar', ...navbarGradient.split(','));
  else window.restoreDefault('navbar');

  if (dark) {
    body.classList.add('dark-mode');
    darkToggle.classList.remove('bi-moon');
    darkToggle.classList.add('bi-sun');
  }
};

document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.toggle-submenu').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();
      const submenu = this.nextElementSibling;
      submenu.classList.toggle('show');
      this.querySelector('.bi-chevron-down').classList.toggle('rotate');
    });
  });
});






window.onload = window.applyInitialContrast;
