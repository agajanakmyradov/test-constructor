<x-layout>
	@slot('title')
		Главная страница
	@endslot
	<div class="container">
		@if(session()->get('success'))
			<div class="alert alert-success alert-dismissible fade show">
			  {{ session()->get('success') }}  
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif
  
		<div class="d-flex flex-wrap justify-content-center ">
			@foreach($tests as $test)
				@if(!$test->private)
					<div class="test-show text-center border p-2 m-2 align-self-start">
						<img src="{{ asset('/storage/' . $test->img_path) }}" alt="sd" style="width: 300px; height: 200px;">
						<div class="description">						
							<h5>{{ $test->title }}</h5>
							<p class="fw-bold">{{ $test->description }}</p>

							
							<a href="{{ route('test.show', ['test' => $test->id]) }}" class="btn border-primary">
							    Пройти тест
							</a>
							
						</div>
					</div>
				@endif
			@endforeach
		</div>
		<div class="pagination">
			<div class="text-end">{{ $tests->links() }}</div>
		</div>
	</div>
</x-layout> 