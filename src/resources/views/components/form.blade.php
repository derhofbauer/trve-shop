<form class="form" action="@if($action){{ $action }}@endif" method="post" role="form" id="module-form" enctype="multipart/form-data">
    {{ csrf_field() }}

    <div class="form__header">
        <h2>{{ $header }}</h2>
    </div>
    <div class="form__body">{{ $body }}</div>
</form>