$(function() {
	// console.log("LA PAGINA HA CARGADO");

	let mediaquery = window.matchMedia("(max-width: 768px)");
	if (mediaquery.matches) {
		remover_cajas_logos();
		//recrear_cajas_movil();
	} else {
		remover_cajas_logos();
		recrear_cajas_logos();
	}
	mediaquery.addListener(handleOrientationChange);
});

function handleOrientationChange(mediaquery) {
	if (mediaquery.matches) {
		remover_cajas_logos();
		//recrear_cajas_movil();
	} else {
		remover_cajas_logos();
		recrear_cajas_logos();
	}
}

function remover_cajas_logos() {
	$("#logo_1").remove();
	$("#logo_2").remove();
}

function recrear_cajas_logos() {
	$("#login").before(
		$("<div>", {
			id: "logo_1",
			class: "col-xs-6 col-sm-4 caja_de_imagen"
		}).append(
			$("<img>", {
				src: imagen_conare,
				alt: "logo del OLaP",
				class: "imagen"
			})
		)
	);

	$("#login").after(
		$("<div>", {
			id: "logo_2",
			class: "col-xs-6 col-sm-4 caja_de_imagen"
		}).append(
			$("<img>", {
				src: imagen_olap,
				alt: "logo del CONARE",
				class: "imagen"
			})
		)
	);
}

function recrear_cajas_movil() {
	$("#login").after(
		$("<div>", {
			id: "logo_1",
			class: "col-xs-6 caja_de_imagen"
		}).append(
			$("<img>", {
				src: "img/logo_oficial_olap_transparente.png",
				alt: "logo del OLaP",
				class: "imagen"
			}).css({'width':'150px', 'margin-top':'-10px'})
		)
	);

	$("#logo_1").after(
		$("<div>", {
			id: "logo_2",
			class: "col-xs-6 caja_de_imagen"
		}).append(
			$("<img>", {
				src: "img/logo_oficial_conare_transparente.png",
				alt: "logo del CONARE",
				class: "imagen"
			}).css({'width':'150px', 'margin-top':'-10px'})
		)
	);
}