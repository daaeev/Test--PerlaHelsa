<template>
	<form id="price-calculator-form" @submit.prevent="submitForm">
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Маршрут</p>
				<p class="m-0 pl-2 d-flex align-items-center">
					<i class="material-icons text-success">done</i>
				</p>
			</div>

			<div class="col-10 row">
				<div class="col-5">
					<label>Місто-відправник</label>
					<select class="custom-select" name="country_sender" required>
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
					<select class="custom-select" name="country_recipient" required>
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
				<p class="m-0 pl-2 d-flex align-items-center">
					<i class="material-icons text-success">done</i>
				</p>
			</div>

			<div class="col-10 row">
				<div class="col-5">
					<select class="custom-select" name="service_type" required>
						<option>Відділення-відділення</option>
						<option>Двері-двері</option>
						<option>Двері-відділення</option>
						<option>Відділення-двері</option>
					</select>
				</div>
			</div>
		</div>
		<hr/>
		<div class="row pb-4">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Вид відправлення</p>
				<p class="m-0 pl-2 d-flex align-items-center">
					<i class="material-icons text-success">done</i>
				</p>
			</div>

			<div class="col-10 row">
				<div class="col-5">
					<select class="custom-select" name="send_type" v-model="send_type" required>
						<option>Вантажі</option>
						<option>Документи</option>
						<option>Шини та диски</option>
						<option>Паллети</option>
					</select>
				</div>
			</div>
		</div>
		<!-- <div class="row pb-4">
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
		</div>-->

		<div class="row pb-4" id="packages" v-if="send_type === 'Вантажі'">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Місця</p>
			</div>

			<button type="button" class="btn btn-success" @click="addPackage">Додати</button>

			<div class="col-10 row" :class="'package-' + index" v-for="index in packages_count" :key="index">
				<div class="col-1 form-group">
					<label>Кількість</label>
					<input
						type="number"
						class="custom-control px-0 text-center"
						:name="'package[' + index + '][count]'"
						value="1"
						style="width: 60px"
						required
						min="1"
						step="1"
					/>
				</div>
				<div class="col-1 form-group">
					<label>Вартість</label>
					<input
						type="text"
						class="custom-control px-0 text-center"
						:name="'package[' + index + '][price]'"
						style="width: 60px"
						placeholder="грн."
						required
					/>
				</div>
				<div class="col-1 form-group">
					<label>Вага</label>
					<input
						type="text"
						class="custom-control px-0 text-center"
						:name="'package[' + index + '][weight]'"
						style="width: 60px"
						placeholder="кг."
						required
					/>
				</div>
				<div class="col-1 form-group ml-2">
					<label>Довжина</label>
					<input
						type="text"
						class="custom-control px-0 text-center"
						:name="'package[' + index + '][length]'"
						style="width: 60px"
						placeholder="см."
						required
					/>
				</div>
				<div class="col-1 form-group">
					<label>Ширина</label>
					<input
						type="text"
						class="custom-control px-0 text-center"
						:name="'package[' + index + '][width]'"
						style="width: 60px"
						placeholder="см."
						required
					/>
				</div>
				<div class="col-1 form-group">
					<label>Висота</label>
					<input
						type="text"
						class="custom-control px-0 text-center"
						:name="'package[' + index + '][height]'"
						style="width: 60px"
						placeholder="см."
						required
					/>
				</div>
				<div class="col-1 form-group ml-3">
					<label>Видалити</label>
					<i class="material-icons" @click="removePackage(index)" style="cursor: pointer">clear</i>
				</div>
			</div>
		</div>

		<div class="row pb-4" id="pallets" v-if="send_type === 'Паллети'">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Місця</p>
			</div>

			<button type="button" class="btn btn-success" @click="addPallet">Додати</button>

			<div class="col-10 row" :class="'pallet-' + index" v-for="index in pallets_count" :key="index">
				<div class="col-5 form-group">
					<label>Тип палети</label>
					<select class="custom-select" :name="'pallet[' + index + '][type]'" required>
						<option value="0-0,49">Паллета до 0,49 м2</option>
						<option value="0,5-0,99">Паллета от 0,5 м2 до 0,99 м2</option>
						<option value="1-1,49">Паллета от 1 м2 до 1,49 м2</option>
						<option value="1,5-2">Паллета от 1,5 м2 до 2 м2</option>
					</select>
				</div>
				<div class="col-1 form-group">
					<label>Вартість</label>
					<input
						type="text"
						class="custom-control px-0 text-center"
						:name="'pallet[' + index + '][price]'"
						style="width: 60px"
						placeholder="грн."
						required
					/>
				</div>
				<div class="col-1 form-group">
					<label>Кількість</label>
					<input
						type="number"
						class="custom-control px-0 text-center"
						:name="'pallet[' + index + '][count]'"
						value="1"
						style="width: 60px"
						placeholder="од."
						min="1"
						step="1"
						required
					/>
				</div>
				<div class="col-1 form-group ml-3">
					<label>Видалити</label>
					<i class="material-icons" @click="removePallet(index)" style="cursor: pointer">clear</i>
				</div>
			</div>
		</div>

		<div class="row pb-4" id="tires-disks" v-if="send_type === 'Шини та диски'">
			<div class="col-2 d-flex">
				<p class="col-form-label d-flex align-items-center">Місця</p>
			</div>

			<button type="button" class="btn btn-success" @click="addTire">Додати шину</button>
			<button type="button" class="btn btn-success" @click="addDisk">Додати диск</button>

			<div class="col-10 row" :class="'tire-' + index" v-for="index in tires_count" :key="index">
				<div class="col-1 form-group">
					<p>Шина</p>
				</div>
				<div class="col-3 form-group">
					<label>Тип</label>
					<select class="custom-select" :name="'tire[' + index + '][type]'" required>
						<option value="r 13-14">Легкові R 13-14</option>
						<option value="r 15-17">Легкові R 15-17</option>
						<option value="r 18-23">Легкові R 18-23</option>
						<option value="R 17,5-19,5">Вантажні R 17,5-19,5</option>
						<option value="R 20">Вантажні R 20</option>
						<option value="R 21-22,5">Вантажні R 21-22,5</option>
					</select>
				</div>
				<div class="col-1 form-group">
					<label>Кількість</label>
					<input
						type="number"
						class="custom-control px-0 text-center"
						:name="'tire[' + index + '][count]'"
						value="1"
						style="width: 60px"
						placeholder="од."
						min="1"
						step="1"
						required
					/>
				</div>
				<div class="col-1 form-group ml-3">
					<label>Видалити</label>
					<i class="material-icons" @click="removeTire(index)" style="cursor: pointer">clear</i>
				</div>
			</div>

			<div class="col-10 row" :class="'disk-' + index" v-for="index in disks_count" :key="index">
				<div class="col-1 form-group">
					<p>Диск</p>
				</div>
				<div class="col-3 form-group">
					<label>Тип</label>
					<select class="custom-select" :name="'disk[' + index + '][type]'" required>
						<option value="r 13-14">Легкові R 13-14</option>
						<option value="r 15-17">Легкові R 15-17</option>
						<option value="r 18-23">Легкові R 18-23</option>
						<option value="R 17,5-19,5">Вантажні R 17,5-19,5</option>
						<option value="R 20">Вантажні R 20</option>
						<option value="R 21-22,5">Вантажні R 21-22,5</option>
					</select>
				</div>
				<div class="col-1 form-group">
					<label>Кількість</label>
					<input
						type="number"
						class="custom-control px-0 text-center"
						:name="'disk[' + index + '][count]'"
						value="1"
						style="width: 60px"
						placeholder="од."
						min="1"
						step="1"
						required
					/>
				</div>
				<div class="col-1 form-group ml-3">
					<label>Видалити</label>
					<i class="material-icons" @click="removeDisk(index)" style="cursor: pointer">clear</i>
				</div>
			</div>
		</div>

		<button type="submit" class="btn btn-primary font-weight-bold">Розрахувати ціну</button>

		<p class="alert alert-danger" v-if="req_failed">{{ req_failed }}</p>

		<h3>Ціна за відправку: <b>{{ result_price }} грн.</b></h3>
	</form>
