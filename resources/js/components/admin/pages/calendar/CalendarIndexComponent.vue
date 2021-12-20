<template>
	<div>
		<vue-snotify></vue-snotify>
		<div class="page-header">
			<ol class="breadcrumb"><!-- breadcrumb -->
				<li class="breadcrumb-item">
					<router-link tag="a" :to="{ name: 'dashboard' }">Dashboard</router-link>
				</li>
				<li class="breadcrumb-item active" aria-current="page">Lịch biểu</li>
			</ol><!-- End breadcrumb -->
		</div>
		<div class="form-group">
			<button class="btn btn-info btn-lg mb-3 btn-3d" @click="create()"><li class="fa fa-plus"></li> Tạo mới</button>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h2 class="card-title"><strong>Lịch biểu</strong></h2>
					</div>

					<span @click="onClickNavi($event)">
						<div class="ml-2 mr-2">
							<select v-model="selectedView" class="form-control-styling">
								<option value="" disabled selected>Lựa chọn hiển thị</option>
								<option value="day">Ngày</option>
								<option value="week">Tuần</option>
								<option value="month">Tháng</option>
							</select>
							<button type="button" class="btn btn-primary btn-lg move-today ml-2 fa fa-star" data-action="move-today"> Hôm nay</button>
							<button type="button" class="btn btn-indigo btn-lg move-day fa fa-arrow-left" data-action="move-prev"></button>
							<button type="button" class="btn btn-indigo btn-lg move-day fa fa-arrow-right" data-action="move-next"></button>
							<span class="render-range font-styling">{{dateRange}}</span>
						</div>
					</span>

					<calendar
					ref="tuiCal" 
					:taskView="false"
					:schedules="calendars"
					:timezones="timezones"
					:view="selectedView"
					:month="month"
					:week="week"
					:useCreationPopup="false"
					:useDetailPopup="false"
					@afterRenderSchedule="onAfterRenderSchedule"
					@beforeCreateSchedule="onBeforeCreateSchedule"
					@beforeDeleteSchedule="onBeforeDeleteSchedule"
					@beforeUpdateSchedule="onBeforeUpdateSchedule"
					@clickDayname="onClickDayname"
					@clickSchedule="onClickSchedule"></calendar>
				</div>
			</div><!-- col end -->
		</div>
	</div>
</template>

<script>
	import 'tui-calendar/dist/tui-calendar.css'
	import { Calendar } from '@toast-ui/vue-calendar'
	import 'tui-date-picker/dist/tui-date-picker.css'
	import 'tui-time-picker/dist/tui-time-picker.css'

	const today = new Date();

	const getDate = (type, start, value, operator) => {
		start = new Date(start);
		type = type.charAt(0).toUpperCase() + type.slice(1);

		if (operator === '+') {
			start[`set${type}`](start[`get${type}`]() + value);
		} else {
			start[`set${type}`](start[`get${type}`]() - value);
		}

		return start;
	};

	export default {
		components: {
			'calendar': Calendar
		},
		data() {
			return {
				selectedView:'month',
				dateRange: '',
				calendars:[],
				timezones: [{
					displayLabel: 'GMT+07:00',
					tooltip: 'Vietnam'
				}],
				month: {
					daynames:['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
					startDayOfWeek: 1
				},
				week: {
					daynames:['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
					startDayOfWeek: 1
				},
			}
		},
		mounted() {
			this.fetchCalendars();
			this.init();
		},
		watch: {
			selectedView(newValue) {
				this.$refs.tuiCal.invoke('changeView', newValue, true);
				this.setRenderRangeText();
			},
		},
		methods: {
			fetchCalendars(page_url) {
				let vm = this;
				page_url = `../../api/admin/calendar-schedule/lich-bieu`;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.calendars = res.data;
				})
				.catch(err => console.log(err));
			},
			init() {
				this.setRenderRangeText();
			},
			setRenderRangeText() {
				const {invoke} = this.$refs.tuiCal;
				const view = invoke('getViewName');
				const calDate = invoke('getDate');
				const rangeStart = invoke('getDateRangeStart');
				const rangeEnd = invoke('getDateRangeEnd');
				let year = calDate.getFullYear();
				let month = calDate.getMonth() + 1;
				let date = calDate.getDate();
				let dateRangeText = '';
				let endYear, endMonth, endDate, start, end;

				switch (view) {
					case 'month':
					dateRangeText = `${month}/${year}`;
					break;
					case 'week':
					year = rangeStart.getFullYear();
					month = rangeStart.getMonth() + 1;
					date = rangeStart.getDate();
					endMonth = rangeEnd.getMonth() + 1;
					endDate = rangeEnd.getDate();
					endYear = rangeEnd.getFullYear();

					start = `${date}/${month}/${year}`;
					end = `${endDate}/${endMonth}/${endYear}`;
					dateRangeText = `${start} ~ ${end}`;
					break;
					default:
					dateRangeText = `${date}/${month}/${year}`;
				}
				this.dateRange = dateRangeText;
			},
			onClickNavi(event) {
				if (event.target.tagName === 'BUTTON') {
					const {target} = event;
					let action = target.dataset ? target.dataset.action : target.getAttribute('data-action');
					action = action.replace('move-', '');

					this.$refs.tuiCal.invoke(action);
					this.setRenderRangeText();
				}
			},
			onAfterRenderSchedule(e) {
				//console.log(e);
			},
			onBeforeCreateSchedule(e) {
				//console.log('open modal');
			},
			onBeforeDeleteSchedule(e) {
				//console.log('delete modal');
			},
			onBeforeUpdateSchedule(e) {
				//console.log('update modal');
			},
			onClickDayname(e) {
				//console.log('view date in weekly');
			},
			onClickSchedule(e) {
				//console.log('view detail schedule');
				//console.log(e);
			},
		}
	};
</script>

<style lang="css" scoped>
	.font-styling {
		font-size: 30px;
		font-weight: bold;
		color: darkblue;
		vertical-align: middle;
		margin-left: 20px;
	}
</style>
