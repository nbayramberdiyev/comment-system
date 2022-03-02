<script setup>
import { ref } from 'vue'

// Assumption: there is only one blog post that can be commented on.
const posts = ref([
    { id: 1, slug: 'lorem-ipsum-dolor-sit-amet', title: 'Lorem ipsum dolor sit amet', excerpt: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dolor nisi, interdum id iaculis et, ultricies quis elit. Cras vel eros vitae leo venenatis tempor in eget ex. Proin in hendrerit ipsum, sed dictum velit.', body: '' },
])
</script>

<template>
    <header class="py-8 text-center">
        <h1 class="mb-4 text-2xl tracking-tight text-slate-800 font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600 sm:text-4xl">
            My Awesome Blog
        </h1>
        <p class="text-md text-slate-600 sm:text-lg">
            All the latest Laravel and Vue.js news from another human being 👋
        </p>
    </header>

    <!-- Blog posts -->
    <article v-for="post in posts" class="p-6 mb-6 rounded-md border border-gray-200">
        <h3 class="mb-4 text-xl text-slate-800 tracking-tight font-bold">
            <router-link :to="{ name: 'posts.show', params: { slug: post.slug } }">
                {{ post.title }}
            </router-link>
        </h3>
        <div class="mb-6">
            <p>{{ post.excerpt }}</p>
        </div>
        <div class="mt-auto flex justify-between items-center">
            <router-link :to="{ name: 'posts.show', params: { slug: post.slug } }" class="text-sm no-underline transition hover:text-black">
                Read this article →
            </router-link>
            <div class="text-sm">
                <time datetime="2022-03-03">March 3, 2022</time>
            </div>
        </div>
    </article>
</template>
