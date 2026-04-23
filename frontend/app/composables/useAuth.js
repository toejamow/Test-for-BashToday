export const useAuth = () => {
  const user = useState('user', () => null)
  const router = useRouter()
  const config = useRuntimeConfig()
  

const apiFetch = $fetch.create({
    baseURL: config.public.backendUrl, 
    headers: {
      'Accept': 'application/json',
    },
    credentials: 'include',
    
    onRequest({ options }) {
      const xsrfToken = useCookie('XSRF-TOKEN').value
      
      if (xsrfToken) {
        options.headers = {
          ...options.headers,
          'X-XSRF-TOKEN': xsrfToken
        }
      }
    }
  })

  const fetchUser = async () => {
    try {
      const data = await apiFetch('/api/user')
      user.value = data
    } catch (e) {
      user.value = null
    }
  }

  const login = async (credentials) => {
    try {
      await apiFetch('/sanctum/csrf-cookie')
      
      await apiFetch('/login', { method: 'POST', body: credentials })
      
      await fetchUser()
      
      router.push('/')
    } catch (error) {
      console.error('Ошибка логина:', error)
      throw error
    }
  }

  const register = async(credentials) => {
    try {
      await apiFetch('/sanctum/csrf-cookie')
      
      await apiFetch('/register', { method: 'POST', body: credentials })

      await fetchUser()

      router.push('/')
    } catch (error) {
        console.error('Ошибка регистрации:', error)
        throw error
    }
  }

  const logout = async () => {
    await apiFetch('/logout', { method: 'POST' })
    user.value = null
    router.push('/login')
  }

  return { user, login, register, logout, fetchUser }
}