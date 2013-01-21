$(document).ready(function() {

	$("input.score").on("click", function(e) {
		$(this)[0].focus();

		$(this)[0].setSelectionRange(0, 9999);

	})

	$("input.score").on("tap", function(e) {

		$(this)[0].focus();
		$(this)[0].setSelectionRange(0, 9999);

	})
	$(".pagina_a").on("click", function(e) {

		debugger;

		e.preventDefault();
		id = $(this).data("id");
		$(".pagina").removeClass("active");
		$(this).parent().addClass("active");

		jornadas = $(".jornada"); 

		for (var i = 0; i <  jornadas.length; i++) {
	

			if ($(jornadas[i]).data("jornada") == id) {
				$(jornadas[i]).show();
			} else {
				$(jornadas[i]).hide();
			}

		}

	})
})
