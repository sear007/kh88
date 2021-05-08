$("#btn-login").click(function(){
    $(this).html(`<i class="fas fa-sync fa-spin"></i>`); $(this).prop('disabled',true);
    setTimeout(() => {$(this).html(`LOGIN`);$(this).prop('disabled',false);}, 1500);
    var username = $("#username").val();
    var password = $("#password").val();
    var token =   $("meta[name='csrf-token']").attr('content');
    if(username && password){
      $.ajax({
        url:"/login",
        method:"post",
        data: {"_token": token,"username": username, "password":password},
        success: function(response){
          if(response.code === 200){
            successAlert(response.message);
            setTimeout(()=>{window.location.reload()},2000);
          }else{
            errorInput(response.message);
          }
          
        },
        error: function(error){
          console.error(error);
        }
      })
    }else{
      errorInput('Please enter the account.!');
    }
  });
  function successAlert(message){
    Toast.fire({
      icon: 'success',
      title: message,
      position: 'top'
    });
    $("#username").addClass('was-validated');$("#password").addClass('was-validated ');
    setTimeout(() => {$("#username").removeClass('was-validated ');$("#password").removeClass('was-validated');}, 1500);
  }
  function errorInput(message){
    Toast.fire({
      icon: 'error',
      title: message,
      position: 'top'
    })
    $("#username").addClass('is-invalid');$("#password").addClass('is-invalid');
    setTimeout(() => {$("#username").removeClass('is-invalid');$("#password").removeClass('is-invalid');}, 1500);
  }