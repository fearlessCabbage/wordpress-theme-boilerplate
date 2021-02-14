// Nav and scroll behaviors
var navBar = document.getElementById('primary-nav');
var navToggle = document.querySelector('#primary-nav .js-toggle');
var isNavOpen = false;

function toggleNav() {
	navBar.classList.toggle('on');
	if(isNavOpen) { isNavOpen = false; }
	else { isNavOpen = true}
}

function closeNav() {
	navBar.classList.remove('on');
	isNavOpen = false;
}

closeNav();
window.addEventListener('resize', closeNav);
navToggle.addEventListener('click', toggleNav);
window.addEventListener('scroll', function() {
	if(scrollY > 100) { document.body.classList.add('scrolled'); }
	else { document.body.classList.remove('scrolled'); }
});