<script setup>
import { Head, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)

// Fake data - to be replaced with real data from your backend
const stats = [
    { name: 'Total Policies', value: '12', icon: '📋' },
    { name: 'Claims Filed', value: '3', icon: '理赔' },
    { name: 'Active Coverage', value: '8', icon: '🛡️' },
    { name: 'Savings', value: '$2,450', icon: '💰' }
]

const recentActivity = [
    { id: 1, action: 'Policy Renewed', policy: 'Auto Insurance', date: 'Oct 10, 2025', status: 'Completed' },
    { id: 2, action: 'Claim Submitted', policy: 'Health Insurance', date: 'Oct 5, 2025', status: 'Processing' },
    { id: 3, action: 'Payment Made', policy: 'Home Insurance', date: 'Sep 28, 2025', status: 'Completed' },
    { id: 4, action: 'Policy Updated', policy: 'Life Insurance', date: 'Sep 15, 2025', status: 'Completed' }
]

const policies = [
    { id: 1, name: 'Auto Insurance', provider: 'ABC Insurance', premium: '$120/mo', expiry: 'Dec 15, 2025', status: 'Active' },
    { id: 2, name: 'Health Insurance', provider: 'XYZ Health', premium: '$250/mo', expiry: 'Nov 30, 2025', status: 'Active' },
    { id: 3, name: 'Home Insurance', provider: 'Secure Home', premium: '$85/mo', expiry: 'Jan 20, 2026', status: 'Active' }
]
</script>

<template>
    <Head title="User Dashboard" />
    
    <div class="min-h-screen bg-gray-50">
      <!-- Header -->
      <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
          <p class="mt-1 text-sm text-gray-600">Welcome back, {{ user.name }}!</p>
        </div>
      </header>

      <main>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
          <!-- User Profile Card -->
          <div class="bg-white overflow-hidden shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
              <div class="flex flex-col sm:flex-row items-start sm:items-center">
                <img class="h-16 w-16 rounded-full mb-4 sm:mb-0" :src="user.avatar" alt="User avatar">
                <div class="ml-0 sm:ml-4">
                  <h2 class="text-xl font-semibold text-gray-900">{{ user.name }}</h2>
                  <p class="text-gray-600">{{ user.email }}</p>
                  <div class="mt-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                      {{ user.role }}
                    </span>
                    <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                      {{ user.status }}
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <div v-for="stat in stats" :key="stat.name" class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                  <div class="text-2xl mr-3">{{ stat.icon }}</div>
                  <div>
                    <dt class="text-sm font-medium text-gray-500 truncate">{{ stat.name }}</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ stat.value }}</dd>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900">Recent Activity</h3>
              </div>
              <div class="border-t border-gray-200">
                <ul class="divide-y divide-gray-200">
                  <li v-for="activity in recentActivity" :key="activity.id" class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                      <div class="text-sm font-medium text-gray-900">{{ activity.action }}</div>
                      <div :class="activity.status === 'Completed' ? 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800' : 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800'">
                        {{ activity.status }}
                      </div>
                    </div>
                    <div class="mt-2 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-1">
                      <div class="text-sm text-gray-500">{{ activity.policy }}</div>
                      <div class="text-sm text-gray-500">{{ activity.date }}</div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <!-- Current Policies -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg font-medium text-gray-900">Current Policies</h3>
              </div>
              <div class="border-t border-gray-200">
                <ul class="divide-y divide-gray-200">
                  <li v-for="policy in policies" :key="policy.id" class="px-4 py-4 sm:px-6">
                    <div class="flex items-center justify-between">
                      <div class="text-sm font-medium text-gray-900">{{ policy.name }}</div>
                      <div :class="policy.status === 'Active' ? 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800' : 'ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800'">
                        {{ policy.status }}
                      </div>
                    </div>
                    <div class="mt-2 space-y-1">
                      <div class="flex flex-col sm:flex-row justify-between">
                        <span class="text-sm text-gray-500">Provider:</span>
                        <span class="text-sm text-gray-900 sm:ml-2">{{ policy.provider }}</span>
                      </div>
                      <div class="flex flex-col sm:flex-row justify-between">
                        <span class="text-sm text-gray-500">Premium:</span>
                        <span class="text-sm text-gray-900 sm:ml-2">{{ policy.premium }}</span>
                      </div>
                      <div class="flex flex-col sm:flex-row justify-between">
                        <span class="text-sm text-gray-500">Expires:</span>
                        <span class="text-sm text-gray-900 sm:ml-2">{{ policy.expiry }}</span>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
</template>
