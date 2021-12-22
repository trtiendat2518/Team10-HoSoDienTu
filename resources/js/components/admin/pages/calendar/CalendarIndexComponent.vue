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
							<button type="button" class="btn btn-primary btn-3d btn-lg move-today ml-2 fa fa-star" data-action="move-today"> Hôm nay</button>
							<button type="button" class="btn btn-indigo btn-3d btn-lg move-day fa fa-arrow-left" data-action="move-prev"></button>
							<button type="button" class="btn btn-indigo btn-3d btn-lg move-day fa fa-arrow-right" data-action="move-next"></button>
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
					:template="template"
					:useCreationPopup="false"
					:useDetailPopup="false"
					@beforeCreateSchedule="onBeforeCreateSchedule"
					@beforeDeleteSchedule="onBeforeDeleteSchedule"
					@beforeUpdateSchedule="onBeforeUpdateSchedule"
					@clickDayname="onClickDayname"
					@clickSchedule="onClickSchedule"></calendar>
				</div>
			</div><!-- col end -->
		</div>

		<!-- Modal -->
		<div class="modal fade bd-example-modal-lg" id="CalendarModal" tabindex="-1" role="dialog" aria-labelledby="CalendarModalTitle" aria-hidden="true">
			<div class="modal-dialog modal-lg" role="document">
				<form @submit.prevent="editMode?update():store()" @keydown="form.onKeydown($event)">
					<span class="alert-danger" :form="form"></span>
					<div class="modal-content">
						<div class="modal-header styling-modal-header-update">
							<h5 class="modal-title" id="CalendarModalTitle">{{ editMode ? "Cập nhật" : "Thêm mới" }} Lịch biểu</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Tiêu đề <span class="text-danger">(*)</span></label>
								<input v-model="form.title" type="text" name="title" class="form-control" placeholder="Nhập tiêu đề" :class="{'is-invalid': form.errors.has('title')}">
								<div class="text-danger" v-if="form.errors.has('title')" v-html="form.errors.get('title')"></div>
							</div>

							<div class="form-group">
								<label class="mt-3">Nội dung <span class="text-danger">(*)</span></label>
								<input v-model="form.body" type="text" name="body" class="form-control" placeholder="Nhập nội dung" :class="{'is-invalid': form.errors.has('body')}">
								<div class="text-danger" v-if="form.errors.has('body')" v-html="form.errors.get('body')"></div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="mt-3">Thời gian bắt đầu <span class="text-danger">(*)</span></label>
										<input v-model="form.start" type="datetime-local" name="start" class="form-control" :class="{'is-invalid': form.errors.has('start')}">
										<div class="text-danger" v-if="form.errors.has('start')" v-html="form.errors.get('start')"></div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="mt-3">Thời gian kết thúc <span class="text-danger">(*)</span></label>
										<input v-model="form.end" type="datetime-local" name="end" class="form-control" :class="{'is-invalid': form.errors.has('end')}">
										<div class="text-danger" v-if="form.errors.has('end')" v-html="form.errors.get('end')"></div>
									</div>
								</div>
							</div>

							<div class="form-group">
								<label class="mt-3">Loại sự kiện <span class="text-danger">(*)</span></label>
								<select v-model="form.calendarId" name="calendarId" class="form-control select-option" :class="{'is-invalid': form.errors.has('calendarId')}">
									<option value="" selected disabled>Chọn sự kiện</option>
									<option disabled>---------------</option>
									<option value="0">Đăng ký kế hoạch học tập</option>
									<option value="1">Đăng ký môn học</option>
									<option value="2">Thi học kỳ lần 1</option>
									<option value="3">Thi học kỳ lần 2</option>
									<option value="4">Đánh giá điểm rèn luyện</option>
								</select>
								<div class="text-danger mb-3" v-if="form.errors.has('calendarId')" v-html="form.errors.get('calendarId')"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn-3d btn btn-secondary" data-dismiss="modal">Đóng</button>
							<button :disabled="form.busy" type="submit" class="btn-3d btn btn-primary background-update">{{ editMode ? "Cập nhật" : "Thêm mới" }}</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Modal end-->
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
				editMode: false,
				form: new Form({
					id:'',
					title:'',
					body:'',
					category: '',
					start: '',
					end: '',
					calendarId: '',
				}),
				timezones: [{
					timezoneName: 'Asia/Ho_Chi_Minh',
					displayLabel: 'UTC+07:00',
					tooltip: 'Viet Nam'
				}],
				month: {
					daynames:['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
					startDayOfWeek: 1
				},
				week: {
					daynames:['Chủ nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'],
					startDayOfWeek: 1,
				},
				template: {
					timegridDisplayPrimayTime(time) {
						if (time.hour < 10) {
							return '0' + time.hour + ':00';
						}else {
							return time.hour + ':00';
						}
					},
					timegridDisplayTime(time) {
						if (time.hour < 10) {
							return '0' + time.hour + ':00';
						}else {
							return time.hour + ':00';
						}
					},
					alldayTitle() {
						return '<span class="tui-full-calendar-left-content">Cả ngày</span>';
					},
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
			create() {
				this.editMode = false;
				this.form.reset();
				this.form.clear();
				$('#CalendarModal').modal('show');
			},
			store(){
				this.form.busy = true;
				this.form.post('../../api/admin/calendar-schedule/lich-bieu')
				.then(res => {
					this.fetchCalendars();
					$('#CalendarModal').modal('hide');
					if(this.form.successful){
						this.form.clear();
						this.form.reset();
						this.$snotify.success('Thêm mới thành công!');
					}else{
						this.$snotify.error('Không thể thêm', 'Lỗi');
					}
				})
				.catch(err => console.log(err));
			},
			onBeforeCreateSchedule(e) {
				this.editMode = false;
				this.form.clear();
				this.form.reset();
				$('#CalendarModal').modal('show');

				var time_start = new Date(e.start._date);
				var time_end = new Date(e.end._date);

				var month_start = time_start.getMonth()+1;
				var date_start = time_start.getDate();
				var hour_start = time_start.getHours();
				var minute_start = time_start.getMinutes();

				var month_end = time_end.getMonth()+1;
				var date_end = time_end.getDate();
				var hour_end = time_end.getHours();
				var minute_end = time_end.getMinutes();

				month_start = month_start<10 ? `0` + month_start : month_start;
				date_start = date_start<10 ? `0` + date_start : date_start;
				hour_start = hour_start<10 ? `0` + hour_start : hour_start;
				minute_start = minute_start<10 ? `0` + minute_start : minute_start;

				month_end = month_end<10 ? `0` + month_end : month_end;
				date_end = date_end<10 ? `0` + date_end : date_end;
				hour_end = hour_end<10 ? `0` + hour_end : hour_end;
				minute_end = minute_end<10 ? `0` + minute_end : minute_end;

				var datetime_start = time_start.getFullYear() + '-' + month_start + '-' + date_start + 'T' + hour_start + ':' + minute_start;
				var datetime_end = time_end.getFullYear() + '-' + month_end + '-' + date_end + 'T' + hour_end + ':' + minute_end;

				this.form.start = datetime_start;
				this.form.end = datetime_end;
				e.guide.clearGuideElement();
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
	.td-styling {
		text-align: center;
	}
	.not-allowed {
		cursor: not-allowed;
	}
	.select-option {
		cursor: pointer;
	}
	.h3-strong {
		color: #1753fc;
	}
	.styling-modal-header-info {
		background-color: darkblue;
		color: white;
	}
	.styling-font-modal-header {
		font-size: 20px;
		font-weight: bold;
	}
	.styling-modal-header-update {
		background-color: darkblue;
		color: white;
	}
	.td-borderight {
		border-right: 2px solid black;
	}
	.td-borderbottom {
		border-bottom: 2px solid black;
	}
	.background-update {
		background-color: darkblue;
		border-color: darkblue;
	}
	.background-update:hover {
		background-color: darkslateblue;
		border-color: darkblue;
	}
	.btn-3d {
		border-bottom: 3px solid #6c757db0;
		border-right: 3px solid #6c757db0;
	}
</style>
