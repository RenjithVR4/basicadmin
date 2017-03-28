var adminaddsubcategory={
	init:function(){
                this.getCategories();
		this.addSubcategory();
	},
        getCategories(){
                var _this = this;
		data = {};
		data['status'] = 'YES';
                $.ajax({
                    type: "GET",
		    data:data,
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
        addSubcategory:function(){
		var _this=this;
		$("#submitsubcategory").on("click",function(){

		      var formData = {};
                      formData['title'] = $("#title").val();
                      formData['catid'] = $("#category").val();

                      if((!formData['title']) || (formData['title'] == ""))
                      {
                              $(".errormessage").html()
                              $('#title').css('border-color', 'red');
                              $(".errormessage").html("Please enter Title");
                              return false;
                      }
                      else
                      {
                                 $("#title").css("border-color", "#ccc");
                      }

                      if((!formData['catid']) || (formData['catid'] == ""))
                      {
                              $(".errormessage").html()
                              $('#category').css('border-color', 'red');
                              $(".errormessage").html("Please select category");
                              return false;
                      }
                      else
                      {
                                 $("#category").css("border-color", "#ccc");
                      }

		      _this.submitSubcategory(formData);
		      return false;

		  });
	},
	submitSubcategory:function(formData){
		console.log(formData);
		var _this=this;
		showLoadingDiv(".grid-form");
		$.ajax({
			type:"POST",
			url:"./admin/subcategory.php",
			dataType: 'json',
                        data:formData,
			success:function(data){
				stopLoadingDiv(".grid-form");
                                console.log(data);
				if(!data.error)
				{
                                        $(".successmessage").html();
                                        $(".successmessage").html("Subcategory successfully added.");;
                                        setTimeout(function (){
						  window.location="subcategories.php";
					  },2000);
				}
				else
				{
                                        $(".errormessage").html();
                                        $(".errormessage").html(data.error);
				}
			},
			error:function(data)
                        {
				stopLoadingDiv(".grid-form");
                                $(".errormessage").html();
                                $(".errormessage").html(data.error);
			}
		});
	}
}

adminaddsubcategory.init();
