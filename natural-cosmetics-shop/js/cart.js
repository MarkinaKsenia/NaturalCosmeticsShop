var cart = {};


function loadCart (){
    if(localStorage.getItem('cart')){
        cart = JSON.parse(localStorage.getItem('cart'));
        showMiniCart();
    }
    else { 
        $('.prov').html("Корзина пуста!");
    }
}

function showMiniCart() {
    if (!isEmpty(cart)) {
        $('.shopping-cart').html('Корзина пуста!');
    }
    else {
 var out="";
 var total= parseFloat("0");
 
       $.getJSON("../data.json", function(data){
           for (var key in cart) 
           {
               for (var id in data){
                   if (data[id].id == key){
                     
                       out +='<div class="item"><div class="buttons">';   
                       out +=`<span class="delete-btn" data-id="${key}"></span></div>`;      
                       out += `<div class="cont"><div class="image_korz"><img src="../images/${data[id].image}" alt=""/></div></div>`;      
                       out +=`<div class="description"> <span>${data[id].name}</span> </div>`;       
                       out +=`<div class="quantity"> <button class="plus-btn" type="button" name="button" data-id="${key}"> <img src="../images/plus.svg" alt="" /></button><input type="text" name="${key}" value="${cart[key]}"><button class="minus-btn" type="button" name="button" data-id="${key}"><img src="../images/minus.svg" alt="" /></button></div>`;       
                       out += `<div class="total-price">`;
                       out += cart[id]*data[id].price;
                       out += "руб.</div></div>";
                       total += cart[id]*data[id].price;
                   } 
               }  
           }
      //   console.log(out);
        total +=" руб.";
         $('.shopping-cart').html(out);
         $('.total').html(total);
         $('.delete-btn').on('click',delFunc);
         $('.minus-btn').on('click',minFunc);
         $('.plus-btn').on('click',plusFunc);
       });    
     //  console.log(cart);
    }
    
    
    
}

function isEmpty(object) {
    //проверка корзины на пустоту
    for (var key in object)
    if (object.hasOwnProperty(key)) return true;
    return false;
}


function delFunc (){
    var id =$(this).attr('data-id');
    delete cart[id];
    saveCart ();
    showMiniCart();
}

function plusFunc (){
    var id = $(this).attr('data-id');
    cart[id]++; 
    showMiniCart();
    saveCart();
}

function minFunc (){
    var id =$(this).attr('data-id');
    console.log(cart[id]);
    if (cart[id]>1){
        cart[id]--; 
        saveCart ();
        showMiniCart();
    }   
}

function saveCart (){

    localStorage.setItem('cart', JSON.stringify(cart));
}


$(document).ready(function (){
    loadCart();
});