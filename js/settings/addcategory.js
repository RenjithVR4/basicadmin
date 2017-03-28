var adminaddcategory={
	init:function(){
		this.addCategory();
	},
        addCategory:function(){
		var _this=this;
		$("#submitcategory").on("click",function(){

		      var formData = {};
                      formData['title'] = $("#title").val();

                      if((!formData['title']) || (formData['title'] == ""))
                      {
                              $(".errormessage").html()
                              $('#title').css('border-color', 'red');
                              $(".errormessage").html("Please enter Title");
                              return false;
                      }
                      else
                      {
                                 $("#title").css("border-color", "#F3F3F4");
                      }

		      _this.submitCategory(formData);

                      return false
		  });
	},
	submitCategory:function(formData){
		var _this=this;
                showLoadingDiv(".grid-form");
		$.ajax({
			type:"POST",
			url:"./admin/category.php",
			dataType: 'json',
                        data:formData,
			success:function(data){
                                stopLoadingDiv(".grid-form");
                                console.log(data);
				if(!data.error)
				{
                                        $(".successmessage").html();
                                        $(".successmessage").html("Category successfully added.");;
                                        setTimeout(function (){
						  window.location="categories.php";
					  },2000);
				}
				else
				{
                                        $(".errormessage").html()
                                        $(".errormessage").html(data.error);
				}
			},
			error:function(data)
                        {
                                stopLoadingDiv(".grid-form");
                                $(".errormessage").html()
                                $(".errormessage").html(data.error);
			}
		});
	}
}

adminaddcategory.init();
