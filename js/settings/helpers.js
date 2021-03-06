function verifyEmail(email)
{
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

          return regex.test(email);
}

function getFormObj(formid)
{
	formdata = $("#"+formid).serializeArray();
	obj = new Object();
	for(i in formdata)
	{
		if(formdata[i].value !== "")
                    {
                              obj[formdata[i].name] = formdata[i].value;
                    }
	}

	return obj;
}

function showLoadingDiv(id)
{
	$(id).children().css({"opacity":"0"});
	$(id).append("<div class='loading'></div>");
}

function stopLoadingDiv(id)
{
	$(id).children().css({"opacity":"1"});
	$(id+" .loading").remove();
}

function adminLogout()
{
        var thispath = document.location.pathname;
        thispath = thispath.substring(0,thispath.lastIndexOf("/"));
        thispath = thispath.substring(0,thispath.lastIndexOf("/"));
        console.log(thispath);

        showLoadingDiv("body");
        $.ajax({
                type:"GET",
                url:thispath+"/basicadmin/admin/logout.php",
                success:function(data)
                {
                        window.location=thispath+'/basicadmin/login.php';
                },
                error:function(data)
                {
                        window.location=thispath+'/basicadmin/login.php';
                }

        });
}

function usermessage(message,type)
{
        notif({
                  msg: message,
                  type: type,
                  position: "center"
          });
}
