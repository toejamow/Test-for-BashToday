<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
const config = useRuntimeConfig();
const route = useRoute()

const page = computed(() => Number(route.query.page) || 1)

function to(page) {
  return {
    query: {
      page
    }
  }
}

const { data: posts, pending, error } = await useFetch('/posts', {
  baseURL: config.public.apiBase,
  server: false,
  query: { page: page }, 
  watch: [page] 
})

useHead({
    title: 'Bash Today | Главная'
})
</script>

<template>
  <div>
    <h1 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">Блог Bash Today</h1>

    <div v-if="pending" class="text-xl text-gray-500 text-center py-10">
      Загружаем посты...
    </div>

    <div v-else-if="posts && posts.data" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <UCard 
        v-for="post in posts.data" 
        :key="post.id" 
        class="flex flex-col h-full"
      >
        <template #header>
          <img 
            :src="post.image" 
            :alt="post.title" 
            class="w-full h-48 object-cover rounded-t-lg"
          />
        </template>

        <h2 class="text-xl font-semibold mb-2 truncate">{{ post.title }}</h2>
        <p class="text-gray-600 dark:text-gray-400 line-clamp-2 min-h-[48px]">
          {{ post.excerpt }}
        </p>

        <template #footer>
          <UButton 
            :to="`/posts/${post.id}`" 
            color="primary" 
            variant="solid" 
            block
          >
            Читать далее
          </UButton>
        </template>
      </UCard>
    </div>
    
    <div v-else-if="error" class="text-red-500">
      Не удалось загрузить данные.
    </div>
  </div>

  <div v-if="posts && posts.total > posts.per_page" class="flex justify-center mt-12">
  <UPagination
    v-model:page="page"
    :items-per-page="posts.per_page"
    :total="posts.total"
    :to="to"
  />
</div>
</template>

