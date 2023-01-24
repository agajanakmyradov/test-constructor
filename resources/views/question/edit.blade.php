<x-layout>
	@slot('title')
		Вопросы и ответы
	@endslot
	<div class="container">
		@if(session()->get('success'))
			<div class="alert alert-success alert-dismissible fade show">
			  {{ session()->get('success') }}  
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@endif
	
		<form action="{{ route('question.update', ['question' => $question->id]) }}" method="POST" enctype="multipart/form-data" id="testStore">
			@csrf			
			
			<div class="d-flex flex-column justify-content-center text-center p-2">
				<label for="" class="form-label">Картинка вопроса</label>
				<div class="questions_0_image" style="color: red"></div>
				
				<div class="text-center">
					<img @if($question->img_path) src="{{ asset('/storage/' . $question->img_path) }}" @endif  id="questions[0][image]" class="output">
				</div>
				
				<div class="form__input-file mt-2">
				    <input class="visually-hidden" type="file" name="questions[0][image]" id="questFile0" onchange="loadFile(event, this)">
				    <label for="questFile0">						       
				        <span class="btn border-primary">Изменить</span>
				    </label>
				</div>
			</div>


			<div class="question-inputs px-3 ">
				<div class="mb-3 ">
				    <label for="text" class="form-label">Вопрос</label>
				    <div class="questions_0_text" style="color: red"></div>
				    <input type="text" class="form-control" name="questions[0][text]" value="{{ $question->text }}">
				</div>

				<div class="text-center">
					<span style="font-weight: bold;">Ответы</span>
				</div>

				<input type="hidden" class="answerCount" value="{{ count($question->answers) }}">
				<input type="hidden" class="questCount" value="0">


				<table class="variants">
					<tr>
						<td>Верный</td>
						<td><div class="questions_0_correct" style="color: red;"></div></td>
					</tr>

					@foreach($question->answers as $answer)
						<tr>
							<td></td>
							<td>
								<div class="questions_0_answer_{{ $loop->iteration - 1 }}" style="color: red;"></div>
							</td>
						</tr>
						<tr class="answerVariant" id="mainRow">
							<td>
								<input type="checkbox" class="form-check-input" name="questions[0][correct][{{ $loop->iteration - 1 }}]" value="0" @if($answer->correct_answer) checked @endif>
							</td>
							<td>
								<input type="text" class="form-control" name="questions[0][answer][{{ $loop->iteration - 1 }}]" value="{{ $answer->text }}">
							</td>
							<td>
								<a href="{{ route('answer.destroy', ['answer' => $answer->id]) }}" class="btn border-danger"  style=" color: red;" >x</a>
							</td>			
						</tr>
					@endforeach
					<tr>
						<td></td>
						<td class="text-center"><a href="{{ route('answer.create', ['question' => $question->id]) }}" class="btn border-primary my-2">Добавить ответ</a></td>
					</tr>
												
					
				</table>
			</div>
			<div class="text-center">
				<input type="submit" value="Сохранить" name="next" class="btn border-success my-4">
			</div>		

		</form>	
		
	</div>
</x-layout>