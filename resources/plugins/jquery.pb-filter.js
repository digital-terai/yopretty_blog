// PB filter
// mostra o nasconde elemnti del dom mentre digiti
//
// UTILIZZO:
// 1.	Associare la classe "pbf-group" al contenitore di un gruppo di input o select
// 2.	Allo stesso elemento associare l'attributo "data-filter" contenente il selettore jquery degli elementi del dom che si desidera filtrare
// 3.	Associare ad ogni input o select una delle seguenti classi:
// 			pbf-filter			-	Filtro per valore esatto
// 			pbf-like		-	Filtro per somiglianza (come %like%)
// 			pbf-checked	-	Filtro per checkbox
// 			pbf-limit	-	Filtro per tutti i valori superiori o inferiori a una soglia
// 		Gli input con "pbf-limit" necessitano anche del'attributo "data-limit" con valore "min" o "max" a seconda se si vuole filtrare per valori superiori o inferiori al valore inserito, rispettivamente
// 		Ogni input deve avere anche l'attributo "name".
// 4.	Facoltativo - se l'operazione richiesta dal filtro non è un "and" ma un "or", è sufficiente aggiungere l'attributo "data-pbf-operation" con valore "or"
// 5.	Tutti gli elementi del dom che devono essere filtrati devono avere un data attribute formattato come segue: data-[nome filtro]="[valore-filtro]".
//	 	Ad esempio, se l'input ha name="description", ogni elemento dovrà avere un attributo data-description contenente il testo nel quale si vuole cercare la descrizione digitata dall'utente.
//	 	I filter limit funzionano in modo analogo, ma accettano solo valori numerici.
// 6.	Associare ad un elemento che funge da "invio" la classe "pbf-button"
// 7.	Facoltativo - un elemento con la classe "pbf-reset" causa la pulizia di tutti i filtri, se premuto
//
// Quando il filtro viene avviato, per la pressione del controllo dedicato o perché vengono cambiati i valori nei campi di input, il sistema nasconde tutti gli elementi e mostra solo quelli che rispondono ai valori inseriti dall'utente

//	costanti di configurazione
var GROUPS			= ".pbf-group",
	FILTERS			= ".pbf-filter",
	FILTER_LIKE		= ".pbf-like",
	FILTER_CHECKED	= ".pbf-checked",
	FILTER_LIMIT	= ".pbf-limit",
	BUTTONS			= ".pbf-button",
	RESETS			= ".pbf-reset";

function init_filters() {
	//	recupero i gruppi
	$(GROUPS).each(function() {
		var elem = $(this);
		//	recupero il selettore degli elementi da filtrare
		var target = elem.data("filter");
		//	trovo il pulsante che attiva il filtro
		var button = elem.find(BUTTONS);
		//	trovo il pulsante che reimposta il filtro
		var reset = elem.find(RESETS);
		//	evento click
		button.click(function(e) {
			e.preventDefault();

			var values = {};
			var values_or = {};

			//	costruisco una lista di classi da filtrare
			elem.find(FILTERS).each(function() {
				if ($(this).val() != "")
					if ($(this).data('pbf-operation') == 'or')
						values_or[$(this).attr('name')] = $(this).val();
					else {
						values[$(this).attr('name')] = $(this).val();
					}
			});

			elem.find(FILTER_CHECKED).each(function() {
				if ($(this).is(':checked')) {
					if ($(this).data('pbf-operation') == 'or')
						values_or[$(this).attr('name')] = $(this).val();
					else
						values[$(this).attr('name')] = $(this).val();
				}
			});

			//	nascondo tutti gli elementi e mostro le classi trovate
			$(target).addClass('hidden');
			if (Object.keys(values).length || Object.keys(values_or).length) {
				var values_string = '';
				$.each(values, function(k,v) {
					values_string += '[data-'+k+'="'+v+'"]';
				});
				if (Object.keys(values_or).length)
					$.each(values_or, function(k,v) {
						$(target + values_string + '[data-'+k+'="'+v+'"]').removeClass('hidden');
					});
				else
					$(target + values_string).removeClass('hidden');
			}
			else {
				$(target).removeClass('hidden');
			}

			//	filtro ulteriormente per i filtri limite
			elem.find(FILTER_LIMIT).each(function() {
				var filter = $(this);
				var filter_value = parseInt(filter.val(), 10);
				var filter_name = filter.attr('name');
				var filter_limit = filter.data('limit');
				$(target).each(function() {
					var item_value = parseInt($(this).data(filter_name), 10);
					switch (filter_limit) {
						case 'min':
							if (item_value < filter_value)
								$(this).addClass('hidden');
							break;
						case 'max':
							if (item_value > filter_value)
								$(this).addClass('hidden');
							break;
					}
				});
			});

			// filtro ulteriormente per i filtri like
			elem.find(FILTER_LIKE).each(function() {
				var filter = $(this);
				var filter_value = filter.val().toLowerCase();
				var filter_name = filter.attr('name');
				if (filter_value)
					$(target).each(function() {
						if ($(this).data(filter_name) != null) {
							var item_value = $(this).data(filter_name).toString().toLowerCase();
							if (item_value.toString().indexOf(filter_value) == -1)
								$(this).addClass('hidden');
						}
					});
			});
		});

		elem.find(FILTERS+','+FILTER_CHECKED+','+FILTER_LIMIT).change(function () {
			elem.find(BUTTONS).click();
		});

		elem.find(FILTER_LIKE).keyup(function () {
			elem.find(BUTTONS).click();
		});

		reset.click(function(e) {
			e.preventDefault();
			elem.find(FILTERS).each(function() {
				$(this).val("");
			});
			button.click();
		});
	});
}

$(function() {
	init_filters();
});
