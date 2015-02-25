 loginPage();
 
  $(document).ready(function(e) {
  $("#shadow").fadeIn("normal");
  $("#login_form").fadeIn("normal");
  $("#user_name").focus();
  
  $("#cancel_hide").click(function(){
  $("#username").val()="";
  $("#password").val()="";
  });
  $("#username").change(function(e) {
  
  });
  $("#login").click(function(){
  
  if($("#username").val().length==0 && $("#password").val().length==0)
  {
  // $(this).next().html("Field needs filling");
  $("#username").after('<span class="errorkeyup">Kolom tidak diperbolehkan kosong</span>');
  $("#password").after('<span class="errorkeyup">Kolom tidak diperbolehkan kosong</span>');
  //return false;
  success = false;
  }
  
  }); 
  }); 