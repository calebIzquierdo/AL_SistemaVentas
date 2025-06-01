function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  sidebar.classList.toggle('collapsed');

  if (sidebar.classList.contains('collapsed')) {
    sidebar.style.width = '60px';
    document.querySelectorAll('.sidebar-menu a span').forEach(span => span.style.display = 'none');
  } else {
    sidebar.style.width = '250px';
    document.querySelectorAll('.sidebar-menu a span').forEach(span => span.style.display = 'inline');
  }
}
