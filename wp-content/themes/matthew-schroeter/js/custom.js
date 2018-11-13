/**
 * Menu Toggle
 */
var menuToggle = document.querySelector('#menu-toggle');
var page       = document.querySelector('#page-primary');
var nav        = document.querySelector('#site-navigation');
var body       = document.querySelector('body');

menuToggle.addEventListener('click', () => {
  menuToggle.classList.toggle('open');
  page.classList.toggle('toggled');
  nav.classList.toggle('toggled');
  // body.classList.toggle('toggled');
});

/**
 * Add class to projects on home page on click
 * to show details
 *
 * @type {Element}
 */
var projectsWrap = document.querySelector('#ms-projects-wrap');

if(projectsWrap != undefined) {
  var projects = projectsWrap.querySelectorAll('.project-wrap');
  [].forEach.call(projects, project => {
    project.addEventListener('click', () => {
      project.classList.toggle('zoom');
    })
  })
}

/**
 * Count up commit count
 */

// Wait for page to load and then count up
document.addEventListener('DOMContentLoaded', () => {
  var commitCount = document.querySelector('#ms-gitlab-commit-count');

  if(commitCount != undefined) {
    // Get commit count and reset to zero
    var stopNumber = parseInt(commitCount.dataset.number);
    commitCount.innerHTML = '0';
    // Start counting
    countUp(commitCount, stopNumber);
  }
})

/**
 * Count up a whole number
 *
 * @param element Element that holds the number
 * @param stop    Number at which to stop
 */
var countUp = (element, stop) => {
  var currentNumber = parseInt(element.innerHTML);

  // Keep counting until we've reached the stop number
  if(currentNumber < stop) {
    element.innerHTML = parseInt(currentNumber + 1).toString();
    setTimeout(() => {
      countUp(element, stop);
    }, 1);
  }
}
