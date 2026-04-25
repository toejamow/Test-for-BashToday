<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const config = useRuntimeConfig()
const { user } = useAuth()

const route = useRoute()
const postId = route.params.id

const { data: post, pending, error } = await useFetch(`/posts/${postId}`, {
  baseURL: config.public.apiBase,
})

const router = useRouter()
const isDeleting = ref(false)
const isDeleteOpen = ref(false)

// Функция удаления
const deletePost = async () => {
  isDeleting.value = true

  try {
    await $fetch(`/posts/${postId}`, {
      baseURL: config.public.apiBase,
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value
      },
      credentials: 'include'
    })

    router.push('/')
  } catch (error) {
    console.error(error)
    alert('Произошла ошибка при удалении поста.')
  } finally {
    isDeleting.value = false
    isDeleteOpen.value = false
  }
}

const isEditing = ref(false)

const form = ref({
  title: '',
  excerpt: '',
  content: '',
  image: ''
})

watch(post, (p) => {
  if (p) {
    form.value = {
      title: p.title,
      excerpt: p.excerpt,
      content: p.content,
      image: p.image
    }
  }
}, { immediate: true })

const isLoading = ref(false)

const updatePost = async () => {
  isLoading.value = true

  try {
    await $fetch(`/posts/${postId}`, {
      baseURL: config.public.apiBase,
      method: 'PUT',
      body: form.value,
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value
      },
      credentials: 'include'
    })

    // обновляем данные на странице
    Object.assign(post.value, form.value)

    isEditing.value = false
  } catch (e) {
    console.error(e)
  } finally {
    isLoading.value = false
  }
}

const cancelEdit = () => {
  // откат к исходным данным
  form.value = {
    title: post.value.title,
    excerpt: post.value.excerpt,
    content: post.value.content,
    image: post.value.image
  }

  isEditing.value = false
}
</script>

<template>
  <div class="max-w-4xl mx-auto">
    <div class="post-nav flex justify-between mb-8">
      <UButton to="/" color="gray" variant="ghost" icon="i-lucide-arrow-left"
        class="hover:-translate-x-1 transition-transform">
        Назад к списку
      </UButton>

      <div v-if="post && user.id === post.user_id" class="control-post flex gap-3">

        <template v-if="!isEditing">
          <UButton @click="isEditing = true" color="primary" variant="soft" icon="i-lucide-square-pen" />

          <UButton @click="isDeleteOpen = true" variant="outline" color="neutral" icon="i-lucide-trash" />

        </template>

        <template v-else>
          <UButton @click="updatePost" color="primary" icon="i-lucide-check" />

          <UButton @click="cancelEdit" color="neutral" variant="outline" icon="i-lucide-x" />
        </template>

        <template>
          <UModal v-model:open="isDeleteOpen" :title='`Удалить пост "${post.title}"?`'>
            <template #body>
              <div class="modal flex flex-col items-center gap-4">
                <p class="text-center">Вы уверены, что хотите удалить этот пост?</p>
                <div class="delete-buttons flex gap-2">
                  <UButton @click="isDeleteOpen = false" color="neutral" variant="outline">
                    Отмена
                  </UButton>

                  <UButton @click="deletePost" :loading="isDeleting" color="primary" variant="solid">
                    Удалить
                  </UButton>
                </div>
              </div>
            </template>
          </UModal>
        </template>
      </div>
    </div>

    <div v-if="pending" class="space-y-8 animate-pulse">
      <USkeleton class="h-[400px] w-full rounded-3xl" />
      <div class="max-w-3xl mx-auto space-y-4">
        <USkeleton class="h-12 w-3/4 mx-auto" />
        <USkeleton class="h-4 w-48 mx-auto" />
      </div>
      <div class="max-w-3xl mx-auto space-y-3 pt-8">
        <USkeleton class="h-4 w-full" v-for="i in 5" :key="i" />
        <USkeleton class="h-4 w-5/6" />
      </div>
    </div>

    <article v-else-if="post" class="animate-fade-in pb-20">

      <div class="relative mb-10">
        <img :src="post.image" :alt="post.title"
          class="w-full h-[400px] md:h-[500px] object-cover rounded-3xl shadow-xl ring-1 ring-gray-200 dark:ring-gray-800" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-3xl pointer-events-none">
        </div>
      </div>

      <header class="mb-10 text-center max-w-3xl mx-auto">
        <div v-if="!isEditing">
          <h1 class="text-4xl md:text-5xl font-black mb-6 text-gray-900 dark:text-white tracking-tight leading-tight">
            {{ post.title }}
          </h1>
        </div>

        <div v-else>

          <UInput size="4xl" v-model="form.title" :ui="{
            base: 'text-center mb-6 text-4xl md:text-5xl font-black tracking-tight leading-tight'
          }" />
        </div>

        <div
          class="flex flex-wrap items-center justify-center gap-4 text-sm font-medium text-gray-500 dark:text-gray-400">
          <div class="flex items-center gap-1.5">
            <UIcon name="i-lucide-circle-user" class="w-5 h-5 text-primary-500" />
            <span>{{ post.user?.name }}</span>
          </div>
          <span>&bull;</span>
          <div class="flex items-center gap-1.5">
            <UIcon name="i-lucide-calendar" class="w-5 h-5" />
            <time>{{ new Date(post.created_at).toLocaleDateString('ru-RU', {
              day: 'numeric', month: 'long', year:
                'numeric'
            }) }}</time>
          </div>
        </div>
      </header>

      <div class="max-w-3xl mx-auto">

        <div v-if="!isEditing">
          <p class="break-all text-lg leading-relaxed text-gray-700 dark:text-gray-300 whitespace-pre-wrap">
            {{ post.content }}
          </p>
        </div>

        <div v-else class="space-y-4">
          <UFormField label="Отрывок">
            <UTextarea v-model="form.excerpt" :rows="2" placeholder="Краткое описание (анонс)..." class="w-full" />
          </UFormField>
          <UFormField label="Основной текст">
            <UTextarea v-model="form.content" class="w-full" />
          </UFormField>
        </div>

      </div>

    </article>

    <div v-else-if="error" class="text-center py-20">
      <UIcon name="i-lucide-triangle-alert" class="w-16 h-16 text-red-500 mx-auto mb-4" />
      <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Пост не найден</h2>
      <p class="text-gray-500 mb-8">Возможно, он был удален или вы перешли по неверной ссылке.</p>
      <UButton to="/" color="primary" variant="soft" size="lg">
        Вернуться на главную
      </UButton>
    </div>

  </div>
</template>