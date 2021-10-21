<template>
	<div>
		<div class="row">
			<div class="col-md-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Danh sách giảng viên</h3>
					</div>

					<div class="row">
						<div class="col-md-2">
							<div class="between:flex bottom:margin-3 ml-2">
								<div class="center:flex-items">
									<span class="right:marign-1">Hiển thị</span>
									<select class="select form-control-styling" v-model="currentEntries">
										<option v-for="entry in showEntries" :key="entry" :value="entry">{{ entry }}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<input type="text" class="form-control mt-2" v-model="query" placeholder="Tìm kiếm...">
						</div>
						<div class="col-md-2">
							<button class="btn btn-danger mt-2 ml-3"><i class="fa fa-trash"></i> Xóa</button>
						</div>
					</div>
					

					<div class="table-responsive">
						<table class="table card-table table-vcenter text-nowrap table-nowrap">
							<thead  class="blue-background text-white">
								<tr >
									<th class="w-5"></th>
									<th class="text-white w-30">Họ tên</th>
									<th class="text-white w-30">Địa chỉ Email</th>
									<th class="text-white w-30">Vai trò</th>
									<th class="w-5"></th>
									<th class="w-5"></th>
								</tr>
							</thead>
							<tbody>
								<tr v-show="lecturers.length" v-for="lecturer in lecturers" :key="lecturer.lecturer_id">
									<td>
										<center><input type="checkbox" name="" id=""></center>
									</td>
									<td><a href="#">{{ lecturer.lecturer_fullname }}</a></td>
									<td>{{ lecturer.lecturer_email }}</td>
									<td>
										<div v-if="lecturer.lecturer_role==2">
											<p>Chủ nhiệm sinh viên</p>
										</div>
										<div v-else-if="lecturer.lecturer_role==1">
											<p>Ban chủ nhiệm khoa</p>
										</div>
										<div v-else>
											<p>Giảng viên mới</p>
										</div>
									</td>
									<td style="text-align: center">
										<a href="" class="active styling-edit" ui-toggle-class="">
											<i class="fa fa-pencil-square-o text-success text-active"></i>
										</a>
									</td>
									<td>
										<a href="" class="active styling-delete" ui-toggle-class="" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')">
											<i class="fa fa-trash text-danger text"></i>
										</a>
									</td>
								</tr>
								<tr v-show="!lecturers.length">
									<td colspan="8">
										<div class="alert alert-danger">
											Không tìm thấy kết quả phù hợp!
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="query === '' ? fetchLecturers() : searchLecturers() "></pagination>
					</div>
					<!-- table-responsive -->
				</div>
			</div><!-- col end -->
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				lecturers:[],
				lecturer_id:'',
				pagination:{
					current_page: 1,
				},
				currentEntries: 5,
				showEntries: [5, 10, 25, 50],
				query: '',
			};
		},
		watch: {
			currentEntries(number) {
				if(number===5) {
					this.fetchLecturers();
				}else{
					this.fetchLecturers();
				}
			},
			query: function(keyword){
				if(keyword === ''){
					this.fetchLecturers();
				}else{
					this.searchLecturers();
				}
			}
		},
		mounted() {
			this.fetchLecturers();
		},
		methods: {
			fetchLecturers(page_url) {
				let vm = this;
				page_url = 'giang-vien/list/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
			searchLecturers(page_url){
				let vm = this;
				page_url = 'giang-vien/search/'+this.query+'/'+this.currentEntries+'?page='+this.pagination.current_page;
				fetch(page_url)
				.then(res => res.json())
				.then(res => {
					this.lecturers = res.data;
					this.pagination = res.meta;
				})
				.catch(err => console.log(err));
			},
		}
	};
</script>

<style scoped>
</style>
