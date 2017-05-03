var editproductid={
	init:function(productid){
                this.getCategories();
                this.changeEvent();
		this.getProduct(productid);
		// this.imageUpload();
		// this.deleteImage();
		// this.editProduct();
	},
	postImage:"",
        getCategories(){
                var _this = this;
		data = {};
		data['status'] = 'YES';
                $.ajax({
                    type: "GET",
                    url: "./admin/category.php/categories",
		    data:data,
                    success: function(data){
                            $("#category").append("");
                            for(i in data)
                            {
                                var option = $('<option value="' + data[i].idcategory + '">' + data[i].title + '</option>');
                                $("#category").append(option);
                            }
                    },
                    error: function(data){
                        console.log(data.responseText);
                    }
                });
        },
        getProduct:function(productid){
          _this=this;
                   if(productid)
                   {
                      showLoadingDiv(".gray-bg");
                      $.ajax({
                        url:"admin/product.php/"+productid,
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
                                 $("#category").val(data['idcategory']);
                                 _this.getSubcategories(data['idcategory']);
                      	    	_this.productData(data);
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
                       window.location="products.php";
                     },2000);
                  }
        },
        getSubcategories(category){
                var _this = this;
                var data = {};
                data['catid'] = category;
		showLoadingDiv(".grid-form");
                $.ajax({
                    type: "GET",
                    url: "./admin/subcategory.php/subcatbycat",
                    data:data,
                    success: function(data){
			    stopLoadingDiv(".grid-form");
                            console.log(data);
                            if(!data.error)
                            {
                                    $("#subcategory").html("");
				    $("#subcategory").append('<option value="">Select subcategory</option>');
                                    for(i in data)
                                    {
                                            var option = $('<option value=' + data[i].idsubcategory + '>' + data[i].title + '</option>');
                                            $("#subcategory").append(option);
                                    }
                            }
                            else
                            {
                                     $("#subcategory").html("");
                                     $("#subcategory").append('<option value="">Select subcategory</option>');
                            }

                    },
                    error: function(data){
			    stopLoadingDiv(".grid-form");
                        console.log(data.responseText);
                    }
                });

        },
        productData:function(data)
        {

                console.log(data['idsubcategory']);
                $("input[name=title]").val(data['title']);
		$('#subcategory').val("");
		$('#description').val(data['description']);
		if(data['image'])
		{
			var url = "uploads/"+data['image'];
			console.log(url);
			$('.middle-content-1').show();
			$('.middle-content-1').append('<img target="_blank" src="'+url+'" style="border: 1px solid black;width:100%" >');
		}

                if(data['status'] == 'YES')
                {
                       $("input[name=status]").prop('checked', true);
                }
        },
        changeEvent:function(){
                var _this = this
                $("#category").change("#category",function(){
                        var category = $("#category").val();
                        $("#subcategory").append("");
                        _this.getSubcategories(category);

                });
        },
	imageUpload:function(){
		var _this=this;
		$(".image-group").hide();
		$("#deleteImage").addClass("disabled");
		document.getElementById("uploadimage").disabled = false;
		$("#uploadimage").on("change", function ()
		{
			var imagetype = $(this).get(0).files[0]['type'];
			var imagesize = $(this).get(0).files[0]['size'];
			var imagename = $(this).get(0).files[0]['name'];
			var filepath  =$("input[name=uploadimage]").val();

			var file_data = $('#uploadimage').prop('files')[0];
			var formdata = new FormData();
			formdata.append('image', file_data);
			console.log(formdata);
     			$.ajax({
     				type:"POST",
     				url:"./settings/uploadfile.php",
				dataType: 'json',
                		cache: false,
                		contentType: false,
				processData: false,
     	                        data:formdata,
     				success:function(data)
				{
     					if(!data.error)
     					{
						console.log(data);
						_this.postImage = data.success;
						$(".image-group").show();
						$("#deleteImage").removeClass("disabled");
						document.getElementById("uploadimage").disabled = true;
						var imagename = data.success;
						var url = "uploads/"+imagename
						$('.middle-content-1').append('<img target="_blank" src="'+url+'" style="border: 1px solid black;width:100%" >');
     					}
     					else
     					{
     						console.log(data);
						$("#uploadimage").val("");
     					}
     				},
     				error:function(data)
     	                        {
     					console.log(data);
     				}
     			});


		});
        },
	deleteImage:function()
	{
		var _this = this;

		$('body').on('click', '#deleteImage', function(e)
		{
			e.preventDefault();
			var imagepath = $('.middle-content-1 img').attr('src');
			var image = imagepath.substring(imagepath.lastIndexOf("/") + 1, imagepath.length);
			console.log(image);
			var data = {};
			data['image'] = image;
			$.ajax(
			{
				url:"./settings/deletefile.php",
				type:"POST",
				data:data,
				success:function(data)
				{
					console.log(data);
					_this.postImage = "";
					$(".image-group").load(location.href + " .image-group");
					$(".image-group").hide();
					document.getElementById("uploadimage").disabled = false;
					$("#uploadimage").val("");
					return false;

				},
				error:function(data)
				{
					console.log(data);
				}
			});
			return false;
		});
	},
        editProduct:function(){
		var _this=this;
		$("#submitproduct").on("click",function(){

		      var formData = {};
                      formData['title'] = $("#title").val();
                      formData['catid'] = $("#category").val();
		      formData['subcatid'] = $("#subcategory").val();
                      formData['description'] = $("#description").val();

		      if(_this.postImage)
		      {
			      formData['image'] =  _this.postImage;
		      }

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

                      if((!formData['subcatid']) || (formData['subcatid'] == ""))
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


		      _this.submitProduct(formData);
		      return false;

		  });
	},
	submitProduct:function(formData){
		console.log(formData);
		var _this=this;
		showLoadingDiv(".grid-form");
		$.ajax({
			type:"POST",
			url:"./admin/product.php",
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
						  window.location="products.php";
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
