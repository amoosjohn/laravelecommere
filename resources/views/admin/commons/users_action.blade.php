<div class="pull-right">
    @if($user->status == '1')
    <a href="<?php echo url('admin/user/disapprove/' . $user->id); ?>" class="btn btn-default"> Disapprove</a>
    @else
    <a href="<?php echo url('admin/user/approve/' . $user->id); ?>" class="btn btn-default">Approve</a>
    @endif
</div>
