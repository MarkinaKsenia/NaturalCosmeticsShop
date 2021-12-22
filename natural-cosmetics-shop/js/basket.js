
var cart = {}; // корзина

function init() {
    $.getJSON("../data.json", dataOut);
}

function dataOut(data) {

    console.log(data);  
    var out=''; 
    $('.prod-elem__btn').on('click', addToCart);
    $('.prod-card__btn').on('click', addToCart);
    
}

function addToCart() {
    
    var id = $(this).attr('data-id');
    console.log(id); 
    if (cart[id]==undefined) {     
        cart[id] = 1; //если в корзине нет товара - делаем равным 1
    }
    else {
        cart[id]++; //если такой товар есть - увеличиваю на единицу
    }
    
    showMiniCart();
    saveCart();
}

function saveCart (){

    localStorage.setItem('cart', JSON.stringify(cart));

    
}


function showMiniCart() {

    var out="";
    $.getJSON("../data.json", function(data){
        for (var key in cart) 
        {
            for (var id in data){
                if (data[id].id == key){
                    sum.textContent = parseFloat(data[id].price)*parseFloat(cart[key]);
                    
                  
                    out +='<div class="buttons">';   
                    out +='<span class="delete-btn"></span></div>';      
                    out += `<div class="cont"><div class="image_korz"><img src="../images/${data[id].image}" alt=""/></div></div>`;      
                    out +=`<div class="description"> <span>${data[id].name}</span> </div>`;       
                    out +=`<div class="quantity"> <button class="plus-btn" type="button" name="button" data-id="${key}"> <img src="../images/plus.svg" alt="" /></button><input type="text" name="${key}" value="${cart[key]}"><button class="minus-btn" type="button" name="button" data-id="${key}"><img src="../images/minus.svg" alt="" /></button></div>`;       
                    out +=`<div class="total-price" id="sum">${data[id].price} руб.</div>`;
                }
            }  
        }
    });
 
}


 
$('.minus-btn').on('click', function(e) {
      e.preventDefault();
      var $this = $(this);
      var $input = $this.closest('div').find('input');
      var value = parseInt($input.val());

      if (value > 1) {
          value = value - 1;
      } else {
          value = 0;
      }

  $input.val(value);

  });

  $('.plus-btn').on('click', function(e) {
      e.preventDefault();
      var $this = $(this);
      var $input = $this.closest('div').find('input');
      var value = parseInt($input.val());

      if (value < 100) {
        value = value + 1;
      } else {
          value =100;
      }

      $input.val(value);
  });


function loadCart (){
    if(localStorage.getItem('cart')){
        cart = JSON.parse(localStorage.getItem('cart'));
        showMiniCart();
    }
}

$(document).ready(function () {
    init();
   
    loadCart();

   
  
});
