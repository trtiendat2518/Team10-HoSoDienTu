import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Post from './components/admin/pages/posts/PostComponent.vue';
import PostIndex from './components/admin/pages/posts/PostIndexComponent.vue';
import PostCreate from './components/admin/pages/posts/PostCreateComponent.vue';

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
				}
			]
		}
	],
	//mode:'history'
})