<x-layout>
	@slot('title')
		Добавить тест
	@endslot
	<div class="container">
		@if (session('success'))
		    <div class="alert alert-success alert-dismissible fade show" role="alert">
			  {{ session('success') }}
			  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		 @endif

		<div class="text-center pt-3">
			<h4>Добавление теста</h4>
		</div>
			<form action="{{ route('test.store') }}" id="testStore" method="POST" enctype="multipart/form-data" >
				@csrf
				
				<div class="test d-flex justify-content-center border rounded flex-wrap ">
					<div class="d-flex flex-column justify-content-center text-center p-2">
						<label for="" class="form-label">Картинка теста</label>
						<div class="testImage_error" style="color: red"></div>
						
						<img  id="testImage" class="output">
						
						<div class="form__input-file text-center mt-2">
						    <input class="visually-hidden input" type="file" name="testImage" id="testFile" onchange="loadFile(event, this)">
						    <label for="testFile">						       
						        <span class="btn btn-primary">Добавить</span>
						    </label>
						</div>
					</div>


					<div class="w-100 px-3"  style="max-width: 800px;">		
						<div class="mb-3">
						    <label for="title" class="form-label">Название</label>
						    <div class="title_error" style="color: red"></div>
						    <div style=" color:red; ">@error('title') {{ $message }} @enderror</div>
						    <input type="text" class="form-control" name="title">
						</div>

						<div class="form-check form-switch">
						  <input class="form-check-input" type="checkbox" name="private" value="true">
						  <label class="form-check-label" for="private">Приватный тест</label>
						</div>

						<div class="mb-3 ">
						    <label for="description" class="form-label">Краткое описание</label>
						    <div class="description_error" style="color: red"></div>
						    <textarea name="description" class="form-control" id="" cols="30" rows="8"></textarea>
						</div>
					</div>
				</div>

				<h3 class="mt-2">Вопросы и варианты ответов</h3>


				<div class="questionsAndAnswers p-4 border rounded" id="questions">
					<div class="questions d-flex justify-content-center flex-wrap">
						
						<div class="d-flex flex-column justify-content-center text-center p-2">
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
							    <input type="text" class="form-control" name="questions[0][text]" value="{{ old('title') }}">
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
					</div>
					
					<div class="btn " id="createQuest" onclick="createQuestion(this)">Следуюший вопрос</div>
					<div class="btn" id="removeQuest" onclick="removeQuestion(this)" style="display: none;">Отмена</div>
					
				</div>	

				<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">			
				
				<input type="submit"  value="Сохранить" class="form-control btn btn-success mt-2">
				

			</form>

	</div>
	 
</x-layout>