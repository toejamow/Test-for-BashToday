<script setup>
import { reactive, ref } from 'vue'

definePageMeta({
  middleware: 'guest'
})

const { register } = useAuth()

const state = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '' 
})

const isLoading = ref(false)
const errorMessage = ref('')

const onSubmit = async () => {
  if (state.password !== state.password_confirmation) {
    errorMessage.value = 'Пароли не совпадают'
    return
  }

  isLoading.value = true
  errorMessage.value = ''
  
  try {
    await register(state)
  } catch (error) {
    // В идеале тут нужно парсить error.data.errors, но для MVP хватит общего сообщения
    errorMessage.value = 'Ошибка регистрации. Возможно, такой email уже занят или пароль слишком короткий (нужно 8 символов).'
  } finally {
    isLoading.value = false
  }
}

useHead({
    title: 'Bash Today | Регистрация'
})
</script>

<template>
  <div class="max-w-sm mx-auto">
    <UCard>
      <template #header>
        <h1 class="text-2xl font-bold text-center">Регистрация</h1>
      </template>

      <form @submit.prevent="onSubmit" class="space-y-4 flex flex-col ">
        <UAlert v-if="errorMessage" variant="outline" :title="errorMessage" />

        <UFormField class="w-full" name="name">
          <UInput class="w-full" v-model="state.name" type="text" placeholder="" :ui="{ base: 'peer' }">
          <label class="pointer-events-none absolute left-0 -top-2.5 text-highlighted text-xs font-medium px-1.5 transition-all peer-focus:-top-2.5 peer-focus:text-highlighted peer-focus:text-xs peer-focus:font-medium peer-placeholder-shown:text-sm peer-placeholder-shown:text-dimmed peer-placeholder-shown:top-1.5 peer-placeholder-shown:font-normal">
      <span class="inline-flex bg-default px-1">Имя</span>
        </label>
        </UInput>
        </UFormField>

        <UFormField class="w-full" name="email">
          <UInput class="w-full" v-model="state.email" type="email" placeholder="" :ui="{ base: 'peer' }">
          <label class="pointer-events-none absolute left-0 -top-2.5 text-highlighted text-xs font-medium px-1.5 transition-all peer-focus:-top-2.5 peer-focus:text-highlighted peer-focus:text-xs peer-focus:font-medium peer-placeholder-shown:text-sm peer-placeholder-shown:text-dimmed peer-placeholder-shown:top-1.5 peer-placeholder-shown:font-normal">
      <span class="inline-flex bg-default px-1">Эл. почта</span>
        </label>
        </UInput>
        </UFormField>

        <UFormField class="w-full" name="password">
          <UInput class="w-full" v-model="state.password" type="password" placeholder="" :ui="{ base: 'peer' }">
          <label class="pointer-events-none absolute left-0 -top-2.5 text-highlighted text-xs font-medium px-1.5 transition-all peer-focus:-top-2.5 peer-focus:text-highlighted peer-focus:text-xs peer-focus:font-medium peer-placeholder-shown:text-sm peer-placeholder-shown:text-dimmed peer-placeholder-shown:top-1.5 peer-placeholder-shown:font-normal">
      <span class="inline-flex bg-default px-1">Пароль</span>
          </label>
        </UInput>
        </UFormField>

        <UFormField class="w-full" name="password_confirmation">
          <UInput class="w-full" v-model="state.password_confirmation" type="password" placeholder="" :ui="{ base: 'peer' }">
          <label class="pointer-events-none absolute left-0 -top-2.5 text-highlighted text-xs font-medium px-1.5 transition-all peer-focus:-top-2.5 peer-focus:text-highlighted peer-focus:text-xs peer-focus:font-medium peer-placeholder-shown:text-sm peer-placeholder-shown:text-dimmed peer-placeholder-shown:top-1.5 peer-placeholder-shown:font-normal">
      <span class="inline-flex bg-default px-1">Повторите пароль</span>
          </label>
        </UInput>
        </UFormField>

        <UButton type="submit" color="primary" block :loading="isLoading" class="mt-4">
          Зарегистрироваться
        </UButton>
      </form>
      
      <template #footer>
        <p class="text-sm text-center text-gray-500">
          Уже зарегистрированы? <UButton to="/login" variant="link" :padded="false">Войти</UButton>
        </p>
      </template>
    </UCard>
  </div>
</template>