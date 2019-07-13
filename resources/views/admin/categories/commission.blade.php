@extends('admin/admin_template')
@section('content')
<!-- Main row -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

<h1 class="page-title">Commission Fees</h1>
<div class="row">
<div class="col-md-12">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <p><i class="icon fa fa-check"></i> &nbsp  {!! session('success') !!}</p>
        </div>
    @endif
    <!-- BEGIN SAMPLE TABLE PORTLET-->
    <div class="portlet light">
        <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase"> Total Categories : {{ count($allCategories) }}  </span>
            </div>
            <div class="btn-group pull-right">
                <a href="{{ url('admin/categories/create') }}" class="btn sbold green"> Add New
					<i class="fa fa-plus"></i>
				</a>
            </div>
		
        </div>
        <div class="portlet-body">
          
<div class="table-area">
<table class="level--1--cata-1">
<tr>
        <th>Category</th>
        <th colspan="4">Commission</th>
</tr>
    <tr class="rootCategory">
            <td><strong>Root Category</strong></td>
            <td>10.00%</td>
    </tr>
    <?php
     $i = 1;
    foreach ($categories as $id => $category) {
      if (!isset($category['name']))
      continue;
    ?>
    <tr class="root__category--2 ">
    <td >
        <a class="toggleCollapseBtn collapsed" data-toggle="collapse" data-target="#demo<?php echo $id; ?>">
        <?php echo $category['name']; ?></a>
    </td>
		<td class="editableRow">
		<div class="edit__commission">
		<div class="commission__percentage is-active" id="percentage<?php echo $id;?>"><?php echo ($category['commission']>0)?$category['commission']."%":''; ?></div>
		<input type="number" step="0.01" min="0" id="comm<?php echo $id;?>" value="<?php echo ($category['commission']>0)?$category['commission']:''; ?>" class="hidden" />
		<ul>
			<li>
			<button type="button" class="edit-btn">Edit<i class="fa fa-pencil-square-o"></i></button>
			<button type="button" class="update-btn hidden" onclick="editData(<?php echo $id;?>);">Update<i class="fa fa-check"></i></button>
			<button type="button" class="cancel-btn hidden">Cancel<i class="fa fa-times"></i></button>
			</li>
		</ul>
		</div>
    </td>
    </tr>
    <?php if (!empty($category['categories'])) {   ?> 
    <tr class="row__collapse">
        <td colspan="4">
    <table class="level--2--cata-2 m20"> 
     <tr>
       <td>     
       <div id="demo<?php echo $id; ?>" class="collapse data-holder">
    <?php
        foreach ($category['categories'] as $subCatId=>$subCategory) {     
    ?>
    
        <table class="level--3--cata-3">
            <tr>
                <td><a class="toggleCollapseBtn collapsed" data-toggle="collapse" data-target="#demo<?php echo $subCatId; ?>"><?php echo $subCategory; ?><a></td>
                <td class="editableRow">
                    <div class="edit__commission">
                    <div class="commission__percentage is-active" id="percentage<?php echo $subCatId;?>"><?php echo ($category['categories_commission'][$subCatId]>0)?$category['categories_commission'][$subCatId]."%":''; ?></div>
                    <input type="number" step="0.01" min="0" id="comm<?php echo $subCatId;?>" value="<?php echo ($category['categories_commission'][$subCatId]>0)?$category['categories_commission'][$subCatId]:''; ?>" class="hidden" />
                    <ul>
                    <li>
                    <button type="button" class="edit-btn">Edit<i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="update-btn hidden" onclick="editData(<?php echo $subCatId;?>);">Update<i class="fa fa-check"></i></button>
                    <button type="button" class="cancel-btn hidden">Cancel<i class="fa fa-times"></i></button>
                    </li>
                    </ul>
                    </div>
                </td>
            </tr>
            <?php
            if (!empty($category[$subCatId]['subcategories'])) {
            ?>
            <tr>
        <table class="level--4--cata-4">
        <tr>
        <td>
        <div id="demo<?php echo $subCatId; ?>" class="collapse">
        
            <?php
            foreach ($category[$subCatId]['subcategories'] as $subSubCatId => $subSubCategory) {
             ?>
        <table>
               <tr>
        <td><?php echo $subSubCategory; ?></td>
        <td class="editableRow">
        <div class="edit__commission">
            <div class="commission__percentage is-active" id="percentage<?php echo $subSubCatId;?>"><?php echo  ($category[$subCatId]['subcategories_commission'][$subSubCatId]>0)?$category[$subCatId]['subcategories_commission'][$subSubCatId]."%":''; ?></div>
            <input type="number" step="0.01" min="0" id="comm<?php echo $subSubCatId;?>" value="<?php echo  ($category[$subCatId]['subcategories_commission'][$subSubCatId]>0)?$category[$subCatId]['subcategories_commission'][$subSubCatId]:''; ?>" class="hidden" />
            <ul>
                    <li>
                    <button type="button" class="edit-btn">Edit<i class="fa fa-pencil-square-o"></i></button>
                    <button type="button" class="update-btn hidden" onclick="editData(<?php echo $subSubCatId;?>);">Update<i class="fa fa-check"></i></button>
                    <button type="button" class="cancel-btn hidden">Cancel<i class="fa fa-times"></i></button>
                    </li>
            </ul>
        </div>
        </td>
        </tr> 
        </table>
             <?php
            }
            ?>
       
        </div>
        </td>
        </tr>
        
        <?php
            }
          ?>
      </table>
           
      
     
    <?php
        } ?>
     </div>   
     </td>        
     </tr>   
    </table>
        </td>       
    </tr>
    <?php
        } 
    ?>
    <?php
        $i++;
    }
    ?>        
            
   
