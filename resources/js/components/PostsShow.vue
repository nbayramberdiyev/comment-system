<script setup>
import { reactive, ref } from 'vue'
import CommentItem from '../components/CommentItem'
import client from '../client'

// Assumption: the only blog post that can be commented on is fetched by its slug.
const post = {
    id: 1,
    slug: 'lorem-ipsum-dolor-sit-amet',
    title: 'Lorem ipsum dolor sit amet',
    excerpt: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dolor nisi, interdum id iaculis et, ultricies quis elit. Cras vel eros vitae leo venenatis tempor in eget ex. Proin in hendrerit ipsum, sed dictum velit.',
    body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dolor nisi, interdum id iaculis et, ultricies quis elit. Cras vel eros vitae leo venenatis tempor in eget ex. Proin in hendrerit ipsum, sed dictum velit. Donec pulvinar, metus nec imperdiet fringilla, ipsum tellus vulputate dui, eu egestas elit tortor sit amet felis. Sed libero nisi, efficitur id magna vel, mollis elementum ipsum. Praesent cursus lacinia dapibus. Fusce quis rutrum lorem. Donec ultricies viverra quam, sed mollis arcu viverra vitae. Ut non risus nisl. Aliquam suscipit velit a ultricies hendrerit. Fusce consequat dignissim urna, sed fringilla lectus iaculis sit amet. Pellentesque rutrum massa mauris, at consectetur elit dictum id. Nunc dapibus leo viverra porttitor venenatis. Aliquam facilisis iaculis metus. Nulla pharetra, dolor vel elementum mollis, augue lectus molestie augue, eget maximus ipsum sem et nibh.',
}

// Props
const props = defineProps(['slug'])

// Local state
const newComment = reactive({ author: '', body: '' })
const comments = ref([])

client.get(`/posts/${post.id}/comments`).then(({ data }) => comments.value = data.data)

const createComment = () => {
    if (!newComment.author || !newComment.body) {
        return
    }

    client.post(`/posts/1/comments`, newComment).then(({ data }) => {
        comments.value.unshift(data.data)
        newComment.author = ''
        newComment.body = ''
    })
}
</script>

<template>
    <h1 class="mb-4 text-slate-800 text-2xl text-center font-bold">{{ post.title }}</h1>
    <p class="leading-relaxed">{{ post.body }}</p>
    <p class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-200/5"></p>

    <div class="bg-gray-50 shadow sm:rounded-lg sm:overflow-hidden">
        <div class="divide-y divide-gray-200">
            <div class="px-4 py-5 sm:px-6">
                <h2 class="text-lg font-medium text-slate-800">Comments</h2>
            </div>
            <div class="px-4 py-6 sm:px-6">
                <div class="space-y-6">
                    <CommentItem v-for="comment in comments" :key="comment.id" :comment="comment" />
                </div>
            </div>
        </div>

        <div class="bg-gray-50 px-4 py-6 sm:px-6">
            <div class="flex">
                <div class="flex-shrink-0 mr-4">
                    <img class="h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/3?d=identicon&f=y" alt="avatar">
                </div>
                <div class="min-w-0 flex-1">
                    <input
                        v-model.trim="newComment.author"
                        type="text"
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                        placeholder="Your Name"
                    >
                    <textarea
                        v-model.trim="newComment.body"
                        rows="3"
                        class="mt-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                        placeholder="Your Comment"
                    ></textarea>
                    <div class="mt-3">
                        <button
                            @click.prevent="createComment"
                            type="submit"
                            class="py-2 px-3 border border-transparent rounded-md shadow-sm text-sm font-medium leading-4 text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                            Comment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
