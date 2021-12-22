function getData(obj_form){
    var hData = {};
    $('input, textarea, select',  obj_form).each(function(){
         if(this.name && this.name!=''){
              hData[this.name] = this.value;
              console.log('hData[' + this.name + '] = ' + hData[this.name]);
         }
    });
    return hData;
};

function saveOrder(){

$.ajax({
		type: 'POST',
		async: true,
		url: "../php/order.php",
   //     data: postData,
		dataType: 'json',
		success: function(data){
            console.log("LL");
			if(data['success']){
                console.log("LL");
				alert(data['message']);
			} else {
				alert(data['message']);
            }
		}
	 });
}

function showProducts(id){
	var objName = "#informForOrderId_" + id;
	if( $(objName).css('display') != 'table-row' ) {
		$(objName).show();
	} else {
		$(objName).hide();
	}
}