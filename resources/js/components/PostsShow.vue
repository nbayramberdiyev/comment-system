<script setup>
const props = defineProps(['slug'])

// Assumption: the only blog post that can be commented on is fetched by its slug.
const post = {
    id: 1,
    slug: 'lorem-ipsum-dolor-sit-amet',
    title: 'Lorem ipsum dolor sit amet',
    excerpt: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dolor nisi, interdum id iaculis et, ultricies quis elit. Cras vel eros vitae leo venenatis tempor in eget ex. Proin in hendrerit ipsum, sed dictum velit.',
    body: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi dolor nisi, interdum id iaculis et, ultricies quis elit. Cras vel eros vitae leo venenatis tempor in eget ex. Proin in hendrerit ipsum, sed dictum velit. Donec pulvinar, metus nec imperdiet fringilla, ipsum tellus vulputate dui, eu egestas elit tortor sit amet felis. Sed libero nisi, efficitur id magna vel, mollis elementum ipsum. Praesent cursus lacinia dapibus. Fusce quis rutrum lorem. Donec ultricies viverra quam, sed mollis arcu viverra vitae. Ut non risus nisl. Aliquam suscipit velit a ultricies hendrerit. Fusce consequat dignissim urna, sed fringilla lectus iaculis sit amet. Pellentesque rutrum massa mauris, at consectetur elit dictum id. Nunc dapibus leo viverra porttitor venenatis. Aliquam facilisis iaculis metus. Nulla pharetra, dolor vel elementum mollis, augue lectus molestie augue, eget maximus ipsum sem et nibh.',
}
</script>

<template>
    <h1 class="mb-4 text-slate-800 text-2xl text-center font-bold">{{ post.title }}</h1>
    <p class="leading-relaxed">{{ post.body }}</p>
    <p class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-200/5"></p>
</template>
