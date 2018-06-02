<form action="{{ route('products.comment.add', ['id' => $object->id]) }}" method="post">
    @csrf

    <textarea name="comment" id="comment" class="form-control comment__form" placeholder="{{ __('Please give feedback') }}"></textarea>
    <select name="rating" id="rating" class="form-control comment__rating col-sm-3">
        <option value="0">{{ __('Please rate ...') }}</option>
        <option value="1">{{ __('Very good') }}</option>
        <option value="2">{{ __('Good') }}</option>
        <option value="3">{{ __('OK') }}</option>
        <option value="4">{{ __('Bad') }}</option>
        <option value="5">{{ __('Very bad') }}</option>
    </select>
    <div>
        <input type="submit" name="do-comment" value="{{ __('Comment') }}" class="btn btn-primary col-sm-3">
    </div>
</form>