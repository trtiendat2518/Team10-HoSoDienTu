import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Post from './components/admin/pages/posts/PostComponent.vue';
import PostIndex from './components/admin/pages/posts/PostIndexComponent.vue';
import PostCreate from './components/admin/pages/posts/PostCreateComponent.vue';
import PostUpdate from './components/admin/pages/posts/PostUpdateComponent.vue';
import Error404 from './components/pagination/ErrorComponent.vue';

export default new VueRouter({
	routes: [
		{
			path: '/',
			name: 'post',
			component: Post,
			children: [
				{
					path: '',
					name: 'postindex',
					component: PostIndex
				},

				{
					path: 'tao-moi',
					name: 'postcreate',
					component: PostCreate
				},

				{
					path: 'cap-nhat/:idPost',
					name: 'postupdate',
					component: PostUpdate
				}
			]
		},

		{ 	path: '/404', 
			name: 'error404', 
			component: Error404 
		},
		
		{	
			path: '*',
			redirect: { name: 'error404' }
		},
	],
	//mode:'history'
})