$(document).ready(function() {
	"use strict";
	
	try { 
		$( "body" ).on( "click", ".buy-btn", function(event) {
			event.preventDefault();
			var id = $(this).data("id");
			var price = $(this).data("price");
			var score = $(".bs-buy").data("score");

			$("#price-post").val(price);
			$("#id-post").val(id);
			
			if(price > score) {
				$(".bs-buy .alert").show();

				$(".bs-buy").find( 'button[name="buy"]' ).prop("disabled", true);
			} else {
				$(".bs-buy .alert").hide();

				$(".bs-buy").find( 'button[name="buy"]' ).prop("disabled", false)
			}

		});
	}
	catch(err) {}
	
	try { 
		$( "body" ).on( "click", "#alertify-subscribe", function(event) {
			event.preventDefault();
			var id = $(this).data("id");
			var subscribe = $(this).data("subscribe");
			var name = $(this).data("name");

			var posting = $.post( '', { 
				subscribe: subscribe, id: id
			});

			/* Put the results in a div */
			posting.done(function( ) {
				alertify.success("Вы подписанны на мыслителя "+name);
			});

		});
	}
	catch(err) {}


	try { 
		
		$( "body" ).on( "submit", "#buy-form", function(event) {
			event.preventDefault();
			
			var $form = $( this ),
			price = $form.find( 'input[name="price"]' ).val(),
			id = $form.find( 'input[name="id"]' ).val(),
			buy = $form.find( 'button[name="buy"]' ).val(),
			url = $form.attr( 'action' );

			var posting = $.post( url, { 
				price: price, id: id, buy: buy
			});

			/* Put the results in a div */
			posting.done(function( ) {
				window.location.replace('/');
			});
		});
		

		$( "body" ).on( "click", "a.complain", function(event) {
			event.preventDefault();
			var id = $(this).data("id");
			$("#complain_id").val(id);
		});


		$( "body" ).on( "submit", "#promo-form", function(event) {
			event.preventDefault();
			
			var $form = $( this ),
			score = $form.find( 'input[name="score"]' ).val(),
			slug = $form.find( 'input[name="slug"]' ).val(),
			promo = $form.find( 'button[name="promo"]' ).val(),
			url = $form.attr( 'action' );

			var posting = $.post( url, { 
				score: score, slug: slug, promo: promo
			});

			/* Put the results in a div */
			posting.done(function( ) {
				window.location.replace('/');
			});
		});
	}
	catch(err) {}

	try { 
		
		$( "body" ).on( "submit", "#donate-form", function(event) {
			event.preventDefault();
			
			var $form = $( this ),
			score = $form.find( 'input[name="score"]' ).val(),
			user_id = $form.find( 'input[name="user_id"]' ).val(),
			donate = $form.find( 'button[name="donate"]' ).val(),
			url = $form.attr( 'action' );

			var posting = $.post( url, { 
				score: score, user_id: user_id, donate: donate
			});

			/* Put the results in a div */
			posting.done(function( ) {
				window.location.replace('');
			});
		});
	}
	catch(err) {}

	
	try { 
		
		$( "body" ).on( "click", ".power", function(event) {
			event.preventDefault();
			
			var id = $(this).data('id');
			var power = $(this).data('power');

			var posting = $.post( '/post/power/', { 
				id: id, power: power
			});
			
			var count = $(this).parents(".sila:first").find(".power-count");

			/* Put the results in a div */
			posting.done(function( data ) {

				if(data) {
					console.log(data);
					count.text( data );
				}
			});
			return false;
		});
	}
	catch(err) {}

	try { 
		
		$( "body" ).on( "click", ".power-comment", function(event) {
			event.preventDefault();
			
			var id = $(this).data('id');
			var power = $(this).data('power');

			var posting = $.post( '/comment/power/', { 
				id: id, power: power
			});
			
			var count = $(this).parents(".sila:first").find(".power-count");

			/* Put the results in a div */
			posting.done(function( data ) {

				if(data) {
					console.log(data);
					count.text( data );
				}
			});
			return false;
		});
	}
	catch(err) {}

});