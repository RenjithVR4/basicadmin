var login={
          init:function()
          {
                    this.loginform();
	},
          loginform:function()
          {
                    var _this = this;
                    var  data = {};

                    $("#loginform").submit(function()
                    {
                              var  adminemail = $("#email").val();
                              var  adminpassword = $("#password").val();

                              if(!adminemail)
                              {
                                      $('.emailfield').css('border-color', 'red');
                                      msg =  "Please enter your email";
                                      usermessage(msg,"error");
                                      return false;
                              }
                              else
                              {
                                         $(".emailfield").css("border-color", "#F3F3F4");
                              }


                              if(!verifyEmail(adminemail))
                              {
                                        $('.emailfield').css('border-color', 'red');
                                        msg =  "Please enter valid email";
                                        usermessage(msg,"error");
                                        return false;
                              }
                              else
                              {
                                         $(".emailfield").css("border-color", "#F3F3F4");
                              }

                              if(!adminpassword)
                              {
                                        $('.passwordfield').css('border-color', 'red');
                                        msg =  "Please enter your password";
                                        usermessage(msg,"error");
                                        return false;
                              }
                              else
                              {
                                         $(".passwordfield").css("border-color", "#F3F3F4");
                              }

                              if(adminemail && adminpassword)
                              {
                                        data['email'] = adminemail.trim();
                                        data['password'] = adminpassword.trim();
                                        _this.userLogin(data);
                                        return false;
                              }
                    });
          },
          userLogin:function(data)
          {
                    var _this = this;

                    showLoadingDiv(".loginbody");
                    $.ajax({
			url:"./admin/login.php",
			data:data,
			success:function(data)
                              {
                                      stopLoadingDiv(".loginbody");
                                      if(data.error)
                                      {
                                              usermessage(data.error,"error");
                                      }
                                      else
                                      {
                                              window.location.href = "index.php";
                                      }
                              },
                              error:function(data)
                              {
                                      stopLoadingDiv(".loginbody");

                                      usermessage(data.error,"error");
                              }
                      });
              },
      }

      $(document).ready(function()
      {
              login.init();
      });
