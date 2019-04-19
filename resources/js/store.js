const CART_COUNT = '.cart-count';
const CART_TOTAL = '.cart-total';
const CART_PREVIEW = '.cart-preview'; //triggers preview calculations
const CART_BUTTONS = '#cart-buttons';

const ITEM_BLOCK = '.cart-item-block';
const ITEM_ADD = '.cart-item-add';
const ITEM_REMOVE = '.cart-item-remove';
const ITEM_QUANTITY = '.cart-item-quantity';
const ITEM_TOTAL = '.cart-item-total';

const ORDER_PREVIEW = '.order-preview'; //triggers preview calculations
const ORDER_PRODUCTS = '.order-products-cost';
const ORDER_SHIPPING = '.order-shipping-cost';
const ORDER_VAT = '.order-vat-cost';
const ORDER_TOTAL = '.order-total-cost';


window.Store = function () {
	function formatPrice(price) {
		let parts = price.toFixed(StoreConfig.decimals).split(".");
		  parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, StoreConfig.thousands_separator);
		formatted_price = parts.join(StoreConfig.decimal_separator);

		if (StoreConfig.prepend_currency) {
			formatted_price = StoreConfig.currency_symbol+' '+formatted_price;
		}
		if (StoreConfig.append_currency) {
			formatted_price += ' '+config('maguttiCms.store.currency_symbol');
		}

		return formatted_price;
	}

	function handleCartItemQuantity() {
		$(document).on('change', ITEM_QUANTITY, function() {
			let elem = $(this);
			$(ITEM_ADD).data('quantity', Math.max(elem.val(), 1));
		});
	}

	function handleCartItemAdd() {
		$(document).on('click', ITEM_ADD, function(e) {
			e.preventDefault();
			let elem = $(this);

			let product_code = elem.data('product-code');
			let product_model_code = elem.data('product-model-code');
			let quantity = elem.data('quantity');

			$.ajax({
				type : 'POST',
				url : '/api/store/cart-item-add',
				data : {
					product_code :product_code,
					product_model_code: product_model_code,
					quantity: quantity,
					_token: Laravel.csrfToken
				},
				dataType : 'json',
				success : function(response) {
					$(CART_COUNT).text(response.cart_count);
					$.each(response.alerts, function() {
						$.smkAlert({
							text: this.text,
							type: this.type,
							time: this.time
						});
					});
				},
				error : function(response) {
					$.smkAlert({
						text: 'Error',
						type: 'danger',
						time: 5
					});
				}
			});
		});
	}

	function handleCartItemRemove() {
		$(document).on('click', ITEM_REMOVE, function(e) {
			e.preventDefault();
			let elem = $(this);

			let id = elem.data('id');

			$.ajax({
				type : 'POST',
				url : '/api/store/cart-item-remove',
				data : {
					cart_item_id: id,
					_token: Laravel.csrfToken
				},
				dataType : 'json',
				success : function(response) {
					$(CART_COUNT).text(response.cart_count);
					elem.closest(ITEM_BLOCK).remove();
					calcCartPreview();
					if (!$(ITEM_BLOCK).length)
						$(CART_BUTTONS).remove();
					$.each(response.alerts, function() {
						$.smkAlert({
							text: this.text,
							type: this.type,
							time: this.time
						});
					});
				},
				error : function(response) {
					$.smkAlert({
						text: 'Error',
						type: 'danger',
						time: 5
					});
				}
			});
		});
	}

	function calcCartPreview() {
		let total = 0;
		$(ITEM_BLOCK).each(function() {
			let elem = $(this);
			let price = elem.data('price');
			let quantity = elem.find(ITEM_QUANTITY).first().val();
			let partial = price * quantity;
			elem.find(ITEM_TOTAL).first().text(formatPrice(partial));
			total += partial;
		});
		$(CART_TOTAL).text(formatPrice(total));
	}

	function handleCartPreview() {
		$(CART_PREVIEW).change(function() {
			calcCartPreview();
		});
	}

	function calcOrderPreview() {
		let cart = $('#order-cart').val();
		let billing = $('#order-billing-address').val();
		let shipping = $('#order-shipping-address').val();

		$.ajax({
			type : 'POST',
			url : '/api/store/order-calc',
			data : {
				cart :cart,
				address: shipping || billing,
				_token: Laravel.csrfToken
			},
			dataType : 'json',
			success : function(response) {
				$(ORDER_PRODUCTS).text(formatPrice(response.products));
				$(ORDER_SHIPPING).text(formatPrice(response.shipping));
				$(ORDER_VAT).text(formatPrice(response.vat));
				$(ORDER_TOTAL).text(formatPrice(response.total));
			},
			error : function(response) {
			}
		});
	}

	function handleOrderPreview() {
		$(ORDER_PREVIEW).change(function() {
			calcOrderPreview();
		});
		if ($(ORDER_PREVIEW).length)
			calcOrderPreview();
	}

    return {
        init: function () {
			handleCartItemQuantity();
            handleCartItemAdd();
            handleCartItemRemove();
			handleCartPreview();
			handleOrderPreview();
        },
    };
}();
