<script setup>
import { onMounted, computed } from 'vue'

const { user, logout, fetchUser } = useAuth()
const colorMode = useColorMode()

onMounted(async () => {
  await fetchUser()
})

const navItems = computed(() => {
  const items = []

  if (user.value) { 
    items.push(
      {
        label: user.value.name,
        icon: 'i-lucide-circle-user',
      },
      {
        label: 'Создать пост',
        icon: 'i-lucide-pencil',
        to: '/posts/',
        color: 'gray',
        variant: 'ghost'
      }
    )
  } else {
    items.push({
      label: 'Войти',
      icon: 'i-lucide-log-in',
      to: '/login',
      color: 'primary',
      variant: 'solid'
    })
  }

  items.push({
    icon: colorMode.value === 'dark' ? 'i-lucide-sun' : 'i-lucide-moon',
    onSelect: (e) => {
      // e.preventDefault() можно добавить, если меню вдруг будет пытаться перезагрузить страницу
      e.preventDefault() 
      colorMode.preference = colorMode.value === 'dark' ? 'light' : 'dark'
    }
  })

  if (user.value) {
    items.push({
      label: 'Выйти',
      icon: 'i-lucide-log-out',
      color: 'primary',
      variant: 'outline',
      onSelect: async (e) => {
        e.preventDefault()
        await logout()
      }
    })
  }

  return items
})
</script>

<template>
  <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-950">
    <header class="border-b border-gray-200 dark:border-gray-800 bg-white/80 dark:bg-gray-900/80 backdrop-blur-md sticky top-0 z-50">
      <UContainer class="flex items-center justify-between h-16">
        
        <NuxtLink to="/" class="flex items-center gap-2 group">
          <div class="w-8 h-8 bg-primary-500 rounded-lg flex items-center justify-center group-hover:rotate-12 transition-transform">
            <UIcon name="i-lucide-book-heart" class="text-white w-5 h-5" />
          </div>
          <span class="text-xl font-black tracking-tighter text-gray-900 dark:text-white uppercase">
            Bash <span class="text-primary-500">Today</span>
          </span>
        </NuxtLink>

       <UNavigationMenu class="hidden sm:flex" :items="navItems" />

        <UDropdownMenu
          :items="navItems"
          :content="{ align: 'end' }"
          :ui="{ content: 'w-56' }"
          class="sm:hidden"
        >
          <UButton icon="i-heroicons-bars-3" color="gray" variant="ghost" />
        </UDropdownMenu>

      </UContainer>
    </header>

    <main class="flex-1 flex items-center justify-center py-10">
      <UContainer>
        <slot />
      </UContainer>
    </main>

    <footer class="border-t border-gray-200 dark:border-gray-800 py-8 text-center text-sm text-gray-500">
      &copy; 2026 BashToday
    </footer>
  </div>
</template>