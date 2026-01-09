$(document).ready(function() {

	const icon = document.getElementById('theme-toggler')

	// console.log(localStorage.dark-kn-Mode)

	if (localStorage.getItem('dark-kn-Mode') === undefined || localStorage.getItem('dark-kn-Mode') === null){

		localStorage.setItem('dark-kn-Mode', 'false')
	}

	enabletheme(icon)
    
	$('#theme-toggler').on('click', function(event){

		event.preventDefault()
		let currentMode = localStorage.getItem('dark-kn-Mode');
    	let newMode = currentMode === 'true' ? 'false' : 'true';
    	localStorage.setItem('dark-kn-Mode', newMode);
		enabletheme(icon)
	});

});

function enabletheme(icon){

	if(localStorage.getItem('dark-kn-Mode') === 'false'){

		if (icon.classList.contains('fa-moon-o')) {
			icon.classList.remove('fa-moon-o')
			icon.classList.add('fa-sun-o')
			document.body.classList.remove('dark-mode')
		}

	} else {
		
		if (icon.classList.contains('fa-sun-o')) {
			icon.classList.remove('fa-sun-o')
			icon.classList.add('fa-moon-o')
			document.body.classList.add('dark-mode')
		}
	}
}
