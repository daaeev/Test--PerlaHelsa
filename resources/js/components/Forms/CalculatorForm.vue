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
					<select class="custom-select" name="contry_sender">
						<option value="Вінниця">Вінниця</option>
						<option value="Дніпро">Дніпро</option>
						<option value="Запоріжжя">Запоріжжя</option>
						<option value="Київ">Київ</option>
						<option value="Кривий Ріг">Кривий Ріг</option>
						<option value="Миколаїв">Миколаїв</option>
						<option value="Львів">Львів</option>
						<option value="Одеса">Одеса</option>
						<option value="Полтава">Полтава</option>
						<option value="Харків">Харків</option>
					</select>
				</div>
				<div class="col-5">
					<label>Місто-одержувач</label>
					<select class="custom-select" name="country_recipient">
						<option value="Вінниця">Вінниця</option>
						<option value="Дніпро">Дніпро</option>
						<option value="Запоріжжя">Запоріжжя</option>
						<option value="Київ">Київ</option>
						<option value="Кривий Ріг">Кривий Ріг</option>
						<option value="Миколаїв">Миколаїв</option>
						<option value="Львів">Львів</option>
						<option value="Одеса">Одеса</option>
						<option value="Полтава">Полтава</option>
						<option value="Харків">Харків</option>
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
					<select class="custom-select" name="service_type">
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
					<select class="custom-select" name="send_type">
						<option>Вантажі</option>
						<option>Документи</option>
						<option>Шини та диски</option>
						<option>Палети</option>
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
					<input type="text" class="custom-control px-0 text-center" name="actual_weight" value="1" style="width: 60px">
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
