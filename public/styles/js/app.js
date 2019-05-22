
//options
$('select').select2(); 
//contact property
var $contactButton = $('#contactButton');
$contactButton.click(e => {
	e.preventDefault();
	$('#contactForm').slideDown();
	$contactButton.slideUp();
});

//Suppression des éléments
document.querySelectorAll('[data-delete]').forEach(a => {
	a.addEventListener('click', e => {
		e.preventDefault()
		fetch(a.getAttribute('href'), {
			method: 'DELETE',
			headers: {
				'X-Requested-With': 'XMLHttpRequest',
				'Content-Type': 'application/json'
			},
			body: JSON.stringify({'_token': a.dataset.token})
		}).then(response => response.json())
		.then(data => {
			if (data.success) {
				a.parentNode.parentNode.removeChild(a.parentNode)
			} else {
				alert(data.error)
			}
		})
		.catch(e => alert(e))
	})
});

//navigation
function myNavFunction(id) {
	$("#date-popover").hide();
	var nav = $("#" + id).data("navigation");
	var to = $("#" + id).data("to");
	console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
}


console.log('Edit me in assets/js/app.js');
