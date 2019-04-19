<?php

return [
	'product' => [
		'code' => 'Codice',
		'price' => 'Prezzo'
	],

	'cart' => [
		'title' => 'Il mio carrello',
		'total' => 'Totale',
		'empty' => 'Il carrello è vuoto',
		'buy' => 'Acquista',
		'back' => 'Torna allo store',
		'table' => [
			'code' => 'Codice',
			'name' => 'Prodotto',
			'quantity' => 'Quantità',
			'price' => 'Prezzo',
			'total' => 'Totale',
			'actions' => 'Azioni'
		]
	],

	'shipping' => [
		'free' => 'Spedizione gratuita'
	],

	'items' => [
		'add' => 'Aggiungi al carrello',
		'remove' => 'Rimuovi dal carrello'
	],

	'alerts' => [
		'add_success' => 'Prodotto aggiunto al carrello',
		'add_fail' => 'Impossibile aggiungere il prodotto al carrello',
		'remove_success' => 'Prodotto rimosso dal carrello',
		'remove_fail' => 'Impossibile rimuovere il prodotto dal carrello',
		'cart_invalid' => 'Carrello non valido',
		'cart_empty' => 'Il carrello è vuoto',
		'order_success' => 'Ordine inviato correttamente',
		'order_fail' => 'Impossibile inviare l\'ordine',
		'payment_fail' => 'Pagamento fallito',
		'payment_already_paid' => 'Ordine Già pagato',
		'payment_success' => 'Pagamento avvenuto con successo',
	],

	'order' => [
		'guard' => 'Per proseguire è necessario essere registrati',
		'login' => 'Login',
		'register' => 'Crea un nuovo account',
		'title' => 'Ordine di acquisto',
		'back' => 'Torna al carrello',
		'resume' => 'Riepilogo prodotti',
		'addresses' => 'Indirizzi',
		'totals' => 'Riepologo costi',
		'confirm' => 'Conferma l\'acquisto',
		'payment' => 'Modalità di pagamento',
		'billing' => 'Indirizzo di fatturazione',
		'shipping' => 'Indirizzo di spedizione',
		'products_cost' => 'Costo dei prodotti',
		'shipping_cost' => 'Spese di spedizione',
		'vat_cost' => 'Iva',
		'total_cost' => 'Totale ordine',
	],

	'payment' => [
		'title' => 'Esito del pagamento',
		'pay' => 'Paga l\'ordine',
		'method' => 'Metodo di pagamento',
		'paid' => 'Pagato',
		'unpaid' => 'Non pagato',
		'back' => 'Torna all\'ordine',
	],

	'address' => [
		'new' => 'Aggiungi un nuovo indirizzo',
		'fields' => [
			'street' => 'Via',
			'number' => 'Numero civico',
			'zip_code' => 'CAP',
			'city' => 'Città',
			'province' => 'Provincia',
			'country' => 'Nazione',
			'phone' => 'Telefono',
			'mobile' => 'Cellulare',
			'email' => 'Email',
			'vat' => 'Partita IVA'
		],
		'save' => 'Salva'
	],

	'dashboard' => [
		'orders' => 'Ordini',
		'addresses' => 'Indirizzi',
		'table' => [
			'products' => 'Prodotti',
			'total' => 'Totale',
			'payment' => 'Pagamento',
			'paid' => 'Pagato',
			'date' => 'Data'
		]
	],

	'paypal' => [
		'items_total' => 'Totale prodotti'
	]
];
