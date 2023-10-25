$(document).ready(function(){ 

  $("#basketItemsWrap li:first").hide();
  $(".sliderProductos img:first").addClass('imagen');

  $(".productPriceWrapRight a").click(function() {
    var productIDValSplitter 	= $(this).attr('id').split("_");
    var productIDVal 			= productIDValSplitter[1];
    var cantidad 				= $(this).attr('class');
    var color 				= $("#color").val();
    var talla 				= $("#tallas").val();
    
      $("#notificationsLoader").html('<img src="/php/images/loader.gif">');
    
      $.ajax({  
        type: "POST",  
        url: "/php/inc/functions.php",  
        data: { productID: productIDVal, cantidad: cantidad, color: color, talla: talla, action: "addToBasket"},  
        success: function(theResponse) {
          
          if( $("#productID_" + productIDVal).length > 0){
            $("#productID_" + productIDVal).animate({ opacity: 0 }, 500);
            $("#productID_" + productIDVal).before(theResponse).remove();
            $("#productID_" + productIDVal).animate({ opacity: 0 }, 500);
            $("#productID_" + productIDVal).animate({ opacity: 1 }, 500);
            $("#notificationsLoader").empty();
            
          } else {
            $("#basketItemsWrap li:first").before(theResponse);
            $("#basketItemsWrap li:first").hide();
            $("#basketItemsWrap li:first").show("slow");  
            $("#notificationsLoader").empty();			
          }

          $.ajax({  
            type: "POST",  
            url: "/php/inc/conteo.php",  
            cache: false,
            success: function(html) {
              $("#numero").html(html);
              } 
          });
          
        }  
      });
        
  });
  
  
  
  $('tr.first a, .content-product a.eliminar').on('click', 'img', function(event){
    var productIDValSplitter 	= (this.id).split("_");
    var productIDVal 			= productIDValSplitter[1];

    $("#notificationsLoader").html('<img src="/php/images/loader.gif">');
  
    $.ajax({
      type: "POST",  
      url: "/php/inc/functions.php",
      data: { basketID: productIDVal, action: "deleteFromBasket"},
      success: function(theResponse) {
                console.log(theResponse)
                //window.location.href = "/carrito";
                location.reload();

                $.ajax({  
                  type: "POST",  
                  url: "/php/inc/conteo.php",  
                  cache: false,
                  success: function(html) {
                    $("#numero").html(html);
                  } 
                }); 

      }  
    });    
  });



  $('body').on('change', '.cantidadCarro', function() {
    if($(this).val()>0){
    var basketID 	= $(this).data("id");
    var cantidad 	= $(this).val();
  
    $.ajax({
      type: "POST",  
      url: "/php/inc/functions.php",
      data: { basketID: basketID, cantidad: cantidad, action: "updateQuantity"},
      success: function(theResponse) {
                window.location.href = "/carrito";
      }  
    });
    }
  });

  $('.cantidadCarroCotizar').on('change', function() {
    if($(this).val() > 0){
      var basketID 	= $(this).data("id");
      var cantidad 	= $(this).val();
    
      $.ajax({
        type: "POST",  
        url: "/php/inc/functions.php",
        data: { basketID: basketID, cantidad: cantidad, action: "updateQuantity"},
        success: function(theResponse) {
                  window.location.href = "/carrito-cotizar";
        }  
      });
    }
  });

  $('.descuentoCotizar').on('change', function() {
    if($(this).val() >= 0){
      var basketID 	= $(this).data("id");
      var descuentoCotizar 	= $(this).val();
    
      $.ajax({
        type: "POST",  
        url: "/php/inc/functions.php",
        data: { basketID: basketID, descuentoCotizar: descuentoCotizar, action: "updateDescuento"},
        success: function(theResponse) {
                  window.location.href = "/carrito-cotizar";
        }  
      });
    }
  });

});


