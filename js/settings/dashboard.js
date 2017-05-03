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
		this.getBrowser();
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
					$("#categories").append("Count data Error");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#categories").append("Found an unknown Error");
				console.log(data);
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
					$("#activecategories").append("Count data Error");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#activecategories").append("Found an unknown Error");
				console.log(data);
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
					$("#activesubcategories").append("Count data Error");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#activesubcategories").append("Found an unknown Error");
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
					$("#activesubcategories").append("Count data Error");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#activesubcategories").append("Found an unknown Error");
				console.log(data);
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
					$("#products").append("Count data Error");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#products").append("Found an unknown Error");
				console.log(data);
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
				console.log(data);
				stopLoadingDiv(".container");
				if(!data.error)
				{
					$("#activeproducts").append(data.count);
				}
				else
				{
					$("#activeproducts").append("Count data Error");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#activeproducts").append("Found an unknown Error");
				console.log(data);
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
                                    var list = $('<li>' + data[i].title + ' <i class="pull-right">' + formatDate(data[i].created, false, false, false) + '</i></li>');
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
                                    var list = $('<li>' + data[i].title + ' <i class="pull-right">' + formatDate(data[i].created, false, false, false) + '</i></li>');
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
                                    var list = $('<li>' + data[i].title + ' <i class="pull-right">' + formatDate(data[i].created, false, false, false) + '</i></li>');
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
	getBrowser:function(){
		_this=this;
		showLoadingDiv(".container");
		$.ajax({
		type:"GET",
		url:"./admin/dashboard.php/browser",
		success:function(data){
			stopLoadingDiv(".container");
			console.log(data);
			if(!data.error)
			{
				$(".browser").append(data);
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
