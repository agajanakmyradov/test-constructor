<x-layout>
	@slot('title')
		Тест
	@endslot
	<div class="container">
		@if (session('success'))
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
			  {{ session('success') }}
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		 @endif	

		 @foreach($errors->all() as $error)
			 {{ $error }}
		 @endforeach	

		<div class="text-center">
			<h2>{{ $test->title }}</h2>			
			<img src="{{ asset('/storage/' . $test->img_path) }}" alt="" class="question-image">
			<div class="p-4">
				<p class="fw-bold">{{ $test->description }}</p>
			</div>
			<hr>
		</div>

		<form action="{{ route('result.show', ['test'=> $test->id]) }}" method="POST">
			@csrf

			@foreach($test->questions as $question)
					
				<div class="text-center">
					@if($question->img_path !== null)
						<img src="{{ asset('/storage/' . $question->img_path) }}" alt="" class="question-image">
					@endif
					<h5 class="my-2">{{ $question->text }}</h5>
				</div>

			<div class="question">
				<ol class="m-2">
					@foreach($question->answers as $answer)
						@if($answer->correct_answer)
							<li style="color: green;">
								{{ $answer->text }}
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16">
								  <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
								</svg>
							</li>
						@else
							<li>{{ $answer->text }}</li>
						@endif
					@endforeach
				</ol>
			</div>
					
				<div class="text-center pt-2">
					<a href="{{ route('question.destroy', ['question' => $question->id]) }}" class="btn border-danger">Удалить вопрос</a>
					<a href="{{ route('question.edit', ['question' => $question->id]) }}" class="btn border-primary">Редактировать вопрос</a>
				</div>
				<hr>
				
			@endforeach

			<div class="text-center">
				<a href="{{ route('test.destroy', ['test' => $test->id]) }}" class="btn border-danger">Удалить тест</a>
				<a href="{{ route('test.edit', ['test' => $test->id]) }}" class="btn border-primary">Редактировать тест</a>
				<a href="{{ route('question.create', ['test' => $test->id]) }}" class="btn border-success">Добавить вопрос</a>
			</div>
			
		</form>
	</div>
</x-layout> 