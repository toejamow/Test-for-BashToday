<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
const config = useRuntimeConfig();

const router = useRouter()

definePageMeta({
  middleware: 'auth'
})

const state = reactive({
  title: '',
  excerpt: '',
  content: '',
  // заглушка изображения
  image: 'https://images.unsplash.com/photo-1498050108023-c5249f4df085' 
})

const isLoading = ref(false)
const errorMessage = ref('')

const onSubmit = async () => {
  isLoading.value = true
  errorMessage.value = ''
  
  try {
    await $fetch('/posts', {
      baseURL: config.public.apiBase,
      method: 'POST',
      body: state,
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': useCookie('XSRF-TOKEN').value
      },
      credentials: 'include'
    })
    
    router.push('/')
  } catch (error) {
    console.error(error)
    errorMessage.value = 'Ошибка при создании поста. Проверьте правильность заполнения.'
  } finally {
    isLoading.value = false
  }
}

useHead({
    title: 'Bash Today | Создание поста' 
})
</script>

<template>
  <div class="max-w-2xl mx-auto mt-10">
    <UCard>
      <template #header>
        <h1 class="text-3xl font-black text-gray-900 dark:text-white">Новый пост</h1>
      </template>

      <form @submit.prevent="onSubmit" class="space-y-6 flex flex-col items-center">
        <UAlert v-if="errorMessage" variant="outline" :title="errorMessage" />

        <UFormField class="w-full" label="Заголовок" name="title">
          <UInput class="w-full" v-model="state.title" required />
        </UFormField>

        <UFormField class="w-full" label="Краткое описание" name="excerpt">
          <UTextarea class="w-full" v-model="state.excerpt" :rows="2" required />
        </UFormField>

        <UFormField class="w-full" label="Основной текст" name="content">
          <UTextarea class="w-full" v-model="state.content" :rows="6" required />
        </UFormField>

        <UFormField class="w-full" label="URL обложки" name="image">
          <UInput class="w-full" v-model="state.image" type="url" placeholder="https://..." />
        </UFormField>

        <div class="flex justify-end gap-4 pt-4">
          <UButton to="/" color="gray" variant="soft">Отмена</UButton>
          <UButton type="submit" color="primary" :loading="isLoading" icon="i-lucide-send-horizontal">
            Опубликовать
          </UButton>
        </div>
      </form>
    </UCard>
  </div>
</template>