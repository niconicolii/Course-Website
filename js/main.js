var nav = document.getElementById('nav');
var alter_nav = document.getElementById('alter-nav');
var main_block = document.getElementById('main_block');
var nav_is_fixed = true;
window.addEventListener('scroll', function() {
	let header_box_bottom = header.getBoundingClientRect().bottom;
	// If the postition of the screen reach the top of the nav bar.
	if(nav_is_fixed && header_box_bottom < 0) {
		nav_is_fixed = false;
		nav.className = 'mv-bar';
		alter_nav.className = 'mv-bar';
		alter_nav.style.backgroundColor = 'rgba(231,231,231,0.7)';
		main_block.style.top = '3em';
	} else if (!nav_is_fixed && header_box_bottom > 0) {
		nav_is_fixed = true;
		nav.className = '';
		alter_nav.className = '';
		alter_nav.style.backgroundColor = 'rgba(231,231,231,0.9)';
		main_block.style.top = '0';
		}
});
//
var is_alter = false;
let threshold = 960;
window.addEventListener("resize", function() {
	let flag = nav.offsetHeight > 48;
	if(!is_alter && flag) {
		nav.style.display = 'none';
		alter_nav.style.display = 'block';
		is_alter = true;
		threshold = window.innerWidth;
	}
	else if(is_alter && window.innerWidth > threshold){
		nav.style.display = 'flex';
		alter_nav.style.display = 'none';
		is_alter = false;
	}
});
let is_flip = false;
function showDropDown(e){
	let menu = e.target;
	let menu_dropdown = document.getElementById('menu-dropdown')
	let child_menu = menu_dropdown.childNodes[1];
	if (is_flip){
		menu.style.transform = 'rotate(0deg)';
		is_flip = false;
		child_menu.style.opacity = '0';
	    child_menu.style.display = 'none';
	} else {
		menu.style.transform = 'rotate(90deg)';
		is_flip = true;
		child_menu.style.display = '-webkit-flex';
		window.setTimeout( function() {
	    	child_menu.style.opacity = '1';
		}, 100);
	}
}

function OnInput() {
	this.style.height = 'auto';
	this.style.height = (this.scrollHeight) + 'px';
	this.nextElementSibling.innerHTML = "Remaining characters : " +(500 - this.value.length);
}