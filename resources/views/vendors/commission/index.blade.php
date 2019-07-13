@extends('vendors/vendor_template')
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
            
        </div>
        <div class="portlet-body">
          
<div class="table-area">
<table class="level--1--cata-1">
<tr>
        <th>Category</th>
        <th>Commission</th>
</tr>
    <tr class="rootCategory">
            <td><strong>Root Category</strong></td>
            <td></td>
    </tr>
    <?php
     $i = 1;
    foreach ($categories as $id => $category) {
      if (!isset($category['name']))
      continue;
    ?>
    <tr class="root__category--2">
    <td>
        <a class="toggleCollapseBtn collapsed" data-toggle="collapse" data-target="#demo<?php echo $id; ?>">
        <?php echo $category['name']; ?></a>
    </td>
    <td class="editableRow">
<!--    <div class="edit__commission">
    <div class="commission__percentage is-active" id="percentage<?php echo $id;?>"><?php echo ($category['commission']>0)?$category['commission']."%":''; ?></div>
    </div>-->
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
