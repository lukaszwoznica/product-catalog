function calculateValue(event) {
	let price = event.data.param1.toFixed(2)
	let quantity = parseInt(event.data.param2[event.data.param4].value)
	event.data.param3[event.data.param4].innerText = (price * quantity).toFixed(2)
}

function calculateTotal(event) {
	let sum = 0
	for(let i = 0; i < event.data.param1.length; i++){
		sum = sum + parseFloat(event.data.param1[i].innerText)
	}
	event.data.param2.innerText = sum.toFixed(2)
}

function update(event) {
	let row_id = event.data.param1[event.data.param3].value
	let quantity = event.data.param2[event.data.param3].value
	$.ajax({
		type: 'POST',
		url: 'clipboard/update-quantity.php',
		data: 'rowId=' + row_id + '&quantity=' + quantity,
		dataType: 'json',
		error: function(jqXHR, textStatus, errorThrown) {
			alert('Wystąpił błąd! Sprawdź konsolę aby uzyskać więcej informacji!')
			console.log('jqXHR:')
			console.log(jqXHR)
			console.log('textStatus:')
			console.log(textStatus)
			console.log('errorThrown:')
			console.log(errorThrown)
		},
	}).done(function(response) {
		if (response.status == 'error') {
			alert(response.text)
		}
	})
}

$(document).ready(function() {
	const buttons = document.querySelectorAll('.btn-decrement, .btn-increment')
	const rows_id = document.getElementsByClassName('row-id')
	const quantity_arr = document.getElementsByClassName('quantity-input')
	const prices_arr = document.getElementsByClassName('product-price')
	const values_arr = document.getElementsByClassName('product-value')
	const total_price = document.getElementById("totalPrice")
	let j = 0

	for (let i = 0; i < buttons.length; i++) {
		let price = parseFloat(prices_arr[j].innerText)
		$(buttons[i]).click({ param1: price, param2: quantity_arr, param3: values_arr, param4: j }, calculateValue)
		$(buttons[i]).click({ param1: values_arr, param2: total_price }, calculateTotal)
		$(buttons[i]).click({ param1: rows_id, param2: quantity_arr, param3: j }, update)
		if(i % 2 != 0 && i != 0)
			j++
	}
	
	for (let i = 0; i < quantity_arr.length; i++) {
		let price = parseFloat(prices_arr[i].innerText)
		let quantity = parseInt(quantity_arr[i].value)
		values_arr[i].innerText = (price * quantity).toFixed(2)
		$(quantity_arr[i]).change({ param1: price, param2: quantity_arr, param3: values_arr, param4: i }, calculateValue)
		$(quantity_arr[i]).change({ param1: values_arr, param2: total_price }, calculateTotal)
		$(quantity_arr[i]).change({ param1: rows_id, param2: quantity_arr, param3: i }, update)
	}

	let sum = 0
	for(let i = 0; i < values_arr.length; i++){
		sum = sum + parseFloat(values_arr[i].innerText)
	}
	total_price.innerText = sum.toFixed(2)
})
