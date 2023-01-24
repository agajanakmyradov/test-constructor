<x-layout>
	@slot('title')
		Редактирование теста
	@endslot
	<div class="container">
		
			<form action="{{ route('test.update', ['test' => $test->id]) }}" method="POST" enctype="multipart/form-data" id="testStore">
				@csrf

                <div class="test d-flex justify-content-center  flex-wrap ">
					<div class="d-flex flex-column justify-content-center text-center p-2">
							<label for="" class="form-label">Главная картинка</label>
						<div class="testImage_error" style="color: red"></div>
						
						<img src="{{ asset('/storage/' . $test->img_path) }}"  id="testImage" class="output">
						
						<div class="form__input-file text-center mt-2">
						    <input class="visually-hidden input" type="file" name="testImage" id="testFile" onchange="loadFile(event, this)">
						    <label for="testFile">						       
						        <span class="btn border-primary">Изменить</span>
						    </label>
						</div>
					</div>


					<div class="w-100 px-3"  style="max-width: 800px;">		
						<div class="mb-3">
						    <label for="title" class="form-label">Название</label>
						    <div class="title_error" style="color: red"></div>
						    <div style=" color:red; ">@error('title') {{ $message }} @enderror</div>
						    <input type="text" class="form-control" name="title" value="{{ $test->title }}">
						</div>

						<div class="form-check form-switch">
						  <input class="form-check-input" type="checkbox" name="private" value="true" @if($test->private) checked @endif>
						  <label class="form-check-label" for="private">Приватный тест</label>
						</div>

						<div class="mb-3 ">
						    <label for="description" class="form-label">Краткое описание</label>
						    <div class="description_error" style="color: red"></div>
						    <textarea name="description" class="form-control" id="" cols="30" rows="8">{{ $test->description }}</textarea>
						</div>
					</div>
				</div>

				<input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
				
				<div class="text-center">
					<input type="submit" value="Сохранить" class="btn border-success">
				</div>

			</form>
					
	</div>
</x-layout>