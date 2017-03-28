var adminlistsubcategories={
	init:function(){
		this.listsubcategory();
		this.paginationEvent();
                this.subcategoryEvent();
		this.editClickEvent();
		this.blockSearchSubmit();
	},
	filterPage:1,
	filterTitle:"",
	filterStatus:"",
	listsubcategory:function(){
		var _this=this;
		showLoadingDiv(".container");
		$.ajax({
			type:"GET",
			url:"./admin/subcategory.php/subcategories",
			dataType: 'json',
			success:function(data){
				stopLoadingDiv(".container");
                                console.log(data);
				if(!data.error)
				{
					_this.rendersubcategories(data);
				}
				else
				{
					$("#content-body").html("<tr><td colspan='11'>"+data.error+"</td></tr>");
				}

			},
			error:function(data){
				stopLoadingDiv(".container");
				$("#content-body").html("<tr><td colspan='11'>No subcategory available.</td></tr>");
			}
		});
	},
	rendersubcategories:function(data){
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

		var row='<tr id={idsubcategory} style="word-break:break-all">'+
		'<td>{title}</a></td>'+
		'<td>{categorytitle}</a></td>'+
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
	subcategoryEvent:function(){
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

		      _this.getSubcategoryByFilter(filtervalue);
		  });
	},
	getSubcategoryByFilter:function(filterdata)
	{
                console.log(filterdata);
		_this=this;
		showLoadingDiv(".container");
		$.ajax({
		type:"GET",
		url:"./admin/subcategory.php/subcategories",
		data:filterdata,
		success:function(data){
			stopLoadingDiv(".container");
			console.log(data);
			if(!data.error)
			{
				_this.rendersubcategories(data);
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
			$("#content-body").html("<tr><td colspan='11'>No subcategory available.</td></tr>");
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

	        _this.getSubcategoryByFilter(filtervalue);
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

	        _this.getSubcategoryByFilter(filtervalue);
	    });
	},
	editClickEvent:function(){
		_this=this;
		$("body").on("click",".anchoredit",function(){
			thisid=$(this).parents("tr").attr("id");
			window.location='editsubcategory.php?subcategoryid='+thisid;

		});
	},
	blockSearchSubmit:function(){
		$("#search-form").submit(function(){
			return false;
		});
	}
}

adminlistsubcategories.init();
