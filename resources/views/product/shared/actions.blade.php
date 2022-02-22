<a class="btn btn-primary btn-sm" style="min-width: 70px" 
     href="{{ route('product.edit', ['product' => $product->id]) }}"
     data-target="#delete-product-form-{{ $product->id }}" 
     title="Edit {{ $product->name }}">
    Edit
</a><br>

<a class="btn btn-danger btn-sm mt-2 btn-delete-product" style="min-width: 70px" 
     data-delete-form="#delete-product-form-{{ $product->id }}" 
     title="Delete {{ $product->name }}">
    Delete
</a>
<form id="delete-product-form-{{ $product->id }}" method="POST" action="{{ route('product.destroy') }}" style="display: none;">
  @csrf
  @method('DELETE')
  <input type="hidden" name="product_id" value="{{ $product->id }}">
</form>

@section('js')
  <script>

    document.querySelectorAll('.btn-delete-product').forEach(item => {
      item.addEventListener('click', event => {
        let deleteForm = document.querySelector(item.dataset.deleteForm)
        deleteForm.submit();
      })
    })
    
  </script>
@endsection