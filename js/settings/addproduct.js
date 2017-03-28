var adminaddproduct={
	init:function(){
		this.setRichtext();
                this.getCategories();
		this.imageUpload();
                this.changeEvent();
		this.deleteImage();
		this.addProduct();
	},
	postImage:"",
	setRichtext()
	{
		tinymce.init({
		  selector: 'textarea.description',
		  height: 200,
		  menubar:false,
		  toolbar: 'undo redo | bold italic | bullist numlist',
		  plugins:'wordcount'
		});
	},
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
                    error: function(data)
		    {
                        console.log(data.responseText);
			usermessage(data.responseText,"error");
                    }
                });
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
				    $("#subcategory").append('<option value="">Select category</option>');
                                    for(i in data)
                                    {
                                            var option = $('<option value="' + data[i].idsubcategory + '">' + data[i].title + '</option>');
                                            $("#subcategory").append(option);
                                    }
                            }
                            else
                            {
                                     $("#subcategory").html("");
                                     $("#subcategory").append('<option value="">Select category</option>');
                            }

                    },
                    error: function(data)
		    {
			    stopLoadingDiv(".grid-form");
                            console.log(data.responseText);
			    usermessage(data.responseText,"error");
                    }
                });

        },
        changeEvent:function(){
                var _this = this;

		$(".subcategorydiv").hide("");

		$('#category').change(function()
		{
			if($("#subcatstatus").is(':checked'))
			{
				var category = $("#category").val();
				console.log(category);
				$("#subcategory").append("");
				_this.getSubcategories(category);
			}
		});


		$('#subcatstatus').change(function()
		{
			var subcat = $('#subcatstatus:checked').val();
			console.log(subcat);
        		if($(this).is(':checked'))
			{
            			$(".subcategorydiv").show("");
	                        var category = $("#category").val();
	                        $("#subcategory").append("");
	                        _this.getSubcategories(category);
        		}
			else
			{
				$(".subcategorydiv").hide("");
				$('#subcategory').val('');
			}
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
						usermessage(data.error,"error");
						$("#uploadimage").val("");
     					}
     				},
     				error:function(data)
     	                        {
     					console.log(data);
					usermessage(data.responseText,"error");
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
					usermessage(data.responseText,"error");
					console.log(data);
				}
			});
			return false;
		});
	},
        addProduct:function(){
		var _this=this;
		$("#submitproduct").on("click",function(){

		      var formData = {};
                      formData['title'] = $("#title").val();
                      formData['catid'] = $("#category").val();

		      if(tinyMCE.activeEditor.getContent())
		      {
			      formData['description'] = tinyMCE.activeEditor.getContent();
		      }

		      if(_this.postImage)
		      {
			      formData['image'] =  _this.postImage;
		      }

                     if((!formData['title']) || (formData['title'] == ""))
                      {
                              $('#title').css('border-color', 'red');
                              var message = "Please enter Title";
			      usermessage(message,"error");
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
			      var message = "Please select category";
			      usermessage(message,"error");
                              return false;
                      }
                      else
                      {
			      $("#category").css("border-color", "#ccc");
                      }

			if($("#subcatstatus").is(':checked'))
			{
				var subcategory = $("#subcategory").val();
				if(!subcategory)
				{
					$('#subcatstatus').css('border-color', 'red');
					var message = "Please select subcategory";
					usermessage(message,"error");
					return false;
				}
				else
				{
				    $("#subcatstatus").css("border-color", "#ccc");
				    formData['subcatid'] = subcategory;
				}

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
                                        var message = "Subcategory successfully added.";
					usermessage(message,"success");
                                        setTimeout(function (){
						  window.location="products.php";
					  },2000);
				}
				else
				{
                                        usermessage(data.error,"error");
				}
			},
			error:function(data)
                        {
				stopLoadingDiv(".grid-form");
                                usermessage(data.error,"error");
			}
		});
	}
}

adminaddproduct.init();
