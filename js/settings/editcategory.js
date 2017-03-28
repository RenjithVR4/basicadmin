var editcategory={
  init:function(categoryid){
    this.getCategory(categoryid);
    this.updateClickevent(categoryid);
  },
  oldData:"",
  getCategory:function(categoryid){
    _this=this;
     if(categoryid)
     {
        showLoadingDiv(".gray-bg");
        $.ajax({
          url:"admin/category.php/"+categoryid,
          success:function(data){
            console.log(data);
            stopLoadingDiv(".gray-bg");
            if(data.error)
            {
		    usermessage(data.error,"error");
            }
	    else
	    {
		 _this.oldaData = data;
	    	_this.categoryData(data);
	    }
          },
          error:function(data)
          {
                  stopLoadingDiv(".gray-bg");
                  usermessage(data.error,"error");
          }
        });
    }
    else
    {
       var msg = "Invalid Request";
       usermessage(msg,"error");
       setTimeout(function (){
         window.location="categories.php";
       },2000);
    }
  },
 categoryData:function(data)
 {
	 $("input[name=title]").val(data['title']);
	 if(data['status'] == 'YES')
	 {
		$("input[name=status]").prop('checked', true);
	 }

	 return false;
 },
 updateClickevent:function(categoryid)
 {
	 var _this=this;
	 $("#submitcategory").on("click",function(){

	       var formData = {};
	       formData['title'] = $("#title").val();

               $(".form-horizontal").find(':checkbox').each(function()
               {
                    if(this.checked)
                    {
                            formData['status'] = 'YES';
                    }
                    else
                    {
                            formData['status'] = 'NO';
                    }
                });

	       if((!formData['title']) || (formData['title'] == ""))
	       {
		       $('#title').css('border-color', 'red');
                       var msg = "Please enter Title";
                       usermessage(msg,"error");
		       return false;
	       }
	       else
	       {
			  $("#title").css("border-color", "#F3F3F4");
	       }

               console.log(formData['status']);

	       _this.updateCategory(categoryid,formData);

	       return false
	   });
 },
  updateCategory:function(categoryid,data){
    _this= this;
    console.log(categoryid);
    console.log(data);
    showLoadingDiv(".gray-bg");
    $.ajax({
      type:"PUT",
      url:"admin/category.php/"+categoryid,
      data:JSON.stringify(data),
      success:function(data){
        console.log(data)
        stopLoadingDiv(".gray-bg");
        if(data.success)
        {
                var msg = "Category modified successfully"
                usermessage(msg,"success");
                    setTimeout(function (){
                      window.location="categories.php";
                    },2000);
        }
        else
        {
           usermessage(data.error,"error");
           console.log(data.error)
        }
      },
      error:function(data)
      {
          stopLoadingDiv(".gray-bg");
          console.log(data.status);
          usermessage(data.error,"error");
          if(data.status === 401)
          {

            setTimeout(function (){
              window.location="login.php";
            },1000);
          }
          console.log(data.error);
      }
    })
  },
}
