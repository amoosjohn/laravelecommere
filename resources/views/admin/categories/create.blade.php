@extends('admin/admin_template')
<?php
$size = Config::get('params.best_image_size') ;
$required = "required";
?>
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>  
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular-route.min.js"></script>  
<div class="row">
    <div class="col-md-12">
        <!-- Horizontal Form -->

        <!-- /.box -->
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Add New Category</h3>
            </div>
      
            <!-- /.box-header -->
            @include('admin/commons/errors')
            <div class="box-body" ng-app="vitalmart" ng-controller="CategoryController" ng-init="loadCategory()">
                <form class="form" method="POST" action="{{url('admin/categories/insert')}}" enctype="multipart/form-data">
                    <input type="hidden" value="{{csrf_token()}}" name="_token">

                     <div class="form-group">
                        <label>Parent Category</label> 
                        <select name="parent_id" class="form-control" ng-model="parent_id" ng-change="loadSubCategory()">
                            <option value="">Select Parent Category</option>
                            <option ng-repeat="category in categories" value="@{{category.id}}">@{{category.name}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Sub Category</label> 
                        <select name="sub_id" class="form-control" ng-model="sub_id">
                            <option value="">Select Sub Category</option>
                            <option ng-repeat="subcategory in subcategories" value="@{{subcategory.id}}">
                                @{{subcategory.name}}
                            </option>

                        </select>
                    </div>
                  
                    
                    <div class="form-group">
                        <label>Category Name <span class="required">*</span></label> 
                        <input type="text" name="name" class="form-control" value="" required="required">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control ckeditor" name="description" required="required"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Commission <span class="required">*</span></label> 
                        <input type="text" name="commission" class="form-control" value="" required="required" placeholder="1.0" pattern="[\-\+]?[0-9]*(\.[0-9]+)?">
                    </div>
                    <div class="form-group last">
                        <div class="">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail" style="width:200px; height: 200px;">
                                    <img src="<?php echo (isset($model)) ? asset('/' . $model->image) : asset('front/images/no-image.png') ?>" style="width: 200px; height: 300px;" alt="" /> </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="image" accept="image/*" > </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                            <div class="margin-top-10 margin-bottom-10">
                                <span class="label label-danger">NOTE!</span> Best Image Size <?php echo $size ;?> </div>
                        </div>
                    </div> 
                    <div class="clearfix"></div>
                   
                    <div class="form-group">
                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Save</button>
                    <a href="{{ url('admin/categories')}}" class="btn btn-outline grey-salsa">Cancel</a>
                    </div>
                      
                </form>
                
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<script>
var app = angular.module("vitalmart",[]);

app.controller("CategoryController",function($scope,$http){
    
    $scope.loadCategory =function (){
        $http.get("<?php echo url('admin/categories/category') ?>")
                .success(function (data){
                    $scope.categories = data;
                });
    }
    $scope.loadSubCategory =function (){
        $http.get("<?php echo url('admin/categories/sub-category') ?>/"+$scope.parent_id)
                .success(function (data){
                    console.log(data);
                    $scope.subcategories = data;
                });
              
    }
    
});

</script>
@endsection