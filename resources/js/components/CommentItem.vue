<script setup>
import { reactive, ref } from 'vue'
import CommentItem from './CommentItem'
import client from '../client'

// Props
const props = defineProps({
    comment: {
        type: Object,
        default () {
            return { id: null, parent_id: null, author: '', body: '', children: [] }
        },
    },
    indentLevel: {
        type: Number,
        default: 1,
    },
})

// Local state
const isReplying = ref(false)
const newReply = reactive({ parent_id: props.comment.id, author: '', body: '' })

const createReplyComment = () => {
    if (!isReplying.value) {
        return
    }

    if (!newReply.author || !newReply.body) {
        return
    }

    client.post(`/posts/1/comments`, newReply).then(({ data }) => {
        props.comment.children.unshift(data.data)
        isReplying.value = false
        newReply.author = ''
        newReply.body = ''
    })
}
</script>

<template>
    <div class="flex">
        <img class="shrink-0 h-10 w-10 rounded-full" src="https://www.gravatar.com/avatar/8?d=identicon&f=y" alt="" />
        <div class="ml-3">
            <p class="text-sm font-medium text-slate-800 hover:text-slate-900">{{ comment.author }}</p>
            <p class="text-sm hover:text-slate-800">{{ comment.body }}</p>
            <button v-if="indentLevel < 3" @click.prevent="isReplying = !isReplying" type="button" class="text-sm font-medium hover:underline">
                Reply
            </button>
        </div>
    </div>
    <div class="ml-12 space-y-6">
        <div v-if="indentLevel < 3 && isReplying">
            <input
                v-model.trim="newReply.author"
                type="text"
                class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                placeholder="Your Name"
            >
            <textarea
                v-model.trim="newReply.body"
                rows="3"
                class="mt-3 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                placeholder="Your Reply"
            ></textarea>
            <div class="mt-3 flex items-center">
                <button
                    @click.prevent="isReplying = false"
                    type="button"
                    class="py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm font-medium leading-4 text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Cancel
                </button>
                <button
                    @click.prevent="createReplyComment"
                    type="submit"
                    class="ml-3 py-2 px-3 border border-transparent rounded-md shadow-sm text-sm font-medium leading-4 text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Comment
                </button>
            </div>
        </div>
        <CommentItem v-for="child in comment.children" :key="child.id" :comment="child" :indent-level="indentLevel + 1" />
    </div>
</template>
