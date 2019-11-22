<template>
  <card title="Add Material">
    <b-alert
              variant="success"
              dismissible
              :show="showAlert"
              @dismissed="showAlert=false"
            >Material has been added!</b-alert>
    <form @submit.prevent="add_material" @keydown="form.onKeydown($event)">
      <!-- Product Name -->
      <b-form-group
        id="input-group-1"
        label="Material Name:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.material_name"
          type="text"
          required
        ></b-form-input>
      </b-form-group>

      <!-- Product Quantity -->
      <b-form-group
        id="input-group-1"
        label="Material Quantity:"
        label-for="input-1"
      >
        <b-form-input
          id="input-1"
          v-model="form.material_quantity"
          type="number"
          required
        ></b-form-input>
      </b-form-group>

      <!-- Submit Button -->
      <div>
        <b-button
          type="submit"
          variant="outline-primary"
        >
            Add Material
        </b-button>
      </div>
    </form>
  </card>
</template>

<script>
import Form from 'vform'
import { mapGetters } from 'vuex'

export default {
  scrollToTop: false,

  metaInfo () {
    return { title: "Add Material" }
  },

  data: () => ({
    showAlert: false,
    form: new Form({
    })
  }),

  methods: {
    async add_material () {
      const { data } = await this.form.post('/api/material')
      this.showAlert = true
      this.form.reset()
    }
  }
}
</script>
