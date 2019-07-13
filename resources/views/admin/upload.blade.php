<?php
if (!empty($_GET['status'])) {
    switch ($_GET['status']) {
        case 'succ':
            $statusMsgClass = 'alert-success';
            $statusMsg = 'Data data has been inserted successfully.';
            break;
        case 'err':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Some problem occurred, please try again.';
            break;
        case 'invalid_file':
            $statusMsgClass = 'alert-danger';
            $statusMsg = 'Please upload a valid CSV file.';
            break;
        default:
            $statusMsgClass = '';
            $statusMsg = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Import CSV File Data into MySQL Database using PHP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style type="text/css">
            .panel-heading a{float: right;}
            #importFrm{margin-bottom: 20px;display: block;}
            #importFrm input[type=file] {display: inline;}
        </style>
    </head>
    <body>

        <div class="container">
            <h2>Import CSV File Data into MySQL Database using PHP</h2>
            <?php
            if (!empty($statusMsg)) {
                echo '<div class="alert ' . $statusMsgClass . '">' . $statusMsg . '</div>';
            }
            ?>
            <!--<div class="panel panel-default">
                <div class="panel-heading">
                    Members list
                    <a href="javascript:void(0);" onclick="$('#importFrm').slideToggle();">Import Members</a>
                </div>
                <div class="panel-body">-->
            <div class="col-md-6">
                <h2>Import Service Area File</h2>
                {!! Form::open(array( 'class' => 'form','id' => 'myform','url' => 'admin/upload', 'files' => true, 'id' => 'importFrm')) !!}

                <input type="file" name="file" />
                <input type="hidden" name="type" value="area"/>
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                {!! Form::close() !!}
            </div>
            
            
            <div class="col-md-6">
                <h2>Import Product File</h2>
                {!! Form::open(array( 'class' => 'form','id' => 'myform','url' => 'admin/upload', 'files' => true, 'id' => 'importFrm')) !!}

                <input type="file" name="file" />
                <input type="hidden" name="type" value="product"/>
                <input type="submit" class="btn btn-primary" name="importSubmit" value="IMPORT">
                {!! Form::close() !!}
            </div>
           
            <!--</div>
        </div>-->
        </div>

    </body>
</html>