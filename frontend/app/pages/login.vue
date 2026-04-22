<script setup>
import { reactive, ref } from 'vue'

definePageMeta({
  middleware: 'guest'
})

const { login } = useAuth()

const state = reactive({
  email: '',
  password: ''
})

const isLoading = ref(false)
const errorMessage = ref('')

const onSubmit = async () => {
  isLoading.value = true
  errorMessage.value = ''
  
  try {
    await login(state)
  } catch (error) {
    errorMessage.value = 'Неверный email или пароль'
  } finally {
    isLoading.value = false
  }
}

useHead({
    title: 'Bash Today | Войти'
})
</script>

<template>
  <div class="max-w-sm mx-auto">
    <UCard>
      <template #header>
        <h1 class="text-2xl font-bold text-center">Вход в систему</h1>
      </template>

      <form @submit.prevent="onSubmit" class="space-y-4 gap-x-2 flex flex-col ">
        <UAlert v-if="errorMessage" variant="outline" :title="errorMessage" />

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

        <UButton type="submit" color="primary" block :loading="isLoading" class="mt-4">
          Войти
        </UButton>
      </form>
      
      <template #footer>
        <p class="text-sm text-center text-gray-500">
          Еще не с нами? <UButton to="/register" variant="link" :padded="false">Зарегистрироваться</UButton>
        </p>
      </template>
    </UCard>
  </div>
</template>