<?php
use App\Functions\Functions;
$required = "required";
?>
@include('vendors/commons/errors')
<style>
.stars__container ul {
    margin-left: 0 !important;
    padding: 0;
}
.stars-rating{
    float: left;
    margin-right: 0;
    margin-bottom: 10px;
}

.stars__container ul li i.fa-star{
	color:#ffdc2e;
}
.stars__container ul li i.fa-star-o{
	color:#848585;
}
.stars__container ul li {
    list-style: none;
    display: inline-block;
}
</style>
<div class="portlet-body">
    <div class="tabbable-line">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">

                <div class="row">
                    <div class="col-md-8 col-sm-12">
                        <div class="portlet blue-hoki box">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-cogs"></i>Review Details </div>

                            </div>
                            
                            <div class="portlet-body">
                                <div class="row static-info">
                                    <div class="col-md-5 name">Product: </div>
                                    <div class="col-md-7 value">{{ (count($model->products)>0)?$model->products->name:'' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Customer Name: </div>
                                    <div class="col-md-7 value">{{ (count($model->users)>0)?$model->users->firstName:'' }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Name or Nickname: </div>
                                    <div class="col-md-7 value">{{ $model->name }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Title: </div>
                                    <div class="col-md-7 value">{{ $model->title }}</div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Date: </div>
                                    <div class="col-md-7 value"> {{ Functions::frontDate($model->created_at)}} </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Ratings: </div>
                                    <div class="col-md-7 value"><div class="stars-rating">
                                 <div class="stars__container">
                                <ul>
                                    @for($i=1;$i<=5;$i++)
                                    <li><i class="fa fa-star<?php echo ($model->ratings >= $i) ? '' : '-o'; ?>"></i></li>
                                    @endfor
                                </ul>
                                </div>
                                </div></div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name"> Status: </div>
                                    <div class="col-md-7 value">
                                        {!! Form::select('status', $status,null , array('class' => 'form-control',$required) ) !!}
                                    </div>
                                </div>
                                <div class="row static-info">
                                    <div class="col-md-5 name">Comment: </div>
                                    <div class="col-md-7 value">{{ $model->comment }}</div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>   
</div>
