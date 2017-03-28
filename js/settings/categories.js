var adminlistcategories={
	init:function(){
		this.listcategory();
		this.paginationEvent();
                this.categoryEvent();
		this.editClickEvent();
		this.blockSearchSubmit();
	},
	filterPage:1,
	filterTitle:"",
	filterStatus:"",
	listcategory:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/category.php/categories",
			dataType: 'json',
			success:function(data){
                                console.log(data);
				stopLoadingDiv(".container");
				if(!data.error)
				{
					_this.rendercategories(data);
				}
				else
				{
					$("#content-body").html("<tr><td colspan='11'>"+data.error+"</td></tr>");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#content-body").html("<tr><td colspan='11'>No category available.</td></tr>");
			}
		});
	},
	rendercategories:function(data){
		_this=this;
		var obj = data;
                console.log(obj.length);

		if(obj.length < 15)
            	{
                        $(".next").addClass("disabled");
            	}
                else
            	{
            		$(".next").removeClass("disabled");
            	}

		var testcontent = "";
		linkedit = '<a class="anchoredit" href="#">';

		var fstatus = '';

		var row='<tr id={idcategory} style="word-break:break-all">'+
		'<td>{title}</a></td>'+
		'<td>{status}</a></td>'+
                // '<td>{created}</a></td>'+
		'<td>'+linkedit+'Edit</a></td>' +
		"</tr>";

		for(i in obj)
		{
			str=row;

			for(j in obj[i])
			{
				thisvalue=obj[i][j];

				if(thisvalue===null)
				thisvalue="Not Defined";

				if(obj[i]['status'] == 'YES')
				{
					fstatus = 'ACTIVE';
				}

				if(obj[i]['status'] == 'NO')
				{
					fstatus = 'INACTIVE';
				}

				var test = "{"+j+"}";
				str=str.replace("{"+j+"}",thisvalue);
				str=str.replace("{status}",fstatus);
			}

			testcontent+=str;
		}

		$("#content-body").html(testcontent);
	},
	categoryEvent:function(){
		_this=this;
		$(".filter").change(function(){
		      var data = new Object();
		      searchobj = $("#search-form").serializeArray();
                      console.log(searchobj);
		      for(i in searchobj)
		      {
		        	if(searchobj[i].name==="title")
		        		_this.filterTitle=searchobj[i].value;

		        	if(searchobj[i].name==="status")
		        		_this.filterStatus=searchobj[i].value;
		      }

		      _this.filterPage=1;

		      var filtervalue = new Object();
		      filtervalue['page']=_this.filterPage;
		      filtervalue['title']=_this.filterTitle;
		      filtervalue['status']=_this.filterStatus;

		      $(".next").addClass("disabled");
		      $(".previous").addClass("disabled");

		      _this.getCategoryByFilter(filtervalue);
		  });
	},
	getCategoryByFilter:function(filterdata)
	{
                console.log(filterdata);
		_this=this;
		showLoadingDiv(".container");
		$.ajax({
		type:"GET",
		url:"./admin/category.php/categories",
		data:filterdata,
		success:function(data){
			console.log(data);
			stopLoadingDiv(".container");
			if(!data.error)
			{
				_this.rendercategories(data);
			}
			else
			{
				$("#content-body").html("<tr><td colspan='11'>"+data.error+"</td></tr>");
			}

		},
		error:function(data){
			stopLoadingDiv(".container");
			if(data.status === 401)
				{
					console.log(data.status);
					showError("Session Expired");
					setTimeout(function (){
					  window.location="index.php";
				  },1000);
				}
			$("#content-body").html("<tr><td colspan='11'>No category available.</td></tr>");
		}
	  });
	},
	paginationEvent:function(){

		_this=this;

		$(".previous").off("click").on("click",function(){

	    	 _this.filterPage--;

	        if(_this.filterPage <= 1)
	        {
	        	$(".previous").addClass("disabled");
	        }

	        var filtervalue = new Object();
	        filtervalue['page']=_this.filterPage;
	        filtervalue['title']=_this.filterTitle;
	        filtervalue['status']=_this.filterStatus;

	        _this.getCategoryByFilter(filtervalue);
	    });

		$(".next").off("click").on("click",function(){

			_this.filterPage++;
	        if(_this.filterPage > 1)
	        {
	        	$(".previous").removeClass("disabled");
	        }

	        var filtervalue = new Object();
                filtervalue['page']=_this.filterPage;
	        filtervalue['title']=_this.filterTitle;
	        filtervalue['status']=_this.filterStatus;

	        _this.getCategoryByFilter(filtervalue);
	    });
	},
	editClickEvent:function(){
		_this=this;
		$("body").on("click",".anchoredit",function(){
			thisid=$(this).parents("tr").attr("id");
			window.location='editcategory.php?categoryid='+thisid;

		});
	},
	blockSearchSubmit:function(){
		$("#search-form").submit(function(){
			return false;
		});
	}
}

adminlistcategories.init();