</table>
			</div>
		  
		  
            
        </div>
    </div>
    <!-- END SAMPLE TABLE PORTLET-->
</div>
</div>
<!-- /.row -->
<script type="text/javascript">
    $(document).ready(function () {
        $.fn.extend({
            treed: function (o) {

                var openedClass = 'glyphicon-minus-sign';
                var closedClass = 'glyphicon-plus-sign';

                if (typeof o != 'undefined') {
                    if (typeof o.openedClass != 'undefined') {
                        openedClass = o.openedClass;
                    }
                    if (typeof o.closedClass != 'undefined') {
                        closedClass = o.closedClass;
                    }
                }
                ;

                //initialize each of the top levels
                var tree = $(this);
                tree.addClass("tree");
                tree.find('li').has("ul").each(function () {
                    var branch = $(this); //li with children ul
                    branch.prepend("<i class='indicator glyphicon " + closedClass + "'></i>");
                    branch.addClass('branch');
                    branch.on('click', function (e) {
                        if (this == e.target) {
                            var icon = $(this).children('i:first');
                            icon.toggleClass(openedClass + " " + closedClass);
                            $(this).children().children().toggle();
                        }
                    })
                    branch.children().children().toggle();
                });
                //fire event from the dynamically added icon
                tree.find('.branch .indicator').each(function () {
                    $(this).on('click', function () {
                        $(this).closest('li').click();
                    });
                });
                //fire event to open branch if the li contains an anchor instead of text
                tree.find('.branch>a').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
                //fire event to open branch if the li contains a button instead of text
                tree.find('.branch>button').each(function () {
                    $(this).on('click', function (e) {
                        $(this).closest('li').click();
                        e.preventDefault();
                    });
                });
            }
        });

        //Initialization of treeviews

        $('#tree1').treed();
    });
</script>
<script>

	$(".edit-btn").on("click", function() {
	  $(this).parentsUntil(".editableRow").children("input").removeClass('hidden');
	  $(this).parentsUntil(".editableRow").children(".commission__percentage").addClass('hidden');
	  $(this).addClass('hidden');
	  $(this).parentsUntil(".editableRow").children(".update-btn").removeClass('hidden');
	  $(this).parentsUntil(".editableRow").children(".cancel-btn").removeClass('hidden');
          
          
	});
        $(".update-btn").on("click", function() {
            $(this).parentsUntil(".editableRow").children(".update-btn").addClass('hidden');
            $(this).parentsUntil(".editableRow").children(".cancel-btn").addClass('hidden');
            $(this).parentsUntil(".editableRow").children("input").addClass('hidden');
            $(this).parentsUntil(".editableRow").children(".commission__percentage").removeClass('hidden');
            $(this).parentsUntil(".editableRow").children(".edit-btn").removeClass('hidden');
        });
        $(".cancel-btn").on("click", function() {
            $(this).parentsUntil(".editableRow").children(".update-btn").addClass('hidden');
            $(this).parentsUntil(".editableRow").children(".cancel-btn").addClass('hidden');
            $(this).parentsUntil(".editableRow").children("input").addClass('hidden');
            $(this).parentsUntil(".editableRow").children(".commission__percentage").removeClass('hidden');
            $(this).parentsUntil(".editableRow").children(".edit-btn").removeClass('hidden');
        });
        
        
     function editData(id)  
     {  
           var comm = $("#comm"+id).val();
           $.ajax({  
                url:"{{ url('admin/commission/update') }}",  
                method:"POST",  
                data:{id:id, commission:comm, _token:'<?php echo csrf_token();?>'},  
                success:function(data){  
                     if(data==1){
                         $("#percentage"+id).text(comm+'%');
                         $("#comm"+id).val(comm);
                     }
                }  
           });  
     }

</script>
@endsection
