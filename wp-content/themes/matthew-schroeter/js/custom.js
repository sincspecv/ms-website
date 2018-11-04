var menuToggle = document.querySelector('#menu-toggle');
var page       = document.querySelector('#page-primary');
var nav        = document.querySelector('#site-navigation');
var body       = document.querySelector('body');

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('open');
  page.classList.toggle('toggled');
  nav.classList.toggle('toggled');
  // body.classList.toggle('toggled');
})