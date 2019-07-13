@foreach($model as $row)
<li class="parent">
    @if(isset($category2))
        <?php $checked = (in_array($row->id,$category2))?'checked':''; ?>
    @endif
    <input type="checkbox" name="category2[]" value="{{ $row->id }}" <?php echo $checked;?> class="parent" id='{{ $row->id }}'/><label>{{ $row->name }}</label>
    @if(count($row->children)>0)
    <ul class="category__list">
    @foreach($row->children as $children)
        <li class="list__subcategory">
            @if(isset($category3))
            <?php $checked = (in_array($children->id, $category3)) ? 'checked' : ''; ?>
            @endif
            <input type="checkbox" name="category3[]" value="{{ $children->id }}" <?php echo $checked;?> class="child" id="{{ $children->id }}"/>
            <label>{{ $children->name }}</label>
        </li>
    @endforeach
    </ul>
    @endif
</li>
@endforeach
<script>
$(".child[type='checkbox']").click(function(){
    if($(this).is(':checked')){
      $(this).closest('li.parent').find('.parent').prop("checked",true);
    }
    /*else{
      $(this).closest('li.parent').find('.parent').prop("checked",false);
    }*/
});

$(".parent[type='checkbox']").click(function(){
    if($(this).is(':checked')){
      $(this).parent('li').find('.child').prop("checked",true);
    }else{
      $(this).parent('li').find('.child').prop("checked",false);
    }
});
</script>