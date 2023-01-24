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
	
		<form action="{{ route('question.store', ['test' => $test->id]) }}" method="POST" enctype="multipart/form-data" id="testStore">
			@csrf			
			
			<div class=" d-flex flex-column justify-content-center text-center p-2">
				<label for="" class="form-label">Картинка вопроса</label>
				<div class="questions_0_image" style="color: red"></div>
				
				<div class="text-center">
					<img  id="questions[0][image]" class="output">
				</div>
				
				<div class="form__input-file mt-2">
				    <input class="visually-hidden" type="file" name="questions[0][image]" id="questFile0" onchange="loadFile(event, this)">
				    <label for="questFile0">						       
				        <span class="btn border-primary">Добавить</span>
				    </label>
				</div>
			</div>


			<div class="question-inputs w-100 px-3"  style="max-width: 800px;">		
				<div class="mb-3">
				    <label for="title" class="form-label">Вопрос</label>
				    <div class="questions_0_text" style="color: red"></div>
				    <input type="text" class="form-control" name="questions[0][text]" >
				</div>

				<input type="hidden" class="answerCount" value="1">
				<input type="hidden" class="questCount" value="0">

				<table class="variants">
					<tr>
						<td>Верный</td>
						<td><div class="questions_0_correct" style="color: red;"></div></td>
					</tr>
					<tr>
						<td></td>
						<td>
							<div class="questions_0_answer_0" style="color: red;"></div>
						</td>
					</tr>
												
					<tr class="answerVariant" id="mainRow">
						<td><input type="checkbox" class="form-check-input" name="questions[0][correct][0]" value="0" checked></td>
						<td>
							<input type="text" class="form-control" name="questions[0][answer][0]">
						</td>
						<td><div class="btn border-success mx-2" id="addAnswerBtn0" onclick="addAnswer(this)" style="color:green">+</div></td>
						<td><div class="btn border-danger" id="removeAnswerBtn0" style="display: none; color: red;" onclick="removeAnswer(this)">x</div></td>	
					</tr>
				</table>
			</div>
			<div class="text-center">
				<input type="submit" value="Сохранить" name="next" class="btn border-success my-4">
			</div>		

		</form>	
		
	</div>
</x-layout>