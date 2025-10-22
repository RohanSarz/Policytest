<script setup>
import { Head } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Button } from "@/components/ui/button";
import AdminLayout from "@/Layouts/AdminLayout.vue";

// Set the layout for this page
defineOptions({
    layout: AdminLayout,
});

const page = usePage();

// Safely access user — fallback to empty object if missing
const user = computed(() => page.props.auth?.user || {});

// Example system settings
const settings = {
  siteName: 'My Laravel App',
  siteDescription: 'A Laravel application with Vue.js frontend',
  siteUrl: 'https://example.com',
  contactEmail: 'admin@example.com',
  timezone: 'UTC',
  dateFormat: 'Y-m-d',
  postsPerPage: 10,
  maintenanceMode: false
};

// Function to handle form submission
const updateSettings = () => {
  console.log('Updating settings:', settings);
  // In a real app, this would send a request to update settings
};
</script>

<template>
  <div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
      <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
      <p class="mt-2 text-gray-600">Configure system preferences and settings</p>
    </div>

    <!-- Settings Form -->
    <div class="bg-white rounded-xl shadow-md p-6">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">General Settings</h2>
      
      <form @submit.prevent="updateSettings" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="siteName" class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
            <input
              id="siteName"
              v-model="settings.siteName"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label for="siteUrl" class="block text-sm font-medium text-gray-700 mb-1">Site URL</label>
            <input
              id="siteUrl"
              v-model="settings.siteUrl"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div class="md:col-span-2">
            <label for="siteDescription" class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
            <textarea
              id="siteDescription"
              v-model="settings.siteDescription"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            ></textarea>
          </div>
          
          <div>
            <label for="contactEmail" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
            <input
              id="contactEmail"
              v-model="settings.contactEmail"
              type="email"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
          
          <div>
            <label for="timezone" class="block text-sm font-medium text-gray-700 mb-1">Timezone</label>
            <select
              id="timezone"
              v-model="settings.timezone"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="UTC">UTC</option>
              <option value="America/New_York">America/New_York</option>
              <option value="America/Chicago">America/Chicago</option>
              <option value="America/Denver">America/Denver</option>
              <option value="America/Los_Angeles">America/Los_Angeles</option>
              <option value="Europe/London">Europe/London</option>
              <option value="Europe/Paris">Europe/Paris</option>
              <option value="Asia/Tokyo">Asia/Tokyo</option>
            </select>
          </div>
          
          <div>
            <label for="dateFormat" class="block text-sm font-medium text-gray-700 mb-1">Date Format</label>
            <select
              id="dateFormat"
              v-model="settings.dateFormat"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            >
              <option value="Y-m-d">Y-m-d (2023-01-01)</option>
              <option value="m/d/Y">m/d/Y (01/01/2023)</option>
              <option value="d/m/Y">d/m/Y (01/01/2023)</option>
              <option value="F j, Y">F j, Y (January 1, 2023)</option>
            </select>
          </div>
          
          <div>
            <label for="postsPerPage" class="block text-sm font-medium text-gray-700 mb-1">Posts Per Page</label>
            <input
              id="postsPerPage"
              v-model.number="settings.postsPerPage"
              type="number"
              min="1"
              max="50"
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
            />
          </div>
        </div>
        
        <div class="pt-4">
          <div class="flex items-center">
            <input
              id="maintenanceMode"
              v-model="settings.maintenanceMode"
              type="checkbox"
              class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
            />
            <label for="maintenanceMode" class="ml-2 block text-sm text-gray-900">
              Enable Maintenance Mode
            </label>
          </div>
          <p class="mt-1 text-sm text-gray-500">When enabled, only administrators will be able to access the site.</p>
        </div>
        
        <div class="pt-6 flex justify-end">
          <Button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg">
            Save Settings
          </Button>
        </div>
      </form>
    </div>
    
    <!-- Security Settings -->
    <div class="bg-white rounded-xl shadow-md p-6 mt-8">
      <h2 class="text-xl font-semibold text-gray-900 mb-6">Security Settings</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4">Password Requirements</h3>
          <ul class="space-y-2">
            <li class="flex items-center">
              <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
              <span>Minimum 8 characters</span>
            </li>
            <li class="flex items-center">
              <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
              <span>At least one uppercase letter</span>
            </li>
            <li class="flex items-center">
              <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
              <span>At least one number</span>
            </li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-medium text-gray-900 mb-4">Two-Factor Authentication</h3>
          <p class="text-gray-600">Enable two-factor authentication for admin accounts.</p>
          <Button class="mt-4 bg-gray-200 hover:bg-gray-300 text-gray-800">
            Configure 2FA
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>