<script setup lang="ts">
import { ref } from "vue";
import NewsletterSubscription from "@/components/Article/NewsletterSubscription.vue";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Textarea } from "@/components/ui/textarea";
import { Label } from "@/components/ui/label";
import { useForm } from "@inertiajs/vue3";

// Contact form data
const contactForm = useForm({
  name: "",
  email: "",
  subject: "",
  message: "",
});

const submitContact = () => {
  contactForm.post("/contact", {
    onSuccess: () => {
      alert("Thank you for your message! We'll get back to you soon.");
      contactForm.reset();
    },
  });
};
</script>

<template>
  <div class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <!-- About Section -->
    <section class="mb-16">
      <h1 class="text-3xl font-bold text-gray-900 mb-6">About Our News Site</h1>
      
      <Card class="mb-8">
        <CardContent class="pt-6">
          <p class="text-gray-700 mb-4">
            Welcome to our news platform, where we deliver the latest and most important stories from around the world. 
            Our mission is to provide accurate, timely, and comprehensive news coverage across a wide range of topics.
          </p>
          
          <p class="text-gray-700 mb-4">
            Founded in 2025, we have grown to become a trusted source of information, 
            with a dedicated team of journalists, editors, and content creators working 
            around the clock to bring you the stories that matter most.
          </p>
          
          <p class="text-gray-700">
            Our editorial team is committed to upholding the highest standards of journalism, 
            ensuring that all our content is thoroughly researched, fact-checked, and presented 
            in an accessible and engaging manner.
          </p>
        </CardContent>
      </Card>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Our Mission</CardTitle>
          </CardHeader>
          <CardContent>
            <p class="text-gray-700">
              To provide accurate, timely, and comprehensive news coverage that helps our readers stay informed about the world around them.
            </p>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Our Vision</CardTitle>
          </CardHeader>
          <CardContent>
            <p class="text-gray-700">
              To be the most trusted and widely-read news source, setting the standard for digital journalism.
            </p>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader>
            <CardTitle class="text-lg">Our Values</CardTitle>
          </CardHeader>
          <CardContent>
            <p class="text-gray-700">
              Accuracy, integrity, independence, and commitment to public interest guide everything we do.
            </p>
          </CardContent>
        </Card>
      </div>
    </section>
    
    <!-- Editorial Team Section -->
    <section class="mb-16">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Meet Our Editorial Team</h2>
      
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Card class="text-center">
          <div class="p-6">
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 mx-auto mb-4" />
            <h3 class="font-bold text-gray-900">John Smith</h3>
            <p class="text-gray-600 text-sm">Editor-in-Chief</p>
          </div>
        </Card>
        
        <Card class="text-center">
          <div class="p-6">
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 mx-auto mb-4" />
            <h3 class="font-bold text-gray-900">Jane Doe</h3>
            <p class="text-gray-600 text-sm">Managing Editor</p>
          </div>
        </Card>
        
        <Card class="text-center">
          <div class="p-6">
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 mx-auto mb-4" />
            <h3 class="font-bold text-gray-900">Robert Johnson</h3>
            <p class="text-gray-600 text-sm">Senior Reporter</p>
          </div>
        </Card>
      </div>
    </section>
    
    <!-- Contact Section -->
    <section class="mb-16">
      <h2 class="text-2xl font-bold text-gray-900 mb-6">Contact Us</h2>
      
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <Card>
          <CardHeader>
            <CardTitle>Send us a message</CardTitle>
          </CardHeader>
          <CardContent>
            <form @submit.prevent="submitContact" class="space-y-4">
              <div>
                <Label for="name">Name</Label>
                <Input 
                  id="name" 
                  v-model="contactForm.name" 
                  placeholder="Your name"
                  :disabled="contactForm.processing"
                />
              </div>
              
              <div>
                <Label for="email">Email</Label>
                <Input 
                  id="email" 
                  v-model="contactForm.email" 
                  type="email" 
                  placeholder="Your email"
                  :disabled="contactForm.processing"
                />
              </div>
              
              <div>
                <Label for="subject">Subject</Label>
                <Input 
                  id="subject" 
                  v-model="contactForm.subject" 
                  placeholder="Subject"
                  :disabled="contactForm.processing"
                />
              </div>
              
              <div>
                <Label for="message">Message</Label>
                <Textarea 
                  id="message" 
                  v-model="contactForm.message" 
                  placeholder="Your message"
                  rows="4"
                  :disabled="contactForm.processing"
                />
              </div>
              
              <Button 
                type="submit" 
                class="bg-blue-600 hover:bg-blue-700"
                :disabled="contactForm.processing"
              >
                <span v-if="!contactForm.processing">Send Message</span>
                <span v-else>Sending...</span>
              </Button>
            </form>
          </CardContent>
        </Card>
        
        <Card>
          <CardHeader>
            <CardTitle>Get in touch</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="space-y-4">
              <div>
                <h3 class="font-semibold text-gray-900">General Inquiries</h3>
                <p class="text-gray-600">info@newssite.com</p>
              </div>
              
              <div>
                <h3 class="font-semibold text-gray-900">Editorial</h3>
                <p class="text-gray-600">editor@newssite.com</p>
              </div>
              
              <div>
                <h3 class="font-semibold text-gray-900">Advertising</h3>
                <p class="text-gray-600">ads@newssite.com</p>
              </div>
              
              <div>
                <h3 class="font-semibold text-gray-900">Address</h3>
                <p class="text-gray-600">
                  123 News Street<br>
                  Media City, MC 12345<br>
                  United States
                </p>
              </div>
            </div>
          </CardContent>
        </Card>
      </div>
    </section>
    
    <!-- Newsletter Subscription -->
    <NewsletterSubscription />
  </div>
</template>