</template>

<script>
import axios from "../../axios/api";

export default {
	name: "CalculatorForm",

	data() {
		return {
			send_type: "Вантажі",

			packages_count: 1,
			pallets_count: 1,
			tires_count: 0,
			disks_count: 0,

			req_failed: '',

			result_price: 0,
		};
	},

	methods: {
		submitForm() {
			const formData = new FormData(
				document.querySelector("#price-calculator-form")
			);

			axios
				.post("/calculator/price", formData)
				.then((res) => {
					this.req_failed = '';
					this.result_price = res?.data?.price ?? 0;
				})
				.catch((err) => {
					this.result_price = 0;
					this.req_failed = err?.response?.data?.error ?? 'Щось пішло не так';
				});
		},

		/**
		 * Добавить посылку
		 */
		addPackage() {
			this.packages_count++;
		},

		/**
		 * Добавить палет
		 */
		addPallet() {
			this.pallets_count++;
		},

		/**
		 * Добавить шину
		 */
		addTire() {
			this.tires_count++;
		},

		/**
		 * Добавить диск
		 */
		addDisk() {
			this.disks_count++;
		},

		/**
		 * Удалить посылку
		 */
		removePackage(id) {
			document
				.querySelector(
					"#price-calculator-form #packages .package-" + id
				)
				.remove();
		},

		/**
		 * Удалить палет
		 */
		removePallet(id) {
			document
				.querySelector("#price-calculator-form #pallets .pallet-" + id)
				.remove();
		},

		/**
		 * Удалить шину
		 */
		removeTire(id) {
			document
				.querySelector(
					"#price-calculator-form #tires-disks .tire-" + id
				)
				.remove();
		},

		/**
		 * Удалить диск
		 */
		removeDisk(id) {
			document
				.querySelector(
					"#price-calculator-form #tires-disks .disk-" + id
				)
				.remove();
		},
	},
};
</script>
