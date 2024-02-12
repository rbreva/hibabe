document.addEventListener('DOMContentLoaded', function() {
	main();
});

let contador = 1;

function main() {
	const btnMenu = document.querySelector('.menu_mob');
	const btnMenu_x = document.querySelector('.menu_mob_x');
	const menu = document.querySelector('.navbar');
	const menuItems = document.querySelectorAll('.navbar li');

	btnMenu.addEventListener('click', function() {
		menu.style.left = '0';
	});
	
	btnMenu_x.addEventListener('click', function() {
		menu.style.left = '-100%';
	});

}

