<template>
  <div>
    <h2>Favorite Images</h2>

    <p v-if="error" style="color:red;">
      {{ error }}
    </p>

    <form @submit.prevent="submit">
      <input v-model="title" placeholder="Title" required />
      <br />

      <textarea
        v-model="description"
        placeholder="Description"
      ></textarea>
      <br />

      <input type="file" @change="handleFile" required />
      <br />

      <button>Save</button>
    </form>

    <div v-for="img in images" :key="img.id">
      <p>{{ img.title }}</p>
      <p>{{ img.description }}</p>
      <img :src="`/storage/${img.image_path}`" width="200" />
      <br />
      <button @click="remove(img.id)">Delete</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      images: [],
      title: '',
      description: '',
      image: null,
      error: null
    }
  },
  mounted() {
    this.fetchImages()
  },
  methods: {
    handleFile(e) {
      this.image = e.target.files[0]
    },
    fetchImages() {
      axios.get('/api/images').then(res => {
        this.images = res.data
      })
    },
    submit() {
      this.error = null

      const form = new FormData()
      form.append('title', this.title)
      form.append('description', this.description)
      form.append('image', this.image)

      axios.post('/api/images', form)
        .then(() => {
          this.fetchImages()
          this.title = ''
          this.description = ''
          this.image = null
        })
        .catch(err => {
          this.error = err.response?.data?.message || 'Upload failed'
        })
    },
    remove(id) {
      axios.delete(`/api/images/${id}`).then(() => {
        this.fetchImages()
      })
    }
  }
}
</script>
