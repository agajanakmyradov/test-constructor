<x-layout>
	@slot('title')
		Тест
	@endslot
	<div class="container">

		<div class="text-center">
			<h2>{{ $test->title }}</h2>			
			<div class="p-4">
				<p class="fw-bold">{{ $test->description }}</p>
			</div>
			<hr>
		</div>

		<form action="{{ route('result.check', ['test'=> $test->id]) }}" method="POST" id="testStore">
			@csrf

			@foreach($test->questions as $question)
			<div class="text-center">
						@if($question->img_path !== null)
							<img src="{{ asset('/storage/' . $question->img_path) }}" alt="" class="question-image">
						@endif
					</div>
				<div class="question my-2 pt-4">
		
					<h5>{{ $question->text }}</h5>

					@if(count($question->answers) == 1)
					    <input type="hidden" name="questions[{{ $question->id }}][control]" value="0">
						<div class="error_message questions_{{ $question->id }}_correct_{{ $question->answers[0]->id }}" style="color:red;"></div>
						<input type="text" name="questions[{{ $question->id }}][correct][{{ $question->answers[0]->id }}]" >
					@else
					    <input type="hidden" name="questions[{{ $question->id }}][control]" value="0">
					    <div class="error_message questions_{{ $question->id }}_correct" style="color: red;"></div>
						@foreach($question->answers as $answer)
							<table>
								<tr>
									<td class="align-top">
										<input type="checkbox" class="form-check-input" name="questions[{{ $question->id }}][correct][{{ $answer->id }}]" value="{{ $answer->id }}">
									</td>
									<td>
										<label class="form-check-label ps-2" for="flexRadioDefault1">
										    {{ $answer->text }}
										 </label>
									</td>
								</tr>
							</table>									 
						@endforeach
					@endif

					
				</div>
				<hr>
				
			@endforeach
			
			<div class="text-center">
				<input type="submit" value="Пoрверить" class="btn border-primary " id="submit">
			</div>
		</form>
	</div>
</x-layout> 