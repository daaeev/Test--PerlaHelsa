<template>
	<form>
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Маршрут</p>
				<p class="m-0 pl-2 d-flex align-items-center"><i class="material-icons text-success">done</i></p>
			</div>

			<div class="col-10 row">
				<div class="col-5">
					<label>Місто-відправник</label>
					<select class="custom-select">
						<option>1</option>
					</select>
				</div>
				<div class="col-5">
					<label>Місто-одержувач</label>
					<select class="custom-select">
						<option>1</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Тип послуги</p>
				<p class="m-0 pl-2 d-flex align-items-center"><i class="material-icons text-success">done</i></p>
			</div>

			<div class="col-10 row">
				<div class="col-5">
					<select class="custom-select">
						<option>Відділення-відділення</option>
						<option>Двері-двері</option>
						<option>Двері-відділення</option>
						<option>Відділення-двері</option>
					</select>
				</div>
			</div>
		</div>
		<hr>
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Вид відправлення</p>
				<p class="m-0 pl-2 d-flex align-items-center"><i class="material-icons text-success">done</i></p>
			</div>

			<div class="col-10 row">
				<div class="col-5">
					<select class="custom-select">
						<option>Посилки</option>
						<option>Документи</option>
						<option>Шини та диски</option>
						<option>Пластик</option>
						<option>Скло</option>
						<option>Інше</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Фактична вага (кг.)</p>
				<p class="m-0 pl-2 d-flex align-items-center"><i class="material-icons text-success">done</i></p>
			</div>

			<div class="col-10 row">
				<div class="col-5 form-group">
					<label>Вага</label>
					<input type="text" class="custom-control px-0 text-center" style="width: 60px">
				</div>
			</div>
		</div>
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Габарити (см.)</p>
				<p class="m-0 pl-2 d-flex align-items-center"><i class="material-icons text-success">done</i></p>
			</div>

			<div class="col-10 row">
				<div class="col-1 form-group">
					<label>Довжина</label>
					<input type="text" value="1" class="custom-control px-0 text-center" style="width:60px">
				</div>
				<div class="col-1 form-group ml-2">
					<label>Ширина</label>
					<input type="text" value="1" class="custom-control px-0 text-center" style="width:60px">
				</div>
				<div class="col-1 form-group ml-2">
					<label>Висота</label>
					<input type="text" value="1" class="custom-control px-0 text-center" style="width:60px">
				</div>
			</div>
		</div>
		<button type="submit" class="btn btn-primary font-weight-bold">Розрахувати ціну</button>
	</form>
</template>

<script>
export default {
	name: "CalculatorForm"
}
</script>
