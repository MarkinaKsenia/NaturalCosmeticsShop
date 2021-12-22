function getData(){
    var hData = {};
    hData['email']=$('#email').val();
    hData['password']=$('#password').val();
    hData['password2']=$('#password2').val();
    return hData;

};

function getData2(){
    var hData = {};
    hData['loginEmail']=$('#loginEmail').val();
    hData['loginPassword']=$('#loginPassword').val();
    return hData;

};

function show (data){
    document.getElementById('reg-box').style.display="none";
    document.getElementById('login-box').style.display="none";
    $('#user').html(data['userName']);
    document.getElementById('userBox').style.display="inline";
}

function registerNewUser(){
    var postData = getData();

    var hData = {};
    hData['email']=$('#email').val();
    hData['password']=$('#password').val();
    hData['password2']=$('#password2').val();

    console.log(hData);
    $.ajax({
        type: 'POST',
        async: false,
        url: "../php/authtoriz.php",
        data: hData,
        dataType: 'json',

      success: function(data){
          if(data['success']){

               
         alert('Регистрация прошла успешно!');
                document.getElementById('reg-box').style.display="none";
                document.getElementById('login-box').style.display="none";
                $('#user').html(data['userName']);
                document.getElementById('userBox').style.display="inline";
                document.getElementById('regTable').style.display="inline";
                document.getElementById('zag').style.display="inline";
                document.getElementById('newName').value=data['name'];
                document.getElementById('newPhone').value=data['phone'];
                document.getElementById('newAdress').value=data['adress'];
          }
          else {
              alert(data['message']);
          }
         
      }
      
    });
}

function logout() {
    console.log('Logout');
    $.ajax({
        type: 'POST',
        async: false,
        url: '../php/logout.php',
        success: function(data) {
            location.reload();
            console.log('user logged out'+data);
        }
    });
}

function login(){
	
    var email = $('#loginEmail').val();
    var password   = $('#loginPassword').val();
    
    var postData = "email="+ email +"&password=" +password;
 
    console.log(postData);
    
     $.ajax({
		type: 'POST',
		async: false,
		url: "../php/login.php",
        data: postData,
		dataType: 'json',
		success: function(data){
            console.log("tyt");
			if(data['success']){
                document.getElementById('reg-box').style.display="none";
                document.getElementById('login-box').style.display="none";
                $('#user').html(data['email']);
                document.getElementById('userBox').style.display="inline";
                document.getElementById('regTable').style.display="inline";
                document.getElementById('zag').style.display="inline";
                document.getElementById('newName').value=data['name'];
                document.getElementById('newPhone').value=data['phone'];
                document.getElementById('newAdress').value=data['adress'];
				
			} else {
                alert(data['message']);
            }
            
		}
	}); 
}


function updateUserData (){
    console.log("js - updateUserData()");
    var phone = $('#newPhone').val();
    var adress = $('#newAdress').val();
    var pwd1 = $('#newPwd1').val();
    var pwd2 =  $('#newPwd2').val();
    var curPwd =  $('#curPwd').val();
    var name =  $('#newName').val();

    var postData = {
        phone: phone,
        adress: adress,
        pwd1: pwd1,
        pwd2: pwd2,
        curPwd: curPwd,
        name:name
    };


   $.ajax({
		type: 'POST',
		async: false,
		url: "../php/update.php",
        data: postData,
		dataType: 'json',
		success: function(data){
            console.log("tyt");
			if(data['success']){
               alert(data['message']);
				
			} else {
                alert(data['message']);
            }
            
		}
	}); 
    
   
}



