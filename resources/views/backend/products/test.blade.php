@extends('layouts.backend')
@section('content')
    <h3 class="details">
        <?php echo $pro->pro_description;
        ?>
    </h3>
    <form action="" method="post">
        @csrf
        <textarea name="content" cols="30" rows="10" id="editor1"></textarea>
        <button class="btn btn-primary">Submmit</button>
    </form>
<script>
    var details = document.querySelector('.details');
    details.innerHTML = details.innerHTML.replace(/\n/g, '<td>');
</script>
@stop
