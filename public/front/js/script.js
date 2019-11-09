// ************************************************
// Shopping Cart API
// ************************************************

var shoppingCart = (function() {
  // =============================
  // Private methods and propeties
  // =============================
  $.get("cart_list", function( data ) {

     var count = 0, price = 0;
     $.each(JSON.parse(data), function( key, value ) {
       count += parseFloat(value.count);
       price += parseFloat(value.price) * parseFloat(value.count);
       id=value.id;

     });

     
     if(shoppingCart.totalCount()==0){

       $('.total-count').html(count);
       $('.total-cart').html(price);
       sessionStorage.setItem('shoppingCart',data);

     }else{
       $('.total-cart').html(shoppingCart.totalCart());
          $('.total-count').html(shoppingCart.totalCount());
     }
    });
  cart = [];

  // Constructor
  function Item(name, price, count,id,description) {
    this.name = name;
    this.price = price;
    this.count = count;
    this.id = id;
    this.description = description;

  }

  // Save cart
  function saveCart() {
    sessionStorage.setItem('shoppingCart', JSON.stringify(cart));
    console.log(JSON.stringify(cart));
  }

    // Load cart
  function loadCart() {
    cart = JSON.parse(sessionStorage.getItem('shoppingCart'));
  }
  if (sessionStorage.getItem("shoppingCart") != null) {
    loadCart();
  }


  // =============================
  // Public methods and propeties
  // =============================
  var obj = {};

  // Add to cart
  obj.addItemToCart = function(name, price, count,id,description) {
    for(var item in cart) {
      if(cart[item].name === name) {
        cart[item].count ++;
        cart[item].id == id ;
        cart[item].description == description ;
        saveCart();
        return;
      }
    }
    var item = new Item(name, price, count,id,description);
    cart.push(item);
    saveCart();
  }
  // Set count from item
  obj.setCountForItem = function(name,count) {
    for(var i in cart) {
      if (cart[i].name === name) {
          cart[i].count = count;
          //cart[i].id = id;
          // cart[i].description = id;
        break;
      }
    }
  };
  // Remove item from cart
  obj.removeItemFromCart = function(name) {
      for(var item in cart) {
        if(cart[item].name === name) {
          cart[item].count --;
          if(cart[item].count === 0) {
            cart.splice(item, 1);
          }
          break;
        }
    }
    saveCart();
  }

  // Remove all items from cart
  obj.removeItemFromCartAll = function(id) {
    for(var item in cart) {
      if(cart[item].id === id) {
        cart.splice(item, 1);
        break;
      }
    }
    saveCart();
  }

  // Clear cart
  obj.clearCart = function() {
    cart = [];
    saveCart();
  }

  // Count cart
  obj.totalCount = function() {
    var totalCount = 0;
    for(var item in cart) {
      totalCount += cart[item].count;
    }
    return totalCount;
  }

  // Total cart
  obj.totalCart = function() {
    var totalCart = 0;
    for(var item in cart) {
      totalCart += cart[item].price * cart[item].count;
    }
    return Number(totalCart.toFixed(2));
  }

  // List cart
  obj.listCart = function() {
    var cartCopy = [];
    for(i in cart) {
      item = cart[i];
      itemCopy = {};
      for(p in item) {
        itemCopy[p] = item[p];

      }
      itemCopy.total = Number(item.price * item.count).toFixed(2);
      cartCopy.push(itemCopy)
    }
    return cartCopy;
  }

  // cart : Array
  // Item : Object/Class
  // addItemToCart : Function
  // removeItemFromCart : Function
  // removeItemFromCartAll : Function
  // clearCart : Function
  // countCart : Function
  // totalCart : Function
  // listCart : Function
  // saveCart : Function
  // loadCart : Function
  return obj;
})();


// *****************************************
// Triggers / Events
// *****************************************
// Add item
$('.add-to-cart').click(function(event) {
  event.preventDefault();
  var name = $(this).data('name');
  var id = $(this).data('id');
  var description = $(this).data('description');
  var price = Number($(this).data('price'));
  shoppingCart.addItemToCart(name, price, 1,id,description);
  displayCart();
});

// Clear items
$('.clear-cart').click(function() {
  shoppingCart.clearCart();
  displayCart();
});


function displayCart() {
  var cartArray = shoppingCart.listCart();
  var output = "<tr><th> الاسم </th><th> السعر </th><th> الكمية </th><th> الاجمالي </th><th> حذف </th></tr><tr>";
  for(var i in cartArray) {
    output += "<td>" + cartArray[i].name + "</td>"
      + "<td>(" + cartArray[i].price + ")</td>"
      + "<td><div class='input-group'>"
      + "<input type='number' class='item-count form-control' data-name='" + cartArray[i].name + "' value='" + cartArray[i].count + "'>"
      + "</div></td>"
      + "<td>" + cartArray[i].total + "</td>"
      + "<td><button class='delete-item btn btn-danger' data-name=" + cartArray[i].name + "  data-id=" + cartArray[i].id + ">X</button></td>"
      +  "</tr>";
  }
  $('.show-cart').html(output);
  $('.total-cart').html(shoppingCart.totalCart());
  $('.total-count').html(shoppingCart.totalCount());

}

// Delete item button

$('.show-cart').on("click", ".delete-item", function(event) {
  var name = $(this).data('name')
  var id =   $(this).data('id')
  shoppingCart.removeItemFromCartAll(id);

  displayCart();
})



// -1
$('.show-cart').on("click", ".minus-item", function(event) {
  var name = $(this).data('name')
  var id = $(this).data('id')
  var description = $(this).data('description')
  shoppingCart.removeItemFromCart(name);

  displayCart();
})
// +1
$('.show-cart').on("click", ".plus-item", function(event) {
  var name = $(this).data('name')
  var id = $(this).data('id')
  var description = $(this).data('description')
  var price = Number($(this).data('price'));
  var description = $(this).data('description')

  shoppingCart.addItemToCart(name,price,1,id,description);
  displayCart();
})

// Item count input
$('.show-cart').on("change", ".item-count", function(event) {
   var name = $(this).data('name');
   var description = $(this).data('description');
   var id = $(this).data('id');
   var count = Number($(this).val());
  shoppingCart.setCountForItem(name, count);
  displayCart();
});

displayCart();

$.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });



    $(".btn-checkout").click(function(e){
      sessionStorage.setItem('shoppingCart', JSON.stringify(cart));

      // console.log(JSON.stringify(cart));
      var dataa = JSON.stringify(cart);
        console.log(dataa);

        e.preventDefault();

        $.ajax({

           type:'POST',

           url:'cartstore/json',
           data: {
             data : dataa
           },
           dataType : 'json',

           success:function(data){
            if(data.success==1){
              window.location = '/checkout';
            }else if(data.success==2) {

             $('#loginclick').click();
           }else {
            
           }



           }

        });



	})
