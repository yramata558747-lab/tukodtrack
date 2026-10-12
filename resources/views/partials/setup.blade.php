@if(auth()->user()->isOwner() && \App\Models\Product::count() === 0)
<section class="card setup">
  <div>
    <div class="eyebrow">LET'S SET UP YOUR STORE</div>
    <h3>Start with your product catalog</h3>
    <p class="sub" style="margin:0">Add your own products, or load 8 sample products to try the workflows.</p>
  </div>
  <div class="row">
    <form method="POST" action="{{ route('sample.load') }}">@csrf<button class="btn ghost">Load sample data</button></form>
    <a class="btn" href="{{ route('products.index', ['add' => 1]) }}"><x-icon name="plus" :size="16" /> Add first product</a>
  </div>
</section>
@endif
