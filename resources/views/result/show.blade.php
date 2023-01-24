<x-layout>	
	@slot('title')
		Результат
	@endslot
	<div class="container">	
		<div class="text-center">
			<h2>{{ $test->title }}</h2>			
			<div class="p-4">
				<p class="fw-bold">{{ $test->description }}</p>
			</div>
		</div>
	

		@foreach($test->questions as $question)
			<div class="text-center">
				@if($question->img_path)
					<img src="{{ asset('/storage/' . $question->img_path) }}" class="question-image">
					
				@endif
				<h5 >{{ $question->text }}</h5>
			</div>

			<div class="question">
				<ol >
					@if(count($question->answers) == 1)
						<li style="color: green;">{{ $question->answers[0]->text }}</li>
						@if($question->answers[0]->text != $input[$question->id][$question->answers[0]->id])
							<li class="text-decoration-line-through" style="color: red;">{{ $input[$question->id][$question->answers[0]->id] }}</li>				
						@endif
					@else
						@foreach($question->answers as $answer)
							@if($answer->correct_answer)
								<li style="color: green;">{{ $answer->text }}</li>
							@elseif(isset($input[$question->id][$answer->id]) &&$input[$question->id][$answer->id] == $answer->id)
								<li class="text-decoration-line-through" style="color: red; ">{{ $answer->text }}</li>
							@else
								<li>{{ $answer->text }}</li>
							@endif
						@endforeach
					@endif
					
				</ol>
			</div>
			<hr>
		@endforeach
		<div><p class="fst-italic">Правильных ответов {{ $count }}</p></div>
	</div>



</x-layout>