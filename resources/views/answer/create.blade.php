<x-layout>
	@slot('title')
		Вопросы и ответы
	@endslot
	<div class="container">
		<form action="{{ route('answer.store') }}" method="POST">
			@csrf

			<input type="hidden" name="question_id" value="{{ $question->id }}">
			<div class="d-flex justify-content-center">
				<div class="align-self-center">
					<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
			    <label class="form-check-label" for="flexCheckDefault">
			       Верный
			    </label>
				</div>
				<input type="text" class="form-control align-self-center mx-2" name="text"  style="max-width: 200px;">
				<input type="submit" value="Сохранить" class="btn border-success my-3">
			</div>
			<div class="text-center" style="color: red">@error('text') {{ $message }} @enderror</div>
			
		</form>
	</div>
</x-layout>