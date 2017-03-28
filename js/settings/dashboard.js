var dashboard={
	init:function(){
		this.getCategoriescount();
		this.getActiveCategoriescount();
		this.getsubCategoriescount();
		this.getActivesubCategoriescount();
		this.getProductscount();
		this.getActiveProductscount();
		this.lastAddedcategories();
		this.lastAddedsubcategories();
		this.lastAddedproducts();
	},
	getCategoriescount:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/dashboard.php/categoriescount",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
				if(!data.error)
				{
					$("#categories").append(data.count);
				}
				else
				{
					//error
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				//error
			}
		});
	},
	getActiveCategoriescount:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/dashboard.php/categoriesactivecount",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
				if(!data.error)
				{
					$("#activecategories").append(data.count);
				}
				else
				{
					//error
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				//error
			}
		});
	},
	getsubCategoriescount:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/dashboard.php/subcategoriescount",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
				console.log(data);
				if(!data.error)
				{
					$("#subcategories").append(data.count);
				}
				else
				{
					//error
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				//error
				console.log(data);
			}
		});
	},
	getActivesubCategoriescount:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/dashboard.php/subcategoriesactivecount",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
				console.log(data.count);
				if(!data.error)
				{
					$("#activesubcategories").append(data.count);
				}
				else
				{
					//error
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				//error
			}
		});
	},
	getProductscount:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/dashboard.php/productscount",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
				if(!data.error)
				{
					$("#products").append(data.count);
				}
				else
				{
					//error
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				//error
			}
		});
	},
	getActiveProductscount:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/dashboard.php/productsactivecount",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
				if(!data.error)
				{
					$("#activeproducts").append(data.count);
				}
				else
				{
					//error
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				//error
			}
		});
	},
	lastAddedcategories:function(){
		_this=this;
		showLoadingDiv(".container");
		$.ajax({
		type:"GET",
		url:"./admin/dashboard.php/lastthreecategories",
		success:function(data){
			stopLoadingDiv(".container");
			console.log(data);
			if(!data.error)
			{
				$(".categorylist ul").append("");
                                for(i in data)
                                {
                                    var list = $('<li>' + data[i].title + '</li>');
                                    $(".categorylist ul").append(list);
                                }
			}
			else
			{
				usermessage(data.error,"error");
			}

		},
		error:function(data){
			stopLoadingDiv(".container");
			if(data.status === 401)
				{
					console.log(data.status);
					usermessage("Session Expired","error");
					setTimeout(function (){
					  window.location="index.php";
				  },1000);
				}
			console.log(data);
		}
	  });

	},
	lastAddedsubcategories:function(){
		_this=this;
		showLoadingDiv(".container");
		$.ajax({
		type:"GET",
		url:"./admin/dashboard.php/lastthreesubcategories",
		success:function(data){
			stopLoadingDiv(".container");
			console.log(data);
			if(!data.error)
			{
				$(".subcategorylist ul").append("");
                                for(i in data)
                                {
                                    var list = $('<li>' + data[i].title + '</li>');
                                    $(".subcategorylist ul").append(list);
                                }
			}
			else
			{
				usermessage(data.error,"error");
			}

		},
		error:function(data){
			stopLoadingDiv(".container");
			if(data.status === 401)
				{
					console.log(data.status);
					usermessage("Session Expired","error");
					setTimeout(function (){
					  window.location="index.php";
				  },1000);
				}
			console.log(data);
		}
	  });

	},
	lastAddedproducts:function(){
		_this=this;
		showLoadingDiv(".container");
		$.ajax({
		type:"GET",
		url:"./admin/dashboard.php/lastthreeproducts",
		success:function(data){
			stopLoadingDiv(".container");
			console.log(data);
			if(!data.error)
			{
				$(".productlist ul").append("");
                                for(i in data)
                                {
                                    var list = $('<li>' + data[i].title + '</li>');
                                    $(".productlist ul").append(list);
                                }
			}
			else
			{
				usermessage(data.error,"error");
			}

		},
		error:function(data){
			stopLoadingDiv(".container");
			if(data.status === 401)
				{
					console.log(data.status);
					usermessage("Session Expired","error");
					setTimeout(function (){
					  window.location="index.php";
				  },1000);
				}
			console.log(data);
		}
	  });

    },
}

dashboard.init();
