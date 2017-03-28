var editsubcategory={
  init:function(subcategoryid){
          this.getCategories()
          this.getSubCategory(subcategoryid);
          this.updateClickevent(subcategoryid);
  },
  oldData:"",
  getCategories(){
          var _this = this;
          $.ajax({
              type: "GET",
              url: "admin/category.php/categories",
              success: function(data){
                      $("#category").append("");
                      for(i in data){
                          var option = $('<option value="' + data[i].idcategory + '">' + data[i].title + '</option>');
                          $("#category").append(option);
                      }
              },
              error: function(data){
                  console.log(data.responseText);
              }
          });
  },
  getSubCategory:function(subcategoryid){
    _this=this;
     if(subcategoryid)
     {
        showLoadingDiv(".gray-bg");
        $.ajax({
          url:"admin/subcategory.php/"+subcategoryid,
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
	    	_this.subcategoryData(data);
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
         window.location="subcategories.php";
       },2000);
    }
  },
 subcategoryData:function(data)
 {
         console.log(data);
	 $("input[name=title]").val(data['title']);
         $("#category").val(data['idcategory']);

	 if(data['status'] == 'YES')
	 {
		$("input[name=status]").prop('checked', true);
	 }

	 return false;
 },
 updateClickevent:function(subcategoryid)
 {
	 var _this=this;
	 $("#submitsubcategory").on("click",function(){

	       var formData = {};
	       formData['title'] = $("#title").val();
               formData['catid'] = $("#category").val();

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

               if((!formData['catid']) || (formData['catid'] == ""))
              {
                      $('#category').css('border-color', 'red');
                       var msg = "Please select Category";
                       usermessage(msg,"error");
                      return false;
              }
              else
              {
                         $("#category").css("border-color", "#F3F3F4");
              }

               console.log(formData['status']);

	       _this.updatesubcategory(subcategoryid,formData);

	       return false
	   });
 },
  updatesubcategory:function(subcategoryid,data){
    _this= this;
    console.log(subcategoryid);
    console.log(data);
    showLoadingDiv(".gray-bg");
    $.ajax({
      type:"PUT",
      url:"admin/subcategory.php/"+subcategoryid,
      data:JSON.stringify(data),
      success:function(data){
        console.log(data)
        stopLoadingDiv(".gray-bg");
        if(data.success)
        {
                var msg = "Subcategory modified successfully"
                usermessage(msg,"success");
                    setTimeout(function (){
                      window.location="subcategories.php";
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
